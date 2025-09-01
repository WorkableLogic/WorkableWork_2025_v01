<?php
// Use a more robust path to include initialize.php
// require_once(dirname(__FILE__, 5) . '/private/config/initialize.php');
require_once('../../../../private/config/initialize.php');

require_login();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input: ' . json_last_error_msg());
    }

    if (!$data || !isset($data['id']) || !isset($data['amount'])) {
        throw new Exception('Invalid or incomplete input data.');
    }

    $fcMapRepository = new \App\Repository\FcMapRepository();

    $id = (int) $data['id'];
    $amount = (float) $data['amount'];

    $result = $fcMapRepository->updateAmount($id, $amount);

    if ($result) {
        $updatedItem = $fcMapRepository->getIngredientById($id);
        if (!$updatedItem) {
            throw new Exception('Failed to retrieve updated ingredient.');
        }
        echo json_encode(['success' => true, 'item' => $updatedItem]);
    } else {
        throw new Exception('Failed to update ingredient in the database.');
    }
} catch (Throwable $e) {
    // Log error to a file for internal review
    error_log('Error in ajax_update_ingredient.php: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    
    // Send a structured error response
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false, 
        'message' => 'A server error occurred: ' . $e->getMessage()
    ]);
}
