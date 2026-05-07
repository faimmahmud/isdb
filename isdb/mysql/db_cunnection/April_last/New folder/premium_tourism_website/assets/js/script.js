$(function () {
    // Sticky nav shadow
    const nav = $('#siteNav');
    const onScroll = () => {
        if ($(window).scrollTop() > 10) nav.addClass('scrolled');
        else nav.removeClass('scrolled');
    };
    onScroll();
    $(window).on('scroll', onScroll);

    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function (e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: target.offset().top - 90 }, 650);
        }
    });

    // Reveal on scroll
    const revealEls = $('.reveal');
    const revealOnScroll = function () {
        const triggerBottom = $(window).scrollTop() + $(window).height() * 0.88;
        revealEls.each(function () {
            const top = $(this).offset().top;
            if (top < triggerBottom) $(this).addClass('show');
        });
    };
    revealOnScroll();
    $(window).on('scroll resize', revealOnScroll);

    // Package filter (front-end)
    $('[data-filter]').on('click', function () {
        const filter = $(this).data('filter');
        $('[data-filter]').removeClass('active');
        $(this).addClass('active');
        if (filter === 'all') {
            $('.filter-item').show();
        } else {
            $('.filter-item').hide();
            $('.filter-item[data-category="' + filter + '"]').fadeIn(250);
        }
    });

    // Destination search
    $('#destinationSearch').on('input', function () {
        const query = $(this).val().toLowerCase();
        $('.destination-card').each(function () {
            const text = $(this).data('text').toLowerCase();
            $(this).toggle(text.indexOf(query) > -1);
        });
    });

    // Testimonial rotator
    const testimonials = $('.testimonial-item');
    let current = 0;
    const showTestimonial = (i) => {
        testimonials.hide().removeClass('show');
        testimonials.eq(i).fadeIn(350).addClass('show');
    };
    if (testimonials.length > 1) {
        showTestimonial(current);
        setInterval(() => {
            current = (current + 1) % testimonials.length;
            showTestimonial(current);
        }, 5000);
    }

    // Booking form AJAX
    $('#bookingForm').on('submit', function (e) {
        const form = $(this);
        if (!form.length) return;
        e.preventDefault();

        const formData = new FormData(this);
        $.ajax({
            url: 'booking.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
                const box = $('#bookingMessage');
                box.removeClass('d-none alert-danger alert-success')
                   .addClass('alert-' + (res.status === 'success' ? 'success' : 'danger'))
                   .text(res.message);
                if (res.status === 'success') form.trigger('reset');
            },
            error: function () {
                $('#bookingMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Something went wrong. Please try again.');
            }
        });
    });
});
