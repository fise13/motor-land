<div class="hyst_modal_generatorcontainer"></div>



<div class="plashesbgmodl" onclick="$('.plashesbgmodl').hide();$('#zakazaty').hide();$('#zakazaty0').hide();"></div>

<div class="modalwindow" id="zakazaty">
		<div class="allrelativm">
			<div class="formcraoss" onclick="$('.plashesbgmodl').hide();$('#zakazaty').hide();">X</div>
				<div class="formza">Сделать заказ на: <span id="playpayidv"><?=$print['name'];?></span></div>
			<form method="post">
			<input type="hidden" name="id" id="playpayid" value="<?=$print['name'];?>">
			<input type="text" name="name" placeholder="Имя">
			<input type="text" name="phon" placeholder="Телефон">
			<input type="button" name="JF_send_order" value="Заказать">
			</form>
		</div>
	</div>
	<!---
	<div class="modalwindow" id="zakazaty0">
		<div class="allrelativm">
			<div class="formcraoss" onclick="$('.plashesbgmodl').hide();$('#zakazaty0').hide();">X</div>
				<div class="formza">Получить консультацию бесплатно</div>
			<form method="post">
			<input type="text" name="name" placeholder="Имя">
			<input type="text" name="phon" placeholder="Телефон">
			<input type="hidden" name="consul_one" value="consul">
			<input type="submit" name="consul" value="Отправить">
			</form>
		</div>
	</div>--->