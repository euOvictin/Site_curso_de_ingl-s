<?php
/**
 * Página de Cadastro
 */
require_once __DIR__ . '/../config.php';

use App\Utils\Auth;

$auth = new Auth();

// Se já está logado, redireciona para dashboard
if ($auth->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/public/dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - English Web</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 2rem;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), rgba(15, 23, 42, 0.98));
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.7rem;
            border-radius: 8px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            background: rgba(15, 23, 42, 0.9);
            color: var(--text-main);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus {
            border-color: var(--accent-2);
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        }

        .auth-button {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(120deg, var(--accent-2), var(--accent-3));
            color: #0b1120;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(56, 189, 248, 0.35);
        }

        .auth-links {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .auth-links a {
            color: var(--accent-2);
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }

        .error-message.show {
            display: block;
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
                <a href="<?php echo BASE_URL; ?>/public/login.php" class="nav-link">Login</a>
            </nav>

            <!-- Ícone de perfil redondo -->
            <div class="navbar-profile">
                <div class="profile-icon" id="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <!-- Menu dropdown do perfil -->
                <div class="profile-dropdown" id="profile-dropdown">
                    <a href="<?php echo BASE_URL; ?>/public/index.php" class="dropdown-item">
                        <i class="fa-solid fa-home"></i>
                        Início
                    </a>
                    <a href="<?php echo BASE_URL; ?>/public/login.php" class="dropdown-item">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Login
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo BASE_URL; ?>/public/register.php" class="dropdown-item">
                        <i class="fa-solid fa-user-plus"></i>
                        Cadastro
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
        <div class="auth-container">
            <h1 style="text-align: center; margin-top: 0;">Cadastro</h1>
            
            <div class="error-message" id="error-message"></div>

            <form id="register-form" onsubmit="handleRegister(event)">
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirme a Senha</label>
                    <input type="password" id="password-confirm" name="password-confirm" required>
                </div>

                <button type="submit" class="auth-button">Cadastrar</button>
            </form>

            <div class="auth-links">
                <p>Já tem conta? <a href="<?php echo BASE_URL; ?>/public/login.php">Faça login aqui</a></p>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 English Web. Todos os direitos reservados.</p>
        </div>
    </footer>

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

        function handleRegister(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password-confirm').value;
            const errorMsg = document.getElementById('error-message');

            // Validações
            if (!name || !email || !password || !passwordConfirm) {
                showError('Preencha todos os campos');
                return;
            }

            if (password !== passwordConfirm) {
                showError('As senhas não conferem');
                return;
            }

            if (password.length < 6) {
                showError('A senha deve ter no mínimo 6 caracteres');
                return;
            }

            // Aqui você enviaria os dados para a API de cadastro
            console.log('Cadastro:', { name, email, password });
            
            // Simular sucesso
            alert('Cadastro realizado com sucesso! Faça login agora.');
            window.location.href = '<?php echo BASE_URL; ?>/public/login.php';
        }

        function showError(message) {
            const errorMsg = document.getElementById('error-message');
            errorMsg.textContent = message;
            errorMsg.classList.add('show');
            
            setTimeout(() => {
                errorMsg.classList.remove('show');
            }, 5000);
        }
    </script>
</body>
</html>
