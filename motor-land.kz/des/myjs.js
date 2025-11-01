$(document).ready(function() {

	window.addEventListener("load", () => {
		const preloader = document.getElementById("preloader");
		const logo = preloader.querySelector(".loader-logo");
	  
		logo.classList.add("show"); // сразу
		setTimeout(() => {
		  preloader.classList.add("hide");
		}, 400); // лёгкое растворение
	  });

	
	/**
	 * Функция: Обработка клика по стрелке выпадающего списка
	 * Описание: При клике на стрелку открывает/закрывает выпадающий список фильтров (Марка, Модель, Год).
	 * 			Закрывает все остальные открытые списки и переключает состояние текущего.
	 * Параметры: нет (использует элемент, на который кликнули)
	 * Возвращает: ничего
	 */
    $(document).on("click", ".btmmearrow, .madiv", function () {
		var meinputer = $(this).closest('.meinputer');
        var dd = meinputer.children('.ddwnblock');
        // закрыть все прочие открытые
        $('.ddwnblock').not(dd).removeClass('open');
		// переключить текущий список
		dd.toggleClass('open');
    });

	
	/**
	 * Функция: Очистка поля ввода при фокусе
	 * Описание: При получении фокуса полем ввода удаляет значение-плейсхолдер (например, "Марка", "Модель"),
	 * 			чтобы пользователь мог вводить текст.
	 * Параметры: нет (использует элемент в фокусе)
	 * Возвращает: ничего
	 */
	$(document).on("focus", ".madiv", function () {
		if ($(this).html() == $(this).attr('data-val')) { $(this).html(''); }
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
	 * Функция: Выбор значения из выпадающего списка
	 * Описание: При клике на элемент выпадающего списка устанавливает выбранное значение в поле ввода,
	 * 			закрывает список и, если выбрана марка или модель, загружает через AJAX соответствующие
	 * 			варианты для связанных полей (модели для марки, годы для модели).
	 * Параметры: нет (использует элемент, на который кликнули)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".ddwnblock div", function () {
        var parent = $(this).parent('.ddwnblock').parent('.meinputer');
        $(this).parent('.ddwnblock').removeClass('open');
		parent.children('.madiv').html($(this).html());
		parent.children('input').val($(this).html());

		// Дальнейшие ajax запросы
		if (parent.children('input').attr('name') == 'mk') {
			$("#modellist, #yearlist").html('');
			$('#modellist').parent('.meinputer').children('.madiv').html('Модель');
			$('#yearlist').parent('.meinputer').children('.madiv').html('Год');
			$.ajax({
				type: "POST",
				url: 'getf.php',
				data: { tex: $(this).attr('data-id'), typ: 2 },
				dataType: "json",
				success: function(html){
					$('.meinputer').find('input[name="ml"], input[name="yr"]').val('');
					$("#modellist").html(html.report);
				}
			});
		} else if (parent.children('input').attr('name') == 'ml') {
			$("#yearlist").html('');
			$('#yearlist').parent('.meinputer').children('.madiv').html('Год');
			$.ajax({
				type: "POST",
				url: 'getf.php',
				data: { tex: $(this).attr('data-id'), typ: 3 },
				dataType: "json",
				success: function(html){
					$('.meinputer').find('input[name="yr"]').val('');
					$("#yearlist").html(html.report);
				}
			});
		}
	});
	
	/**
	 * Функция: Переключение вкладок "Каталог" и "Акции"
	 * Описание: При клике на кнопку вкладки переключает отображение между каталогом товаров и акционными товарами.
	 * 			Меняет активное состояние кнопок и плавно показывает/скрывает соответствующие блоки.
	 * Параметры: нет (использует элемент, на который кликнули)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".actionbtms li", function () {
		if ($(this).attr('data-typ') == 'ac') {
			$('.actionbtms li:first-child').addClass('liacactive');
			$('.actionbtms li:last-child').removeClass('liacactive');
			$('#actionb').stop(true,true).fadeIn(200);
			$('#goodsb').stop(true,true).fadeOut(200);
		} else {
			$('.actionbtms li:first-child').removeClass('liacactive');
			$('.actionbtms li:last-child').addClass('liacactive');
			$('#goodsb').stop(true,true).fadeIn(200);
			$('#actionb').stop(true,true).fadeOut(200);
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
	
	function openModal() {
	  overlay.classList.add('show');
	  modal.classList.add('show');
	}
	
	function closeModal() {
	  modal.classList.remove('show');
	  overlay.classList.remove('show');
	  modal.classList.add('hide');
	  overlay.classList.add('hide');
	  setTimeout(() => {
		modal.classList.remove('hide');
		overlay.classList.remove('hide');
	  }, 400); // ждать завершения анимации
	}
	
	/**
	 * Функция: Закрытие модального окна по кнопке
	 * Описание: При клике на кнопку закрытия (крестик) закрывает модальное окно заказа.
	 * Параметры: нет (использует элемент кнопки закрытия)
	 * Возвращает: ничего
	 */
	$(document).on("click", ".closemodal", function () {
    	$('.plashesbgmodl, #zakazaty').removeClass('show');
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
	$(document).on('click', 'input[name="JF_send_casual"]', function () {
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

});