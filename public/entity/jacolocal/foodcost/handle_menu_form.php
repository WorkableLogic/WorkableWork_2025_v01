<?php
require_once('../../../../private/config/initialize.php');
require_login();

use App\DTO\FcMenuDTO;
use App\Repository\FcMenuRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repo = new FcMenuRepository();
    
    $id = $_POST['fc_menu_id'] ?? null;

    if ($id) {
        // Update existing item
        $menuItem = $repo->findById((int)$id);
        if ($menuItem) {
            $menuItem->name = $_POST['fc_menu_name'];
            $menuItem->price = (float)$_POST['fc_menu_price'];
            $menuItem->pageName = $_POST['fc_menu_page'];
            $menuItem->typeName = $_POST['fc_menu_type'];
            // Note: categoryName and groupName are not in the form, so they are not updated here.
            $repo->update($menuItem);
        }
    } else {
        // Create new item
        $menuItem = new FcMenuDTO(
            null,
            $_POST['fc_menu_name'],
            (float)$_POST['fc_menu_price'],
            $_POST['fc_menu_page'],
            $_POST['fc_menu_type'],
            '', // categoryName - not in form
            ''  // groupName - not in form
        );
        $repo->create($menuItem);
    }

    header('Location: index.php?thing=menu_list');
    exit;
} else {
    // Redirect to the list if not a POST request
    header('Location: index.php?thing=menu_list');
    exit;
}
