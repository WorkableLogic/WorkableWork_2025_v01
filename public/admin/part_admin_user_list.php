<?php
// require_once('../../../../private/config/initialize.php');
// require_login();

use App\Repository\AdminUserRepository;

$adminUserRepo = new AdminUserRepository();
$adminUsers = $adminUserRepo->findAll();
?>

<h1>Admin Users</h1>
<table class="wd-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($adminUsers as $user): ?>
            <tr>
                <td><?php echo h($user->getUserId()); ?></td>
                <td><?php echo h($user->getUserFirstName()); ?></td>
                <td><?php echo h($user->getUserLastName()); ?></td>
                <td><?php echo h($user->getUserEmail()); ?></td>
                <td><?php echo h($user->getUserUsername()); ?></td>
                <td>
                    <a href="index.php?thing=admin_user_form&id=<?php echo h($user->getUserId()); ?>">Edit</a> |
                    <a href="delete_admin_user.php?user_id=<?php echo h($user->getUserId()); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
