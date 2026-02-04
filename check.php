<?php
/**
 * Quick Verification - HTML Version
 * Acesse via navegador: http://localhost/teste/check.php
 */

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Verificação - English Web</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;background:#050716;color:#e5e7eb}";
echo ".container{max-width:900px;margin:0 auto}";
echo ".success{color:#4ade80;background:#1f2937;padding:10px;margin:5px 0;border-radius:5px}";
echo ".error{color:#f87171;background:#1f2937;padding:10px;margin:5px 0;border-radius:5px}";
echo ".warning{color:#fbbf24;background:#1f2937;padding:10px;margin:5px 0;border-radius:5px}";
echo "h1{color:#22d3ee;text-align:center}h2{color:#a855f7;margin-top:20px}";
echo ".grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}";
echo "a{color:#22d3ee;text-decoration:none}a:hover{text-decoration:underline}";
echo "</style></head><body><div class='container'>";

echo "<h1>✅ English Web - Verificação de Configuração</h1>";

// Verificar diretórios críticos
echo "<h2>📁 Diretórios</h2>";
$dirs = ['src', 'public', 'public/assets/uploads', 'database', 'api'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    $exists = is_dir($path) ? '✓' : '✗';
    $class = is_dir($path) ? 'success' : 'error';
    echo "<div class='$class'>$exists $dir</div>";
}

// Verificar arquivos críticos
echo "<h2>📄 Arquivos Core</h2>";
$files = [
    'config.php',
    'public/index.php',
    'public/login.php',
    'public/dashboard.php',
    'src/Config/Database.php',
    'src/Utils/Auth.php',
    'database/schema.sql'
];
foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    $exists = file_exists($path) ? '✓' : '✗';
    $class = file_exists($path) ? 'success' : 'error';
    echo "<div class='$class'>$exists $file</div>";
}

// Verificar PHP
echo "<h2>⚙️ Sistema</h2>";
$version = phpversion();
$ext = extension_loaded('pdo_mysql') ? '✓' : '✗';
echo "<div class='success'>✓ PHP " . $version . "</div>";
echo "<div class='" . (extension_loaded('pdo_mysql') ? 'success' : 'error') . "'>$ext PDO MySQL</div>";

// Testar banco
echo "<h2>🗄️ Banco de Dados</h2>";
require_once __DIR__ . '/config.php';
try {
    $db = new App\Config\Database();
    echo "<div class='success'>✓ Conexão testada com sucesso</div>";
} catch (Exception $e) {
    echo "<div class='error'>✗ Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Links úteis
echo "<h2>🔗 Links Rápidos</h2>";
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/teste';
echo "<div class='grid'>";
echo "<div><a href='$baseUrl/public/index.php'>→ Página Inicial</a></div>";
echo "<div><a href='$baseUrl/public/login.php'>→ Login</a></div>";
echo "<div><a href='$baseUrl/public/register.php'>→ Cadastro</a></div>";
echo "<div><a href='$baseUrl/public/dashboard.php'>→ Dashboard</a></div>";
echo "</div>";

// Credenciais padrão
echo "<h2>🔐 Credenciais Padrão</h2>";
echo "<p><strong>Teste:</strong> teste@youremail.com / 12345678</p>";
echo "<p><strong>Admin:</strong> admin@youremail.com / admin123</p>";
echo "<p style='color:#fbbf24;'><strong>⚠️ Mude as senhas antes de ir para produção!</strong></p>";

echo "</div></body></html>";
