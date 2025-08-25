<?php
// /public/entity/jacolocal/foodcost/delete_map.php
require_once('../../../../private/config/initialize.php');

use App\Repository\FcMapRepository;

if (!isset($_GET['id'])) {
    redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=map_list'));
}

$id = $_GET['id'];
$repo = new FcMapRepository();
$repo->delete($id);

redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=map_list'));
