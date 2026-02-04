<?php
/**
 * Classe Database - Conexão PDO Centralizada
 * Gerencia todas as conexões com o banco de dados
 * 
 * @package App\Config
 */

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Obtém instância única do banco (Singleton Pattern)
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retorna conexão PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Trata erros de conexão
     * @param PDOException $e
     */
    private function handleError(PDOException $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Erro de conexão ao banco de dados',
            'message' => APP_ENV === 'development' ? $e->getMessage() : 'Entre em contato com o suporte'
        ]);
        exit;
    }

    // Previne clonagem e unserialize
    public function __clone() {}
    public function __wakeup() {}
}
