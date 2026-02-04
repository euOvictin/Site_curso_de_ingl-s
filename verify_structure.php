#!/usr/bin/env php
<?php
/**
 * Verificação de Integridade do Projeto English Web
 * 
 * Este script verifica se todos os arquivos estão no lugar correto
 * e se a estrutura do projeto está correta.
 * 
 * Uso: php verify_structure.php
 */

// Cores para output
const GREEN = "\033[92m";
const RED = "\033[91m";
const YELLOW = "\033[93m";
const BLUE = "\033[94m";
const RESET = "\033[0m";

$projectRoot = __DIR__;
$errors = [];
$warnings = [];
$checks = [];

echo BLUE . "═══════════════════════════════════════════════════════════\n" . RESET;
echo BLUE . "  VERIFICAÇÃO DE INTEGRIDADE - English Web Project\n" . RESET;
echo BLUE . "═══════════════════════════════════════════════════════════\n\n" . RESET;

// 1. Verificar estrutura de pastas
echo BLUE . "[1] Verificando estrutura de pastas...\n" . RESET;

$requiredDirs = [
    'public',
    'public/assets',
    'public/assets/css',
    'public/assets/js',
    'api',
    'src',
    'src/Config',
    'src/Controllers',
    'src/Models',
    'src/Utils',
    'src/Views',
    'src/Views/admin',
    'database',
    'docs'
];

foreach ($requiredDirs as $dir) {
    $path = $projectRoot . '/' . str_replace('/', '\\', $dir);
    if (is_dir($path)) {
        echo "  " . GREEN . "✓" . RESET . " $dir/\n";
        $checks[] = true;
    } else {
        echo "  " . RED . "✗" . RESET . " $dir/ (FALTANDO)\n";
        $errors[] = "Diretório faltando: $dir";
        $checks[] = false;
    }
}

echo "\n";

// 2. Verificar arquivos PHP principais
echo BLUE . "[2] Verificando arquivos PHP principais...\n" . RESET;

$requiredPhpFiles = [
    'config.php' => 'Configuração central',
    'public/index.php' => 'Homepage',
    'public/login.php' => 'Página de login',
    'public/gerencia.php' => 'Painel administrativo',
    'api/login.php' => 'Endpoint de login',
    'api/register.php' => 'Endpoint de registro',
    'api/logout.php' => 'Endpoint de logout',
    'src/Config/Database.php' => 'Conexão com banco de dados',
    'src/Controllers/AuthController.php' => 'Controlador de autenticação',
    'src/Models/User.php' => 'Modelo de usuário',
    'src/Models/Page.php' => 'Modelo de página',
    'src/Models/Course.php' => 'Modelo de curso',
    'src/Models/Lesson.php' => 'Modelo de lição',
    'src/Utils/Auth.php' => 'Utilidades de autenticação',
    'src/Utils/Validator.php' => 'Validador de entrada',
];

foreach ($requiredPhpFiles as $file => $description) {
    $path = $projectRoot . '/' . str_replace('/', '\\', $file);
    if (file_exists($path)) {
        echo "  " . GREEN . "✓" . RESET . " $file ($description)\n";
        $checks[] = true;
    } else {
        echo "  " . RED . "✗" . RESET . " $file (FALTANDO) - $description\n";
        $errors[] = "Arquivo faltando: $file";
        $checks[] = false;
    }
}

echo "\n";

// 3. Verificar arquivos CSS
echo BLUE . "[3] Verificando arquivos CSS...\n" . RESET;

$cssFiles = [
    'public/assets/css/style.css',
    'public/assets/css/style-login.css',
    'public/assets/css/style-gerencia.css',
];

foreach ($cssFiles as $file) {
    $path = $projectRoot . '/' . str_replace('/', '\\', $file);
    if (file_exists($path)) {
        $size = filesize($path);
        echo "  " . GREEN . "✓" . RESET . " $file (" . number_format($size / 1024, 1) . " KB)\n";
        $checks[] = true;
    } else {
        echo "  " . RED . "✗" . RESET . " $file (FALTANDO)\n";
        $errors[] = "Arquivo CSS faltando: $file";
        $checks[] = false;
    }
}

echo "\n";

// 4. Verificar arquivos JavaScript
echo BLUE . "[4] Verificando arquivos JavaScript...\n" . RESET;

$jsFiles = [
    'public/assets/js/script.js',
    'public/assets/js/script-login.js',
    'public/assets/js/script-gerencia.js',
];

