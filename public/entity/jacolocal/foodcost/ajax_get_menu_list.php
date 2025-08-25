<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/ajax_get_menu_list.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../../private/config/initialize.php';
require_login();

header('Content-Type: application/json');

try {
    $menuRepo = new \App\Repository\FcMenuRepository();

    // Sanitize and prepare criteria from GET parameters
    $filters = [];
    if (!empty($_GET['menu_type'])) {
        // The getFullMenuList expects 'fc_menu_type_name' as the key
        $filters['fc_menu_type_name'] = filter_var($_GET['menu_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if (!empty($_GET['menu_page'])) {
        // The getFullMenuList expects 'fc_menu_page' as the key
        $filters['fc_menu_page'] = filter_var($_GET['menu_page'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if (!empty($_GET['menu_name'])) {
        // The getFullMenuList expects 'fc_menu_name' as the key
        $filters['fc_menu_name'] = filter_var($_GET['menu_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    // Use the existing getFullMenuList method which is designed for filtering
    $menus = $menuRepo->getFullMenuList($filters);

    // We need more fields for the list display
    $results = array_map(function($menu) {
        return [
            'id' => $menu->id,
            'name' => $menu->name,
            'typeName' => $menu->typeName,
            'pageName' => $menu->pageName
        ];
    }, $menus);

    echo json_encode($results);

} catch (\Exception $e) {
    // Return a proper error response
    http_response_code(500);
    echo json_encode(['error' => 'An internal server error occurred.', 'message' => $e->getMessage()]);
    // Optionally log the error
    // error_log($e->getMessage());
}
