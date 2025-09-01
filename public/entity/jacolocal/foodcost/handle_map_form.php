<?php
// /public/entity/jacolocal/foodcost/handle_map_form.php
require_once('../../../../private/config/initialize.php');

use App\Repository\FcMapRepository;
use App\DTO\FcMapDTO;

if (is_post_request()) {
    $repo = new FcMapRepository();
    $id = $_POST['fc_map_id'] ?? null;

    // Create a DTO with the correct named arguments for the constructor
    $map = new FcMapDTO(
        id: $id ? (int)$id : null,
        menuType: '', // Not needed for create/update
        menuId: (int)$_POST['fc_map_menu'],
        menuName: '', // Not needed for create/update
        commId: (int)$_POST['fc_map_comm'],
        commName: '', // Not needed for create/update
        amount: (float)$_POST['fc_map_amount'],
        uom: '', // Not needed for create/update
        costPerUom: 0, // Not needed for create/update
        costExtend: 0  // Not needed for create/update
    );

    if ($id) {
        // Update existing record
        $repo->update($map);
    } else {
        // Create new record
        $repo->create($map);
    }

    redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=map_list'));
} else {
    redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=map_list'));
}
