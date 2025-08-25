<?php
require_once('../../../../private/config/initialize.php');
require_login();

use App\Repository\FcCommUomRepository;
use App\DTO\FcCommUomDTO;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repo = new FcCommUomRepository();
    $dto = new FcCommUomDTO();
    $dto->fc_comm_uom_name = $_POST['fc_comm_uom_name'];
    
    $original_name = $_POST['original_fc_comm_uom_name'] ?? null;

    if ($original_name) {
        $repo->update($original_name, $dto);
    } else {
        $repo->create($dto);
    }

    header('Location: index.php?thing=comm_uom_list');
    exit;
}
