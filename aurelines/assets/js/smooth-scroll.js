/**
 * Aurelines — Smooth scroll + scroll reveal + header effects + logo swap.
 */
(function () {
	'use strict';

	/* ─── Smooth scroll for anchor links ─── */
	document.addEventListener('click', function (e) {
		var link = e.target.closest('a[href*="#"]');
		if (!link) return;

		var href = link.getAttribute('href');
		var hash = href.includes('#') ? '#' + href.split('#')[1] : null;
		if (!hash || hash === '#') return;

		var target = document.querySelector(hash);
		if (!target) return;

		e.preventDefault();

		/* Close mobile nav overlay if open */
		var overlay = link.closest('.wp-block-navigation__responsive-container.is-menu-open');
		if (overlay) {
			var closeBtn = overlay.querySelector('.wp-block-navigation__responsive-container-close');
			if (closeBtn) closeBtn.click();
		}

		var header = document.querySelector('.aurelines-header');
		if (!header) {
			header = document.querySelector('[style*="position:sticky"]');
		}
		var offset = header ? header.offsetHeight : 0;

		var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;

		window.scrollTo({
			top: targetPosition,
			behavior: 'smooth'
		});

		history.pushState(null, null, hash);
	});

	/* ─── Scroll reveal (IntersectionObserver) ─── */
	var revealElements = document.querySelectorAll('.aurelines-reveal');

	if (revealElements.length && 'IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.12,
			rootMargin: '0px 0px -40px 0px'
		});

		revealElements.forEach(function (el) {
			observer.observe(el);
		});
	} else {
		revealElements.forEach(function (el) {
			el.classList.add('is-visible');
		});
	}

	/* ─── Header scroll effect ─── */
	var header = document.querySelector('.aurelines-header');
	if (header) {
		window.addEventListener('scroll', function () {
			var currentScroll = window.pageYOffset;
			if (currentScroll > 60) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		}, { passive: true });
	}
})();
