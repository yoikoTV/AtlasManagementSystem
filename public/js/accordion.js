document.addEventListener('DOMContentLoaded', () => {
  const headers = document.querySelectorAll('.accordion-header');

  headers.forEach(header => {
    header.addEventListener('click', () => {
      const arrow = header.querySelector('.arrow');
      const content = header.nextElementSibling;

      arrow.classList.toggle('rotate');
      content.classList.toggle('open');
    });
  });
});
