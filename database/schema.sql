-- Deleta banco existente
DROP DATABASE IF EXISTS english_web;

-- Cria banco de dados
CREATE DATABASE english_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE english_web;

-- Tabela de usuários com níveis de permissão
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela para conteúdo/páginas
CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela para cursos/aulas
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela para aulas/lessons
CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content LONGTEXT NOT NULL,
    order_number INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Inserir usuários padrão (IMPORTANTE: ajuste as senhas antes de usar em produção!)
-- Credenciais de teste:
-- Email: teste@youremail.com | Senha: 12345678
-- Email: admin@youremail.com | Senha: admin123
INSERT INTO users (name, email, password, role) VALUES 
('Teste User', 'teste@youremail.com', '$2y$10$coknNNT7i6Y7tJbASS.Ma.XitsLXUM/eghWC1oGx3YyBOBByLmTJe', 'user'),
('Admin', 'admin@youremail.com', '$2y$10$lGRQP057Jrgqyp5BuwogXuFXAbSNtTmsOKLWpV/NEVRp9raRVmKgO', 'admin');

-- Inserir página de exemplo
INSERT INTO pages (title, slug, content, author_id) VALUES 
('Bem-vindo', 'bem-vindo', 'Bem-vindo ao English Web! Este é um site para aprender inglês.', 1);

-- Inserir curso de exemplo
INSERT INTO courses (title, description, author_id) VALUES 
('English Basics', 'Aprenda os conceitos básicos de inglês', 2);

-- Inserir lição de exemplo
INSERT INTO lessons (course_id, title, content, order_number) VALUES 
(1, 'Hello World', 'Primeira lição de inglês básico', 1);

-- Índices para performance
CREATE INDEX idx_email ON users(email);
CREATE INDEX idx_slug ON pages(slug);
CREATE INDEX idx_course_id ON lessons(course_id);
CREATE INDEX idx_author_id ON pages(author_id);
