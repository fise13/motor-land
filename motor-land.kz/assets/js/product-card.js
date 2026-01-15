/**
 * PRODUCT CARD - E-COMMERCE FUNCTIONALITY
 * Современный JavaScript для карточки товара
 */

(function() {
	'use strict';
	
	// Глобальные переменные
	let currentImageIndex = 0;
	let productImages = [];
	
	// Инициализация при загрузке DOM
	document.addEventListener('DOMContentLoaded', function() {
		initProductCard();
	});
	
	/**
	 * Инициализация карточки товара
	 */
	function initProductCard() {
		// Получаем данные товара из window.productData
		if (window.productData && window.productData.images) {
			productImages = window.productData.images;
		}
		
		// Инициализация форм
		initFormValidation();
		
		// Инициализация модальных окон
		initModals();
		
		// Инициализация галереи
		initGallery();
		
		// Инициализация избранного
		initFavorite();
		
		// Обработка закрытия модальных окон по ESC
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				closeAllModals();
			}
		});
	}
	
	/**
	 * Инициализация валидации форм
	 */
	function initFormValidation() {
		// Валидация телефона
		const phoneInputs = document.querySelectorAll('input[type="tel"]');
		phoneInputs.forEach(input => {
			input.addEventListener('input', function() {
				validatePhone(this);
			});
			
			input.addEventListener('blur', function() {
				validatePhone(this);
			});
		});
		
		// Валидация имени
		const nameInputs = document.querySelectorAll('input[name="name"]');
		nameInputs.forEach(input => {
			input.addEventListener('blur', function() {
				validateName(this);
			});
		});
	}
	
	/**
	 * Валидация телефона
	 */
	function validatePhone(input) {
		const phone = input.value.replace(/\D/g, '');
		const isValid = phone.length >= 10 && phone.length <= 15;
		
		if (input.value && !isValid) {
			showFieldError(input, 'Введите корректный номер телефона');
			return false;
		} else {
			clearFieldError(input);
			return true;
		}
	}
	
	/**
	 * Валидация имени
	 */
	function validateName(input) {
		const name = input.value.trim();
		const isValid = name.length >= 2 && name.length <= 50;
		
		if (input.value && !isValid) {
			showFieldError(input, 'Имя должно содержать от 2 до 50 символов');
			return false;
		} else {
			clearFieldError(input);
			return true;
		}
	}
	
	/**
	 * Показать ошибку поля
	 */
	function showFieldError(input, message) {
		input.classList.add('error');
		const errorElement = input.parentElement.querySelector('.form-error');
		if (errorElement) {
			errorElement.textContent = message;
			errorElement.style.display = 'block';
		}
	}
	
	/**
	 * Убрать ошибку поля
	 */
	function clearFieldError(input) {
		input.classList.remove('error');
		const errorElement = input.parentElement.querySelector('.form-error');
		if (errorElement) {
			errorElement.style.display = 'none';
		}
	}
	
	/**
	 * Инициализация модальных окон
	 */
	function initModals() {
		// Закрытие по клику на overlay
		const overlays = document.querySelectorAll('.modal-overlay');
		overlays.forEach(overlay => {
			overlay.addEventListener('click', function() {
				const modal = this.closest('.modal');
				if (modal) {
					closeModal(modal);
				}
			});
		});
	}
	
	/**
	 * Открыть модальное окно
	 */
	function openModal(modalId) {
		const modal = document.getElementById(modalId);
		if (modal) {
			// Сохраняем текущую позицию прокрутки
			const scrollY = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;
			
			// Блокируем прокрутку страницы - фиксируем body
			document.body.style.position = 'fixed';
			document.body.style.top = `-${scrollY}px`;
			document.body.style.left = '0';
			document.body.style.right = '0';
			document.body.style.width = '100%';
			document.body.style.overflow = 'hidden';
			document.body.style.height = '100%';
			
			// Также блокируем прокрутку на html элементе
			document.documentElement.style.overflow = 'hidden';
			document.documentElement.style.height = '100%';
			
			// Убеждаемся, что модальное окно фиксировано относительно viewport
			modal.style.position = 'fixed';
			modal.style.top = '0';
			modal.style.left = '0';
			modal.style.right = '0';
			modal.style.bottom = '0';
			modal.style.width = '100vw';
			modal.style.height = '100vh';
			
			// Открываем модальное окно
			modal.classList.add('active');
			
			// Сохраняем позицию прокрутки в data-атрибут для восстановления
			modal.setAttribute('data-scroll-y', scrollY);
			
			// Убеждаемся, что модальное окно по центру viewport
			// Прокручиваем модальное окно в начало, если оно длинное
			const modalContent = modal.querySelector('.modal-content');
			if (modalContent) {
				modalContent.scrollTop = 0;
			}
			
			// Прокручиваем сам модальный контейнер в начало (на случай если он длинный)
			modal.scrollTop = 0;
			
			// Фокус на первое поле формы
			const firstInput = modal.querySelector('input, textarea');
			if (firstInput) {
				setTimeout(() => firstInput.focus(), 100);
			}
		}
	}
	
	/**
	 * Закрыть модальное окно
	 */
	function closeModal(modal) {
		if (typeof modal === 'string') {
			modal = document.getElementById(modal);
		}
		if (modal) {
			modal.classList.remove('active');
			
			// Восстанавливаем прокрутку страницы
			const scrollY = modal.getAttribute('data-scroll-y') || '0';
			
			// Убираем блокировку прокрутки
			document.body.style.position = '';
			document.body.style.top = '';
			document.body.style.left = '';
			document.body.style.right = '';
			document.body.style.width = '';
			document.body.style.overflow = '';
			document.body.style.height = '';
			document.documentElement.style.overflow = '';
			document.documentElement.style.height = '';
			
			// Убираем inline стили с модального окна
			modal.style.position = '';
			modal.style.top = '';
			modal.style.left = '';
			modal.style.right = '';
			modal.style.bottom = '';
			modal.style.width = '';
			modal.style.height = '';
			
			// Восстанавливаем позицию прокрутки
			window.scrollTo({
				top: parseInt(scrollY),
				behavior: 'auto'
			});
			
			// Очистка формы
			const form = modal.querySelector('form');
			if (form) {
				form.reset();
				// Очистка ошибок
				form.querySelectorAll('.error').forEach(el => {
					el.classList.remove('error');
				});
				form.querySelectorAll('.form-error').forEach(el => {
					el.style.display = 'none';
				});
			}
		}
	}
	
	/**
	 * Закрыть все модальные окна
	 */
	function closeAllModals() {
		document.querySelectorAll('.modal.active').forEach(modal => {
			closeModal(modal);
		});
	}
	
	/**
	 * Инициализация галереи
	 */
	function initGallery() {
		// Hover эффект для главного изображения
		const mainImage = document.getElementById('main-product-image');
		if (mainImage) {
			mainImage.addEventListener('mouseenter', function() {
				this.style.cursor = 'zoom-in';
			});
		}
	}
	
	/**
	 * Изменить главное изображение
	 */
	function changeMainImage(index) {
		if (!productImages || !productImages[index]) return;
		
		currentImageIndex = index;
		const imageData = productImages[index];
		const mainImg = document.getElementById('main-product-image');
		const mainContainer = document.getElementById('main-image-container');
		
		if (mainImg && imageData) {
			// Плавная смена изображения
			mainImg.style.opacity = '0';
			
			setTimeout(() => {
				const imgSrc = imageData.webp || imageData.original;
				mainImg.src = imgSrc;
				mainImg.srcset = imgSrc;
				
				// Обновляем source в picture
				const picture = mainImg.closest('picture');
				if (picture) {
					const source = picture.querySelector('source');
					if (source) {
						source.srcset = imgSrc;
					}
				}
				
				// Обновляем data-zoom-src
				mainImg.setAttribute('data-zoom-src', imgSrc);
				
				mainImg.style.opacity = '1';
			}, 150);
		}
		
		// Обновляем активную миниатюру
		document.querySelectorAll('.product-thumb').forEach((thumb, i) => {
			if (i === index) {
				thumb.classList.add('active');
			} else {
				thumb.classList.remove('active');
			}
		});
	}
	
	/**
	 * Открыть модальное окно изображения
	 */
	function openImageModal(index) {
		if (!productImages || !productImages[index]) return;
		
		currentImageIndex = index;
		const imageData = productImages[index];
		const modalImg = document.getElementById('modal-image');
		
		if (modalImg && imageData) {
			const imgSrc = imageData.webp || imageData.original;
			modalImg.src = imgSrc;
			modalImg.alt = window.productData ? window.productData.name : 'Изображение товара';
		}
		
		openModal('image-modal');
	}
	
	/**
	 * Навигация по изображениям в модальном окне
	 */
	function navigateImage(direction) {
		if (!productImages || productImages.length === 0) return;
		
		currentImageIndex += direction;
		
		if (currentImageIndex < 0) {
			currentImageIndex = productImages.length - 1;
		} else if (currentImageIndex >= productImages.length) {
			currentImageIndex = 0;
		}
		
		const imageData = productImages[currentImageIndex];
		const modalImg = document.getElementById('modal-image');
		
		if (modalImg && imageData) {
			const imgSrc = imageData.webp || imageData.original;
			modalImg.src = imgSrc;
		}
	}
	
	/**
	 * Инициализация избранного
	 */
	function initFavorite() {
		const favoriteBtn = document.getElementById('favorite-btn');
		if (favoriteBtn) {
			// Проверяем, есть ли товар в избранном
			const productId = window.productData ? window.productData.id : null;
			if (productId && isFavorite(productId)) {
				favoriteBtn.classList.add('active');
			}
		}
	}
	
	/**
	 * Переключить избранное
	 */
	function toggleFavorite() {
		const productId = window.productData ? window.productData.id : null;
		if (!productId) return;
		
		const favoriteBtn = document.getElementById('favorite-btn');
		const favorites = getFavorites();
		const index = favorites.indexOf(productId);
		
		if (index > -1) {
			// Удалить из избранного
			favorites.splice(index, 1);
			favoriteBtn.classList.remove('active');
			showToast('Удалено из избранного', 'success');
		} else {
			// Добавить в избранное
			favorites.push(productId);
			favoriteBtn.classList.add('active');
			showToast('Добавлено в избранное', 'success');
		}
		
		saveFavorites(favorites);
	}
	
	/**
	 * Получить список избранного
	 */
	function getFavorites() {
		try {
			const favorites = localStorage.getItem('favorites');
			return favorites ? JSON.parse(favorites) : [];
		} catch (e) {
			return [];
		}
	}
	
	/**
	 * Сохранить избранное
	 */
	function saveFavorites(favorites) {
		try {
			localStorage.setItem('favorites', JSON.stringify(favorites));
		} catch (e) {
			console.error('Ошибка сохранения избранного:', e);
		}
	}
	
	/**
	 * Проверить, в избранном ли товар
	 */
	function isFavorite(productId) {
		const favorites = getFavorites();
		return favorites.indexOf(productId) > -1;
	}
	
	/**
	 * Показать toast уведомление
	 */
	function showToast(message, type = 'success', title = '') {
		const container = document.getElementById('toast-container');
		if (!container) return;
		
		const toast = document.createElement('div');
		toast.className = `toast toast-${type}`;
		
		const icon = type === 'success' 
			? '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>'
			: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
		
		toast.innerHTML = `
			<div class="toast-icon">${icon}</div>
			<div class="toast-content">
				${title ? `<div class="toast-title">${title}</div>` : ''}
				<p class="toast-message">${message}</p>
			</div>
			<button class="toast-close" onclick="this.parentElement.remove()">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		`;
		
		container.appendChild(toast);
		
		// Показать toast
		setTimeout(() => {
			toast.classList.add('show');
		}, 10);
		
		// Автоматически скрыть через 5 секунд
		setTimeout(() => {
			toast.classList.remove('show');
			setTimeout(() => {
				toast.remove();
			}, 300);
		}, 5000);
	}
	
	/**
	 * Отправить запрос цены
	 */
	async function submitPriceRequest(event) {
		event.preventDefault();
		
		const form = event.target;
		const formData = new FormData(form);
		const submitBtn = form.querySelector('button[type="submit"]');
		const btnText = submitBtn.querySelector('.btn-text');
		const btnLoader = submitBtn.querySelector('.btn-loader');
		
		// Валидация
		const name = formData.get('name');
		const phone = formData.get('phone');
		
		if (!name || name.trim().length < 2) {
			showToast('Введите ваше имя', 'error');
			return;
		}
		
		if (!phone || !validatePhoneInput(phone)) {
			showToast('Введите корректный номер телефона', 'error');
			return;
		}
		
		// Показать loader
		submitBtn.disabled = true;
		if (btnText) btnText.style.display = 'none';
		if (btnLoader) btnLoader.style.display = 'block';
		
		try {
			const response = await fetch('/api/request-price.php', {
				method: 'POST',
				body: formData
			});
			
			const result = await response.json();
			
			if (result.success) {
				showToast('Запрос отправлен! Мы свяжемся с вами в ближайшее время.', 'success', 'Спасибо!');
				closeModal('price-modal');
				
				// Google Analytics событие
				if (typeof gtag === 'function') {
					gtag('event', 'conversion', {
						'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB',
						'value': window.productData && window.productData.price ? window.productData.price : 0,
						'currency': 'KZT'
					});
				}
			} else {
				showToast(result.message || 'Ошибка при отправке запроса', 'error');
			}
		} catch (error) {
			console.error('Ошибка отправки запроса:', error);
			showToast('Произошла ошибка. Попробуйте позже или свяжитесь с нами по телефону.', 'error');
		} finally {
			// Скрыть loader
			submitBtn.disabled = false;
			if (btnText) btnText.style.display = 'block';
			if (btnLoader) btnLoader.style.display = 'none';
		}
	}
	
	/**
	 * Отправить вопрос
	 */
	async function submitQuestion(event) {
		event.preventDefault();
		
		const form = event.target;
		const formData = new FormData(form);
		const submitBtn = form.querySelector('button[type="submit"]');
		
		// Валидация
		const name = formData.get('name');
		const phone = formData.get('phone');
		const question = formData.get('question');
		
		if (!name || name.trim().length < 2) {
			showToast('Введите ваше имя', 'error');
			return;
		}
		
		if (!phone || !validatePhoneInput(phone)) {
			showToast('Введите корректный номер телефона', 'error');
			return;
		}
		
		if (!question || question.trim().length < 10) {
			showToast('Введите ваш вопрос (минимум 10 символов)', 'error');
			return;
		}
		
		submitBtn.disabled = true;
		submitBtn.textContent = 'Отправка...';
		
		try {
			const response = await fetch('/api/request-question.php', {
				method: 'POST',
				body: formData
			});
			
			const result = await response.json();
			
			if (result.success) {
				showToast('Вопрос отправлен! Мы ответим вам в ближайшее время.', 'success', 'Спасибо!');
				closeModal('question-modal');
			} else {
				showToast(result.message || 'Ошибка при отправке вопроса', 'error');
			}
		} catch (error) {
			console.error('Ошибка отправки вопроса:', error);
			showToast('Произошла ошибка. Попробуйте позже или свяжитесь с нами по телефону.', 'error');
		} finally {
			submitBtn.disabled = false;
			submitBtn.textContent = 'Отправить вопрос';
		}
	}
	
	/**
	 * Валидация телефона
	 */
	function validatePhoneInput(phone) {
		const phoneDigits = phone.replace(/\D/g, '');
		return phoneDigits.length >= 10 && phoneDigits.length <= 15;
	}
	
	// Глобальные функции для вызова из HTML
	window.openPriceModal = function() {
		openModal('price-modal');
	};
	
	window.closePriceModal = function() {
		closeModal('price-modal');
	};
	
	window.openQuestionModal = function() {
		openModal('question-modal');
	};
	
	window.closeQuestionModal = function() {
		closeModal('question-modal');
	};
	
	window.openImageModal = function(index) {
		openImageModal(index);
	};
	
	window.closeImageModal = function() {
		closeModal('image-modal');
	};
	
	window.navigateImage = function(direction) {
		navigateImage(direction);
	};
	
	window.changeMainImage = function(index) {
		changeMainImage(index);
	};
	
	window.toggleFavorite = function() {
		toggleFavorite();
	};
	
	window.submitPriceRequest = function(event) {
		submitPriceRequest(event);
	};
	
	window.submitQuestion = function(event) {
		submitQuestion(event);
	};
	
})();
