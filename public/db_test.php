<?php
require_once __DIR__ . '/../config.php';
use App\Config\Database;

header('Content-Type: application/json');
try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query('SELECT 1 AS ok');
    $row = $stmt->fetch();
    echo json_encode(['success' => true, 'db_ok' => $row['ok']]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
