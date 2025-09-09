<?php

namespace App\Repository;

use App\Database;
use App\DTO\AdminUserDTO;
use PDO;

class AdminUserRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $query = "SELECT * FROM admin_user";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => AdminUserDTO::fromDatabaseRow($row), $rows);
    }

    public function findById(int $id): ?AdminUserDTO {
        $query = "SELECT * FROM admin_user WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? AdminUserDTO::fromDatabaseRow($user) : null;
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

    public function create(AdminUserDTO $adminUser): bool {
        $query = "INSERT INTO admin_user (user_first_name, user_last_name, user_email, user_username, user_hashed_password) VALUES (:firstName, :lastName, :email, :username, :hashedPassword)";
        $stmt = $this->db->prepare($query);
        $firstName = $adminUser->getUserFirstName();
        $lastName = $adminUser->getUserLastName();
        $email = $adminUser->getUserEmail();
        $username = $adminUser->getUserUsername();
        $hashedPassword = $adminUser->getUserHashedPassword();
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(AdminUserDTO $adminUser): bool {
        $query = "UPDATE admin_user SET user_first_name = :firstName, user_last_name = :lastName, user_email = :email, user_username = :username, user_hashed_password = :hashedPassword WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $id = $adminUser->getUserId();
        $firstName = $adminUser->getUserFirstName();
        $lastName = $adminUser->getUserLastName();
        $email = $adminUser->getUserEmail();
        $username = $adminUser->getUserUsername();
        $hashedPassword = $adminUser->getUserHashedPassword();
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM admin_user WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function validateAdminUser(string $username, string $email): array {
        $errors = [];

        // Validate username uniqueness
        $query = "SELECT COUNT(*) FROM admin_user WHERE user_username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
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
