<?php
/**
 * Model: Course
 * Gerencia cursos do site
 * 
 * @package App\Models
 */

namespace App\Models;

use App\Config\Database;

class Course {
    protected $pdo;
    protected $table = 'courses';

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Busca curso por ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT c.*, u.name as author_name, COUNT(l.id) as lesson_count FROM {$this->table} c LEFT JOIN users u ON c.author_id = u.id LEFT JOIN lessons l ON c.id = l.course_id WHERE c.id = ? GROUP BY c.id");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Lista todos os cursos
     * @return array
     */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT c.*, u.name as author_name, COUNT(l.id) as lesson_count FROM {$this->table} c JOIN users u ON c.author_id = u.id LEFT JOIN lessons l ON c.id = l.course_id GROUP BY c.id ORDER BY c.created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Cria novo curso
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (title, description, author_id) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['author_id'] ?? null
        ]);
    }

    /**
     * Atualiza curso
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET title = ?, description = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([
            $data['title'] ?? null,
            $data['description'] ?? null,
            $id
        ]);
    }

    /**
     * Deleta curso
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Conta total de cursos
     * @return int
     */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }
}
