<div class="callback-form">
  <h2>Связаться с нами</h2>

  <div class="form-control">
    <input type="text" required>
    <label>
      <span style="transition-delay:0ms">И</span><span style="transition-delay:50ms">м</span><span style="transition-delay:100ms">я</span>
    </label>
  </div>

  <div class="form-control">
    <input type="tel" required>
    <label>
      <span style="transition-delay:0ms">Т</span><span style="transition-delay:50ms">е</span><span style="transition-delay:100ms">л</span><span style="transition-delay:150ms">е</span><span style="transition-delay:200ms">ф</span><span style="transition-delay:250ms">о</span><span style="transition-delay:300ms">н</span>
    </label>
  </div>

  <div class="form-control">
    <input type="email" required>
    <label>
      <span style="transition-delay:0ms">E</span><span style="transition-delay:50ms">m</span><span style="transition-delay:100ms">a</span><span style="transition-delay:150ms">i</span><span style="transition-delay:200ms">l</span>
    </label>
  </div>

  <button type="submit" class="callback-btn">Отправить</button>
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