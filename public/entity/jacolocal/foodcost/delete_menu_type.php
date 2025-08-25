<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/delete_menu_type.php
require_once('../../../../private/config/initialize.php');
require_login();

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $menuTypeRepo = new \App\Repository\FcMenuTypeRepository();
    $menuTypeRepo->delete($name);
}

header('Location: index.php?thing=menu_type_list');
exit;
