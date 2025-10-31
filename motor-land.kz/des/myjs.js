$(document).ready(function() {

    // Выпадающий список (клик по стрелке) — используем CSS-анимацию через класс .open
    $(document).on("click", ".btmmearrow", function () {
        var dd = $(this).parent('.meinputer').children('.ddwnblock');
        // закрыть все прочие открытые
        $('.ddwnblock').not(dd).removeClass('open');
        // переключить текущее
        dd.toggleClass('open');
    });
	
	// Плейсхолдер для контента editable div
	$(document).on("focus", ".madiv", function () {
		if ($(this).html() == $(this).attr('data-val')) { $(this).html(''); }
	});
	
	$(document).on("input", ".madiv", function () {
		$(this).parent('.meinputer').children('input').val($(this).html());
	});
	
	$(document).on("blur", ".madiv", function () {
		if ($(this).html() == '') { $(this).html($(this).attr('data-val')); }
	});
	
	// Выбор из выпадающего списка
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
	
	// Переключение вкладок действий
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
	
	// Модальное окно
	$(document).on("click", ".toverbuton", function () {
		var name = $(this).attr('data-nam');
		$('#playpayid').val(name);
		$('#playpayidv').html(name);
		$('.plashesbgmodl, #zakazaty').addClass('show');
	});
	// Закрытие окна при клике на фон
	$(document).on("click", ".plashesbgmodl", function () {
  	$('.plashesbgmodl, #zakazaty').removeClass('show');
	});
	
	// Закрытие модалки
$	(document).on("click", ".closemodal", function () {
  	$('.plashesbgmodl, #zakazaty').removeClass('show');
	});
	
	// Автоподбор марок/моделей/годов
	$(document).on("input", "#idmark", function () {
		var tex = $(this).val();
		$.post('getdtls.php', { tex: tex, typ: 1 }, function(html){
			$("#makrlist").html(html.report);
		}, 'json');
	});
	$(document).on("input", "#idmode", function () {
		var tex = $(this).val();
		$.post('getdtls.php', { tex: tex, typ: 2 }, function(html){
			$("#modellist").html(html.report);
		}, 'json');
	});
	$(document).on("input", "#idyear", function () {
		var tex = $(this).val();
		$.post('getdtls.php', { tex: tex, typ: 3 }, function(html){
			$("#yearlist").html(html.report);
		}, 'json');
	});

	// Отправка форм
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