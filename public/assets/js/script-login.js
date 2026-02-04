// Documentação JS: Validações, tabs, toggle senha, feedback forms e navbar mobile
// Mantém estado persistente para animações suaves, compatível com landing page

document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const forms = document.querySelectorAll('.auth-form');
    const togglePwds = document.querySelectorAll('.toggle-password');
    // Seleciona cada elemento de formulário com a classe .auth-form.
    // Em algumas páginas .auth-form é o próprio <form>, em outras é um wrapper.
    const formsSubmit = Array.from(forms).map(f => (f.tagName === 'FORM' ? f : f.querySelector('form'))).filter(Boolean);
    const mobileMenu = document.getElementById('mobile-menu');

    // 1. Tabs Login/Cadastro
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            // Remove active
            tabBtns.forEach(b => b.classList.remove('active'));
            forms.forEach(f => f.classList.remove('active'));
            // Adiciona active
            btn.classList.add('active');
            document.getElementById(tab + '-form').classList.add('active');
        });
    });

    // 2. Toggle visibilidade senha
    togglePwds.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const input = toggle.parentElement.querySelector('input');
            const icon = toggle.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // 3. Validações e submit com feedback — agora usando fetch assíncrono.
    // Cada formulário pode declarar o endpoint no atributo `data-action`.
    formsSubmit.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('.btn-primary');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.textContent = 'Enviando...';
                submitBtn.disabled = true;
            }

            // Endpoint: prioriza data-action (recomendado), cai para action como fallback
            const endpoint = form.dataset.action || form.getAttribute('action') || '';
            const method = (form.method || 'POST').toUpperCase();

            try {
                if (!endpoint) throw new Error('Nenhum endpoint informado no formulário. Use data-action.');

                const formData = new FormData(form);

                const resp = await fetch(endpoint, {
                    method,
                    body: formData,
                    credentials: 'same-origin'
                });

                // Tentar interpretar como JSON, senão usar texto
                let data;
                const contentType = resp.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    data = await resp.json();
                } else {
                    data = await resp.text();
                }

                if (!resp.ok) {
                    const msg = (typeof data === 'string') ? data : (data.message || JSON.stringify(data));
                    alert('Erro: ' + msg);
                } else {
                    // Sucesso — comportamento esperado: backend retorna JSON { success: true, redirect: 'url' }
                    if (typeof data === 'object' && data !== null) {
                        if (data.success && data.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }
                        alert(data.message || 'Operação realizada com sucesso.');
                    } else {
                        // Texto puro (ex: HTML ou string simples)
                        alert(data || (form.id.includes('login') ? 'Login realizado!' : 'Cadastro realizado!'));
                    }
                }
            } catch (err) {
                console.error(err);
                alert('Erro ao enviar formulário: ' + err.message);
            } finally {
                if (submitBtn) {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            }
        });
    });

    // 4. Navbar mobile toggle (consistente com landing)
    if (mobileMenu) {
        mobileMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            // Adicione menu mobile aqui se precisar expandir
        });
    }

    // 5. Validação senha forte no cadastro (exemplo)
    const pwInput = document.querySelector('#register-form input[name="password"]');
    if (pwInput) {
        pwInput.addEventListener('input', () => {
            const pw = pwInput.value;
            if (pw.length < 8) {
                pwInput.style.borderColor = '#ef4444';
            } else {
                pwInput.style.borderColor = 'var(--purple)';
            }
        });
    }
});
