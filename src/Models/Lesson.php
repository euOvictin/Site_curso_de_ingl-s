<?php
/**
 * Model: Lesson
 * Gerencia lições dos cursos
 * 
 * @package App\Models
 */

namespace App\Models;

use App\Config\Database;

class Lesson {
    protected $pdo;
    protected $table = 'lessons';

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Busca lição por ID
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT l.*, c.title as course_title FROM {$this->table} l JOIN courses c ON l.course_id = c.id WHERE l.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Lista lições de um curso
     * @param int $course_id
     * @return array
     */
    public function getByCourse($course_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE course_id = ? ORDER BY order_number");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    /**
     * Lista todas as lições
     * @return array
     */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT l.*, c.title as course_title FROM {$this->table} l JOIN courses c ON l.course_id = c.id ORDER BY l.course_id, l.order_number");
        return $stmt->fetchAll();
    }

    /**
     * Cria nova lição
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (course_id, title, content, order_number) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['course_id'] ?? null,
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['order_number'] ?? 1
        ]);
    }

    /**
     * Atualiza lição
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET title = ?, content = ?, order_number = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['order_number'] ?? null,
            $id
        ]);
    }

    /**
     * Deleta lição
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Conta total de lições
     * @return int
     */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()['total'];
    }

    /**
     * Conta lições de um curso
     * @param int $course_id
     * @return int
     */
    public function countByCourse($course_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetch()['total'];
    }
}
