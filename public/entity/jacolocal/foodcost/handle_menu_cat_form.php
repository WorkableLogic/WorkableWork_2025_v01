<?php
require_once('../../../../private/config/initialize.php');
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_name = $_POST['original_fc_menu_cat_name'] ?? null;
    $name = $_POST['fc_menu_cat_name'];
    $sort = $_POST['fc_menu_cat_sort'];

    $menuCatRepo = new \App\Repository\FcMenuCatRepository();

    $data = [
        'fc_menu_cat_name' => $name,
        'fc_menu_cat_sort' => $sort
    ];

    if ($original_name && $original_name !== $name) {
        // This is an update of the primary key, which is not ideal.
        // For this application, we'll delete the old and insert the new.
        // A better solution would be to use a non-natural primary key.
        $menuCatRepo->delete($original_name);
        $menuCatRepo->create($data);
    } elseif ($original_name) {
        // Update existing record
        $menuCatRepo->update($data);
    }
    else {
        // Create new record
        $menuCatRepo->create($data);
    }

    header('Location: index.php?thing=menu_cat_list');
    exit;
}
