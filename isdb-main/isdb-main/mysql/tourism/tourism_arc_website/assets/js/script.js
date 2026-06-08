$(function () {
  // Navbar shadow on scroll
  const nav = $('.site-nav');
  const handleScroll = () => {
    if ($(window).scrollTop() > 20) {
      nav.addClass('shadow-sm');
    } else {
      nav.removeClass('shadow-sm');
    }
  };
  handleScroll();
  $(window).on('scroll', handleScroll);

  // Reveal animation
  const revealItems = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  revealItems.forEach((el) => observer.observe(el));

  // Destination filters
  $('.btn-filter').on('click', function () {
    const filter = $(this).data('filter');
    $('.btn-filter').removeClass('active');
    $(this).addClass('active');

    $('.destination-item').each(function () {
      const type = $(this).data('type');
      if (filter === 'all' || type === filter) {
        $(this).fadeIn(200);
      } else {
        $(this).fadeOut(150);
      }
    });
  });

  // Package search
  $('#packageSearch').on('input', function () {
    const q = $(this).val().toString().toLowerCase().trim();
    $('.package-item').each(function () {
      const t = $(this).data('title').toString();
      if (t.includes(q)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  // Booking form validation
  $('#bookingForm').on('submit', function (e) {
    const requiredFields = $(this).find('[required]');
    let valid = true;

    requiredFields.each(function () {
      if (!$(this).val().toString().trim()) {
        valid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    const email = $(this).find('input[type="email"]').val();
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      valid = false;
      $(this).find('input[type="email"]').addClass('is-invalid');
    }

    if (!valid) {
      e.preventDefault();
    }
  });

  $('.form-control, .form-select').on('input change', function () {
    $(this).removeClass('is-invalid');
  });
});
