<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_add0">
	<label for="moderator_roller_add0">+</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">Добавить слайдер</div>
		<interfaceform target="hyst/mods/sliders/proces">
			<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="sliders_name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Ключ для вывода<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы (только А-z0-9 и - _)!" type="text" name="sliders_key" check="nick_tag" length=">2" mandatory></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="sliders_add" value="Добавить">
					</div>
				
			</div>
		</interfaceform>
	</div>
</div>

<div class="all_sliders_container">
<?php
$hyst_tmp = $_DB_CONECT->query("SELECT * FROM sliders_slider ORDER BY id DESC");
if (mysqli_num_rows($hyst_tmp) != 0) {
while($hyst_get = mysqli_fetch_array($hyst_tmp)):
?>
	<div class="admin_roller_menu admin_roller100 delet_slider_block<?=$hyst_get['id'];?>">
		<input type="checkbox" id="moderator_roller<?=$hyst_get['id'];?>">
		<label id="visual_ch_slideroler_<?=$hyst_get['id'];?>" for="moderator_roller<?=$hyst_get['id'];?>"><?=$hyst_get['name'];?> [<?=$hyst_get['key_id'];?>]</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			
			<div class="admin_roller_menu adm_matrol_marg">
				<input type="radio" class="one" name="moderator_roller<?=$hyst_get['id'];?>_add" id="moderator_roller<?=$hyst_get['id'];?>_red">
				<input type="radio" class="two" name="moderator_roller<?=$hyst_get['id'];?>_add" id="moderator_roller<?=$hyst_get['id'];?>_add_slide">
				<input type="radio" class="hide" name="moderator_roller<?=$hyst_get['id'];?>_add" id="moderator_roller<?=$hyst_get['id'];?>_hide" checked>
				
				<label class="one" for="moderator_roller<?=$hyst_get['id'];?>_red"><img src="/hyst/visual/images/gear_icon.svg" height="14"></label>
				<label class="two" for="moderator_roller<?=$hyst_get['id'];?>_add_slide">+</label>
				<label class="hide" for="moderator_roller<?=$hyst_get['id'];?>_hide"><img src="/hyst/visual/images/top_arrow_icon.svg" height="14"></label>
				
				<interfaceform target="hyst/mods/sliders/proces" style="display: inline-block;">
						<input type="hidden" name="sliders_id" value="<?=$hyst_get['id'];?>">
						<input confirm-yesno="Вы действительно хотите удалить слайдер?" class="admin_detet_button" type="button" role="submit" name="sliders_del" value="">
				</interfaceform>
				
				<div class="admin_roller_container admin_roler_with_overflow one">
					<div class="form_title_sm">Редактировать слайдер <i id="visual_ch_slidenamei_<?=$hyst_get['id'];?>"><?=$hyst_get['name'];?></i></div>
					
					<interfaceform target="hyst/mods/sliders/proces">
						<div class="admin_content_alignment">
								<div class="admin_content_widht300">
									<label>Название<i>*</i><br><iw><input value="<?=$hyst_get['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="sliders_name" check="name" length=">2" mandatory></iw></label>
								</div>
								<div class="admin_content_widht300">
									<label>Ключ для вывода<i>*</i><br><iw><input value="<?=$hyst_get['key_id'];?>" class="width100" error="Содержит не корреткные символы (только А-z0-9 и - _)!" type="text" name="sliders_key" check="nick_tag" length=">2" mandatory></iw></label>
								</div>
								<input type="hidden" name="sliders_id" value="<?=$hyst_get['id'];?>">
								<div class="admin_content_widht300">
									<input class="width100" type="button" role="submit" name="sliders_red" value="Редактировать">
								</div>
							
						</div>
					</interfaceform>
					
				</div>
				<div class="admin_roller_container admin_roler_with_overflow two">
					<div class="form_title_sm">Добавить слайд в <i><?=$hyst_get['name'];?></i></div>
					
					<interfaceform target="hyst/mods/sliders/proces">
						<div class="admin_content_alignment_forimg">
							<div class="admin_imgblock">
								<div class="admin_content_widht300">
									<iw class="admin_file_label_wraper">
										<div class="admin_select_img_field">
											<input type="hidden" name="sliders_image" check="none" mandatory>
											<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="sliders_image<?=$hyst_get['id'];?>">
												<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
											</div>
										</div>
									</iw>
								</div>
							</div>
							<div class="admin_content_alignment_remain">
								<div class="width100">
									<div>Текст на слайде<iw><wysiwygarea class="width100" name="sliders_text"></wysiwygarea></iw></div>
								</div>
								
								<div class="admin_content_widht300">
									<label>Название кнопки<br><iw><input class="width100" type="text" name="sliders_name"></iw></label>
								</div>
								<div class="admin_content_widht300">
									<label>Ссылка кнопки<br><iw><input class="width100" type="text" name="sliders_href"></iw></label>
								</div>
								<input type="hidden" name="sliders_ids" value="<?=$hyst_get['id'];?>" unclear>
								<div class="admin_content_widht300">
									<input class="width100" type="button" role="submit" name="sliders_slide_add" value="Добавить слайд">
								</div>
							</div>
						</div>
					</interfaceform>
				</div>
				
				<div class="slider_slide_redact_con" id="slider_slide_redact_con<?=$hyst_get['id'];?>">
					<interfaceform target="hyst/mods/sliders/proces" style="display: inline-block;">
						<input type="hidden" name="id" value="<?=$hyst_get['id'];?>">
						<input confirm-yesno="Вы действительно хотите удалить слайд?" class="admin_detet_button" type="button" role="submit" name="slide_del" value="">
					</interfaceform>
					<interfaceform target="hyst/mods/sliders/proces">
						<div class="admin_content_alignment_forimg">
							<div class="admin_imgblock">
								<div class="admin_content_widht300">
									<iw class="admin_file_label_wraper">
										<div class="admin_select_img_field">
											<input type="hidden" name="sliders_image" check="none" mandatory>
											<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="sliders_image_red<?=$hyst_get['id'];?>">
												<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
											</div>
										</div>
									</iw>
								</div>
							</div>
							<div class="admin_content_alignment_remain">
								<div class="width100">
									<div>Текст на слайде<iw><wysiwygarea class="width100" name="sliders_text"></wysiwygarea></iw></div>
								</div>
								<div class="admin_content_widht300">
									<label>Название кнопки<br><iw><input class="width100" type="text" name="sliders_name"></iw></label>
								</div>
								<div class="admin_content_widht300">
									<label>Ссылка кнопки<br><iw><input class="width100" type="text" name="sliders_href"></iw></label>
								</div>
								<input type="hidden" name="id">
								<div class="admin_content_widht300">
									<input class="width100" type="button" role="submit" name="sliders_slide_red" value="Добавить слайд">
								</div>
							</div>
						</div>
					</interfaceform>
					
				</div>
				
				<div class="slider_sliders_container<?=$hyst_get['id'];?>">
					<?php
					$hyst_tmp_a = $_DB_CONECT->query("SELECT * FROM sliders_slide WHERE ids='".$hyst_get['id']."' ORDER BY id DESC");
					if (mysqli_num_rows($hyst_tmp_a) != 0) {
					while($hyst_get_a = mysqli_fetch_array($hyst_tmp_a)):
					?>
					<div class="sliders_mod_slide_prev slider_sliders_delet<?=$hyst_get_a['id'];?>" onclick="slider_slide_redact(<?=$hyst_get_a['id'];?>,<?=$hyst_get['id'];?>);" style="background-image: url(<?=$hyst_get_a['image'];?>);"></div>
					<?php
					endwhile;
					}
					?>
				</div>
			</div>
			
		</div>
	</div>
<?php
endwhile;
}
?>
</div>