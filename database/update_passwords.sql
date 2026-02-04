-- Atualizar senhas dos usuários no banco de dados existente
UPDATE users SET password = '$2y$10$coknNNT7i6Y7tJbASS.Ma.XitsLXUM/eghWC1oGx3YyBOBByLmTJe' 
WHERE email = 'teste@youremail.com';

UPDATE users SET password = '$2y$10$lGRQP057Jrgqyp5BuwogXuFXAbSNtTmsOKLWpV/NEVRp9raRVmKgO' 
WHERE email = 'admin@youremail.com';

-- Verificar se as alterações foram aplicadas
SELECT id, name, email, role FROM users;
