
<!-- Performance: Yandex.Metrika - отложенная загрузка для улучшения производительности -->
<script>
  // Отложенная загрузка Yandex Metrika после загрузки страницы
  window.addEventListener('load', function() {
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();
    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(100700691, "init", {
         clickmap:true,
         trackLinks:true,
         accurateTrackBounce:true,
         webvisor:true
    });
  });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/100700691" style="position:absolute; left:-9999px;" alt="" aria-hidden="true" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<messagelog>
<?php
if (isset($_HYST_REPORT['message'])) {
?>
	<report die="<?=time().'000';?>" <?=($_HYST_REPORT['error']==3?'right':'error');?>><?=$_HYST_REPORT['message'];?></report>
<?php
	}
?>
</messagelog>

<!-- Accessibility: Модальное окно заказа с полной поддержкой screen readers -->
<div class="plashesbgmodl" role="dialog" aria-hidden="true" aria-modal="true" aria-labelledby="modal-title"></div>
<div class="modalwindow" id="zakazaty" role="dialog" aria-hidden="true" aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description">
	<div class="allrelativm">
		<!-- Accessibility: Кнопка закрытия модального окна -->
		<button type="button" class="formcraoss closemodal" aria-label="Закрыть окно заказа" tabindex="0">X</button>
		<h2 id="modal-title" class="formza">Сделать заказ на: <span id="playpayidv"><?=(isset($print['name'])?$print['name']:'');?></span></h2>
		<div id="modal-description" class="sr-only">Заполните форму для оформления заказа</div>
		<form method="post" aria-labelledby="modal-title">
			<input type="hidden" name="id" id="playpayid" value="<?=(isset($print['name'])?$print['name']:'');?>" aria-hidden="true">
			<div class="form-control">
				<label for="order-name" class="sr-only">Ваше имя</label>
				<input type="text" name="name" id="order-name" placeholder="Имя" required aria-required="true" autocomplete="name" aria-label="Введите ваше имя">
			</div>
			<div class="form-control">
				<label for="order-phone" class="sr-only">Ваш телефон</label>
				<input type="tel" name="phon" id="order-phone" placeholder="Телефон" required aria-required="true" autocomplete="tel" aria-label="Введите ваш телефон">
			</div>
			<button type="button" name="JF_send_order" aria-label="Отправить заказ" class="order-submit-btn">Заказать</button>
		</form>
	</div>
</div>