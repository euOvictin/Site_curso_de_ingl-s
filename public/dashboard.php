<?php
/**
 * Dashboard do Usuário
 */
require_once __DIR__ . '/../config.php';

use App\Utils\Auth;
use App\Models\Course;

$auth = new Auth();
$auth->requireLogin();

$user = $auth->getCurrentUser();
$courseModel = new Course();
$courses = $courseModel->getAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - English Web</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .dashboard-header {
            padding: 2rem 1.5rem;
            background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.98));
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }

        .dashboard-container {
            max-width: 1120px;
            margin: 0 auto;
        }

        .user-greeting {
            margin: 0;
            font-size: 1.5rem;
        }

        .courses-section {
            max-width: 1120px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .course-card {
            padding: 1.5rem;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.98));
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.7);
            transition: transform 0.35s ease-out, box-shadow 0.35s ease-out, border-color 0.35s ease-out;
            cursor: pointer;
        }

        .course-card:hover {
            transform: translateY(-6px);
            border-color: rgba(56, 189, 248, 0.7);
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.95);
        }

        .course-card h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.1rem;
        }

        .course-card p {
            margin: 0 0 1rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .course-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            background: rgba(56, 189, 248, 0.2);
            color: var(--accent-2);
            font-size: 0.8rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 1rem;
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
            background: linear-gradient(135deg, var(--accent-2), var(--accent-3));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--bg-dark);
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
            color: var(--text-muted);
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
                <a href="<?php echo BASE_URL; ?>/public/dashboard.php" class="nav-link active">Dashboard</a>
                <?php if ($auth->isAdmin()): ?>
                    <a href="<?php echo BASE_URL; ?>/public/gerencia.php" class="nav-link">Gerência</a>
                <?php endif; ?>
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
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="user-details">
                            <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                            <div class="user-role"><?php echo ucfirst($user['role']); ?></div>
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
                    <?php if ($auth->isAdmin()): ?>
                        <a href="<?php echo BASE_URL; ?>/public/gerencia.php" class="dropdown-item">
                            <i class="fa-solid fa-cogs"></i>
                            Gerência
                        </a>
                    <?php endif; ?>
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
        <div class="dashboard-header">
            <div class="dashboard-container">
                <h1 class="user-greeting">Bem-vindo, <?php echo htmlspecialchars($user['name']); ?>! 👋</h1>
                <p style="color: var(--text-muted); margin: 0.5rem 0 0 0;">Escolha um curso para começar a aprender inglês</p>
            </div>
        </div>

        <section class="courses-section">
            <h2>Cursos Disponíveis</h2>
            
            <?php if (empty($courses)): ?>
                <div class="empty-state">
                    <p>Nenhum curso disponível no momento.</p>
                    <p>Volte mais tarde para novos cursos!</p>
                </div>
            <?php else: ?>
                <div class="courses-grid">
                    <?php foreach ($courses as $course): ?>
                        <div class="course-card">
                            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
                            <span class="course-badge"><?php echo $course['lesson_count']; ?> aulas</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 English Web. Todos os direitos reservados.</p>
        </div>
    </footer>

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
    </script>
</body>
</html>
