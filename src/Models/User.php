<?php
/**
 * Model: User
 * Gerencia dados de usuários no banco de dados
 * 
 * @package App\Models
 */

namespace App\Models;

use App\Config\Database;

class User {
    protected $pdo;
    protected $table = 'users';

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Busca usuário por ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Busca usuário por email
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Lista todos os usuários
     * @return array
     */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Cria novo usuário
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null,
            $data['role'] ?? 'user'
        ]);
    }

    /**
     * Atualiza usuário
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET name = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['role'] ?? null,
            $id
        ]);
    }

    /**
     * Deleta usuário
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Conta total de usuários
     * @return int
     */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }

    /**
     * Verifica se email existe
     * @param string $email
     * @return bool
     */
    public function emailExists($email) {
        return $this->findByEmail($email) !== null;
    }
}
