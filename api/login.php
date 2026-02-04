<?php
/**
 * API: Login
 */
require_once __DIR__ . '/../config.php';

use App\Controllers\AuthController;

header('Content-Type: application/json');

try {
    $controller = new AuthController();
    $controller->login();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno do servidor',
        'error' => APP_ENV === 'development' ? $e->getMessage() : null
    ]);
}
