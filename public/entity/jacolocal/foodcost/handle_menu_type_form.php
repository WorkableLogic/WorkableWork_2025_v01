<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/handle_menu_type_form.php
require_once('../../../../private/config/initialize.php');
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_name = $_POST['original_fc_menu_type_name'] ?? null;
    $name = $_POST['fc_menu_type_name'];
    $sort = $_POST['fc_menu_type_sort'];
    $group = $_POST['fc_menu_type_group'];

    $menuTypeRepo = new \App\Repository\FcMenuTypeRepository();

    $data = [
        'fc_menu_type_name' => $name,
        'fc_menu_type_sort' => $sort,
        'fc_menu_type_group' => $group
    ];

    if ($original_name) {
        // Update existing record
        $data['original_fc_menu_type_name'] = $original_name;
        $menuTypeRepo->update($data);
    } else {
        // Create new record
        $menuTypeRepo->create($data);
    }

    header('Location: index.php?thing=menu_type_list');
    exit;
}
