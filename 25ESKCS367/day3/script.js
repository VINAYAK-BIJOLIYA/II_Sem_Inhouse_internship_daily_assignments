// ===========================================================
// SUPER LEARNERS — script.js
// ===========================================================

// ---------- PRELOADER ----------
window.addEventListener('load', () => {
  const preloader = document.getElementById('preloader');
  setTimeout(() => {
    preloader.classList.add('loaded');
  }, 400);
});

// ---------- STICKY NAVBAR ----------
const navbar = document.getElementById('mainNavbar');
window.addEventListener('scroll', () => {
  if (window.scrollY > 40) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }

  // back to top visibility
  const backToTop = document.getElementById('backToTop');
  if (window.scrollY > 400) {
    backToTop.classList.add('show');
  } else {
    backToTop.classList.remove('show');
  }
});

// ---------- CLOSE MOBILE NAV ON LINK CLICK ----------
document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', () => {
    const navCollapse = document.getElementById('navbarContent');
    if (navCollapse.classList.contains('show')) {
      new bootstrap.Collapse(navCollapse).hide();
    }
  });
});

// ---------- ACTIVE NAV LINK ON SCROLL ----------
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(section => {
    const sectionTop = section.offsetTop - 120;
    if (window.scrollY >= sectionTop) {
      current = section.getAttribute('id');
    }
  });

  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === `#${current}`) {
      link.classList.add('active');
    }
  });
});

// ---------- BACK TO TOP ----------
document.getElementById('backToTop').addEventListener('click', () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ---------- SCROLL REVEAL ----------
const revealElements = document.querySelectorAll('.reveal');

const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('active');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.15 });

revealElements.forEach(el => revealObserver.observe(el));

// ---------- CONTACT FORM SUBMIT (DEMO) ----------
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const btn = contactForm.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Message Sent!';
    btn.disabled = true;
    contactForm.reset();
    setTimeout(() => {
      btn.innerHTML = originalText;
      btn.disabled = false;
    }, 2500);
  });
}

// ---------- CURRENT YEAR IN FOOTER ----------
document.getElementById('year').textContent = new Date().getFullYear();
