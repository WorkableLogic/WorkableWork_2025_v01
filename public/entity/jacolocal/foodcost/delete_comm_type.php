<?php
require_once('../../../../private/config/initialize.php');
require_login();

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $repo = new \App\Repository\FcCommTypeRepository();
    $repo->delete($name);
}

header('Location: index.php?thing=comm_type_list');
exit;
