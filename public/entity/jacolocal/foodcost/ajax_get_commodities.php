<?php
require_once('../../../../private/config/initialize.php');
require_login();

header('Content-Type: application/json');

try {
    $commRepository = new \App\Repository\FcCommRepository();
    $commodities = $commRepository->findAllForDropdown();
    echo json_encode(['success' => true, 'commodities' => $commodities]);
} catch (Throwable $e) {
    error_log('Error in ajax_get_commodities.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'A server error occurred.']);
}