foreach ($jsFiles as $file) {
    $path = $projectRoot . '/' . str_replace('/', '\\', $file);
    if (file_exists($path)) {
        $size = filesize($path);
        echo "  " . GREEN . "✓" . RESET . " $file (" . number_format($size / 1024, 1) . " KB)\n";
        $checks[] = true;
    } else {
        echo "  " . RED . "✗" . RESET . " $file (FALTANDO)\n";
        $errors[] = "Arquivo JS faltando: $file";
        $checks[] = false;
    }
}

echo "\n";

// 5. Verificar arquivos de documentação
echo BLUE . "[5] Verificando documentação...\n" . RESET;

$docFiles = [
    'docs/STRUCTURE.md' => 'Documentação de arquitetura',
    'docs/README.md' => 'Guia de instalação',
    'docs/FINAL_STRUCTURE.md' => 'Estrutura final',
    '.env.example' => 'Template de variáveis de ambiente',
    '.gitignore' => 'Arquivo gitignore',
    'ORGANIZATION_SUMMARY.txt' => 'Resumo de organização',
];

foreach ($docFiles as $file => $description) {
    $path = $projectRoot . '/' . str_replace('/', '\\', $file);
    if (file_exists($path)) {
        echo "  " . GREEN . "✓" . RESET . " $file - $description\n";
        $checks[] = true;
    } else {
        echo "  " . YELLOW . "⚠" . RESET . " $file (Opcional) - $description\n";
        $warnings[] = "Arquivo opcional faltando: $file";
        $checks[] = false;
    }
}

echo "\n";

// 6. Verificar banco de dados
echo BLUE . "[6] Verificando arquivos de banco de dados...\n" . RESET;

$dbFiles = [
    'database/database.sql' => 'Schema do banco de dados',
];

foreach ($dbFiles as $file => $description) {
    $path = $projectRoot . '/' . str_replace('/', '\\', $file);
    if (file_exists($path)) {
        $size = filesize($path);
        echo "  " . GREEN . "✓" . RESET . " $file (" . number_format($size / 1024, 1) . " KB)\n";
        $checks[] = true;
    } else {
        echo "  " . RED . "✗" . RESET . " $file (FALTANDO) - $description\n";
        $errors[] = "Arquivo de BD faltando: $file";
        $checks[] = false;
    }
}

echo "\n";

// 7. Resumo final
echo BLUE . "═══════════════════════════════════════════════════════════\n" . RESET;
echo BLUE . "  RESUMO DA VERIFICAÇÃO\n" . RESET;
echo BLUE . "═══════════════════════════════════════════════════════════\n\n" . RESET;

$total = count($checks);
$passed = array_sum($checks);
$failed = $total - $passed;
$percentage = ($passed / $total) * 100;

echo "Total de verificações: " . GREEN . "$total" . RESET . "\n";
echo "Verificações passadas: " . GREEN . "$passed" . RESET . "\n";
echo "Verificações falhadas: " . ($failed > 0 ? RED : GREEN) . "$failed" . RESET . "\n";
echo "Taxa de sucesso: " . ($percentage >= 95 ? GREEN : YELLOW) . number_format($percentage, 1) . "%" . RESET . "\n";

echo "\n";

if (!empty($errors)) {
    echo RED . "❌ ERROS ENCONTRADOS:\n" . RESET;
    foreach ($errors as $i => $error) {
        echo "  " . ($i + 1) . ". " . $error . "\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo YELLOW . "⚠ AVISOS (não críticos):\n" . RESET;
    foreach ($warnings as $i => $warning) {
        echo "  " . ($i + 1) . ". " . $warning . "\n";
    }
    echo "\n";
}

// Status final
echo BLUE . "═══════════════════════════════════════════════════════════\n" . RESET;

if (empty($errors)) {
    echo GREEN . "✓ ESTRUTURA VERIFICADA COM SUCESSO!" . RESET . "\n";
    echo GREEN . "O projeto está pronto para uso!" . RESET . "\n";
    echo GREEN . "✓ Próximo passo: importar database.sql em phpMyAdmin" . RESET . "\n";
    exit(0);
} else {
    echo RED . "✗ ERROS ENCONTRADOS NA ESTRUTURA" . RESET . "\n";
    echo RED . "Por favor, corrija os erros acima antes de prosseguir." . RESET . "\n";
    exit(1);
}
