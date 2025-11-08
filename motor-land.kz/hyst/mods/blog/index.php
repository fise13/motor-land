<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_add0">
	<label for="moderator_roller_add0">+</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">Добавить статью в блог</div>
		<interfaceform target="hyst/mods/blog/proces">
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Заголовок статьи<i>*</i><br><iw><input class="width100" error="Заголовок должен содержать минимум 3 символа!" type="text" name="blog_title" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>URL статьи (slug)<i>*</i><br><iw><input class="width100" error="URL должен содержать только латинские буквы, цифры, дефисы и подчеркивания!" type="text" name="blog_slug" check="nick_tag" length=">2" mandatory placeholder="nazvanie-stati"></iw></label>
				</div>
				
				<div class="width100">
					<label>Описание (meta description)<i>*</i><br><iw><textarea style="width: 100%; min-height: 80px;" name="blog_description" placeholder="Краткое описание статьи для поисковых систем"></textarea></iw></label>
				</div>
				
				<div class="width100">
					<label>Контент статьи<i>*</i><br><iw><wysiwygarea class="width100" name="blog_content" style="min-height: 400px;"></wysiwygarea></iw></label>
				</div>
				
				<div class="admin_content_alignment_forimg">
					<div class="admin_imgblock">
						<div class="admin_content_widht300">
							<iw class="admin_file_label_wraper">
								<label>Изображение статьи<br>
								<div class="admin_select_img_field">
									<input type="hidden" name="blog_image" check="none">
									<div class="admin_select_img_input" data-tip="Выбрать изображение" unic-return="blog_image_add">
										<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
									</div>
								</div>
								</iw></label>
						</div>
					</div>
					<div class="admin_content_alignment_remain">
						<div class="admin_content_widht300">
							<label>Видео (URL YouTube/Vimeo)<br><iw><input class="width100" type="text" name="blog_video" placeholder="https://www.youtube.com/watch?v=..."></iw></label>
						</div>
						
						<div class="admin_content_widht300">
							<label>Категория<i>*</i><br><iw>
								<select class="width100" name="blog_category" mandatory>
									<option value="Общее">Общее</option>
									<option value="Советы">Советы</option>
									<option value="Гарантия">Гарантия</option>
									<option value="Услуги">Услуги</option>
								</select>
							</iw></label>
						</div>
						
						<div class="admin_content_widht300">
							<label>Время чтения<br><iw><input class="width100" type="text" name="blog_read_time" value="5 мин" placeholder="5 мин"></iw></label>
						</div>
						
						<div class="admin_content_widht300">
							<label>Автор<br><iw><input class="width100" type="text" name="blog_author" value="Motor Land" placeholder="Motor Land"></iw></label>
						</div>
						
						<div class="width100">
							<label>Биография автора<br><iw><textarea style="width: 100%; min-height: 60px;" name="blog_author_bio" placeholder="Краткая биография автора">Эксперты компании Motor Land с более чем 10-летним опытом работы с контрактными двигателями.</textarea></iw></label>
						</div>
						
						<div class="width100">
							<label>Ключевые слова (SEO)<br><iw><input class="width100" type="text" name="blog_keywords" placeholder="ключевое слово 1, ключевое слово 2"></iw></label>
						</div>
						
						<div class="admin_content_widht300">
							<label>Статус<i>*</i><br><iw>
								<select class="width100" name="blog_status" mandatory>
									<option value="draft">Черновик</option>
									<option value="published">Опубликовано</option>
								</select>
							</iw></label>
						</div>
					</div>
				</div>
				
				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="blog_add" value="Добавить статью">
				</div>
			</div>
		</interfaceform>
	</div>
</div>

