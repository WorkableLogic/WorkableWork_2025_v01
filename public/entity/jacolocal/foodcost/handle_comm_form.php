<?php
require_once('../../../../private/config/initialize.php');
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    $commData = new \App\DTO\FcCommDTO(
        $id ? (int)$id : null,
        $_POST['fc_comm_code'],
        $_POST['fc_comm_name'],
        $_POST['fc_comm_type'],
        $_POST['fc_comm_supplier'],
        (float)$_POST['fc_comm_cost_net'],
        (float)$_POST['fc_comm_tax_perc'],
        (float)$_POST['fc_comm_cost_gross'],
        $_POST['fc_comm_invoice_size'],
        $_POST['fc_comm_pack_describe'],
        (float)$_POST['fc_comm_convert'],
        $_POST['fc_comm_uom']
    );

    $repo = new \App\Repository\FcCommRepository();

    if ($id) {
        $repo->update($commData);
    } else {
        $repo->create($commData);
    }
    header('Location: index.php?thing=comm_list');
    exit;
}
?>
