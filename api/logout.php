<?php
/**
 * API: Logout
 */
require_once __DIR__ . '/../config.php';

use App\Utils\Auth;

$auth = new Auth();
$auth->logout();

header('Location: ' . BASE_URL . '/public/login.php');
exit;
