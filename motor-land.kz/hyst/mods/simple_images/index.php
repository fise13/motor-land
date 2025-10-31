
<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_add0">
	<label for="moderator_roller_add0">+</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">Добавить картинку</div>
		<interfaceform target="hyst/mods/simple_images/proces">
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="simple_images_name" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Ключ для вывода<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы (только А-z0-9 и - _)!" type="text" name="simple_images_key" check="nick_tag" length=">2" mandatory></iw></label>
				</div>
				
				<div class="admin_imgblock">
					<div class="admin_content_widht300">
						<iw class="admin_file_label_wraper">
							<div class="admin_select_img_field">
								<input type="hidden" name="simple_images_image" check="none" mandatory>
								<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="simple_images_image">
									<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
								</div>
							</div>
						</iw>
					</div>
				</div>
				
				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="simple_images_add" value="Добавить">
				</div>
				
			</div>
		</interfaceform>
	</div>
</div>


<div>
<?php
$hyst_tmp = $_DB_CONECT->query("SELECT * FROM simple_images ORDER BY id DESC");
if (mysqli_num_rows($hyst_tmp) != 0) {
while($hyst_get = mysqli_fetch_array($hyst_tmp)):
?>
	<div class="admin_roller_menu admin_roller100 delet_slider_block<?=$hyst_get['id'];?>">
		<input type="checkbox" id="moderator_roller<?=$hyst_get['id'];?>">
		<label id="visual_ch_slideroler_<?=$hyst_get['id'];?>" for="moderator_roller<?=$hyst_get['id'];?>"><?=$hyst_get['name'];?> [<?=$hyst_get['key_id'];?>]</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Редактировать контентный блок</div>
			<interfaceform target="hyst/mods/simple_images/proces">
				<div class="admin_content_alignment">
						<div class="admin_content_widht300">
							<label>Название<i>*</i><br><iw><input value="<?=$hyst_get['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="simple_images_name" check="name" length=">2" mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Ключ для вывода<i>*</i><br><iw><input value="<?=$hyst_get['key_id'];?>" class="width100" error="Содержит не корреткные символы (только А-z0-9 и - _)!" type="text" name="simple_images_key" check="nick_tag" length=">2" mandatory></iw></label>
						</div>
						<div class="admin_imgblock">
							<div class="admin_content_widht300">
								<iw class="admin_file_label_wraper">
									<div class="admin_select_img_field">
										<input type="hidden" value="<?=$hyst_get['images'];?>" name="simple_images_image" check="none" mandatory>
										<div class="admin_select_img_input" style="background-image: url(<?=$hyst_get['images'];?>);" data-tip="Выбрать изображение" unic-return="simple_images_image<?=$hyst_get['id'];?>">
											<div class="admin_addimage_tip"></div>
										</div>
										<div class="admin_file_cross"></div>
									</div>
								</iw>
							</div>
						</div>
						<input type="hidden" name="simple_images_id" value="<?=$hyst_get['id'];?>">
						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="simple_images_red" value="Сохранить">
						</div>
					
				</div>
			</interfaceform>
			
			<interfaceform target="hyst/mods/simple_images/proces" style="display: inline-block;">
					<input type="hidden" name="simple_images_id" value="<?=$hyst_get['id'];?>">
					<input confirm-yesno="Вы действительно хотите удалить?" type="button" role="submit" name="simple_images_del" value="Удалить">
			</interfaceform>
		
		</div>
	</div>
<?php
endwhile;
}
?>
</div>
