<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/ajax_get_ingredients.php
require_once('../../../../private/config/initialize.php');

header('Content-Type: application/json');

$menuItemId = $_GET['menu_item_id'] ?? null;

if (!$menuItemId) {
    http_response_code(400);
    echo json_encode(['error' => 'Menu item ID is required.']);
    exit;
}

$mapRepo = new \App\Repository\FcMapRepository();
$ingredients = $mapRepo->findIngredientsByMenuId($menuItemId);

echo json_encode($ingredients);
