(function($){
  const cursor = document.querySelector('.lux-cursor');
  const state = {x: window.innerWidth / 2, y: window.innerHeight / 2, tx: window.innerWidth / 2, ty: window.innerHeight / 2};

  function animateCursor(){
    state.x += (state.tx - state.x) * 0.16;
    state.y += (state.ty - state.y) * 0.16;
    if (cursor) cursor.style.transform = `translate(${state.x}px, ${state.y}px) translate(-50%, -50%)`;
    requestAnimationFrame(animateCursor);
  }
  requestAnimationFrame(animateCursor);

  $(document).on('mousemove', function(e){
    state.tx = e.clientX;
    state.ty = e.clientY;
  });

  $('a, button, .btn, .package-card, .destination-card, .country-card, .full-hero-card').on('mouseenter', function(){
    $('body').addClass('cursor-hover');
  }).on('mouseleave', function(){
    $('body').removeClass('cursor-hover');
  });

  const nav = $('.luxury-nav');
  function navState(){ nav.toggleClass('scrolled', window.scrollY > 10); }
  navState();
  $(window).on('scroll', navState);

  const revealObserver = new IntersectionObserver((entries)=>{
    entries.forEach(entry => {
      if(entry.isIntersecting) entry.target.classList.add('show');
    });
  }, { threshold: 0.12 });

  $('.reveal').each(function(){ revealObserver.observe(this); });

  const slides = $('.hero-bg');
  let current = 0;
  function showSlide(idx){
    slides.removeClass('active');
    slides.eq(idx).addClass('active');
    current = idx;
  }
  if (slides.length > 1){
    showSlide(0);
    setInterval(function(){
      showSlide((current + 1) % slides.length);
    }, 6500);
  } else if (slides.length === 1) {
    slides.addClass('active');
  }

  $(document).on('click', 'a[href^="#"]', function(e){
    const target = this.getAttribute('href');
    if (target.length > 1 && $(target).length){
      e.preventDefault();
      $('html, body').animate({scrollTop: $(target).offset().top - 90}, 700);
      $('.navbar-collapse').collapse('hide');
    }
  });

  $('[data-filter]').on('click', function(){
    const filter = String($(this).data('filter'));
    $('[data-filter]').removeClass('active');
    $(this).addClass('active');
    const items = $('[data-item]');
    if (filter === 'all'){
      items.fadeIn(180);
      return;
    }
    items.each(function(){
      const item = String($(this).data('item') ?? '');
      const search = String($(this).data('search') ?? '').toLowerCase();
      $(this).toggle(item === filter || search.includes(filter.toLowerCase()));
    });
  });

  $('#heroSearch').on('submit', function(e){
    e.preventDefault();
    const val = String($('#searchInput').val() || '').toLowerCase().trim();
    if (!val) return;
    const match = $('[data-search]').filter(function(){
      return String($(this).data('search') || '').toLowerCase().includes(val);
    }).first();
    if (match.length){
      $('html, body').animate({scrollTop: match.offset().top - 90}, 700);
      match.addClass('shadow-lg');
      setTimeout(()=>match.removeClass('shadow-lg'), 1200);
    }
  });

  $('#bookingForm').on('submit', function(e){
    e.preventDefault();
    const btn = $(this).find('button[type="submit"]');
    const label = btn.html();
    btn.prop('disabled', true).html('Sending...');
    $.ajax({
      url: this.action,
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json'
    }).done(function(res){
      if (res && res.success){
        luxToast('success', res.message || 'Booking submitted successfully.');
        $('#bookingForm')[0].reset();
      } else {
        luxToast('danger', (res && res.message) ? res.message : 'Something went wrong.');
      }
    }).fail(function(){
      luxToast('danger', 'Request failed. Please try again.');
    }).always(function(){
      btn.prop('disabled', false).html(label);
    });
  });

  function luxToast(type, message){
    const icon = type === 'success' ? 'bi-check2-circle' : 'bi-exclamation-triangle';
    const title = type === 'success' ? 'Success' : 'Attention';
    const toast = $(`
      <div class="toast lux-toast show align-items-center border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body d-flex align-items-start gap-3">
          <div class="toast-icon"><i class="bi ${icon}"></i></div>
          <div class="flex-grow-1">
            <div class="toast-title text-uppercase">${title}</div>
            <div class="toast-message">${message}</div>
          </div>
          <button type="button" class="btn-close btn-close-white ms-auto" aria-label="Close"></button>
        </div>
      </div>
    `);
    const stack = $('.lux-toast-stack');
    if (!stack.length){
      $('body').append('<div class="lux-toast-stack position-fixed top-0 end-0 p-3" style="z-index:1080;"></div>');
    }
    $('.lux-toast-stack').append(toast);
    toast.find('.btn-close').on('click', function(){ toast.fadeOut(200, ()=>toast.remove()); });
    setTimeout(()=>toast.fadeOut(250, ()=>toast.remove()), 4800);
  }

  const flashToast = $('.lux-toast.show');
  if (flashToast.length){
    setTimeout(()=>flashToast.fadeOut(250, ()=>flashToast.remove()), 5200);
  }
})(jQuery);
