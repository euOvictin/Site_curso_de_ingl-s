<?php
/**
 * API: Logout
 */
require_once __DIR__ . '/../config.php';

use App\Utils\Auth;

try {
    $auth = new Auth();
    $auth->logout();
} catch (Exception $e) {
    // Em caso de erro, fazer logout manual
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = array();
        session_destroy();
    }
    error_log("Erro no logout: " . $e->getMessage());
}

// Redirecionar para a página inicial
header('Location: ' . BASE_URL . '/public/index.php');
exit;
