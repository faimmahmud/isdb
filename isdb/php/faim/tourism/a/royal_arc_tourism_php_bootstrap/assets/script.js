
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) entry.target.classList.add('show');
  });
}, { threshold: 0.15 });

revealEls.forEach(el => observer.observe(el));

document.querySelectorAll('.feature-card, .gallery-card, .user-box, .admin-box, .puzzle').forEach(card => {
  card.addEventListener('mousemove', (e) => {
    const r = card.getBoundingClientRect();
    const x = (e.clientX - r.left) / r.width - 0.5;
    const y = (e.clientY - r.top) / r.height - 0.5;
    card.style.transform = `perspective(1000px) rotateX(${(-y * 4).toFixed(2)}deg) rotateY(${(x * 4).toFixed(2)}deg) translateY(-4px)`;
  });
  card.addEventListener('mouseleave', () => {
    card.style.transform = '';
  });
});
