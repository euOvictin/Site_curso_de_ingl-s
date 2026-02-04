<?php
/**
 * Model: Page
 * Gerencia páginas do site
 * 
 * @package App\Models
 */

namespace App\Models;

use App\Config\Database;

class Page {
    protected $pdo;
    protected $table = 'pages';

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Busca página por ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, u.name as author_name FROM {$this->table} p JOIN users u ON p.author_id = u.id WHERE p.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Busca página por slug
     * @param string $slug
     * @return array|null
     */
    public function findBySlug($slug) {
        $stmt = $this->pdo->prepare("SELECT p.*, u.name as author_name FROM {$this->table} p JOIN users u ON p.author_id = u.id WHERE p.slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Lista todas as páginas
     * @return array
     */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT p.*, u.name as author_name FROM {$this->table} p JOIN users u ON p.author_id = u.id ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Cria nova página
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (title, slug, content, author_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'] ?? null,
            $data['slug'] ?? null,
            $data['content'] ?? null,
            $data['author_id'] ?? null
        ]);
    }

    /**
     * Atualiza página
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET title = ?, slug = ?, content = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([
            $data['title'] ?? null,
            $data['slug'] ?? null,
            $data['content'] ?? null,
            $id
        ]);
    }

    /**
     * Deleta página
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Conta total de páginas
     * @return int
     */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }
}
