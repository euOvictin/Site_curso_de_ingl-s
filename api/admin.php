<?php
/**
 * API para operações administrativas
 */
require_once __DIR__ . '/../config.php';

use App\Utils\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Page;
use App\Config\Database;

header('Content-Type: application/json');

$auth = new Auth();
$auth->requireAdmin();

$currentUser = $auth->getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        // Operações de Usuário
        case 'create_user':
            $userModel = new User();
            
            if ($userModel->emailExists($_POST['email'])) {
                echo json_encode(['success' => false, 'error' => 'Email já existe']);
                exit;
            }
            
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => $_POST['role']
            ];
            
            $result = $userModel->create($data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'update_user':
            $userModel = new User();
            $id = $_POST['id'];
            
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'role' => $_POST['role']
            ];
            
            // Atualizar senha apenas se fornecida
            if (!empty($_POST['password'])) {
                $pdo = Database::getInstance()->getConnection();
                $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?");
                $result = $stmt->execute([
                    $data['name'],
                    $data['email'],
                    $data['role'],
                    password_hash($_POST['password'], PASSWORD_DEFAULT),
                    $id
                ]);
            } else {
                $result = $userModel->update($id, $data);
            }
            
            echo json_encode(['success' => $result]);
            break;
            
        case 'delete_user':
            $userModel = new User();
            $result = $userModel->delete($_POST['id']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'get_user':
            $userModel = new User();
            $user = $userModel->findById($_POST['id']);
            echo json_encode(['success' => true, 'data' => $user]);
            break;
            
        // Operações de Curso
        case 'create_course':
            $courseModel = new Course();
            
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'author_id' => $currentUser['id']
            ];
            
            $result = $courseModel->create($data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'update_course':
            $courseModel = new Course();
            $id = $_POST['id'];
            
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description']
            ];
            
            $result = $courseModel->update($id, $data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'delete_course':
            $courseModel = new Course();
            $result = $courseModel->delete($_POST['id']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'get_course':
            $courseModel = new Course();
            $course = $courseModel->findById($_POST['id']);
            echo json_encode(['success' => true, 'data' => $course]);
            break;
            
        // Operações de Aula
        case 'create_lesson':
            $lessonModel = new Lesson();
            
            $data = [
                'course_id' => $_POST['course_id'],
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'order_number' => $_POST['order_number']
            ];
            
            $result = $lessonModel->create($data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'update_lesson':
            $lessonModel = new Lesson();
            $id = $_POST['id'];
            
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'order_number' => $_POST['order_number']
            ];
            
            $result = $lessonModel->update($id, $data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'delete_lesson':
            $lessonModel = new Lesson();
            $result = $lessonModel->delete($_POST['id']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'get_lesson':
            $lessonModel = new Lesson();
            $lesson = $lessonModel->findById($_POST['id']);
            echo json_encode(['success' => true, 'data' => $lesson]);
            break;
            
        // Operações de Página
        case 'create_page':
            $pageModel = new Page();
            
            $data = [
                'title' => $_POST['title'],
                'slug' => $_POST['slug'],
                'content' => $_POST['content'],
                'author_id' => $currentUser['id']
            ];
            
            $result = $pageModel->create($data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'update_page':
            $pageModel = new Page();
            $id = $_POST['id'];
            
            $data = [
                'title' => $_POST['title'],
                'slug' => $_POST['slug'],
                'content' => $_POST['content']
            ];
            
            $result = $pageModel->update($id, $data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'delete_page':
            $pageModel = new Page();
            $result = $pageModel->delete($_POST['id']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'get_page':
            $pageModel = new Page();
            $page = $pageModel->findById($_POST['id']);
            echo json_encode(['success' => true, 'data' => $page]);
            break;
            
        // Upload de arquivos
        case 'upload_files':
            $uploadDir = __DIR__ . '/../uploads/';
            $results = [];
            
            if (!empty($_FILES['files'])) {
                foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
                    if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = $_FILES['files']['name'][$key];
                        $fileSize = $_FILES['files']['size'][$key];
                        $fileType = $_FILES['files']['type'][$key];
                        
                        // Determinar pasta baseada no tipo
                        $subDir = 'images/';
                        if (strpos($fileType, 'audio') !== false) {
                            $subDir = 'audio/';
                        } elseif (strpos($fileType, 'pdf') !== false) {
                            $subDir = 'pdf/';
                        }
                        
                        // Gerar nome único
                        $uniqueName = time() . '_' . $fileName;
                        $targetPath = $uploadDir . $subDir . $uniqueName;
                        
                        if (move_uploaded_file($tmpName, $targetPath)) {
                            $results[] = [
                                'success' => true,
                                'filename' => $uniqueName,
                                'path' => $subDir . $uniqueName,
                                'size' => $fileSize
                            ];
                        } else {
                            $results[] = [
                                'success' => false,
                                'filename' => $fileName,
                                'error' => 'Erro ao mover arquivo'
                            ];
                        }
                    }
                }
            }
            
            echo json_encode(['success' => true, 'results' => $results]);
            break;
            
        // Listar arquivos
        case 'list_files':
            $uploadDir = __DIR__ . '/../uploads/';
            $files = [];
            
            $directories = ['images', 'audio', 'pdf'];
            
            foreach ($directories as $dir) {
                $fullPath = $uploadDir . $dir . '/';
                if (is_dir($fullPath)) {
                    $dirFiles = scandir($fullPath);
                    foreach ($dirFiles as $file) {
                        if ($file !== '.' && $file !== '..') {
                            $filePath = $fullPath . $file;
                            $files[] = [
                                'name' => $file,
                                'type' => $dir,
                                'size' => filesize($filePath),
                                'modified' => filemtime($filePath),
                                'path' => 'uploads/' . $dir . '/' . $file
                            ];
                        }
                    }
                }
            }
            
            // Ordenar por data de modificação (mais recente primeiro)
            usort($files, function($a, $b) {
                return $b['modified'] - $a['modified'];
            });
            
            echo json_encode(['success' => true, 'files' => $files]);
            break;
            
        // Deletar arquivo
        case 'delete_file':
            $filePath = __DIR__ . '/../' . $_POST['path'];
            
            if (file_exists($filePath) && strpos(realpath($filePath), realpath(__DIR__ . '/../uploads/')) === 0) {
                $result = unlink($filePath);
                echo json_encode(['success' => $result]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Arquivo não encontrado']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'error' => 'Ação não reconhecida']);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>