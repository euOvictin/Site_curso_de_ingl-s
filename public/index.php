<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <!-- Meta básicas -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your English - Domine o Inglês do Futuro</title>

  <!-- Favicon personalizável: troque o href para o seu arquivo -->
  <link rel="icon" type="image/png" href="assets/favicon.png">

  <!-- Fonte futurista simples via Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Ícones (telefone, e-mail, etc.) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- CSS principal -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <!-- Navbar simples e responsiva -->
  <header class="navbar">
    <div class="navbar-container">
      <a href="#hero" class="navbar-logo">
        <!-- Você pode trocar o texto pelo seu logo -->
        <span class="logo-symbol">YE</span>
        <span class="logo-text">Your English</span>
      </a>

      <!-- Navegação -->
      <nav class="navbar-links" id="navbar-links">
        <!-- Links reativos: rolam até a seção correspondente -->
        <a href="#hero" class="nav-link active">Início</a>
        <a href="#benefits" class="nav-link">Benefícios</a>
        <a href="#carousel" class="nav-link">Depoimentos</a>
        <a href="#plans" class="nav-link">Planos</a>
        <a href="#footer" class="nav-link">Contato</a>
      </nav>

      <!-- Ícone de perfil redondo -->
<div class="navbar-profile">
  <div class="profile-icon" id="profile-icon">
    <i class="fa-solid fa-user"></i>
  </div>
  <!-- Menu dropdown do perfil -->
  <div class="profile-dropdown" id="profile-dropdown">
    <a href="#plans" class="dropdown-item">
      <i class="fa-solid fa-credit-card"></i>
      Meus Planos
    </a>
    <a href="#carousel" class="dropdown-item">
      <i class="fa-solid fa-star"></i>
      Avaliações
    </a>
    <a href="#" class="dropdown-item">
      <i class="fa-solid fa-gear"></i>
      Configurações
    </a>
    <div class="dropdown-divider"></div>
    <a href="login.php" class="dropdown-item">
      <i class="fa-solid fa-right-from-bracket"></i>
      Login
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

  <!-- Seção Hero -->
  <section id="hero" class="hero">
    <div class="hero-content">
      <p class="hero-badge">Curso online • Aulas ao vivo e gravadas</p>
      <h1>Domine o inglês com uma experiência de aprendizado <span class="highlight">futurista</span>.</h1>
      <p class="hero-subtitle">
        Alcance fluência mais rápido com metodologia imersiva, inteligência artificial e professores certificados – sem sair de casa.
      </p>

      <div class="hero-buttons">
        <a href="#plans" class="btn btn-primary">Quero começar agora</a>
        <a href="#benefits" class="btn btn-outline">Ver como funciona</a>
      </div>

      <div class="hero-metrics">
        <div class="metric">
          <span class="metric-number">+2.500</span>
          <span class="metric-label">alunos ativos</span>
        </div>
        <div class="metric">
          <span class="metric-number">4,9/5</span>
          <span class="metric-label">satisfação média</span>
        </div>
        <div class="metric">
          <span class="metric-number">8x</span>
          <span class="metric-label">mais prática real</span>
        </div>
      </div>
    </div>

    <!-- Imagem futurista com IA (placeholder) -->
    <div class="hero-image">
      <!-- Substitua a URL abaixo por uma imagem de IA da sua preferência -->
      <img 
        src="https://placeholders.io/img/800x600?text=futuristic+english+learning+interface" 
        alt="Interface futurista de estudo de inglês">
      <div class="hero-glow"></div>
    </div>
  </section>

  <!-- Seção Benefícios com Cards -->
  <section id="benefits" class="section section-benefits">
    <div class="section-header">
      <h2>Por que o <span class="highlight">Your English</span> é diferente?</h2>
      <p>
        Uma jornada completa com foco em conversação, feedback em tempo real e tecnologia que se adapta ao seu ritmo.
      </p>
    </div>

    <div class="cards-grid">
      <!-- Card 1 -->
      <article class="card">
        <div class="card-icon">
          <i class="fa-solid fa-robot"></i>
        </div>
        <h3>Assistente de IA 24/7</h3>
        <p>
          Pratique conversação quando quiser com um assistente inteligente que corrige pronúncia, gramática e vocabulário em tempo real.
        </p>
      </article>

      <!-- Card 2 -->
      <article class="card">
        <div class="card-icon">
          <i class="fa-solid fa-globe"></i>
        </div>
        <h3>Aulas ao vivo globais</h3>
        <p>
          Participe de aulas ao vivo com professores certificados e colegas do mundo inteiro, simulando situações reais de viagem e trabalho.
        </p>
      </article>

      <!-- Card 3 -->
      <article class="card">
        <div class="card-icon">
          <i class="fa-solid fa-gauge-high"></i>
        </div>
        <h3>Metodologia acelerada</h3>
        <p>
          Trilha personalizada que ajusta o nível automaticamente e foca exatamente nos pontos que vão destravar sua fluência.
        </p>
      </article>

      <!-- Card 4 -->
      <article class="card">
        <div class="card-icon">
          <i class="fa-solid fa-mobile-screen-button"></i>
        </div>
        <h3>100% flexível</h3>
        <p>
          Acesse pelo celular, tablet ou PC, com lembretes inteligentes e revisão espaçada para maximizar a retenção.
        </p>
      </article>
    </div>
  </section>

  <!-- Carrossel de Depoimentos -->
  <section id="carousel" class="section section-carousel">
    <div class="section-header">
      <h2>Histórias reais de <span class="highlight">transformação</span></h2>
      <p>Veja como o inglês abriu portas para nossos alunos ao redor do mundo.</p>
    </div>

    <div class="carousel-container">
      <button class="carousel-control prev" id="carousel-prev" aria-label="Anterior">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <div class="carousel-track-container">
        <div class="carousel-track" id="carousel-track">
          <!-- Slide 1 -->
          <article class="carousel-card">
            <div class="carousel-avatar">
              <img src="https://placeholders.io/img/120x120?text=student+1" alt="Aluno 1">
            </div>
            <h3>Marina, 24 anos</h3>
            <p class="carousel-role">Estudante de TI • Remoto para empresa dos EUA</p>
            <p class="carousel-text">
              “Em 6 meses já estava fazendo entrevistas em inglês sem travar. Hoje trabalho remotamente para uma empresa americana.”
            </p>
          </article>

          <!-- Slide 2 -->
          <article class="carousel-card">
            <div class="carousel-avatar">
              <img src="https://placeholders.io/img/120x120?text=student+2" alt="Aluno 2">
            </div>
            <h3>Lucas, 29 anos</h3>
            <p class="carousel-role">Dev Front-end • Europa</p>
            <p class="carousel-text">
              “O foco em conversação e vocabulário de tecnologia fez toda diferença para conquistar minha vaga na Europa.”
            </p>
          </article>

          <!-- Slide 3 -->
          <article class="carousel-card">
            <div class="carousel-avatar">
              <img src="https://placeholders.io/img/120x120?text=student+3" alt="Aluno 3">
            </div>
            <h3>Ana, 32 anos</h3>
            <p class="carousel-role">Analista de Projetos • Multinacional</p>
            <p class="carousel-text">
              “Finalmente consigo participar de reuniões em inglês sem medo. O curso simula exatamente o que vivo no dia a dia.”
            </p>
          </article>
        </div>
      </div>

      <button class="carousel-control next" id="carousel-next" aria-label="Próximo">
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>

    <!-- Indicadores do carrossel -->
    <div class="carousel-indicators" id="carousel-indicators">
      <button class="indicator active" data-slide="0"></button>
      <button class="indicator" data-slide="1"></button>
      <button class="indicator" data-slide="2"></button>
    </div>
  </section>

  <!-- Seção Planos (cards de preço) -->
  <section id="plans" class="section section-plans">
    <div class="section-header">
      <h2>Escolha seu <span class="highlight">ritmo</span> de evolução</h2>
      <p>Planos simples, sem contrato de fidelidade, com garantia de 7 dias.</p>
    </div>

    <div class="plans-grid">
      <!-- Plano 1 -->
      <article class="plan-card">
        <h3>Starter</h3>
        <p class="plan-subtitle">Ideal para iniciar sua jornada no inglês.</p>
        <p class="plan-price">R$ 59<span>/mês</span></p>
        <ul class="plan-features">
          <li>Acesso à plataforma completa</li>
          <li>2 aulas ao vivo por mês</li>
          <li>Atividades guiadas com IA</li>
        </ul>
        <a href="#footer" class="btn btn-primary plan-btn">Começar com Starter</a>
      </article>

      <!-- Plano 2 -->
      <article class="plan-card plan-featured">
        <div class="plan-badge">Mais escolhido</div>
        <h3>Pro Fluency</h3>
        <p class="plan-subtitle">Para quem quer destravar a fluência rápido.</p>
        <p class="plan-price">R$ 129<span>/mês</span></p>
        <ul class="plan-features">
          <li>8 aulas ao vivo por mês</li>
          <li>Simulados de entrevistas</li>
          <li>Correção personalizada semanal</li>
          <li>Comunidade exclusiva</li>
        </ul>
        <a href="#footer" class="btn btn-primary plan-btn">Quero o Pro Fluency</a>
      </article>

      <!-- Plano 3 -->
      <article class="plan-card">
        <h3>Premium Global</h3>
        <p class="plan-subtitle">Para projetos internacionais e alta performance.</p>
        <p class="plan-price">R$ 199<span>/mês</span></p>
        <ul class="plan-features">
          <li>Aulas ilimitadas ao vivo</li>
          <li>Mentorias 1:1 mensais</li>
          <li>Preparação para certificações</li>
        </ul>
        <a href="#footer" class="btn btn-primary plan-btn">Falar com especialista</a>
      </article>
    </div>
  </section>

  <!-- Footer com contato -->
  <footer id="footer" class="footer">
    <div class="footer-content">
      <div class="footer-brand">
        <h3>Your English</h3>
        <p>
          Aprenda inglês com a fluidez e a confiança que o mercado global exige.
        </p>
      </div>

      <div class="footer-contact">
        <h4>Contato</h4>
        <p><i class="fa-solid fa-location-dot"></i> Online • Aulas ao vivo e gravadas</p>
        <p><i class="fa-solid fa-clock"></i> Atendimento: seg a sex, 9h às 19h</p>

        <div class="footer-buttons">
          <!-- Botão de ligação -->
          <a href="tel:+550000000000" class="btn-icon">
            <i class="fa-solid fa-phone"></i>
            <span>Ligar agora</span>
          </a>
          <!-- Botão de e-mail -->
          <a href="mailto:contato@yourenglish.com" class="btn-icon">
            <i class="fa-solid fa-envelope"></i>
            <span>Enviar e-mail</span>
          </a>
        </div>
      </div>

      <div class="footer-newsletter">
        <h4>Receba conteúdos gratuitos</h4>
        <p>Deixe seu e-mail para receber aulas e materiais exclusivos.</p>
        <form class="newsletter-form" id="newsletter-form">
          <input type="email" placeholder="Digite seu melhor e-mail" required>
          <button type="submit" class="btn btn-primary">Quero receber</button>
        </form>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© <span id="year"></span> Your English. Todos os direitos reservados.</p>
      <p class="footer-links">
        <a href="#hero">Início</a> • 
        <a href="#plans">Planos</a> • 
        <a href="#footer">Suporte</a>
      </p>
    </div>
  </footer>

  <!-- Script principal -->
  <script src="assets/js/script.js"></script>
</body>
</html>
