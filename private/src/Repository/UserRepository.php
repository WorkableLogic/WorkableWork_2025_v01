<?php

namespace App\Repository;

use App\Database;
use App\DTO\UserDTO;
use PDO;

class UserRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByUsername(string $username): ?UserDTO {
        $stmt = $this->db->prepare("SELECT * FROM admin_user WHERE user_username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new UserDTO(
            id: $user['user_id'],
            firstName: $user['user_first_name'],
            lastName: $user['user_last_name'],
            email: $user['user_email'],
            username: $user['user_username'],
            hashedPassword: $user['user_hashed_password']
        );
    }
}
