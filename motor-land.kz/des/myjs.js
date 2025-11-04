$(document).ready(function() {
	
	// Плавное появление страницы при загрузке
	// Используем небольшую задержку для более плавного эффекта
	setTimeout(function() {
		$('body').addClass('page-loaded');
		$('html').css('opacity', '1');
	}, 50);


	/**
	 * Функция: Проверка возможности открытия выпадающего списка
	 * Описание: Проверяет, можно ли открыть список (для Модель и Год требуется выбор предыдущих полей)
	 * Параметры: meinputer - jQuery объект контейнера поля
	 * Возвращает: true если можно открыть, false если нельзя
	 */
	function canOpenDropdown(meinputer) {
		var fieldName = meinputer.find('input[type="hidden"]').attr('name');
		
		// Марка всегда доступна
		if (fieldName === 'mk') {
			return true;
		}
		
		// Для Модели требуется выбор Марки
		if (fieldName === 'ml') {
			var markValue = $('.meinputer').find('input[name="mk"]').val();
			if (!markValue || markValue === '') {
				return false;
			}
			return true;
		}
		
		// Для Года требуется выбор Модели
		if (fieldName === 'yr') {
			var modelValue = $('.meinputer').find('input[name="ml"]').val();
			if (!modelValue || modelValue === '') {
				return false;
			}
			return true;
		}
		
		return true;
	}

	/**
	 * Функция: Закрытие выпадающего списка с анимацией
	 * Описание: Плавно закрывает выпадающий список
	 * 			Если dropdown находится внутри .sliderform (главная страница), возвращает absolute позиционирование
	 * Accessibility: Обновляет ARIA атрибуты при закрытии
	 * Параметры: dd - jQuery объект выпадающего списка
	 * Возвращает: ничего
	 */
	function closeDropdown(dd) {
		if (dd.hasClass('open')) {
			var meinputer = dd.closest('.meinputer');
			var btn = meinputer.find('.btmmearrow');
			var isInSliderForm = dd.closest('.sliderform').length > 0;
			
			dd.css({
				'transform': 'translateY(0) scaleY(1)',
				'opacity': 1
			}).animate({
				opacity: 0
			}, {
				step: function(now, fx) {
					var progress = 1 - now;
					$(this).css('transform', 'translateY(' + (-8 * progress) + 'px) scaleY(' + (1 - 0.04 * progress) + ')');
				},
				duration: 250,
				easing: 'swing',
				complete: function() {
					var resetStyles = {
						'display': 'none',
						'transform': 'translateY(-6px) scaleY(0.98)',
						'opacity': 0
					};
					
					// Если dropdown был в fixed позиции, возвращаем absolute
					if (isInSliderForm) {
						resetStyles['position'] = 'absolute';
						resetStyles['left'] = '';
						resetStyles['top'] = '';
						resetStyles['width'] = '';
						resetStyles['z-index'] = '';
					}
					
					$(this).css(resetStyles).removeClass('open');
					// Разблокируем все поля при закрытии
					$('.meinputer').css({
						'pointer-events': '',
						'opacity': ''
					});
					$('.maipttee').removeClass('dropdown-open');
					// Accessibility: Обновляем ARIA атрибуты
					meinputer.attr('aria-expanded', 'false');
					btn.attr('aria-expanded', 'false');
					dd.attr('aria-hidden', 'true');
				}
			});
		}
	}

	/**
	 * Функция: Открытие выпадающего списка с анимацией
	 * Описание: Плавно открывает выпадающий список
	 * 			Если dropdown находится внутри .sliderform (главная страница), использует fixed позиционирование
	 * Accessibility: Обновляет ARIA атрибуты при открытии
	 * Параметры: dd - jQuery объект выпадающего списка
	 * Возвращает: ничего
	 */
	function openDropdown(dd) {
		if (!dd || dd.length === 0) return;
		
		var meinputer = dd.closest('.meinputer');
		if (!meinputer || meinputer.length === 0) return;
		
		var btn = meinputer.find('.btmmearrow');
		var isInSliderForm = dd.closest('.sliderform').length > 0;
		
		// Если dropdown находится внутри .sliderform (главная страница), используем fixed позиционирование
		if (isInSliderForm) {
			var meinputerOffset = meinputer.offset();
			if (!meinputerOffset) return;
			
			var meinputerHeight = meinputer.outerHeight();
			var ddWidth = meinputer.outerWidth();
			var scrollTop = $(window).scrollTop();
			var scrollLeft = $(window).scrollLeft();
			
			dd.css({
				'display': 'block',
				'opacity': 0,
				'transform': 'translateY(-10px) scaleY(0.95)',
				'position': 'fixed',
				'left': (meinputerOffset.left - scrollLeft) + 'px',
				'top': (meinputerOffset.top + meinputerHeight - scrollTop) + 'px',
				'width': ddWidth + 'px',
				'z-index': '999999',
				'pointer-events': 'auto'
			});
		} else {
			dd.css({
				'display': 'block',
				'opacity': 0,
				'transform': 'translateY(-10px) scaleY(0.95)',
				'position': 'absolute',
				'pointer-events': 'auto'
			});
		}
		
		// Небольшая задержка для инициализации
		setTimeout(function() {
			dd.animate({
				opacity: 1
			}, {
				step: function(now, fx) {
					var progress = now;
					var translateY = -10 + (10 * progress);
					var scaleY = 0.95 + (0.05 * progress);
					$(this).css('transform', 'translateY(' + translateY + 'px) scaleY(' + scaleY + ')');
				},
				duration: 300,
				easing: 'swing',
				complete: function() {
					$(this).css({
						'transform': 'translateY(0) scaleY(1)',
						'opacity': 1
					}).addClass('open');
					// Accessibility: Обновляем ARIA атрибуты
					meinputer.attr('aria-expanded', 'true');
					btn.attr('aria-expanded', 'true');
					dd.attr('aria-hidden', 'false');
				}
			});
		}, 10);
	}

	/**
	 * Функция: Обработка клика по стрелке выпадающего списка или по полю ввода
	 * Описание: При клике на стрелку или на само поле (Марка, Модель, Год) открывает/закрывает выпадающий список фильтров.
	 * 			Закрывает все остальные открытые списки и переключает состояние текущего.
	 * 			Проверяет валидацию - нельзя открыть следующее поле без выбора предыдущего.
	 * Accessibility: Обновляет ARIA атрибуты для screen readers
	 * Параметры: нет (использует элемент, на который кликнули)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".btmmearrow, .madiv", function (e) {
		// Предотвращаем всплытие события, чтобы не срабатывали другие обработчики
		e.stopPropagation();
		
		var meinputer = $(this).closest('.meinputer');
		var dd = meinputer.children('.ddwnblock');
		var btn = meinputer.find('.btmmearrow');
		var madiv = meinputer.find('.madiv');
		
		// Проверка валидации перед открытием
		if (!dd.hasClass('open')) {
			if (!canOpenDropdown(meinputer)) {
				var fieldName = meinputer.find('input[type="hidden"]').attr('name');
				var fieldLabel = '';
				if (fieldName === 'ml') {
					fieldLabel = 'Сначала выберите Марку';
				} else if (fieldName === 'yr') {
					fieldLabel = 'Сначала выберите Модель';
				}
				if (fieldLabel) {
					// Визуальная индикация недоступности
					meinputer.css({
						'animation': 'shake 0.5s ease'
					});
					setTimeout(function() {
						meinputer.css('animation', '');
					}, 500);
					e.preventDefault();
					return false;
				}
			}
		}

		// Предотвращаем стандартное поведение только если это не форма
		e.preventDefault();

		// Закрыть другие открытые списки с плавной анимацией
		$('.ddwnblock').not(dd).each(function() {
			closeDropdown($(this));
		});

		// Переключение текущего списка
		if (dd.hasClass('open')) {
			closeDropdown(dd);
			// Разблокируем все поля при закрытии
			$('.meinputer').css('pointer-events', '');
			$('.meinputer').css('opacity', '1');
			// Accessibility: Обновляем ARIA атрибуты
			meinputer.attr('aria-expanded', 'false');
			btn.attr('aria-expanded', 'false');
			dd.attr('aria-hidden', 'true');
		} else {
			// Если кликнули на поле ввода, не очищаем его сразу
			if ($(this).hasClass('madiv')) {
				// Если поле содержит плейсхолдер, оставляем его для отображения
				// Очистка произойдет только при реальном вводе текста
			}
			// Открываем dropdown немедленно
			openDropdown(dd);
			// Блокируем другие поля ввода когда открыт список
			$('.meinputer').not(meinputer).css({
				'pointer-events': 'none',
				'opacity': '0.3'
			});
			// Добавляем класс для дополнительной блокировки через CSS
			$('.maipttee').addClass('dropdown-open');
			// Accessibility: Обновляем ARIA атрибуты
			meinputer.attr('aria-expanded', 'true');
			btn.attr('aria-expanded', 'true');
			dd.attr('aria-hidden', 'false');
		}
		
		return false;
	});

	
	/**
	 * Функция: Очистка поля ввода при фокусе
	 * Описание: При получении фокуса полем ввода удаляет значение-плейсхолдер (например, "Марка", "Модель"),
	 * 			только если список уже открыт (пользователь собирается вводить текст).
	 * 			Если список закрыт, клик откроет список вместо очистки (через обработчик click).
	 * Параметры: нет (использует элемент в фокусе)
	 * Возвращает: ничего
	 */
	$(document).on("focus", ".madiv", function (e) {
		var $this = $(this);
		var dd = $this.closest('.meinputer').children('.ddwnblock');
		// Если список закрыт, не очищаем поле - клик откроет список
		// Добавляем небольшую задержку, чтобы обработчик click успел сработать первым
		setTimeout(function() {
			if (!dd.hasClass('open')) {
				// Список все еще закрыт - значит клик не сработал или был блокирован
				// Не очищаем поле
				return;
			}
			// Очищаем плейсхолдер только если список уже открыт (пользователь собирается вводить текст)
			if (dd.hasClass('open') && $this.html() == $this.attr('data-val')) {
				$this.html('');
			}
		}, 50); // Небольшая задержка для обработки клика
	});
	
	/**
	 * Функция: Обновление позиции fixed dropdown при скролле
	 * Описание: Если открыт dropdown с fixed позиционированием, обновляет его позицию при скролле
	 * Параметры: нет
	 * Возвращает: ничего
	 */
	$(window).on('scroll resize', function() {
		$('.ddwnblock.open').each(function() {
			var dd = $(this);
			var isInSliderForm = dd.closest('.sliderform').length > 0;
			
			if (isInSliderForm && dd.css('position') === 'fixed') {
				var meinputer = dd.closest('.meinputer');
				var meinputerOffset = meinputer.offset();
				var meinputerHeight = meinputer.outerHeight();
				var ddWidth = meinputer.outerWidth();
				var scrollTop = $(window).scrollTop();
				var scrollLeft = $(window).scrollLeft();
				
				dd.css({
					'left': (meinputerOffset.left - scrollLeft) + 'px',
					'top': (meinputerOffset.top + meinputerHeight - scrollTop) + 'px',
					'width': ddWidth + 'px'
				});
			}
		});
	});
	
	/**
	 * Функция: Синхронизация видимого текста со скрытым полем
	 * Описание: При вводе текста в видимый элемент (.madiv) копирует значение в скрытое input поле,
	 * 			чтобы оно отправлялось вместе с формой.
	 * Параметры: нет (использует элемент, в который вводят текст)
	 * Возвращает: ничего
	 */
	$(document).on("input", ".madiv", function () {
		$(this).parent('.meinputer').children('input').val($(this).html());
	});
	
	/**
	 * Функция: Восстановление плейсхолдера при потере фокуса
	 * Описание: Если поле пустое при потере фокуса, восстанавливает значение-плейсхолдер из атрибута data-val.
	 * Параметры: нет (использует элемент, потерявший фокус)
	 * Возвращает: ничего
	 */
	$(document).on("blur", ".madiv", function () {
		if ($(this).html() == '') { $(this).html($(this).attr('data-val')); }
	});

	/**
	 * Функция: Обновление состояния доступности полей
	 * Описание: Обновляет визуальное состояние полей в зависимости от заполненности предыдущих полей
	 * Параметры: нет
	 * Возвращает: ничего
	 */
	function updateFieldsState() {
		var markValue = $('.meinputer').find('input[name="mk"]').val();
		var modelValue = $('.meinputer').find('input[name="ml"]').val();
		
		// Управление полем Модель
		var modelInputer = $('.meinputer').has('input[name="ml"]');
		if (!markValue || markValue === '') {
			modelInputer.addClass('disabled');
		} else {
			modelInputer.removeClass('disabled');
		}
		
		// Управление полем Год
		var yearInputer = $('.meinputer').has('input[name="yr"]');
		if (!modelValue || modelValue === '') {
			yearInputer.addClass('disabled');
		} else {
			yearInputer.removeClass('disabled');
		}
	}

	// Обновление состояния полей при загрузке страницы
	updateFieldsState();
	
	/**
	 * Функция: Выбор значения из выпадающего списка
	 * Описание: При клике на элемент выпадающего списка устанавливает выбранное значение в поле ввода,
	 * 			автоматически закрывает список с плавной анимацией и, если выбрана марка или модель, 
	 * 			загружает через AJAX соответствующие варианты для связанных полей (модели для марки, годы для модели).
	 * Параметры: нет (использует элемент, на который кликнули)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".ddwnblock div", function () {
        var parent = $(this).parent('.ddwnblock').parent('.meinputer');
		var dd = $(this).parent('.ddwnblock');
		var selectedValue = $(this).html();
		var selectedId = $(this).attr('data-id');
		
		// Установка выбранного значения
		parent.children('.madiv').html(selectedValue);
		parent.children('input').val(selectedValue);

		// Автоматическое закрытие выпадающего списка с анимацией
		closeDropdown(dd);

		// Обновление состояния полей после выбора
		updateFieldsState();

		// Дальнейшие ajax запросы
		if (parent.children('input').attr('name') == 'mk') {
			// Очистка зависимых полей
			$("#modellist, #yearlist").html('');
			$('#modellist').parent('.meinputer').children('.madiv').html('Модель');
			$('#modellist').parent('.meinputer').children('.madiv').attr('data-val', 'Модель');
			$('#yearlist').parent('.meinputer').children('.madiv').html('Год');
			$('#yearlist').parent('.meinputer').children('.madiv').attr('data-val', 'Год');
			
			// Обновление состояния полей после очистки зависимых
			updateFieldsState();
			
			// Загрузка моделей для выбранной марки
			$.ajax({
				type: "POST",
				url: 'getf.php',
				data: { tex: selectedId, typ: 2 },
				dataType: "json",
				success: function(html){
					$('.meinputer').find('input[name="ml"], input[name="yr"]').val('');
					$("#modellist").html(html.report);
					// Повторное обновление состояния после загрузки
					updateFieldsState();
				}
			});
		} else if (parent.children('input').attr('name') == 'ml') {
			// Очистка поля Года
			$("#yearlist").html('');
			$('#yearlist').parent('.meinputer').children('.madiv').html('Год');
			$('#yearlist').parent('.meinputer').children('.madiv').attr('data-val', 'Год');
			
			// Обновление состояния полей после очистки зависимых
			updateFieldsState();
			
			// Загрузка годов для выбранной модели
			$.ajax({
				type: "POST",
				url: 'getf.php',
				data: { tex: selectedId, typ: 3 },
				dataType: "json",
				success: function(html){
					$('.meinputer').find('input[name="yr"]').val('');
					$("#yearlist").html(html.report);
					// Повторное обновление состояния после загрузки
					updateFieldsState();
				}
			});
		}
	});
	
	/**
	 * Функция: Переключение вкладок "Каталог" и "Акции"
	 * Описание: При клике на кнопку вкладки переключает отображение между каталогом товаров и акционными товарами.
	 * 			Меняет активное состояние кнопок и плавно показывает/скрывает соответствующие блоки.
	 * Accessibility: Обновляет ARIA атрибуты для screen readers
	 * Параметры: нет (использует элемент, на который кликнули)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".actionbtms li", function () {
		var $clicked = $(this);
		var isCatalog = $clicked.attr('data-typ') == 'ac';
		
		if (isCatalog) {
			$('.actionbtms li:first-child').addClass('liacactive').attr('aria-selected', 'true');
			$('.actionbtms li:last-child').removeClass('liacactive').attr('aria-selected', 'false');
			$('#actionb').stop(true,true).fadeIn(200).attr('aria-hidden', 'false');
			$('#goodsb').stop(true,true).fadeOut(200).attr('aria-hidden', 'true');
		} else {
			$('.actionbtms li:first-child').removeClass('liacactive').attr('aria-selected', 'false');
			$('.actionbtms li:last-child').addClass('liacactive').attr('aria-selected', 'true');
			$('#goodsb').stop(true,true).fadeIn(200).attr('aria-hidden', 'false');
			$('#actionb').stop(true,true).fadeOut(200).attr('aria-hidden', 'true');
		}
	});
	
    // Кнопка звонка теперь ведёт на tel: ссылку, модал не открываем
	
	/**
	 * Функция: Закрытие модального окна при клике на фон
	 * Описание: При клике на затемнённый фон закрывает модальное окно заказа.
	 * Параметры: нет (использует элемент фона)
	 * Возвращает: ничего
	 */
	const modal = document.getElementById('zakazaty');
	const overlay = document.querySelector('.plashesbgmodl');
	
	// Accessibility: Функция открытия модального окна с обновлением ARIA
	function openModal() {
	  overlay.classList.add('show');
	  modal.classList.add('show');
	  overlay.setAttribute('aria-hidden', 'false');
	  modal.setAttribute('aria-hidden', 'false');
	  // Фокус на первом поле ввода
	  const firstInput = modal.querySelector('input[type="text"], input[type="tel"]');
	  if (firstInput) {
		setTimeout(() => firstInput.focus(), 100);
	  }
	}
	
	// Accessibility: Функция закрытия модального окна с обновлением ARIA
	function closeModal() {
	  modal.classList.remove('show');
	  overlay.classList.remove('show');
	  modal.classList.add('hide');
	  overlay.classList.add('hide');
	  overlay.setAttribute('aria-hidden', 'true');
	  modal.setAttribute('aria-hidden', 'true');
	  setTimeout(() => {
		modal.classList.remove('hide');
		overlay.classList.remove('hide');
	  }, 400); // ждать завершения анимации
	}
	
	// Accessibility: Закрытие модального окна по ESC
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
			closeModal();
		}
	});
	
	/**
	 * Функция: Закрытие модального окна по кнопке
	 * Описание: При клике на кнопку закрытия (крестик) закрывает модальное окно заказа.
	 * Accessibility: Обновляет ARIA атрибуты для screen readers
	 * Параметры: нет (использует элемент кнопки закрытия)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".closemodal", function () {
    	$('.plashesbgmodl, #zakazaty').removeClass('show');
		$('.plashesbgmodl').attr('aria-hidden', 'true');
		$('#zakazaty').attr('aria-hidden', 'true');
	});
	
	/**
	 * Функция: Автоподбор марок автомобилей
	 * Описание: При вводе текста в поле поиска марки отправляет AJAX запрос для получения
	 * 			подходящих вариантов марок и отображает их в выпадающем списке.
	 * Параметры: нет (использует значение поля ввода)
	 * Возвращает: ничего
	 */
	$(document).on("input", "#idmark", function () {
		var tex = $(this).val();
		$.post('getdtls.php', { tex: tex, typ: 1 }, function(html){
			$("#makrlist").html(html.report);
		}, 'json');
	});
	
	/**
	 * Функция: Автоподбор моделей автомобилей
	 * Описание: При вводе текста в поле поиска модели отправляет AJAX запрос для получения
	 * 			подходящих вариантов моделей и отображает их в выпадающем списке.
	 * Параметры: нет (использует значение поля ввода)
	 * Возвращает: ничего
	 */
	$(document).on("input", "#idmode", function () {
		var tex = $(this).val();
		$.post('getdtls.php', { tex: tex, typ: 2 }, function(html){
			$("#modellist").html(html.report);
		}, 'json');
	});
	
	/**
	 * Функция: Автоподбор годов автомобилей
	 * Описание: При вводе текста в поле поиска года отправляет AJAX запрос для получения
	 * 			подходящих вариантов годов и отображает их в выпадающем списке.
	 * Параметры: нет (использует значение поля ввода)
	 * Возвращает: ничего
	 */
	$(document).on("input", "#idyear", function () {
		var tex = $(this).val();
		$.post('getdtls.php', { tex: tex, typ: 3 }, function(html){
			$("#yearlist").html(html.report);
		}, 'json');
	});

	/**
	 * Функция: Отправка формы обратного звонка
	 * Описание: При клике на кнопку отправки формы обратного звонка валидирует поля (имя и телефон),
	 * 			отправляет данные через AJAX на сервер, регистрирует событие в Google Analytics
	 * 			и отображает сообщение об успешной отправке или ошибке.
	 * Параметры: нет (использует данные формы)
	 * Возвращает: ничего
	 */
	$(document).on('click', 'input[name="JF_send_casual"], button[name="JF_send_casual"]', function () {
		var parent_form = $(this).closest('.JF_parent_form'),
			name = parent_form.find('input[name="name"]').val(),
			phon = parent_form.find('input[name="phon"]').val();
		
		if (name == '' || phon == '') { alert('Вы должны заполнить поля Имя и Телефон!'); return; }
		
		var data = new FormData();
		data.append('send_leed',true);
		data.append('name', name);
		data.append('phon', phon);
		
		$.ajax({
			url: '/send_form.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: data,
			type: 'post',
			success: function(res) {
				var res = JSON.parse(res);
				if (!res.error) { 
					window.dataLayer = window.dataLayer || [];
					window.dataLayer.push({ event:'sendLeadForm', name:name, phone:phon });
					if (res.conversion) {
						gtag('event', 'conversion', {
							'send_to': 'AW-17661940869/u-y4CIO6zLQbEIWp7-VB',
							'value': 0.4,
							'currency': 'USD'
						});
					}
					parent_form.html('<h3>'+res.message+'</h3>');
				} else { alert(res.message); }
			}
		});
	});
	
	/**
	 * Функция: Отправка формы заказа товара
	 * Описание: При клике на кнопку "Заказать" в модальном окне валидирует поля (имя и телефон),
	 * 			отправляет данные заказа через AJAX на сервер, регистрирует событие в Google Analytics,
	 * 			отображает сообщение об успешной отправке и скрывает форму.
	 * Параметры: нет (использует данные формы и ID товара)
	 * Возвращает: ничего
	 */
	$(document).on('click', 'input[name="JF_send_order"]', function () {
		var parent_form = $(this).closest('.allrelativm'),
			name = parent_form.find('input[name="name"]').val(),
			phon = parent_form.find('input[name="phon"]').val(),
			product = parent_form.find('input[name="id"]').val();
		
		if (name == '' || phon == '') { alert('Вы должны заполнить поля Имя и Телефон!'); return; }
		
		var data = new FormData();
		data.append('zakaz',true);
		data.append('name', name);
		data.append('phon', phon);
		data.append('id', product);
		
		$.ajax({
			url: '/send_form.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: data,
			type: 'post',
			success: function(res) {
				var res = JSON.parse(res);
				if (!res.error) { 
					window.dataLayer = window.dataLayer || [];
					window.dataLayer.push({ event:'sendOrder', name:name, phone:phon, product:product });
					parent_form.find('.formza').html(res.message);
					parent_form.find('form').detach();
				} else { alert(res.message); }
			}
		});
	});

	/**
	 * Performance: Плавные переходы между страницами (оптимизировано)
	 * Перехватывает клики по внутренним ссылкам и делает плавный fade-out перед переходом
	 * Оптимизировано: проверка выполняется быстрее, меньше DOM операций
	 */
	$(document).on('click', 'a[href]:not(.no-transition)', function(e) {
		var $link = $(this);
		var href = $link.attr('href');
		
		// Быстрая проверка пропускаемых ссылок
		if (!href || 
			$link.attr('target') === '_blank' ||
			$link.attr('download') ||
			href.match(/^(https?:\/\/|mailto:|tel:|#|javascript:)/)) {
			return;
		}
		
		// Нормализуем пути для сравнения
		var currentPath = window.location.pathname.replace(/\/$/, '') || '/';
		var targetPath = href.split('?')[0].split('#')[0].replace(/\/$/, '') || '/';
		
		// Если это та же страница, пропускаем
		if (targetPath === currentPath) {
			return;
		}
		
		// Предотвращаем стандартный переход
		e.preventDefault();
		
		// Добавляем класс для анимации fade-out
		$('body').addClass('page-transitioning');
		
		// После окончания анимации переходим на новую страницу
		setTimeout(function() {
				window.location.href = href;
		}, 400); // Время должно совпадать с длительностью pageFadeOut
	});

	// Закрытие выпадающего списка при клике вне его
	$(document).on('click', function(e) {
		if (!$(e.target).closest('.meinputer').length && !$(e.target).closest('.ddwnblock').length) {
			$('.ddwnblock.open').each(function() {
				closeDropdown($(this));
			});
		}
	});

});