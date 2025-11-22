
<div class="admin_page_header">
	<div class="admin_page_header_breadcrumb">
		<a href="/adm">Главная</a>
		<span>›</span>
		<span class="current">Медиафайлы</span>
	</div>
	<div class="admin_page_title">📁 Медиафайлы</div>
	<div class="admin_page_subtitle">Управление изображениями и медиа контентом</div>
</div>

<interfaceform target="hyst/core/admin_profile">
	<div class="form_title">Добавить изображение</div>
	
	<div class="admin_content_alignment">
		<div class="admin_imgblock">
			<div class="admin_content_widht300">
				<iw class="admin_file_label_wraper">
					<label class="admin_image_label" data-allowed="jpg,jpeg,png,svg,webp" data-tip="Добавить изображение">
						<input type="file" error="Нужно выбрать изображение формата jpg,jpeg,png,svg или webp!" check="file" name="image" mandatory>
						<div class="admin_addimage_tip">+<span>Добавить изображение</span></div>
					</label>
				</iw>
			</div>
		</div>
		<div class="admin_content_alignment_remain">
			<div class="admin_content_widht300">
				<label>Сжатие длины изображения (px)<i>*</i><br><iw><input value="<?=isset($_SESSION['mediafiles_width'])?$_SESSION['mediafiles_width']:'1920';?>" class="width100" error="Нужно вводить целое число!" type="text" name="width" check="number" length=">2" unclear mandatory></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Сжатие ширины изображения (px)<i>*</i><br><iw><input value="<?=isset($_SESSION['mediafiles_height'])?$_SESSION['mediafiles_height']:'1080';?>" class="width100" error="Нужно вводить целое число!" type="text" name="height" check="number" length=">2" unclear mandatory></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Title (для SEO)<br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="title" check="name"></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Alt (для SEO)<br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="alt" check="name"></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Тэги для поиска<br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="tags" check="name"></iw></label>
			</div>
			
			<div class="admin_content_widht300">
				<input class="width100" type="button" role="submit" name="add_image" value="Добавить">
			</div>
		</div>
	</div>
</interfaceform>

<div class="admin_mediafiles_general_con">
	<?php
	$year_mt_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/cms_img/');
	array_splice($year_mt_folders, 0, 2);
	arsort($year_mt_folders);
	$count = 0;
	foreach($year_mt_folders as $folder) {
		$images = scandir($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder);
		array_splice($images, 0, 2);
		if (count($images) > 0) {
		?>
		<div class="admin_roller_menu admin_roller100">
			<input type="checkbox" id="moderator_roller<?=$folder;?>"<?=($count==0?' checked':'');?>>
			<label for="moderator_roller<?=$folder;?>"><?=$folder;?></label>
			<div class="admin_roller_container admin_roler_with_overflow img_folder_apend_<?=$folder;?>">
				<?php
				foreach($images as $image) {
				$tags = hyst_imeta($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder.'/'.$image);
					if ($tags && !is_null($tags['tags'])) {
					$tags = $tags['tags'];
					} else {
					$tags = 'N/A';
					}
				?>

				<div tags="<?=$tags;?>" class="mediafiles_image_con del_image_<?=$folder;?>_<?=explode('.',$image)[0];?>">
					<interfaceform target="hyst/core/admin_profile">
						<input type="hidden" name="url" value="<?='/cms_img/'.$folder.'/'.$image;?>">
						<input confirm-yesno="Вы действительно хотите удалить картинку?" class="admin_delet_img" type="button" role="submit" name="del_image" value=" ">
					</interfaceform>
					<div class="hyst_zoom_img mediafiles_image_con_img" data-zoom="<?='/cms_img/'.$folder.'/'.$image;?>" data-width="<?=getimagesize($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder.'/'.$image)[0];?>" data-height="<?=getimagesize($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder.'/'.$image)[1];?>" style="background-image: url(<?='/cms_img/'.$folder.'/'.$image;?>);"></div>
					
				</div>
				<?php
				}
				?>
			</div>
		</div>
		<?php
		} else {
		rmdir($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder);
		}
		if ($count == 0) { $count++; }
	}
	
	?>
</div>