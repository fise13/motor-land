/**
 * Scroll Animations для каталога товаров
 * Использует Intersection Observer для плавных анимаций при появлении элементов
 * Оптимизировано для 60fps с использованием CSS transitions и will-change
 * Поддерживает prefers-reduced-motion
 */

(function() {
	'use strict';

	// Проверка поддержки prefers-reduced-motion
	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	
	// Если пользователь предпочитает уменьшенные анимации, показываем элементы сразу
	if (prefersReducedMotion) {
		const cards = document.querySelectorAll('.toverblock');
		cards.forEach(function(card) {
			card.classList.add('animate-in');
		});
		return;
	}

	// Проверка поддержки Intersection Observer
	if (!('IntersectionObserver' in window)) {
		// Fallback: просто показываем элементы без анимации
		const cards = document.querySelectorAll('.toverblock');
		cards.forEach(function(card) {
			card.classList.add('animate-in');
		});
		return;
	}

	/**
	 * Анимация входа карточки с использованием CSS transitions и requestAnimationFrame
	 * Использует will-change для оптимизации и избегает layout thrashing
	 * @param {HTMLElement} element - Элемент для анимации
	 * @param {string} direction - Направление анимации ('up', 'down', 'left', 'right')
	 */
	function animateIn(element, direction) {
		// Проверяем, не была ли анимация уже запущена
		if (element.classList.contains('animating') || element.classList.contains('animate-in')) {
			return;
		}

		// Используем requestAnimationFrame для синхронизации с браузером
		requestAnimationFrame(function() {
			// Устанавливаем will-change до начала анимации для оптимизации
			element.style.willChange = 'opacity, transform';
			element.classList.add('animating');

			// Определяем начальные значения transform в зависимости от направления
			let startTransform = '';
			switch(direction) {
				case 'up':
					startTransform = 'translateY(30px)';
					break;
				case 'down':
					startTransform = 'translateY(-30px)';
					break;
				case 'left':
					startTransform = 'translateX(30px)';
					break;
				case 'right':
					startTransform = 'translateX(-30px)';
					break;
				default:
					startTransform = 'translateY(30px)';
			}

			// Устанавливаем начальное состояние через requestAnimationFrame
			// Это гарантирует, что браузер обработает изменение до следующего frame
			requestAnimationFrame(function() {
				element.style.opacity = '0';
				element.style.transform = startTransform;

				// Запускаем CSS transition через следующий frame
				// Это позволяет браузеру зафиксировать начальное состояние
				requestAnimationFrame(function() {
					// Добавляем класс для запуска CSS transition к финальному состоянию
					element.classList.add('animate-in');
					
					// Очищаем will-change после завершения анимации для освобождения ресурсов
					setTimeout(function() {
						element.style.willChange = '';
						element.classList.remove('animating');
						// Оставляем inline styles для transform и opacity - они будут переопределены классом
					}, 600); // Длительность анимации из CSS
				});
			});
		});
	}

	/**
	 * Инициализация анимаций для карточек каталога
	 */
	function initCatalogAnimations() {
		// Получаем все карточки, но исключаем те, которые используют revealator
		const allCards = document.querySelectorAll('.toverblock');
		const cards = Array.from(allCards).filter(function(card) {
			// Пропускаем карточки, которые уже используют revealator
			return !card.classList.contains('revealator-slideup') &&
			       !card.classList.contains('revealator-slidedown') &&
			       !card.classList.contains('revealator-slideleft') &&
			       !card.classList.contains('revealator-slideright') &&
			       !card.classList.contains('revealator-fade') &&
			       !card.classList.contains('revealator-zoom');
		});
		
		if (cards.length === 0) {
			return;
		}

		// Создаём Intersection Observer
		const observer = new IntersectionObserver(function(entries, observer) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					const card = entry.target;
					const cardIndex = cards.indexOf(card);
					
					// Определяем направление анимации в зависимости от индекса
					// Чередуем направления: up, right, up, left, up, right и т.д.
					let direction;
					switch(cardIndex % 4) {
						case 0:
							direction = 'up';
							break;
						case 1:
							direction = 'right';
							break;
						case 2:
							direction = 'up';
							break;
						case 3:
							direction = 'left';
							break;
						default:
							direction = 'up';
					}

					// Добавляем небольшую задержку для эффекта каскада
					// Используем requestAnimationFrame для точной синхронизации
					const delay = (cardIndex % 6) * 50;
					
					if (delay === 0) {
						animateIn(card, direction);
					} else {
						setTimeout(function() {
							animateIn(card, direction);
						}, delay);
					}

					// Перестаём наблюдать за элементом после запуска анимации
					observer.unobserve(card);
				}
			});
		}, {
			// Запускаем анимацию когда элемент на 10% виден
			threshold: 0.1,
			// Начинаем загрузку когда элемент на 100px до viewport
			rootMargin: '100px 0px'
		});

		// Наблюдаем за всеми карточками
		cards.forEach(function(card) {
			observer.observe(card);
		});
	}

	// Инициализация после загрузки DOM
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCatalogAnimations);
	} else {
		// DOM уже загружен
		initCatalogAnimations();
	}

})();
