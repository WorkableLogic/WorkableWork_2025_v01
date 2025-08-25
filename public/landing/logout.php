<?php
require_once('../../private/config/initialize.php');

$session->logout();
redirect_to(url_for('/landing/login.php'));
