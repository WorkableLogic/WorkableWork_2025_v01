<?php

use App\Repository\AdminUserRepository;
use App\DTO\AdminUserDTO;

$adminUserRepo = new AdminUserRepository();
$id = $_GET['id'] ?? null;
$adminUser = $id ? $adminUserRepo->findById((int)$id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'user_id' => $_POST['user_id'] ?? null,
        'user_first_name' => $_POST['user_first_name'],
        'user_last_name' => $_POST['user_last_name'],
        'user_email' => $_POST['user_email'],
        'user_username' => $_POST['user_username'],
        'user_hashed_password' => password_hash($_POST['user_password'], PASSWORD_DEFAULT)
    ];

    if ($data['user_id']) {
        $adminUser = AdminUserDTO::fromDatabaseRow($data);
        $adminUserRepo->update($adminUser);
    } else {
        $adminUser = AdminUserDTO::fromDatabaseRow($data);
        $adminUserRepo->create($adminUser);
    }

    redirect_to('index.php?thing=admin_user_list');
}
?>

<h1><?php echo $id ? 'Edit Admin User' : 'New Admin User'; ?></h1>
<form action="" method="post">
    <input type="hidden" name="user_id" value="<?php echo h($adminUser?->getUserId()); ?>">
    
    <div class="w3-row-padding">
    <label for="user_first_name">First Name:</label>
    <input type="text" name="user_first_name" id="user_first_name" value="<?php echo h($adminUser?->getUserFirstName()); ?>" required>
    </div>
    <div class="w3-row-padding">
    <label for="user_last_name">Last Name:</label>
    <input type="text" name="user_last_name" id="user_last_name" value="<?php echo h($adminUser?->getUserLastName()); ?>" required>
    </div>

    <div class="w3-row-padding">
    <label for="user_email">Email:</label>
    <input type="email" name="user_email" id="user_email" value="<?php echo h($adminUser?->getUserEmail()); ?>" required>
    </div>
    <div class="w3-row-padding">
    <label for="user_username">Username:</label>
    <input type="text" name="user_username" id="user_username" value="<?php echo h($adminUser?->getUserUsername()); ?>" required>
    </div>

    <div class="w3-row-padding">
    <label for="user_password">Password:</label>
    <input type="password" name="user_password" id="user_password" <?php echo $id ? '' : 'required'; ?>>
    </div>

    <button type="submit">Submit</button>
</form>
