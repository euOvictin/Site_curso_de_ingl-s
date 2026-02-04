# DEBUG - Problema de Login Não Funcionava

## Problemas Identificados

### 1. **Script JavaScript Não Fazia Requisição à API**
**Arquivo:** `public/login.php`
**Problema:** O script `handleLogin()` apenas validava localmente e redirecionava direto para o dashboard sem autenticar.
**Solução:** 
- Implementar `fetch()` para enviar dados ao endpoint `/api/login.php`
- Usar `FormData()` para enviar dados como POST
- Processar resposta JSON e verificar `success` antes de redirecionar
- Adicionar feedback visual (botão desabilitado, mensagens de erro/sucesso)

### 2. **Senhas No Banco de Dados Inválidas**
**Arquivo:** `database/schema.sql`
**Problema:** Os hashes bcrypt pré-configurados não correspondiam a nenhuma senha real
- Hash original: `$2y$10$YpdjlMgIriqLnJ0K2w2Q6uRNlqk8YKu7GQV3Zf7WqPQ4ZqP5OYWsW`
- Não correspondia a nenhuma senha conhecida

**Solução:**
- Gerar novos hashes válidos com `password_hash()`:
  - Senha: `12345678` → Hash: `$2y$10$coknNNT7i6Y7tJbASS.Ma.XitsLXUM/eghWC1oGx3YyBOBByLmTJe`
  - Senha: `admin123` → Hash: `$2y$10$lGRQP057Jrgqyp5BuwogXuFXAbSNtTmsOKLWpV/NEVRp9raRVmKgO`
- Atualizar registros via SQL: `UPDATE users SET password = ... WHERE email = ...`

### 3. **BASE_URL Calculada Incorretamente**
**Arquivo:** `config.php`
**Problema:** Quando chamado de `/teste/api/login.php`, a BASE_URL era calculada como `http://localhost/teste/api` em vez de `http://localhost/teste`
- Causava redirects para URLs inválidas como `http://localhost/teste/api/public/dashboard.php`

**Solução:**
- Usar regex `preg_replace('#/(public|api)/?$#', '', $scriptPath)` para remover `/public` ou `/api` do final
- Forçar BASE_URL padrão como `/teste` se o cálculo resultar em string vazia

## Dados de Login Para Testes

### Usuário Comum
- **Email:** teste@youremail.com
- **Senha:** 12345678
- **Role:** user

### Usuário Admin
- **Email:** admin@youremail.com
- **Senha:** admin123
- **Role:** admin

## Fluxo de Autenticação Corrigido

1. **Usuário preenche formulário** → `public/login.php`
2. **JavaScript envia POST** → `fetch('api/login.php')`
3. **API processa** → `api/login.php` chama `AuthController->login()`
4. **Validação** → Email válido + Senha matches bcrypt hash
5. **Session criada** → `$_SESSION['user_id']`, `$_SESSION['user_role']`, etc.
6. **Resposta JSON** → `{ success: true, redirect: "...", role: "..." }`
7. **Redirecionamento** → Dashboard (user) ou Gerência (admin)

## Arquivos Modificados

1. ✅ `public/login.php` - Script handleLogin agora faz fetch real
2. ✅ `database/schema.sql` - Senhas atualizadas e documentadas
3. ✅ `config.php` - BASE_URL calculada corretamente
4. ✅ `database/update_passwords.sql` - Script de atualização no banco existente

## Testes Realizados

```bash
# Teste com curl/PowerShell
$body = @{ email = 'teste@youremail.com'; password = '12345678' }
Invoke-WebRequest -Uri "http://localhost/teste/api/login.php" -Method POST -Body $body

# Resposta esperada:
# {"success":true,"message":"Login realizado com sucesso!","redirect":"http://localhost/teste/public/dashboard.php","role":"user"}
```

## Status Final
✅ **Login totalmente funcional!**
- Senhas corrigidas no banco de dados
- API respondendo corretamente
- JavaScript fazendo fetch e processando resposta
- Redirecionamento funcionando
- Session criada corretamente
