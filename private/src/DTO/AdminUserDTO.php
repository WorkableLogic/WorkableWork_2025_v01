<?php

namespace App\DTO;

class AdminUserDTO {
    private ?int $userId;
    private string $userFirstName;
    private string $userLastName;
    private string $userEmail;
    private string $userUsername;
    private string $userHashedPassword;

    public function __construct(
        ?int $userId,
        string $userFirstName,
        string $userLastName,
        string $userEmail,
        string $userUsername,
        string $userHashedPassword
    ) {
        $this->userId = $userId;
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
        $this->userEmail = $userEmail;
        $this->userUsername = $userUsername;
        $this->userHashedPassword = $userHashedPassword;
    }

    public static function fromDatabaseRow(array $row): self {
        return new self(
            userId: isset($row['user_id']) ? (int)$row['user_id'] : null,
            userFirstName: $row['user_first_name'] ?? '',
            userLastName: $row['user_last_name'] ?? '',
            userEmail: $row['user_email'] ?? '',
            userUsername: $row['user_username'] ?? '',
            userHashedPassword: $row['user_hashed_password'] ?? ''
        );
    }

    // Getters
    public function getUserId(): ?int {
        return $this->userId;
    }

    public function getUserFirstName(): string {
        return $this->userFirstName;
    }

    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserEmail(): string {
        return $this->userEmail;
    }

    public function getUserUsername(): string {
        return $this->userUsername;
    }

    public function getUserHashedPassword(): string {
        return $this->userHashedPassword;
    }
}
