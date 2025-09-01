<?php
require_once('../../../../private/config/initialize.php');
require_login();

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id'])) {
        throw new Exception('Invalid input. ID is missing.');
    }

    $id = (int) $data['id'];

    $fcMapRepository = new \App\Repository\FcMapRepository();
    $result = $fcMapRepository->delete($id);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to delete ingredient from the database.');
    }
} catch (Throwable $e) {
    error_log('Error in ajax_delete_ingredient.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'A server error occurred.']);
}
