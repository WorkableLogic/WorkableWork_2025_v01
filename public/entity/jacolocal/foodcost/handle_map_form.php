<?php
// /public/entity/jacolocal/foodcost/handle_map_form.php
require_once('../../../../private/config/initialize.php');

use App\Repository\FcMapRepository;
use App\DTO\FcMapDTO;

if (is_post_request()) {
    $repo = new FcMapRepository();
    $id = $_POST['fc_map_id'] ?? null;

    // Create a DTO with the full field names from the form post
    $map = new FcMapDTO(
        fc_map_id: $id,
        menuType: '', 
        fc_map_menu: (int)$_POST['fc_map_menu'],
        menuName: '', 
        fc_map_comm: (int)$_POST['fc_map_comm'],
        commName: '', 
        fc_map_amount: (float)$_POST['fc_map_amount'],
        commUom: '', 
        commCostUom: 0, 
        mapCostExtend: 0
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
