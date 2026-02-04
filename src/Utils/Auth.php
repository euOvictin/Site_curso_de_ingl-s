<?php
/**
 * Classe Auth - Gerenciamento de Autenticação
 * Controlador de login, logout e verificação de permissões
 * 
 * @package App\Utils
 */

namespace App\Utils;

use App\Config\Database;

class Auth {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Faz login do usuário
     * @param string $email
     * @param string $password
     * @return array|false
     */
    public function login($email, $password) {
        try {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            
            $stmt = $this->pdo->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_email'] = $user['email'];
                return $user;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Faz logout do usuário
     */
    public function logout() {
        // Verificar se há uma sessão ativa
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Limpar todas as variáveis de sessão
            $_SESSION = array();

            // Se existe um cookie de sessão, destruí-lo
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Destruir a sessão
            session_destroy();
        }
    }

    /**
     * Verifica se usuário está autenticado
     * @return bool
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Verifica se é admin
     * @return bool
     */
    public function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Retorna dados do usuário logado
     * @return array|null
     */
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'role' => $_SESSION['user_role'] ?? null
        ];
    }

    /**
     * Redireciona se não está logado
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/public/login.php');
            exit;
        }
    }

    /**
     * Redireciona se não é admin
     */
    public function requireAdmin() {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            header('Location: ' . BASE_URL . '/public/dashboard.php');
            exit;
        }
    }
}
