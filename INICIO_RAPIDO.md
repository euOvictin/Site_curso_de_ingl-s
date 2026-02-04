# 🚀 GUIA RÁPIDO DE INÍCIO

## ✅ O que foi feito?

Seu projeto foi completamente reorganizado com uma estrutura profissional MVC:

### Estrutura Criada:
```
/
├── api/                    → Endpoints da API
├── config.php             → Configuração central
├── database/              → Scripts SQL
├── public/                → Arquivos públicos (CSS, JS, imagens)
├── src/                   → Código-fonte (Models, Controllers, Utils)
├── check.php              → Verificador de configuração
└── README.md              → Documentação completa
```

---

## 🎯 PASSOS PARA COMEÇAR

### 1️⃣ IMPORTAR O BANCO DE DADOS
```bash
# Via phpMyAdmin:
# 1. Acesse http://localhost/phpmyadmin
# 2. Crie um novo banco chamado "english_web"
# 3. Vá em "Importar" e selecione: database/schema.sql

# Ou via terminal (Windows CMD/PowerShell):
mysql -u root -p < database\schema.sql
```

### 2️⃣ VERIFICAR INSTALAÇÃO
Abra seu navegador em: **http://localhost/teste/check.php**

Você deve ver tudo em ✓ (verde)

### 3️⃣ ACESSAR A APLICAÇÃO
- **Página Inicial:** http://localhost/teste/public/index.php
- **Login:** http://localhost/teste/public/login.php
- **Dashboard:** http://localhost/teste/public/dashboard.php

### 4️⃣ FAZER LOGIN
**Credenciais de Teste:**
- Email: `teste@youremail.com`
- Senha: `12345678`

**Credenciais de Admin:**
- Email: `admin@youremail.com`
- Senha: `admin123`

---

## 🔧 CONFIGURAÇÃO (Se Necessário)

Edite o arquivo `config.php` se precisar mudar:

```php
// Banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'english_web');
define('DB_USER', 'root');
define('DB_PASS', '');

// URLs
define('BASE_URL', 'http://localhost/teste');
```

---

## 📚 ESTRUTURA DE PASTAS EXPLICADA

| Pasta | Função |
|-------|--------|
| **api/** | Endpoints (login, cadastro, logout) |
| **public/** | Tudo que pode ser acessado via web |
| **public/assets/** | CSS, JS, uploads (imagens, áudio, PDF) |
| **src/Config/** | Banco de dados e configurações |
| **src/Models/** | Classes para manipular dados (User, Course, etc) |
| **src/Controllers/** | Lógica de negócio (AuthController) |
| **src/Utils/** | Funções auxiliares (Auth, Validator) |
| **src/Views/** | Templates HTML (futuro) |
| **database/** | Scripts SQL e backups |

---

## 🔐 SEGURANÇA - IMPORTANTE!

Antes de colocar em produção, altere:

1. **Senhas Padrão** - Change in database/schema.sql
2. **APP_ENV** - Mude de `development` para `production` em config.php
3. **Chaves de Segurança** - Adicione em produção
4. **HTTPS** - Configure certificado SSL

---

## 💻 EXEMPLOS DE USO

### Fazer Login com PHP
```php
require_once 'config.php';
use App\Utils\Auth;

$auth = new Auth();
$user = $auth->login('teste@youremail.com', '12345678');

if ($user) {
    echo "Login bem-sucedido: " . $user['name'];
} else {
    echo "Email ou senha inválidos";
}
```

### Buscar Usuário
```php
use App\Models\User;

$userModel = new User();
$user = $userModel->findByEmail('teste@youremail.com');
echo $user['name'];
```

### Listar Cursos
```php
use App\Models\Course;

$courseModel = new Course();
$courses = $courseModel->getAll();

foreach ($courses as $course) {
    echo $course['title'] . " (" . $course['lesson_count'] . " aulas)";
}
```

---

## 🐛 SOLUÇÃO DE PROBLEMAS

### Erro: "Conexão com banco recusada"
```
✓ MySQL está rodando?
✓ Verificou credenciais em config.php?
✓ Banco "english_web" foi criado?
```

### Erro: "Arquivo não encontrado"
```
✓ Verifique a URL (use /teste/public/index.php)
✓ O arquivo existe em public/?
```

### Sessão não funciona
```
✓ Limpe cookies do navegador
✓ Verifique se session_start() é chamado
✓ Reinicie o Apache/XAMPP
```

### Upload não funciona
```
✓ Pasta public/assets/uploads existe?
✓ Tem permissão de escrita?
✓ Tamanho do arquivo < 50MB?
```

---

## 📞 COMANDOS ÚTEIS

### Resetar Banco de Dados
```bash
mysql -u root -p english_web < database/schema.sql
```

### Fazer Backup
```bash
mysqldump -u root -p english_web > backup.sql
```

### Testar Conexão
```bash
mysql -u root -p -e "SELECT VERSION();"
```

---

## 🎓 PRÓXIMOS PASSOS

1. ✅ **Instalar e testar** a aplicação
2. 📝 **Adicionar cursos** via painel admin
3. 🎨 **Customizar temas** em public/assets/css/
4. 📧 **Implementar emails** de confirmação
5. 🔒 **Melhorar segurança** (2FA, HTTPS)
6. 🚀 **Deploy** em servidor de produção

---

## 📖 DOCUMENTAÇÃO COMPLETA

Leia **README.md** para documentação detalhada

---

## ✨ RESUMO

✅ Estrutura profissional MVC
✅ Banco de dados configurado
✅ Autenticação implementada
✅ Dashboard funcional
✅ Admin panel
✅ Pronto para rodar localmente

**Você está pronto para começar! 🎉**

Abra: http://localhost/teste/check.php
