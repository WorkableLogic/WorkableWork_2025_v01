<?php
require_once('../../../../private/config/initialize.php');
require_login();

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $menuCatRepo = new \App\Repository\FcMenuCatRepository();
    $menuCatRepo->delete($name);
}

header('Location: index.php?thing=menu_cat_list');
exit;
