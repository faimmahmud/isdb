
document.addEventListener('DOMContentLoaded', () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) entry.target.classList.add('show');
    });
  }, { threshold: 0.14 });

  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  const year = document.querySelector('[data-year]');
  if (year) year.textContent = new Date().getFullYear();

  const chips = document.querySelectorAll('[data-filter]');
  const cards = document.querySelectorAll('[data-card]');
  chips.forEach(chip => {
    chip.addEventListener('click', () => {
      chips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      const val = chip.dataset.filter;
      cards.forEach(card => {
        const ok = val === 'all' || card.dataset.type === val;
        card.style.display = ok ? '' : 'none';
      });
    });
  });
});
