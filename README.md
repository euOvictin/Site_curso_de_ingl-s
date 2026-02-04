# English Web - Sistema de Aprendizado de Inglês Online

## 📋 Descrição
English Web é uma aplicação web profissional para ensino de inglês online, desenvolvida em PHP com uma arquitetura MVC bem organizada.

## 📁 Estrutura do Projeto

```
teste/
├── api/                          # Endpoints da API
│   ├── login.php                 # Endpoint de login
│   ├── register.php              # Endpoint de cadastro
│   └── logout.php                # Endpoint de logout
├── config.php                    # Arquivo de configuração principal
├── database/                     # Scripts de banco de dados
│   └── schema.sql               # Schema do banco de dados
├── public/                       # Arquivos públicos (acessíveis via web)
│   ├── index.php                 # Página inicial
│   ├── login.php                 # Página de login
│   ├── register.php              # Página de cadastro
│   ├── dashboard.php             # Dashboard do usuário
│   ├── gerencia.php              # Painel de gerência (admin)
│   └── assets/
│       ├── css/
│       │   └── style.css         # Estilos CSS
│       ├── js/
│       │   └── script.js         # Scripts JavaScript
│       └── uploads/
│           ├── images/           # Pasta de imagens
│           ├── audio/            # Pasta de áudio
│           └── pdf/              # Pasta de PDF
├── src/                          # Código-fonte (não acessível via web)
│   ├── Config/
│   │   └── Database.php          # Classe de conexão com banco
│   ├── Controllers/
│   │   └── AuthController.php    # Controller de autenticação
│   ├── Models/
│   │   ├── User.php              # Model de usuários
│   │   ├── Course.php            # Model de cursos
│   │   ├── Lesson.php            # Model de aulas
│   │   └── Page.php              # Model de páginas
│   ├── Utils/
│   │   ├── Auth.php              # Utilitário de autenticação
│   │   └── Validator.php         # Utilitário de validação
│   └── Views/                    # Views (templates)
└── .htaccess                     # Configuração Apache (opcional)
```

## 🚀 Como Instalar

### 1. Pré-requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Apache com mod_rewrite ativado (opcional)
- Composer (opcional, para gerenciar dependências futuras)

### 2. Passos de Instalação

#### a) Clonar/Extrair o projeto
```bash
# O projeto já deve estar em c:\xampp\htdocs\teste\
```

#### b) Configurar o Banco de Dados

1. Abra o phpMyAdmin (http://localhost/phpmyadmin)
2. Crie um banco de dados chamado `english_web` ou importe o arquivo `database/schema.sql`:

```bash
# Via linha de comando
mysql -u root -p < database/schema.sql
```

#### c) Configurar as Credenciais do Banco

Edite o arquivo `config.php` e ajuste as constantes:

```php
define('DB_HOST', 'localhost');    // Host do MySQL
define('DB_NAME', 'english_web');  // Nome do banco
define('DB_USER', 'root');         // Usuário MySQL
define('DB_PASS', '');             // Senha MySQL (vazio para localhost)
```

#### d) Configurar as Permissões das Pastas

Certifique-se de que a pasta `public/assets/uploads` tem permissões de escrita:

```bash
# Windows (via Command Prompt ou PowerShell como Admin)
icacls "c:\xampp\htdocs\teste\public\assets\uploads" /grant:r "%USERNAME%":F /T

# Linux/Mac
chmod 755 public/assets/uploads
chmod 755 public/assets/uploads/*
```

## 🌐 Como Usar

### 1. Acessar a Aplicação

Abra seu navegador e acesse:
```
http://localhost/teste/public/index.php
```

Ou se estiver usando um virtual host:
```
http://teste.local/public/index.php
```

### 2. Credenciais Padrão de Teste

Usuário:
- Email: `teste@youremail.com`
- Senha: `12345678`

Admin:
- Email: `admin@youremail.com`
- Senha: `admin123`

**⚠️ IMPORTANTE: Mude essas senhas antes de usar em produção!**

### 3. Principais Páginas

| URL | Descrição |
|-----|-----------|
| `/public/index.php` | Página inicial |
| `/public/login.php` | Login |
| `/public/register.php` | Cadastro |
| `/public/dashboard.php` | Dashboard do usuário (requer login) |
| `/public/gerencia.php` | Painel administrativo (requer ser admin) |

## 🔐 Segurança

### Dados Sensíveis
- Nunca commite arquivos com `config.php` com credenciais reais
- Use variáveis de ambiente em produção
- Senhas são hashadas com bcrypt

### Recomendações
1. Altere as credenciais padrão
2. Use HTTPS em produção
3. Mantenha o PHP e MySQL atualizados
4. Implemente validação extra em formulários
5. Use prepared statements (já implementado)

## 💾 Gerenciamento de Banco de Dados

### Backup
```bash
mysqldump -u root -p english_web > backup.sql
```

### Restaurar
```bash
mysql -u root -p english_web < backup.sql
```

### Resetar para Estado Padrão
```bash
mysql -u root -p < database/schema.sql
```

## 🐛 Troubleshooting

### Erro: "Erro de conexão ao banco de dados"
- Verifique se o MySQL está rodando
- Confirme as credenciais em `config.php`
- Confirme que o banco `english_web` foi criado

### Erro: "Arquivo não encontrado"
- Verifique se a URL está correta
- Confirme que o arquivo existe na pasta `public/`

### Erro: "Permissão negada para upload"
- Verifique as permissões da pasta `public/assets/uploads`
- Reinicie o Apache (XAMPP)

### Sessão não persiste
- Verifique se `session_start()` é chamado no `config.php`
- Limpe os cookies do navegador
- Verifique as configurações de cookies do PHP

## 📦 Dependências

O projeto usa apenas:
- **PHP Nativo** (7.4+)
- **MySQL** (via PDO)
- **HTML5**
- **CSS3**
- **JavaScript (Vanilla)**

Nenhuma dependência externa necessária!

## 🎯 Próximos Passos (Recomendado)

1. **Customizar Temas**: Edite `public/assets/css/style.css`
2. **Adicionar Conteúdo**: Use o painel admin para adicionar cursos e aulas
3. **Configurar Email**: Implemente envio de emails de confirmação
4. **Melhorar Autenticação**: Adicione 2FA (autenticação de dois fatores)
5. **APIs RESTful**: Desenvolva endpoints JSON completos
6. **Testes Automatizados**: Adicione testes unitários e de integração

## 📝 Licença

Este projeto é fornecido como está para fins educacionais.

## 🤝 Suporte

Para dúvidas ou problemas:
1. Verifique o arquivo `README.md`
2. Consulte a estrutura do projeto
3. Revise os comentários no código-fonte

---

**Desenvolvido com ❤️ em 2026**
