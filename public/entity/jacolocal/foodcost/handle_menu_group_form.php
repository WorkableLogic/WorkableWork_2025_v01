<?php
require_once('../../../../private/config/initialize.php');
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_name = $_POST['original_fc_menu_group_name'] ?? null;
    $name = $_POST['fc_menu_group_name'];
    $sort = $_POST['fc_menu_group_sort'];
    $cat = $_POST['fc_menu_group_cat'];

    $menuGroupRepo = new \App\Repository\FcMenuGroupRepository();

    $data = [
        'fc_menu_group_name' => $name,
        'fc_menu_group_sort' => $sort,
        'fc_menu_group_cat' => $cat
    ];

    if ($original_name && $original_name !== $name) {
        // This is an update of the primary key, which is not ideal.
        // For this application, we'll delete the old and insert the new.
        // A better solution would be to use a non-natural primary key.
        $menuGroupRepo->delete($original_name);
        $menuGroupRepo->create($data);
    } elseif ($original_name) {
        // Update existing record
        $menuGroupRepo->update($data);
    }
    else {
        // Create new record
        $menuGroupRepo->create($data);
    }

    header('Location: index.php?thing=menu_group_list');
    exit;
}
