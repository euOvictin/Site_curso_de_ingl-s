<?php
/**
 * Classe Validator - Validação de Dados
 * Fornece métodos para validar diferentes tipos de dados
 * 
 * @package App\Utils
 */

namespace App\Utils;

class Validator {
    private $errors = [];

    /**
     * Valida email
     * @param string $email
     * @return bool
     */
    public static function email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Valida se está vazio
     * @param string $value
     * @return bool
     */
    public static function required($value) {
        return !empty(trim($value));
    }

    /**
     * Valida comprimento mínimo
     * @param string $value
     * @param int $min
     * @return bool
     */
    public static function minLength($value, $min) {
        return strlen($value) >= $min;
    }

    /**
     * Valida comprimento máximo
     * @param string $value
     * @param int $max
     * @return bool
     */
    public static function maxLength($value, $max) {
        return strlen($value) <= $max;
    }

    /**
     * Valida extensão de arquivo
     * @param string $filename
     * @param array $allowed
     * @return bool
     */
    public static function fileExtension($filename, array $allowed) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, $allowed);
    }

    /**
     * Valida tamanho de arquivo
     * @param int $filesize
     * @param int $maxSize
     * @return bool
     */
    public static function fileSize($filesize, $maxSize) {
        return $filesize <= $maxSize;
    }

    /**
     * Valida padrão regex
     * @param string $value
     * @param string $pattern
     * @return bool
     */
    public static function regex($value, $pattern) {
        return preg_match($pattern, $value) === 1;
    }

    /**
     * Sanitiza string
     * @param string $value
     * @return string
     */
    public static function sanitizeString($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitiza email
     * @param string $email
     * @return string
     */
    public static function sanitizeEmail($email) {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Adiciona erro de validação
     * @param string $field
     * @param string $message
     */
    public function addError($field, $message) {
        $this->errors[$field] = $message;
    }

    /**
     * Retorna todos os erros
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Verifica se há erros
     * @return bool
     */
    public function hasErrors() {
        return count($this->errors) > 0;
    }
}
