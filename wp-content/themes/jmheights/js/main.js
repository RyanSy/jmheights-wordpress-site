/**
 * JM Heights - Main JavaScript
 */
document.addEventListener('DOMContentLoaded', function () {
  // Mobile Menu Toggle
  const toggle = document.getElementById('mobile-menu-toggle');
  const nav = document.getElementById('primary-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('active');
      toggle.classList.toggle('active');
    });
  }

  // Header scroll effect
  const header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) {
        header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
      } else {
        header.style.boxShadow = 'none';
      }
    });
  }

  // Contact Form Handler
  const form = document.getElementById('jmheights-contact-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const honeypot = form.querySelector('[name="website"]');
      if (honeypot && honeypot.value) return;

      const btn = form.querySelector('button[type="submit"]');
      const msgEl = document.getElementById('form-message');
      const originalText = btn.innerHTML;

      btn.disabled = true;
      btn.innerHTML = 'Sending...';

      const formData = new FormData(form);
      formData.append('action', 'jmheights_contact');
      formData.append('nonce', jmheights.nonce);

      fetch(jmheights.ajaxUrl, {
        method: 'POST',
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (msgEl) {
            msgEl.style.display = 'block';
            if (data.success) {
              msgEl.style.background = '#d4edda';
              msgEl.style.color = '#155724';
              msgEl.textContent =
                data.data.message ||
                "Thank you! We'll be in touch soon.";
              form.reset();
            } else {
              msgEl.style.background = '#f8d7da';
              msgEl.style.color = '#721c24';
              msgEl.textContent =
                data.data.message || 'Something went wrong. Please try again.';
            }
          }
        })
        .catch(function () {
          if (msgEl) {
            msgEl.style.display = 'block';
            msgEl.style.background = '#f8d7da';
            msgEl.style.color = '#721c24';
            msgEl.textContent =
              'Network error. Please call us directly at (201) 824-3272.';
          }
        })
        .finally(function () {
          btn.disabled = false;
          btn.innerHTML = originalText;
        });
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
});
