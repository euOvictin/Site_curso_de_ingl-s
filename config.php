<?php
/**
 * Configuração Central da Aplicação
 * Arquivo de configuração principal do sistema
 * 
 * @author Sistema English Web
 * @version 1.0
 */

// ===== CONFIGURAÇÕES DE AMBIENTE =====
define('APP_NAME', 'English Web');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // development | production

// ===== CAMINHOS DO PROJETO =====
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Determinar BASE_URL corretamente
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);

// Se estamos acessando via index.php na raiz, ajustar o caminho
if (basename($_SERVER['SCRIPT_NAME']) === 'index.php' && dirname($_SERVER['SCRIPT_NAME']) !== '/') {
    $baseUri = dirname($_SERVER['SCRIPT_NAME']);
} else {
    // Remove /public ou /api do final para encontrar a raiz do projeto
    $baseUri = preg_replace('#/(public|api)/?$#', '', $scriptPath);
}

// Se resultou em string vazia ou apenas '/', usar o diretório atual
if (empty($baseUri) || $baseUri === '/' || $baseUri === '.') {
    // Tentar detectar automaticamente baseado na estrutura de pastas
    $currentDir = basename(dirname($_SERVER['SCRIPT_NAME']));
    if (in_array($currentDir, ['public', 'api'])) {
        $baseUri = dirname(dirname($_SERVER['SCRIPT_NAME']));
    } else {
        $baseUri = dirname($_SERVER['SCRIPT_NAME']);
    }
}

// Garantir que sempre comece com /
if (!empty($baseUri) && $baseUri[0] !== '/') {
    $baseUri = '/' . $baseUri;
}

define('ROOT_PATH', __DIR__);
define('SRC_PATH', ROOT_PATH . '/src');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('DATABASE_PATH', ROOT_PATH . '/database');
define('UPLOADS_PATH', PUBLIC_PATH . '/assets/uploads');
define('VIEWS_PATH', SRC_PATH . '/Views');

// ===== BANCO DE DADOS =====
define('DB_HOST', 'localhost');
define('DB_NAME', 'english_web');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ===== CONFIGURAÇÕES DE SESSÃO =====
define('SESSION_NAME', 'ENGLISH_WEB_SESSION');
define('SESSION_TIMEOUT', 3600); // 1 hora em segundos

// ===== SEGURANÇA =====
define('ALLOWED_IMAGE_EXT', ['jpg', 'jpeg', 'png', 'gif']);
define('ALLOWED_AUDIO_EXT', ['mp3', 'wav', 'ogg', 'm4a']);
define('ALLOWED_PDF_EXT', ['pdf']);
define('MAX_UPLOAD_SIZE', 52428800); // 50MB em bytes

// ===== URLS =====
define('BASE_URL', $protocol . '://' . $domain . $baseUri);

// ===== INICIAR SESSÃO =====
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// ===== AUTOLOADER DE CLASSES =====
spl_autoload_register(function($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) {
        return;
    }
    
    $relative_class = substr($class, strlen($prefix));
    $file = SRC_PATH . '/' . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
