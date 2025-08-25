<?php
require_once('../../../../private/config/initialize.php');
require_login();

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $menuPageRepo = new \App\Repository\FcMenuPageRepository();
    $menuPageRepo->delete($name);
}

header('Location: index.php?thing=menu_page_list');
exit;
