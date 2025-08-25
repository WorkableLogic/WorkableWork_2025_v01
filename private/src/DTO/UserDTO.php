<?php

namespace App\DTO;

class UserDTO {
    public function __construct(
        public readonly ?int $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $username,
        public readonly ?string $hashedPassword = null
    ) {}
}
