<?php
require_once('../../../../private/config/initialize.php');
require_login();

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $menuGroupRepo = new \App\Repository\FcMenuGroupRepository();
    $menuGroupRepo->delete($name);
}

header('Location: index.php?thing=menu_group_list');
exit;
