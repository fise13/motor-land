<div class="generalw foterbag">
	<div class="shirina">
	<div class="foterinline JF_parent_form">
  <div class="foterzago">Закажите обратный звонок</div>
  <form method="post">
    <div class="form-control">
      <input type="text" name="name" id="name" placeholder=" " required>
      <label for="name">Имя</label>
    </div>
    <div class="form-control">
      <input type="text" name="phon" id="phon" placeholder=" " required>
      <label for="phon">Телефон</label>
    </div>
    <input type="hidden" name="send_one" value="send">
    <input type="button" name="JF_send_casual" value="Отправить">
  </form>
</div>

		</div>
		<div class="footer_contacts">
			<div class="footer_contact_center">
				
				<a class="footer_contact_social" style="background-image: url(./img/inst.png);" target="_blank" href="<?=get_simple_texts('footer_instagram');?>">Присоединяйтесь к нам в Instagram</a>
				
			</div>
		
			<div class="footer_contact_block">
				
				<div class="foterconicon" style="background-image: url(./img/loc.png);"><a target="_blank" href="<?=get_simple_texts('2gis_addres_1');?>"><?=get_simple_texts('footer_addr_1');?></a></div>
				<?php
				$phones = get_simple_texts('footer_phone_1');
				$phones = explode(',',$phones);
				$form  = '';
				foreach($phones as $v) {
					$clear = preg_replace('/[^\d+]/', '', $v);
				$form .= '<a href="tel:'.$clear.'" onclick="gtag(\'event\', \'conversion\', {\'send_to\': \'AW-17661940869/8IrgCNzqw7QbEIWp7-VB\'});">'.preg_replace('/^\+(\d)(\d{3})(\d{3})(\d{4})$/', '+$1 $2 $3 $4', $clear).'</a><br>';
				}
				?>
				<div class="foterconicon" style="background-image: url(./img/tel.png);"><?=$form;?></div>
				
				<div class="foterconicon" style="background-image: url(./img/wats.svg);"><a href="https://wa.me/<?=get_simple_texts('footer_whatsapp_1');?>">WhatsApp</a></div>
				
				<div class="foterconicon" style="background-image: url(./img/day.png);"><?=get_simple_texts('work_schedule_1');?></div>	
			</div>
			<div class="footer_contact_block">
				
				<div class="foterconicon" style="background-image: url(./img/loc.png);"><a target="_blank" href="<?=get_simple_texts('2gis_addres_2');?>"><?=get_simple_texts('footer_addr_2');?></a></div>
				
				<?php
				$phones = get_simple_texts('footer_phone_2');
				$phones = explode(',',$phones);
				$form  = '';
				foreach($phones as $v) {
					$clear = preg_replace('/[^\d+]/', '', $v);
				$form .= '<a href="tel:'.$clear.'" onclick="gtag(\'event\', \'conversion\', {\'send_to\': \'AW-17661940869/8IrgCNzqw7QbEIWp7-VB\'});">'.preg_replace('/^\+(\d)(\d{3})(\d{3})(\d{4})$/', '+$1 $2 $3 $4', $clear).'</a><br>';
				}
				?>
				<div class="foterconicon" style="background-image: url(./img/tel.png);"><?=$form;?></div>
				
				<div class="foterconicon" style="background-image: url(./img/wats.svg);"><a href="https://wa.me/<?=get_simple_texts('footer_whatsapp_2');?>">WhatsApp</a></div>
				
				<div class="foterconicon" style="background-image: url(./img/day.png);"><?=get_simple_texts('work_schedule_2');?></div>
				
				<!--<div class="foterconicon" style="background-image: url(./img/pos.png);"></div>-->
			</div>
		
		
		</div>
		
	</div>
</div>

<div class="generalw frayalpfhon">
	<div class="shirina copyr">
		&copy; motorland <?=date('Y');?>
	</div>
</div>