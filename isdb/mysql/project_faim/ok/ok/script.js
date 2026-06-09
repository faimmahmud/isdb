(function ($) {
    'use strict';

    const root = window.location.pathname.includes('/admin/') ? '../' : '';

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function money(value) {
        return Number(value || 0).toLocaleString(undefined, {
            maximumFractionDigits: 0
        });
    }

    function refreshIcons() {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function initNavbar() {
        const $nav = $('.luxury-navbar');
        const update = () => $nav.toggleClass('is-scrolled', window.scrollY > 20);
        update();
        $(window).on('scroll', update);
    }

    function initReveal() {
        const items = document.querySelectorAll('.reveal');

        if (!('IntersectionObserver' in window)) {
            items.forEach((item) => item.classList.add('is-visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.14,
            rootMargin: '0px 0px -8% 0px'
        });

        items.forEach((item) => observer.observe(item));
    }

    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function (event) {
            const target = $(this.getAttribute('href'));

            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 700);
            }
        });
    }

    function initCursor() {
        if (window.matchMedia('(hover: none), (pointer: coarse)').matches) {
            return;
        }

        const dot = document.querySelector('.cursor-dot');
        const ring = document.querySelector('.cursor-ring');
        let mouseX = 0;
        let mouseY = 0;
        let ringX = 0;
        let ringY = 0;

        if (!dot || !ring) {
            return;
        }

        document.body.classList.add('cursor-ready');

        window.addEventListener('mousemove', (event) => {
            mouseX = event.clientX;
            mouseY = event.clientY;
            dot.style.transform = `translate3d(${mouseX}px, ${mouseY}px, 0) translate(-50%, -50%)`;
        }, {
            passive: true
        });

        function renderRing() {
            ringX += (mouseX - ringX) * 0.16;
            ringY += (mouseY - ringY) * 0.16;
            ring.style.transform = `translate3d(${ringX}px, ${ringY}px, 0) translate(-50%, -50%)`;
            requestAnimationFrame(renderRing);
        }

        renderRing();

        $(document)
            .on('mouseenter', 'a, button, .magnetic, input, select, textarea', () => document.body.classList.add('cursor-active'))
            .on('mouseleave', 'a, button, .magnetic, input, select, textarea', () => document.body.classList.remove('cursor-active'));
    }

    function initMagneticButtons() {
        if (window.matchMedia('(hover: none), (pointer: coarse)').matches) {
            return;
        }

        $('.magnetic').on('mousemove', function (event) {
            const rect = this.getBoundingClientRect();
            const x = event.clientX - rect.left - rect.width / 2;
            const y = event.clientY - rect.top - rect.height / 2;
            this.style.transform = `translate3d(${x * 0.09}px, ${y * 0.12}px, 0)`;
        }).on('mouseleave', function () {
            this.style.transform = '';
        });
    }

    function initParallax() {
        const media = Array.from(document.querySelectorAll('.parallax-media > img'));

        if (!media.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        let ticking = false;

        function update() {
            const viewport = window.innerHeight;

            media.forEach((img) => {
                const rect = img.parentElement.getBoundingClientRect();

                if (rect.bottom < 0 || rect.top > viewport) {
                    return;
                }

                const progress = (viewport - rect.top) / (viewport + rect.height);
                const y = (progress - 0.5) * 42;
                img.style.transform = `translate3d(0, ${y}px, 0) scale(1.08)`;
            });

            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        }, {
            passive: true
        });

        update();
    }

    function initCounters() {
        const counters = document.querySelectorAll('[data-count]');

        if (!counters.length) {
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const element = entry.target;
                const target = Number(element.dataset.count);
                const decimals = String(element.dataset.count).includes('.') ? 1 : 0;
                const start = performance.now();
                const duration = 1200;

                function tick(now) {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    element.textContent = (target * eased).toFixed(decimals);

                    if (progress < 1) {
                        requestAnimationFrame(tick);
                    }
                }

                requestAnimationFrame(tick);
                observer.unobserve(element);
            });
        }, {
            threshold: 0.5
        });

        counters.forEach((counter) => observer.observe(counter));
    }

    function initDestinationFilters() {
        $('[data-filter-group="destinations"] .filter-btn').on('click', function () {
            const filter = this.dataset.filter;
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');

            $('.destination-panel').each(function () {
                const match = filter === 'all' || this.dataset.category === filter;
                $(this).stop(true, true)[match ? 'fadeIn' : 'fadeOut'](280);
            });
        });
    }

    function packageTemplate(pkg, index) {
        const highlights = String(pkg.highlights || '')
            .split(',')
            .map((item) => item.trim())
            .filter(Boolean)
            .map((item) => `<span>${escapeHtml(item)}</span>`)
            .join('');

        return `
            <section class="package-story panel-full parallax-media reveal is-visible">
                <img src="${escapeHtml(pkg.image)}" alt="${escapeHtml(pkg.title)}" loading="${index === 0 ? 'eager' : 'lazy'}">
                <div class="panel-shade"></div>
                <div class="container">
                    <article class="package-detail glass-panel">
                        <div class="package-meta">
                            <span>${escapeHtml(pkg.destination)}</span>
                            <span><i data-lucide="star"></i>${escapeHtml(pkg.rating)}</span>
                            <span>${escapeHtml(pkg.duration)}</span>
                        </div>
                        <h2>${escapeHtml(pkg.title)}</h2>
                        <p>${escapeHtml(pkg.description)}</p>
                        <div class="feature-pills">${highlights}</div>
                        <div class="story-actions">
                            <span class="price-tag">$${money(pkg.price)}</span>
                            <a class="btn btn-arc magnetic" href="booking.php?package=${encodeURIComponent(pkg.id)}">Book Now</a>
                        </div>
                    </article>
                </div>
            </section>
        `;
    }

    function initPackageAjax() {
        $('#packageFilters').on('submit', function (event) {
            event.preventDefault();
            const $results = $('#packageResults');
            const params = $(this).serialize();

            $results.addClass('is-loading');

            $.getJSON(`${root}api/packages.php?${params}`)
                .done((response) => {
                    if (!response.ok || !response.packages.length) {
                        $results.html('<section class="panel-soft"><div class="container"><div class="empty-state glass-panel"><h2>No packages found.</h2><p>Try another destination or category.</p></div></div></section>');
                        return;
                    }

                    $results.html(response.packages.map(packageTemplate).join(''));
                    refreshIcons();
                    initMagneticButtons();
                    initParallax();
                })
                .fail(() => {
                    $results.html('<section class="panel-soft"><div class="container"><div class="empty-state glass-panel"><h2>Could not load packages.</h2><p>Please refresh the page.</p></div></div></section>');
                })
                .always(() => {
                    $results.removeClass('is-loading');
                });
        });
    }

    function initHeroSearch() {
        $('#heroSearch').on('submit', function (event) {
            event.preventDefault();
            const query = $.trim($(this).find('[name="q"]').val());
            const $results = $('#heroSearchResults');

            if (!query) {
                $results.hide().empty();
                return;
            }

            $.getJSON(`${root}api/search.php`, {
                q: query
            }).done((response) => {
                const items = response.results || [];

                if (!items.length) {
                    $results.html('<div class="empty">No matching journeys yet.</div>').fadeIn(160);
                    return;
                }

                $results.html(items.map((item) => `
                    <a href="${escapeHtml(item.url)}">
                        <strong>${escapeHtml(item.title)}</strong>
                        <small>${escapeHtml(item.type)} - ${escapeHtml(item.subtitle)}</small>
                    </a>
                `).join('')).fadeIn(160);
            });
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('#heroSearch').length) {
                $('#heroSearchResults').fadeOut(120);
            }
        });
    }

    function initBookingForm() {
        $('#bookingForm').on('submit', function (event) {
            event.preventDefault();
            const form = this;
            const $status = $('#bookingStatus');
            const $button = $(form).find('button[type="submit"]');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            $button.prop('disabled', true).addClass('disabled');
            $status.removeClass('success error').text('');

            $.ajax({
                url: `${root}api/booking_submit.php`,
                method: 'POST',
                data: $(form).serialize(),
                dataType: 'json'
            }).done((response) => {
                $status.addClass('success').text(response.message || 'Booking request received.');
                form.reset();
            }).fail((xhr) => {
                const response = xhr.responseJSON || {};
                $status.addClass('error').text(response.message || 'Could not submit booking. Please try again.');
            }).always(() => {
                $button.prop('disabled', false).removeClass('disabled');
            });
        });
    }

    function initCountrySearch() {
        $('#countrySearch').on('input', function () {
            const query = $.trim(this.value).toLowerCase();
            let shown = 0;

            $('.country-panel').each(function () {
                const match = !query || String(this.dataset.country || '').includes(query);
                this.classList.toggle('is-hidden', !match);

                if (match) {
                    shown += 1;
                }
            });

            $('.country-atlas').toggleClass('has-filter', Boolean(query));
        });
    }

    $(function () {
        refreshIcons();
        initNavbar();
        initReveal();
        initSmoothScroll();
        initCursor();
        initMagneticButtons();
        initParallax();
        initCounters();
        initDestinationFilters();
        initPackageAjax();
        initHeroSearch();
        initBookingForm();
        initCountrySearch();
    });
})(jQuery);
