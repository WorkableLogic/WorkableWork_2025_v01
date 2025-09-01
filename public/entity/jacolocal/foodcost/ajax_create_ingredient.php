<?php
require_once(dirname(__DIR__, 4) . '/private/config/initialize.php');
require_login();

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['menu_id']) || !isset($data['comm_id']) || !isset($data['amount'])) {
        throw new Exception('Invalid or incomplete input data.');
    }

    $mapRepository = new \App\Repository\FcMapRepository();

    $menuId = (int) $data['menu_id'];
    $commId = (int) $data['comm_id'];
    $amount = (float) $data['amount'];

    // Create a DTO for the new map entry
    $mapDTO = new \App\DTO\FcMapDTO(null, null, $menuId, null, $commId, null, $amount, null, null, null);

    $newId = $mapRepository->create($mapDTO);

    if ($newId) {
        $newItem = $mapRepository->getIngredientById($newId);
        if (!$newItem) {
            throw new Exception('Failed to retrieve newly created ingredient.');
        }
        echo json_encode(['success' => true, 'item' => $newItem]);
    } else {
        throw new Exception('Failed to create ingredient in the database.');
    }
} catch (Throwable $e) {
    error_log('Error in ajax_create_ingredient.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'A server error occurred.']);
}
