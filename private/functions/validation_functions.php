<?php
// Validation functions

function is_blank($value) {
    return !isset($value) || trim($value) === '';
}

function has_length($value, $options=[]) {
    if(isset($options['max']) && (strlen($value) > $options['max'])) {
        return false;
    }
    if(isset($options['min']) && (strlen($value) < $options['min'])) {
        return false;
    }
    if(isset($options['exact']) && (strlen($value) != $options['exact'])) {
        return false;
    }
    return true;
}

function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function has_valid_username_format($value) {
    return preg_match('/\A[a-zA-Z0-9_]+\Z/', $value);
}

function has_valid_password($password, $options=[]) {
    $default_options = [
        'min_length' => 8,
        'require_numbers' => true,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_symbols' => true
    ];
    $options = array_merge($default_options, $options);
    
    if(strlen($password) < $options['min_length']) { return false; }
    if($options['require_numbers'] && !preg_match('/[0-9]/', $password)) { return false; }
    if($options['require_uppercase'] && !preg_match('/[A-Z]/', $password)) { return false; }
    if($options['require_lowercase'] && !preg_match('/[a-z]/', $password)) { return false; }
    if($options['require_symbols'] && !preg_match('/[^A-Za-z0-9]/', $password)) { return false; }
    
    return true;
}

function has_unique_username($username, $current_id="0") {
    $user = Admin_User::find_by_username($username);
    if($user === false || $user->user_id == $current_id) {
        return true;
    }
    return false;
}

// Display validation or other errors as an HTML unordered list
function display_errors($errors = []) {
    $output = '';
    if (!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $error) {
            $output .= "<li>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}
