<?php
require_once('../../../../private/config/initialize.php');
require_login();

use App\Repository\FcCommTypeRepository;
use App\DTO\FcCommTypeDTO;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repo = new FcCommTypeRepository();
    $dto = new FcCommTypeDTO();
    $dto->fc_comm_type_name = $_POST['fc_comm_type_name'];
    
    $original_name = $_POST['original_fc_comm_type_name'] ?? null;

    if ($original_name) {
        $repo->update($original_name, $dto);
    } else {
        $repo->create($dto);
    }

    header('Location: index.php?thing=comm_type_list');
    exit;
}