<div>
<?php
$hyst_tmp = $_DB_CONECT->query("SELECT * FROM blog_articles ORDER BY id DESC");
if (mysqli_num_rows($hyst_tmp) != 0) {
while($hyst_get = mysqli_fetch_array($hyst_tmp)):
	$status_class = $hyst_get['status'] == 'published' ? 'blog-status-published' : 'blog-status-draft';
	$status_text = $hyst_get['status'] == 'published' ? 'Опубликовано' : 'Черновик';
?>
	<div class="admin_roller_menu admin_roller100 delet_blog_block<?=$hyst_get['id'];?>">
		<input type="checkbox" id="moderator_roller<?=$hyst_get['id'];?>">
		<label id="visual_ch_blog_<?=$hyst_get['id'];?>" for="moderator_roller<?=$hyst_get['id'];?>">
			<?=$hyst_get['title'];?> [<?=$hyst_get['slug'];?>] 
			<span class="<?=$status_class;?>"><?=$status_text;?></span>
		</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Редактировать статью</div>
			<interfaceform target="hyst/mods/blog/proces">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Заголовок статьи<i>*</i><br><iw><input value="<?=htmlspecialchars($hyst_get['title'], ENT_QUOTES, 'UTF-8');?>" class="width100" error="Заголовок должен содержать минимум 3 символа!" type="text" name="blog_title" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>URL статьи (slug)<i>*</i><br><iw><input value="<?=htmlspecialchars($hyst_get['slug'], ENT_QUOTES, 'UTF-8');?>" class="width100" error="URL должен содержать только латинские буквы, цифры, дефисы и подчеркивания!" type="text" name="blog_slug" check="nick_tag" length=">2" mandatory></iw></label>
					</div>
					
					<div class="width100">
						<label>Описание (meta description)<i>*</i><br><iw><textarea style="width: 100%; min-height: 80px;" name="blog_description" placeholder="Краткое описание статьи для поисковых систем"><?=htmlspecialchars($hyst_get['description'], ENT_QUOTES, 'UTF-8');?></textarea></iw></label>
					</div>
					
					<div class="width100">
						<label>Контент статьи<i>*</i><br><iw><wysiwygarea class="width100" name="blog_content" style="min-height: 400px;"><?=$hyst_get['content'];?></wysiwygarea></iw></label>
					</div>
					
					<div class="admin_content_alignment_forimg">
						<div class="admin_imgblock">
							<div class="admin_content_widht300">
								<iw class="admin_file_label_wraper">
									<label>Изображение статьи<br>
									<div class="admin_select_img_field">
										<input type="hidden" name="blog_image" value="<?=htmlspecialchars($hyst_get['image'], ENT_QUOTES, 'UTF-8');?>" check="none">
										<div class="admin_select_img_input" data-tip="Выбрать изображение" unic-return="blog_image_red<?=$hyst_get['id'];?>">
											<?php if (!empty($hyst_get['image'])): ?>
											<div class="admin_selected_img" style="background-image: url(<?=$hyst_get['image'];?>);"></div>
											<?php else: ?>
											<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
											<?php endif; ?>
										</div>
									</div>
									</iw></label>
							</div>
						</div>
						<div class="admin_content_alignment_remain">
							<div class="admin_content_widht300">
								<label>Видео (URL YouTube/Vimeo)<br><iw><input class="width100" type="text" name="blog_video" value="<?=htmlspecialchars($hyst_get['video'], ENT_QUOTES, 'UTF-8');?>" placeholder="https://www.youtube.com/watch?v=..."></iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Категория<i>*</i><br><iw>
									<select class="width100" name="blog_category" mandatory>
										<option value="Общее" <?=$hyst_get['category'] == 'Общее' ? 'selected' : '';?>>Общее</option>
										<option value="Советы" <?=$hyst_get['category'] == 'Советы' ? 'selected' : '';?>>Советы</option>
										<option value="Гарантия" <?=$hyst_get['category'] == 'Гарантия' ? 'selected' : '';?>>Гарантия</option>
										<option value="Услуги" <?=$hyst_get['category'] == 'Услуги' ? 'selected' : '';?>>Услуги</option>
									</select>
								</iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Время чтения<br><iw><input class="width100" type="text" name="blog_read_time" value="<?=htmlspecialchars($hyst_get['read_time'], ENT_QUOTES, 'UTF-8');?>" placeholder="5 мин"></iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Автор<br><iw><input class="width100" type="text" name="blog_author" value="<?=htmlspecialchars($hyst_get['author'], ENT_QUOTES, 'UTF-8');?>" placeholder="Motor Land"></iw></label>
							</div>
							
							<div class="width100">
								<label>Биография автора<br><iw><textarea style="width: 100%; min-height: 60px;" name="blog_author_bio" placeholder="Краткая биография автора"><?=htmlspecialchars($hyst_get['author_bio'], ENT_QUOTES, 'UTF-8');?></textarea></iw></label>
							</div>
							
							<div class="width100">
								<label>Ключевые слова (SEO)<br><iw><input class="width100" type="text" name="blog_keywords" value="<?=htmlspecialchars($hyst_get['keywords'], ENT_QUOTES, 'UTF-8');?>" placeholder="ключевое слово 1, ключевое слово 2"></iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Статус<i>*</i><br><iw>
									<select class="width100" name="blog_status" mandatory>
										<option value="draft" <?=$hyst_get['status'] == 'draft' ? 'selected' : '';?>>Черновик</option>
										<option value="published" <?=$hyst_get['status'] == 'published' ? 'selected' : '';?>>Опубликовано</option>
									</select>
								</iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Дата публикации<br><iw><input class="width100" type="text" value="<?=date('d.m.Y H:i', strtotime($hyst_get['date']));?>" readonly style="background: #f5f5f5;"></iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Дата изменения<br><iw><input class="width100" type="text" value="<?=date('d.m.Y H:i', strtotime($hyst_get['date_modified']));?>" readonly style="background: #f5f5f5;"></iw></label>
							</div>
						</div>
					</div>
					
					<input type="hidden" name="blog_id" value="<?=$hyst_get['id'];?>">
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="blog_red" value="Сохранить изменения">
					</div>
				</div>
			</interfaceform>
			
			<interfaceform target="hyst/mods/blog/proces" style="display: inline-block;">
				<input type="hidden" name="blog_id" value="<?=$hyst_get['id'];?>">
				<input confirm-yesno="Вы действительно хотите удалить статью?" type="button" role="submit" name="blog_del" value="Удалить статью">
			</interfaceform>
		</div>
	</div>
<?php
endwhile;
}
?>
</div>

