<?php
require_once('../../private/config/initialize.php');

// Check if all required parameters are present in the URL
if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['page'])) {
    
    // Set the location ID and name in the session
    $_SESSION['locent_id'] = $_GET['id'];
    $_SESSION['locent_name'] = $_GET['name'];
    
    // Decode the URL-encoded page path
    $redirect_url = urldecode($_GET['page']);
    
    // Redirect to the final destination page
    redirect_to(url_for($redirect_url));
    
} else {
    // If parameters are missing, redirect back to the landing page
    redirect_to(url_for('/landing/index.php'));
}
?>
