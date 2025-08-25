<?php
require_once('../../../../private/config/initialize.php');
require_login();

$id = $_GET['id'] ?? null;
if ($id) {
    $repo = new \App\Repository\FcCommRepository();
    $repo->delete((int)$id);
}
header('Location: index.php?thing=comm_list');
exit;
