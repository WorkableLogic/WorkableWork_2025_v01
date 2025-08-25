<?php
require_once('../../../../private/config/initialize.php');
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_name = $_POST['original_fc_menu_page_name'] ?? null;
    $name = $_POST['fc_menu_page_name'];
    $sort = $_POST['fc_menu_page_sort'];

    $menuPageRepo = new \App\Repository\FcMenuPageRepository();

    $data = [
        'fc_menu_page_name' => $name,
        'fc_menu_page_sort' => $sort
    ];

    if ($original_name && $original_name !== $name) {
        $menuPageRepo->delete($original_name);
        $menuPageRepo->create($data);
    } elseif ($original_name) {
        $menuPageRepo->update($data);
    }
    else {
        $menuPageRepo->create($data);
    }

    header('Location: index.php?thing=menu_page_list');
    exit;
}
