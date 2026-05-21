/* Smooth Scroll Enhancement */

document.addEventListener('DOMContentLoaded', function() {
  const scrollToTopBtn = document.querySelector('.scroll-to-top, .scroll-to-target');

  // Show/hide scroll to top button
  window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
      if (scrollToTopBtn) {
        scrollToTopBtn.classList.add('show');
      }
    } else {
      if (scrollToTopBtn) {
        scrollToTopBtn.classList.remove('show');
      }
    }
  });

  // Scroll to top button click handler
  if (scrollToTopBtn) {
    scrollToTopBtn.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');

      // Skip if href is just '#' or empty
      if (href === '#' || href === '') {
        return;
      }

      const targetElement = document.querySelector(href);

      if (targetElement) {
        e.preventDefault();
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Smooth scroll for page anchors with data-scroll attribute
  document.querySelectorAll('[data-scroll]').forEach(element => {
    element.addEventListener('click', function() {
      const target = this.getAttribute('data-scroll');
      const targetElement = document.querySelector(target);

      if (targetElement) {
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});
