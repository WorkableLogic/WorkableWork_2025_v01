<?php

namespace App\Repository;

use App\Database;
use App\DTO\AdminUserDTO;
use PDO;

class UserRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByUsername(string $username): ?AdminUserDTO {
        $stmt = $this->db->prepare("SELECT * FROM admin_user WHERE user_username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return AdminUserDTO::fromDatabaseRow($user);
    }

    public function validateAdminUser(string $username, string $email): array {
        $errors = [];

        // Validate username uniqueness
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM admin_user WHERE user_username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Username already exists.';
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address.';
        }

        return $errors;
    }
}
