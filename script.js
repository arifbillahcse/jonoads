const menuToggle = document.querySelector('.menu-toggle');
const siteNav = document.querySelector('#site-nav');
const navLinks = document.querySelectorAll('#site-nav a');
const leadForm = document.querySelector('#lead-form');
const formMessage = document.querySelector('.form-message');
const yearEl = document.querySelector('#year');
const revealItems = document.querySelectorAll('.reveal');
const parallaxItems = document.querySelectorAll('[data-parallax]');

if (yearEl) {
  yearEl.textContent = new Date().getFullYear();
}

if (menuToggle && siteNav) {
  menuToggle.addEventListener('click', () => {
    const isOpen = siteNav.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded', String(isOpen));
  });

  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      if (siteNav.classList.contains('open')) {
        siteNav.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
      }
    });
  });
}

if (revealItems.length) {
  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        entry.target.classList.add('in-view');
        obs.unobserve(entry.target);
      });
    },
    {
      threshold: 0.14,
      rootMargin: '0px 0px -30px 0px',
    },
  );

  revealItems.forEach((item) => observer.observe(item));
}

if (parallaxItems.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  window.addEventListener('pointermove', (event) => {
    const ratioX = event.clientX / window.innerWidth - 0.5;
    const ratioY = event.clientY / window.innerHeight - 0.5;

    parallaxItems.forEach((item) => {
      const strength = Number(item.dataset.parallax) || 0;
      const x = ratioX * strength;
      const y = ratioY * strength;
      item.style.transform = `translate3d(${x}px, ${y}px, 0)`;
    });
  });
}

if (leadForm && formMessage) {
  leadForm.addEventListener('submit', (event) => {
    event.preventDefault();

    if (!leadForm.checkValidity()) {
      formMessage.textContent = 'Please complete all required fields.';
      return;
    }

    const submitButton = leadForm.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Submitting...';
    formMessage.textContent = 'Sending your request...';

    window.setTimeout(() => {
      formMessage.textContent = 'Thanks! Your demo request has been captured. We will contact you shortly.';
      leadForm.reset();
      submitButton.disabled = false;
      submitButton.textContent = 'Submit';
    }, 900);
  });
}
