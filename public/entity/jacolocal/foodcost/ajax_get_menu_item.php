<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/ajax_get_menu_item.php
require_once '../../../../private/config/initialize.php';
require_login();

use App\Repository\FcMenuRepository;

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request'];

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $menuRepo = new FcMenuRepository();
    $menuItem = $menuRepo->findById($id);

    if ($menuItem) {
        $response = [
            'success' => true,
            'data' => $menuItem->toArray()
        ];
    } else {
        $response['message'] = 'Menu item not found';
    }
}

echo json_encode($response);
