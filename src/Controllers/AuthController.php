<?php
/**
 * Controller: Auth
 * Controlador de autenticação (login/registro)
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

use App\Models\User;
use App\Utils\Auth;
use App\Utils\Validator;

class AuthController {
    protected $userModel;
    protected $auth;
    protected $validator;

    public function __construct() {
        $this->userModel = new User();
        $this->auth = new Auth();
        $this->validator = new Validator();
    }

    /**
     * Realiza login do usuário
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(false, 'Método inválido', 405);
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validação
        if (!Validator::required($email) || !Validator::required($password)) {
            return $this->jsonResponse(false, 'Dados incompletos');
        }

        if (!Validator::email($email)) {
            return $this->jsonResponse(false, 'Email inválido');
        }

        // Autenticar
        $user = $this->auth->login($email, $password);
        if (!$user) {
            return $this->jsonResponse(false, 'Email ou senha inválidos');
        }

        // Redirecionar baseado no role
        $redirect = $user['role'] === 'admin' ? 
            BASE_URL . '/public/gerencia.php' : 
            BASE_URL . '/public/dashboard.php';

        return $this->jsonResponse(true, 'Login realizado com sucesso!', 200, [
            'redirect' => $redirect,
            'role' => $user['role']
        ]);
    }

    /**
     * Registra novo usuário
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(false, 'Método inválido', 405);
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validação
        if (!Validator::required($name) || !Validator::required($email) || !Validator::required($password)) {
            return $this->jsonResponse(false, 'Dados incompletos');
        }

        if (!Validator::email($email)) {
            return $this->jsonResponse(false, 'Email inválido');
        }

        if (!Validator::minLength($password, 6)) {
            return $this->jsonResponse(false, 'Senha deve ter no mínimo 6 caracteres');
        }

        // Verificar email duplicado
        if ($this->userModel->emailExists($email)) {
            return $this->jsonResponse(false, 'Email já cadastrado');
        }

        // Criar usuário
        $success = $this->userModel->create([
            'name' => Validator::sanitizeString($name),
            'email' => Validator::sanitizeEmail($email),
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'user'
        ]);

        if (!$success) {
            return $this->jsonResponse(false, 'Erro ao registrar usuário');
        }

        return $this->jsonResponse(true, 'Cadastro realizado! Faça login.');
    }

    /**
     * Realiza logout
     */
    public function logout() {
        $this->auth->logout();
        header('Location: ' . BASE_URL . '/public/login.php');
        exit;
    }

    /**
     * Retorna resposta JSON
     */
    protected function jsonResponse($success, $message, $code = 200, $extra = []) {
        http_response_code($code);
        header('Content-Type: application/json');
        
        $response = [
            'success' => $success,
            'message' => $message
        ];

        echo json_encode(array_merge($response, $extra));
        exit;
    }
}
