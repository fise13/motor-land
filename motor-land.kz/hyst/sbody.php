
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
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
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/100700691" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
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

<!-- Модальное окно заказа (восстановлено) -->
<div class="plashesbgmodl"></div>
<div class="modalwindow" id="zakazaty">
	<div class="allrelativm">
		<div class="formcraoss closemodal">X</div>
		<div class="formza">Сделать заказ на: <span id="playpayidv"><?=(isset($print['name'])?$print['name']:'');?></span></div>
		<form method="post">
			<input type="hidden" name="id" id="playpayid" value="<?=(isset($print['name'])?$print['name']:'');?>">
			<input type="text" name="name" placeholder="Имя">
			<input type="text" name="phon" placeholder="Телефон">
			<input type="button" name="JF_send_order" value="Заказать">
		</form>
	</div>
</div>