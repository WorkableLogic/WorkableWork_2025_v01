<?php

namespace App;

use App\DTO\UserDTO;

class Session {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(UserDTO $user): void {
        session_regenerate_id();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public function getUsername(): ?string {
        return $_SESSION['username'] ?? null;
    }

    public function logout(): void {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
    }

    // Methods for FC Menu Criteria
    public function setFcMenuCriteria(array $criteria): void {
        $_SESSION['fc_menu_criteria'] = $criteria;
    }

    public function getFcMenuCriteria(): array {
        return $_SESSION['fc_menu_criteria'] ?? [
            'fc_menu_cat_name' => 'All',
            'fc_menu_group_name' => 'All',
            'fc_menu_type_name' => 'All',
            'fc_menu_page' => 'All',
            'fc_menu_name' => ''
        ];
    }

    public function clearFcMenuCriteria(): void {
        unset($_SESSION['fc_menu_criteria']);
    }

    // Methods for FC Comm Criteria
    public function setFcCommCriteria(array $criteria): void {
        $_SESSION['fc_comm_criteria'] = $criteria;
    }

    public function getFcCommCriteria(): array {
        return $_SESSION['fc_comm_criteria'] ?? [
            'fc_comm_name' => '',
            'fc_comm_type' => 'All',
            'fc_comm_supplier' => ''
        ];
    }

    public function clearFcCommCriteria(): void {
        unset($_SESSION['fc_comm_criteria']);
    }

    // Methods for FC Map Criteria
    public function setFcMapCriteria(array $criteria): void {
        $_SESSION['fc_map_criteria'] = $criteria;
    }

    public function getFcMapCriteria(): array {
        return $_SESSION['fc_map_criteria'] ?? [
            'fc_menu_type' => 'All',
            'fc_menu_name' => '',
            'fc_comm_name' => ''
        ];
    }

    public function clearFcMapCriteria(): void {
        unset($_SESSION['fc_map_criteria']);
    }
}
