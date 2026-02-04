// =============================
// NAVBAR: MENU MOBILE & LINK ATIVO
// =============================

// Seleciona elementos principais da navbar
const navbarToggle = document.getElementById('navbar-toggle');
const navbarLinks = document.getElementById('navbar-links');
const navLinks = document.querySelectorAll('.nav-link');

// Abre/fecha menu em telas pequenas
if (navbarToggle && navbarLinks) {
  navbarToggle.addEventListener('click', () => {
    navbarToggle.classList.toggle('active');
    navbarLinks.classList.toggle('open');
  });

  // Fecha o menu ao clicar em um link (em mobile)
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navbarToggle.classList.remove('active');
      navbarLinks.classList.remove('open');
    });
  });
}

// Destaca link da navbar com base na seção visível
const sections = document.querySelectorAll('section, footer');

function handleScrollActiveLink() {
  const scrollY = window.pageYOffset;

  sections.forEach(sec => {
    const sectionTop = sec.offsetTop - 120; // offset para considerar altura da navbar
    const sectionHeight = sec.offsetHeight;
    const sectionId = sec.getAttribute('id');

    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${sectionId}`) {
          link.classList.add('active');
        }
      });
    }
  });
}

window.addEventListener('scroll', handleScrollActiveLink);

// =============================
// CARROSSEL SIMPLES
// =============================

// Comentário: carrossel controlado por JS, com set de slides horizontal
const track = document.getElementById('carousel-track');
const prevBtn = document.getElementById('carousel-prev');
const nextBtn = document.getElementById('carousel-next');
const indicators = document.querySelectorAll('.indicator');

let currentSlide = 0;

// Atualiza posição do carrossel
function updateCarousel() {
  if (!track) return;
  const slideWidth = track.children[0].getBoundingClientRect().width;
  const offset = -(slideWidth * currentSlide);
  track.style.transform = `translateX(${offset}px)`;

  // Atualiza indicadores ativos
  indicators.forEach((dot, index) => {
    dot.classList.toggle('active', index === currentSlide);
  });
}

// Navegação pelos botões
if (prevBtn && nextBtn) {
  prevBtn.addEventListener('click', () => {
    const totalSlides = track.children.length;
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
  });

  nextBtn.addEventListener('click', () => {
    const totalSlides = track.children.length;
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  });
}

// Navegação pelos indicadores
if (indicators.length > 0) {
  indicators.forEach(dot => {
    dot.addEventListener('click', () => {
      const slide = Number(dot.dataset.slide);
      currentSlide = slide;
      updateCarousel();
    });
  });
}

// Auto-play suave (opcional)
if (track && track.children.length > 1) {
  setInterval(() => {
    if (!track) return;
    const totalSlides = track.children.length;
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  }, 9000); // muda a cada 9s
}

// Ajuste inicial
window.addEventListener('load', updateCarousel);
window.addEventListener('resize', updateCarousel);

// =============================
// FOOTER: ANO AUTOMÁTICO
// =============================

const yearSpan = document.getElementById('year');
if (yearSpan) {
  yearSpan.textContent = new Date().getFullYear();
}

// =============================
// NEWSLETTER FORM
// =============================

const newsletterForm = document.getElementById('newsletter-form');
if (newsletterForm) {
  newsletterForm.addEventListener('submit', (e) => {
    e.preventDefault();
    // Adicionar lógica de envio de email aqui
    const emailInput = newsletterForm.querySelector('input[type="email"]');
    console.log('Email enviado:', emailInput.value);
    alert('Email registrado com sucesso!');
    emailInput.value = '';
  });
}

// =============================
// MENU DROPDOWN DO PERFIL
// =============================

// Seleciona os elementos do dropdown
const profileIcon = document.getElementById('profile-icon');
const profileDropdown = document.getElementById('profile-dropdown');

// Se os elementos existem, adiciona a lógica
if (profileIcon && profileDropdown) {
  
  // Abre/fecha o dropdown ao clicar no ícone
  profileIcon.addEventListener('click', (e) => {
    e.stopPropagation(); // Impede que o clique feche imediatamente
    profileDropdown.classList.toggle('open');
  });
  
  // Fecha o dropdown ao clicar fora dele
  document.addEventListener('click', (e) => {
    if (!profileIcon.contains(e.target) && !profileDropdown.contains(e.target)) {
      profileDropdown.classList.remove('open');
    }
  });
  
  // Fecha o dropdown ao rolar a página
  window.addEventListener('scroll', () => {
    profileDropdown.classList.remove('open');
  });
}
