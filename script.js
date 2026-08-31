const menuToggle = document.querySelector('.menu-toggle');
const siteNav = document.querySelector('#site-nav');
const navLinks = document.querySelectorAll('#site-nav a');
const leadForm = document.querySelector('#lead-form');
const formMessage = document.querySelector('.form-message');
const yearEl = document.querySelector('#year');

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
