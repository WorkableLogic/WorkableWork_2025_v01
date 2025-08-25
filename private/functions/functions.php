<?php
// URL and Path functions
function url_for($script_path) {
    if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function u($string="") {
    // Only urlencode if not null
    return urlencode($string ?? "");
}

function raw_u($string="") {
    return rawurlencode($string);
}

// HTML Escape function
function h($string="") {
    return htmlspecialchars($string ?? "", ENT_QUOTES, 'UTF-8');
}

// Redirect function
function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

// Request type check functions
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Authentication functions
function require_login() {
    if(!isset($_SESSION['user_id'])) {
        redirect_to(url_for('/landing/login.php'));
    }
}

// Date formatting functions
function format_date($date) {
    if($date == "") { return ""; }
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d ? $d->format('m/d/Y') : "";
}

function mysql_date($date) {
    if($date == "") { return ""; }
    $d = DateTime::createFromFormat('m/d/Y', $date);
    return $d ? $d->format('Y-m-d') : "";
}
