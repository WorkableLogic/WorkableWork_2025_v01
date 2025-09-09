<?php
require_once '../../private/config/initialize.php';

use App\Repository\AdminUserRepository;

// Check if the user is logged in and has the necessary permissions
require_login();

// Validate the user_id parameter
$user_id = $_GET['user_id'] ?? null;
if (!$user_id || !is_numeric($user_id)) {
    $_SESSION['message'] = 'Invalid user ID.';
    redirect_to(url_for('/admin/index.php?thing=admin_user_list'));
}

// Attempt to delete the user
$adminUserRepository = new AdminUserRepository();
try {
    $adminUserRepository->delete((int)$user_id);
    $_SESSION['message'] = 'Admin user deleted successfully.';
} catch (Exception $e) {
    $_SESSION['message'] = 'Failed to delete admin user: ' . $e->getMessage();
}

// Redirect back to the admin user list
redirect_to(url_for('/admin/index.php?thing=admin_user_list'));
