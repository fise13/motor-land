/**
 * КАТАЛОГ - ИНТЕРАКТИВНОСТЬ КАРТОЧЕК ТОВАРОВ
 * Фокус на конверсию и UX
 */

(function() {
	'use strict';
	
	// Инициализация при загрузке DOM
	document.addEventListener('DOMContentLoaded', function() {
		initCatalogCards();
	});
	
	/**
	 * Инициализация карточек каталога
	 */
	function initCatalogCards() {
		// Добавляем hover-эффекты для изображений
		initImageHover();
		
		// Добавляем анимации появления карточек
		initScrollAnimations();
		
		// Улучшаем кликабельность CTA
		initCTAClicks();
	}
	
	/**
	 * Hover-эффекты для изображений
	 */
	function initImageHover() {
		const cards = document.querySelectorAll('.catalog-product-card');
		
		cards.forEach(function(card) {
			const img = card.querySelector('.catalog-product-img');
			if (!img) return;
			
			// При наведении на карточку - увеличиваем изображение
			card.addEventListener('mouseenter', function() {
				if (img) {
					img.style.transform = 'scale(1.05)';
				}
			});
			
			card.addEventListener('mouseleave', function() {
				if (img) {
					img.style.transform = 'scale(1)';
				}
			});
		});
	}
	
	/**
	 * Анимации появления карточек при скролле
	 */
	function initScrollAnimations() {
		const cards = document.querySelectorAll('.catalog-product-card');
		
		if (!cards.length) return;
		
		// Intersection Observer для анимации появления
		const observerOptions = {
			root: null,
			rootMargin: '50px',
			threshold: 0.1
		};
		
		const observer = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry, index) {
				if (entry.isIntersecting) {
					setTimeout(function() {
						entry.target.style.opacity = '1';
						entry.target.style.transform = 'translateY(0)';
					}, index * 50); // Задержка для каскадного эффекта
					observer.unobserve(entry.target);
				}
			});
		}, observerOptions);
		
		// Инициализация начального состояния
		cards.forEach(function(card, index) {
			card.style.opacity = '0';
			card.style.transform = 'translateY(20px)';
			card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
			observer.observe(card);
		});
	}
	
	/**
	 * Улучшение кликабельности CTA
	 */
	function initCTAClicks() {
		const ctaButtons = document.querySelectorAll('.catalog-btn-primary');
		
		ctaButtons.forEach(function(button) {
			// Добавляем визуальную обратную связь при клике
			button.addEventListener('click', function(e) {
				// Создаем ripple-эффект
				const ripple = document.createElement('span');
				ripple.style.position = 'absolute';
				ripple.style.borderRadius = '50%';
				ripple.style.background = 'rgba(255, 255, 255, 0.6)';
				ripple.style.width = '20px';
				ripple.style.height = '20px';
				ripple.style.left = '50%';
				ripple.style.top = '50%';
				ripple.style.transform = 'translate(-50%, -50%)';
				ripple.style.animation = 'ripple 0.6s ease-out';
				ripple.style.pointerEvents = 'none';
				
				button.style.position = 'relative';
				button.style.overflow = 'hidden';
				button.appendChild(ripple);
				
				setTimeout(function() {
					ripple.remove();
				}, 600);
			});
		});
	}
	
	// Добавляем CSS для ripple-эффекта
	const style = document.createElement('style');
	style.textContent = `
		@keyframes ripple {
			to {
				transform: translate(-50%, -50%) scale(10);
				opacity: 0;
			}
		}
	`;
	document.head.appendChild(style);
	
})();
