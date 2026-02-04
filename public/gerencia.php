<?php
/**
 * Página de Gerenciamento - Admin
 */
require_once __DIR__ . '/../config.php';

use App\Utils\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Page;

$auth = new Auth();
$auth->requireAdmin();

$user = $auth->getCurrentUser();
$userModel = new User();
$courseModel = new Course();
$lessonModel = new Lesson();
$pageModel = new Page();

// Estatísticas
$totalUsers = $userModel->count();
$totalCourses = $courseModel->count();
$totalLessons = $lessonModel->count();
$totalPages = $pageModel->count();

// Dados para as abas
$users = $userModel->getAll();
$courses = $courseModel->getAll();
$lessons = $lessonModel->getAll();
$pages = $pageModel->getAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerência - English Web</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .admin-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.98));
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.7);
        }

        .stat-card h3 {
            margin: 0 0 0.5rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-2);
            margin: 0;
        }

        /* Tabs */
        .tabs-container {
            margin: 2rem 0;
        }

        .tabs-nav {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }

        .tab-button {
            padding: 1rem 1.5rem;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
            font-size: 1rem;
            font-weight: 500;
        }

        .tab-button.active {
            background: rgba(37, 99, 235, 0.2);
            color: var(--accent-2);
            border-bottom: 2px solid var(--accent-2);
        }

        .tab-button:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--text-main);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.98));
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.7);
            margin-bottom: 2rem;
        }

        .data-table th {
            background: rgba(37, 99, 235, 0.4);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.15);
            color: var(--text-main);
        }

        .data-table tr:hover {
            background: rgba(37, 99, 235, 0.15);
        }

        .role-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            font-size: 0.8rem;
        }

        .role-admin {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .role-user {
            background: rgba(56, 189, 248, 0.2);
            color: var(--accent-2);
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--accent-2);
            color: var(--bg-dark);
        }

        .btn-primary:hover {
            background: var(--accent-1);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.8);
            color: white;
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 1);
        }

        .btn-edit {
            background: rgba(34, 197, 94, 0.8);
            color: white;
        }

        .btn-edit:hover {
            background: rgba(34, 197, 94, 1);
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        /* Forms */
        .form-container {
            background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 18px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.7);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 8px;
            background: rgba(15, 23, 42, 0.5);
            color: var(--text-main);
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-2);
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Upload area */
        .upload-area {
            border: 2px dashed rgba(148, 163, 184, 0.25);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background: rgba(15, 23, 42, 0.3);
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: var(--accent-2);
            background: rgba(37, 99, 235, 0.1);
        }

        .upload-area.dragover {
            border-color: var(--accent-2);
            background: rgba(37, 99, 235, 0.2);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--bg-dark);
            border-radius: 18px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .modal-close:hover {
            color: var(--text-main);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tabs-nav {
                flex-wrap: wrap;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .data-table {
                font-size: 0.9rem;
            }
            
            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }
        }

        /* Dropdown personalizado com info do usuário */
        .dropdown-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
            margin-bottom: 0.5rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #fca5a5;
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="<?php echo BASE_URL; ?>/public/index.php" class="navbar-logo">
                <span class="logo-symbol">YE</span>
                <span class="logo-text">Your English</span>
            </a>

            <nav class="navbar-links" id="navbar-links">
                <a href="<?php echo BASE_URL; ?>/public/index.php" class="nav-link">Início</a>
                <a href="<?php echo BASE_URL; ?>/public/dashboard.php" class="nav-link">Dashboard</a>
                <a href="<?php echo BASE_URL; ?>/public/gerencia.php" class="nav-link active">Gerência</a>
            </nav>

            <!-- Ícone de perfil redondo -->
            <div class="navbar-profile">
                <div class="profile-icon" id="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <!-- Menu dropdown do perfil -->
                <div class="profile-dropdown" id="profile-dropdown">
                    <div class="dropdown-user-info">
                        <div class="user-avatar">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div class="user-details">
                            <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                            <div class="user-role">Administrador</div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo BASE_URL; ?>/public/index.php" class="dropdown-item">
                        <i class="fa-solid fa-home"></i>
                        Início
                    </a>
                    <a href="<?php echo BASE_URL; ?>/public/dashboard.php" class="dropdown-item">
                        <i class="fa-solid fa-chart-line"></i>
                        Dashboard
                    </a>
                    <a href="<?php echo BASE_URL; ?>/public/gerencia.php" class="dropdown-item">
                        <i class="fa-solid fa-cogs"></i>
                        Gerência
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa-solid fa-gear"></i>
                        Configurações
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo BASE_URL; ?>/api/logout.php" class="dropdown-item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Sair
                    </a>
                </div>
            </div>

            <!-- Botão hamburguer para mobile -->
            <button class="navbar-toggle" id="navbar-toggle" aria-label="Abrir menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h1>Painel de Gerência</h1>
            <p style="color: var(--text-muted);">Bem-vindo, <?php echo htmlspecialchars($user['name']); ?>!</p>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total de Usuários</h3>
                    <p class="stat-number"><?php echo $totalUsers; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total de Cursos</h3>
                    <p class="stat-number"><?php echo $totalCourses; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total de Aulas</h3>
                    <p class="stat-number"><?php echo $totalLessons; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total de Páginas</h3>
                    <p class="stat-number"><?php echo $totalPages; ?></p>
                </div>
            </div>

            <div class="tabs-container">
                <div class="tabs-nav">
                    <button class="tab-button active" data-tab="users">👥 Usuários</button>
                    <button class="tab-button" data-tab="courses">📚 Cursos</button>
                    <button class="tab-button" data-tab="lessons">📖 Aulas</button>
                    <button class="tab-button" data-tab="pages">📄 Páginas</button>
                    <button class="tab-button" data-tab="uploads">📁 Uploads</button>
                </div>

                <!-- Tab: Usuários -->
                <div class="tab-content active" id="users">
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="openModal('userModal')">➕ Novo Usuário</button>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Função</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?php echo $u['id']; ?></td>
                                    <td><?php echo htmlspecialchars($u['name']); ?></td>
                                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                                    <td>
                                        <span class="role-badge role-<?php echo $u['role']; ?>">
                                            <?php echo ucfirst($u['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($u['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-edit btn-small" onclick="editUser(<?php echo $u['id']; ?>)">✏️</button>
                                        <button class="btn btn-danger btn-small" onclick="deleteItem('user', <?php echo $u['id']; ?>)">🗑️</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Cursos -->
                <div class="tab-content" id="courses">
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="openModal('courseModal')">➕ Novo Curso</button>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Autor</th>
                                <th>Data de Criação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?php echo $course['id']; ?></td>
                                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($course['description'], 0, 100)) . '...'; ?></td>
                                    <td><?php echo htmlspecialchars($course['author_name'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($course['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-edit btn-small" onclick="editCourse(<?php echo $course['id']; ?>)">✏️</button>
                                        <button class="btn btn-danger btn-small" onclick="deleteItem('course', <?php echo $course['id']; ?>)">🗑️</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Aulas -->
                <div class="tab-content" id="lessons">
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="openModal('lessonModal')">➕ Nova Aula</button>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Curso</th>
                                <th>Ordem</th>
                                <th>Data de Criação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lessons as $lesson): ?>
                                <tr>
                                    <td><?php echo $lesson['id']; ?></td>
                                    <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                                    <td><?php echo htmlspecialchars($lesson['course_title'] ?? 'N/A'); ?></td>
                                    <td><?php echo $lesson['order_number']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($lesson['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-edit btn-small" onclick="editLesson(<?php echo $lesson['id']; ?>)">✏️</button>
                                        <button class="btn btn-danger btn-small" onclick="deleteItem('lesson', <?php echo $lesson['id']; ?>)">🗑️</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Páginas -->
                <div class="tab-content" id="pages">
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="openModal('pageModal')">➕ Nova Página</button>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Slug</th>
                                <th>Autor</th>
                                <th>Data de Criação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $page): ?>
                                <tr>
                                    <td><?php echo $page['id']; ?></td>
                                    <td><?php echo htmlspecialchars($page['title']); ?></td>
                                    <td><?php echo htmlspecialchars($page['slug']); ?></td>
                                    <td><?php echo htmlspecialchars($page['author_name'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($page['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-edit btn-small" onclick="editPage(<?php echo $page['id']; ?>)">✏️</button>
                                        <button class="btn btn-danger btn-small" onclick="deleteItem('page', <?php echo $page['id']; ?>)">🗑️</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Uploads -->
                <div class="tab-content" id="uploads">
                    <div class="form-container">
                        <h3>Gerenciar Arquivos</h3>
                        
                        <div class="upload-area" id="uploadArea">
                            <p>📁 Arraste arquivos aqui ou clique para selecionar</p>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">
                                Tipos aceitos: PDF, Imagens (JPG, PNG, GIF), Áudio (MP3, WAV)
                            </p>
                            <input type="file" id="fileInput" multiple accept=".pdf,.jpg,.jpeg,.png,.gif,.mp3,.wav" style="display: none;">
                        </div>
                        
                        <div id="uploadProgress" style="display: none;">
                            <div style="background: rgba(37, 99, 235, 0.2); border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                                <div id="progressBar" style="background: var(--accent-2); height: 4px; border-radius: 2px; width: 0%; transition: width 0.3s;"></div>
                                <p id="progressText" style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Enviando...</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-container">
                        <h3>Arquivos Existentes</h3>
                        <div id="filesList">
                            <!-- Lista de arquivos será carregada via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 English Web. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Modais -->
    <!-- Modal: Usuário -->
    <div class="modal" id="userModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="userModalTitle">Novo Usuário</h3>
                <button class="modal-close" onclick="closeModal('userModal')">&times;</button>
            </div>
            <form id="userForm">
                <input type="hidden" id="userId" name="id">
                <div class="form-group">
                    <label for="userName">Nome:</label>
                    <input type="text" id="userName" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <input type="email" id="userEmail" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="userPassword">Senha:</label>
                    <input type="password" id="userPassword" name="password" class="form-control">
                    <small style="color: var(--text-muted);">Deixe em branco para manter a senha atual (apenas edição)</small>
                </div>
                <div class="form-group">
                    <label for="userRole">Função:</label>
                    <select id="userRole" name="role" class="form-control" required>
                        <option value="user">Usuário</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn" onclick="closeModal('userModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Curso -->
    <div class="modal" id="courseModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="courseModalTitle">Novo Curso</h3>
                <button class="modal-close" onclick="closeModal('courseModal')">&times;</button>
            </div>
            <form id="courseForm">
                <input type="hidden" id="courseId" name="id">
                <div class="form-group">
                    <label for="courseTitle">Título:</label>
                    <input type="text" id="courseTitle" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="courseDescription">Descrição:</label>
                    <textarea id="courseDescription" name="description" class="form-control" required></textarea>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn" onclick="closeModal('courseModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Aula -->
    <div class="modal" id="lessonModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="lessonModalTitle">Nova Aula</h3>
                <button class="modal-close" onclick="closeModal('lessonModal')">&times;</button>
            </div>
            <form id="lessonForm">
                <input type="hidden" id="lessonId" name="id">
                <div class="form-group">
                    <label for="lessonCourse">Curso:</label>
                    <select id="lessonCourse" name="course_id" class="form-control" required>
                        <option value="">Selecione um curso</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lessonTitle">Título:</label>
                    <input type="text" id="lessonTitle" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lessonContent">Conteúdo:</label>
                    <textarea id="lessonContent" name="content" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="lessonOrder">Ordem:</label>
                    <input type="number" id="lessonOrder" name="order_number" class="form-control" min="1" required>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn" onclick="closeModal('lessonModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Página -->
    <div class="modal" id="pageModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="pageModalTitle">Nova Página</h3>
                <button class="modal-close" onclick="closeModal('pageModal')">&times;</button>
            </div>
            <form id="pageForm">
                <input type="hidden" id="pageId" name="id">
                <div class="form-group">
                    <label for="pageTitle">Título:</label>
                    <input type="text" id="pageTitle" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pageSlug">Slug (URL):</label>
                    <input type="text" id="pageSlug" name="slug" class="form-control" required>
                    <small style="color: var(--text-muted);">Ex: minha-pagina (sem espaços ou caracteres especiais)</small>
                </div>
                <div class="form-group">
                    <label for="pageContent">Conteúdo:</label>
                    <textarea id="pageContent" name="content" class="form-control" required></textarea>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn" onclick="closeModal('pageModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="./assets/js/script.js"></script>
    <script>
        // Dropdown do perfil
        const profileIcon = document.getElementById('profile-icon');
        const profileDropdown = document.getElementById('profile-dropdown');
        const navbarToggle = document.getElementById('navbar-toggle');
        const navbarLinks = document.getElementById('navbar-links');

        profileIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('open');
        });

        // Menu mobile
        navbarToggle.addEventListener('click', () => {
            navbarToggle.classList.toggle('active');
            navbarLinks.classList.toggle('open');
        });

        // Fechar dropdown ao clicar fora
        document.addEventListener('click', () => {
            profileDropdown.classList.remove('open');
        });

        // Gerenciamento de Tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;
                
                // Remove active de todos os botões e conteúdos
                document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Adiciona active ao botão e conteúdo clicado
                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
                
                // Carregar arquivos quando a aba de uploads for ativada
                if (tabId === 'uploads') {
                    loadFilesList();
                }
            });
        });

        // Gerenciamento de Modais
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            // Reset form
            const form = document.querySelector(`#${modalId} form`);
            if (form) {
                form.reset();
                // Reset hidden ID field
                const idField = form.querySelector('input[type="hidden"]');
                if (idField) idField.value = '';
            }
        }

        // Fechar modal clicando fora
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });

        // Funções CRUD
        async function deleteItem(type, id) {
            if (!confirm('Tem certeza que deseja excluir este item?')) return;
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=delete_${type}&id=${id}`
                });
                
                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Erro ao excluir item: ' + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert('Erro ao excluir item: ' + error.message);
            }
        }

        // Funções de edição
        async function editUser(id) {
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=get_user&id=${id}`
                });
                
                const result = await response.json();
                if (result.success) {
                    const user = result.data;
                    document.getElementById('userId').value = user.id;
                    document.getElementById('userName').value = user.name;
                    document.getElementById('userEmail').value = user.email;
                    document.getElementById('userRole').value = user.role;
                    document.getElementById('userModalTitle').textContent = 'Editar Usuário';
                    openModal('userModal');
                }
            } catch (error) {
                alert('Erro ao carregar dados do usuário');
            }
        }

        async function editCourse(id) {
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=get_course&id=${id}`
                });
                
                const result = await response.json();
                if (result.success) {
                    const course = result.data;
                    document.getElementById('courseId').value = course.id;
                    document.getElementById('courseTitle').value = course.title;
                    document.getElementById('courseDescription').value = course.description;
                    document.getElementById('courseModalTitle').textContent = 'Editar Curso';
                    openModal('courseModal');
                }
            } catch (error) {
                alert('Erro ao carregar dados do curso');
            }
        }

        async function editLesson(id) {
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=get_lesson&id=${id}`
                });
                
                const result = await response.json();
                if (result.success) {
                    const lesson = result.data;
                    document.getElementById('lessonId').value = lesson.id;
                    document.getElementById('lessonCourse').value = lesson.course_id;
                    document.getElementById('lessonTitle').value = lesson.title;
                    document.getElementById('lessonContent').value = lesson.content;
                    document.getElementById('lessonOrder').value = lesson.order_number;
                    document.getElementById('lessonModalTitle').textContent = 'Editar Aula';
                    openModal('lessonModal');
                }
            } catch (error) {
                alert('Erro ao carregar dados da aula');
            }
        }

        async function editPage(id) {
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=get_page&id=${id}`
                });
                
                const result = await response.json();
                if (result.success) {
                    const page = result.data;
                    document.getElementById('pageId').value = page.id;
                    document.getElementById('pageTitle').value = page.title;
                    document.getElementById('pageSlug').value = page.slug;
                    document.getElementById('pageContent').value = page.content;
                    document.getElementById('pageModalTitle').textContent = 'Editar Página';
                    openModal('pageModal');
                }
            } catch (error) {
                alert('Erro ao carregar dados da página');
            }
        }

        // Submissão de formulários
        document.getElementById('userForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const isEdit = formData.get('id') !== '';
            
            formData.append('action', isEdit ? 'update_user' : 'create_user');
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    closeModal('userModal');
                    location.reload();
                } else {
                    alert('Erro ao salvar usuário: ' + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert('Erro ao salvar usuário: ' + error.message);
            }
        });

        document.getElementById('courseForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const isEdit = formData.get('id') !== '';
            
            formData.append('action', isEdit ? 'update_course' : 'create_course');
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    closeModal('courseModal');
                    location.reload();
                } else {
                    alert('Erro ao salvar curso: ' + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert('Erro ao salvar curso: ' + error.message);
            }
        });

        document.getElementById('lessonForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const isEdit = formData.get('id') !== '';
            
            formData.append('action', isEdit ? 'update_lesson' : 'create_lesson');
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    closeModal('lessonModal');
                    location.reload();
                } else {
                    alert('Erro ao salvar aula: ' + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert('Erro ao salvar aula: ' + error.message);
            }
        });

        document.getElementById('pageForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const isEdit = formData.get('id') !== '';
            
            formData.append('action', isEdit ? 'update_page' : 'create_page');
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    closeModal('pageModal');
                    location.reload();
                } else {
                    alert('Erro ao salvar página: ' + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert('Erro ao salvar página: ' + error.message);
            }
        });

        // Upload de arquivos
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            const formData = new FormData();
            formData.append('action', 'upload_files');
            
            for (let file of files) {
                formData.append('files[]', file);
            }
            
            uploadFiles(formData);
        }

        async function uploadFiles(formData) {
            const progressDiv = document.getElementById('uploadProgress');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            
            progressDiv.style.display = 'block';
            progressBar.style.width = '0%';
            progressText.textContent = 'Enviando...';
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Upload concluído!';
                    
                    setTimeout(() => {
                        progressDiv.style.display = 'none';
                        loadFilesList();
                    }, 1000);
                } else {
                    progressText.textContent = 'Erro no upload';
                }
                
            } catch (error) {
                progressText.textContent = 'Erro no upload: ' + error.message;
            }
        }

        async function loadFilesList() {
            const filesList = document.getElementById('filesList');
            filesList.innerHTML = '<p style="color: var(--text-muted);">Carregando arquivos...</p>';
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=list_files'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    if (result.files.length === 0) {
                        filesList.innerHTML = '<p style="color: var(--text-muted);">Nenhum arquivo encontrado.</p>';
                        return;
                    }
                    
                    let html = '<div style="display: grid; gap: 1rem;">';
                    
                    result.files.forEach(file => {
                        const fileSize = (file.size / 1024).toFixed(1) + ' KB';
                        const fileDate = new Date(file.modified * 1000).toLocaleString('pt-BR');
                        const typeIcon = getFileIcon(file.type);
                        
                        html += `
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: rgba(37, 99, 235, 0.1); border-radius: 8px; border: 1px solid rgba(148, 163, 184, 0.25);">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <span style="font-size: 1.5rem;">${typeIcon}</span>
                                    <div>
                                        <div style="font-weight: 500;">${file.name}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">${file.type} • ${fileSize} • ${fileDate}</div>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="../${file.path}" target="_blank" class="btn btn-primary btn-small">👁️ Ver</a>
                                    <button onclick="deleteFile('${file.path}')" class="btn btn-danger btn-small">🗑️</button>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    filesList.innerHTML = html;
                } else {
                    filesList.innerHTML = '<p style="color: var(--text-muted);">Erro ao carregar arquivos.</p>';
                }
                
            } catch (error) {
                filesList.innerHTML = '<p style="color: var(--text-muted);">Erro ao carregar arquivos.</p>';
            }
        }

        function getFileIcon(type) {
            switch (type) {
                case 'images': return '🖼️';
                case 'audio': return '🎵';
                case 'pdf': return '📄';
                default: return '📁';
            }
        }

        async function deleteFile(path) {
            if (!confirm('Tem certeza que deseja excluir este arquivo?')) return;
            
            try {
                const response = await fetch('../api/admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=delete_file&path=${encodeURIComponent(path)}`
                });
                
                const result = await response.json();
                if (result.success) {
                    loadFilesList();
                } else {
                    alert('Erro ao excluir arquivo: ' + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert('Erro ao excluir arquivo: ' + error.message);
            }
        }

        // Auto-gerar slug a partir do título
        document.getElementById('pageTitle').addEventListener('input', (e) => {
            const slug = e.target.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('pageSlug').value = slug;
        });

        // Validação de senha
        document.getElementById('userPassword').addEventListener('input', (e) => {
            const password = e.target.value;
            const isEdit = document.getElementById('userId').value !== '';
            
            if (!isEdit && password.length < 6) {
                e.target.setCustomValidity('A senha deve ter pelo menos 6 caracteres');
            } else {
                e.target.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
