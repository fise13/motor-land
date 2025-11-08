<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/page_content/proces.php');

// Получаем список всех страниц
$stmt = $_DB_CONECT->query("SELECT * FROM page_content ORDER BY id ASC");
$pages_list = [];
while ($row = $stmt->fetch_assoc()) {
	$pages_list[] = $row;
}

$page_icons = [
	'catalog_page' => '📦',
	'service_page' => '🔧',
	'pay_page' => '💳',
	'guarantees_page' => '🛡️',
	'contacts_page' => '📞'
];
?>

<div class="admin_blog_field_group" style="margin-bottom: 30px; padding: 20px; background: rgba(254, 0, 0, 0.05); border-radius: 10px; border: 1px solid rgba(254, 0, 0, 0.2);">
	<div class="admin_blog_field_group_title" style="font-size: 18px; margin-bottom: 10px;">📄 Редактирование страниц</div>
	<div style="color: #bbb; font-size: 13px;">Управление контентом страниц сайта: заголовки, SEO-метатеги, текст страниц</div>
</div>

<?php foreach ($pages_list as $page): ?>
<div class="admin_roller_menu admin_roller100">
	<input type="checkbox" id="moderator_roller_page_<?=$page['id'];?>">
	<label id="visual_ch_page_<?=$page['id'];?>" for="moderator_roller_page_<?=$page['id'];?>">
		<?=isset($page_icons[$page['page_key']]) ? $page_icons[$page['page_key']] : '📄';?> <?=htmlspecialchars($page['page_name'], ENT_QUOTES, 'UTF-8');?>
		<span style="color: #888; font-size: 12px; font-weight: normal; margin-left: 8px;">[<?=htmlspecialchars($page['page_key'], ENT_QUOTES, 'UTF-8');?>]</span>
	</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">✏️ Редактировать страницу: <?=htmlspecialchars($page['page_name'], ENT_QUOTES, 'UTF-8');?></div>
		<interfaceform target="hyst/mods/page_content/proces">
			<div class="admin_content_alignment">
				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">📋 Основная информация</div>
					<div class="admin_content_widht300">
						<label>Название страницы<i>*</i><br>
						<iw><input value="<?=htmlspecialchars($page['page_name'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="page_name" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Ключ страницы (не изменяется)<br>
						<iw><input value="<?=htmlspecialchars($page['page_key'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="page_key" readonly style="background: #1f1e27 !important; border-color: #2a2933 !important; color: #999 !important; cursor: not-allowed;"></iw></label>
					</div>
					<div class="width100">
						<label>H1 заголовок<i>*</i><span class="admin_blog_hint">(заголовок страницы)</span><br>
						<iw><input value="<?=htmlspecialchars($page['h1_text'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="h1_text" mandatory></iw></label>
					</div>
				</div>

				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">🔍 SEO настройки</div>
					<div class="width100">
						<label>Meta Title<i>*</i><span class="admin_blog_hint">(заголовок для поисковых систем, 50-60 символов)</span><br>
						<iw><input value="<?=htmlspecialchars($page['meta_title'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="meta_title" mandatory></iw></label>
					</div>
					<div class="width100">
						<label>Meta Description<i>*</i><span class="admin_blog_hint">(описание для поисковых систем, 150-160 символов)</span><br>
						<iw><textarea style="width: 100%; min-height: 80px;" name="meta_description" mandatory><?=htmlspecialchars($page['meta_description'], ENT_QUOTES, 'UTF-8');?></textarea></iw></label>
					</div>
					<div class="width100">
						<label>Meta Keywords<span class="admin_blog_hint">(ключевые слова через запятую)</span><br>
						<iw><input value="<?=htmlspecialchars($page['meta_keywords'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="meta_keywords"></iw></label>
					</div>
				</div>

				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">✍️ Контент страницы</div>
					<div class="width100">
						<label>Текст страницы<i>*</i><span class="admin_blog_hint">(используйте редактор для форматирования)</span><br>
						<iw><wysiwygarea class="width100" name="content" style="min-height: 400px;"><?=$page['content'];?></wysiwygarea></iw></label>
					</div>
				</div>

				<input type="hidden" name="page_key" value="<?=htmlspecialchars($page['page_key'], ENT_QUOTES, 'UTF-8');?>">
				<div class="admin_content_widht300" style="margin-top: 20px;">
					<input class="width100" type="button" role="submit" name="page_content_save" value="💾 Сохранить изменения">
				</div>
			</div>
		</interfaceform>
	</div>
</div>
<?php endforeach; ?>

<div class="admin_blog_field_group" style="margin: 40px 0 20px 0; padding: 20px; background: rgba(254, 0, 0, 0.05); border-radius: 10px; border: 1px solid rgba(254, 0, 0, 0.2);">
	<div class="admin_blog_field_group_title" style="font-size: 18px; margin-bottom: 10px;">📝 Простые текстовые блоки (Строки)</div>
	<div style="color: #bbb; font-size: 13px;">Управление простыми текстовыми блоками без форматирования, которые можно использовать на любых страницах сайта</div>
</div>

<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_add_text">
	<label for="moderator_roller_add_text">➕ Добавить текстовый блок</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">Добавить текстовый блок</div>
		<interfaceform target="hyst/mods/page_content/proces">
			<input type="hidden" name="comand" value="simple_texts_add">
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="simple_texts_name" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Ключ для вывода<i>*</i><br><iw><input class="width100" error="Содержит не корректные символы (только А-z0-9 и - _)!" type="text" name="simple_texts_key" check="nick_tag" length=">2" mandatory></iw></label>
				</div>
				<div class="width100">
					<label>Текст<i>*</i><br><iw><textarea style="width: 100%; min-height: 120px;" name="simple_texts_text" placeholder="Введите текст"></textarea></iw></label>
				</div>
				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="simple_texts_add" value="Добавить">
				</div>
			</div>
		</interfaceform>
	</div>
</div>

<div>
<?php
$hyst_tmp = $_DB_CONECT->query("SELECT * FROM simple_texts ORDER BY id DESC");
if (mysqli_num_rows($hyst_tmp) != 0) {
while($hyst_get = mysqli_fetch_array($hyst_tmp)):
?>
	<div class="admin_roller_menu admin_roller100 delet_slider_block<?=$hyst_get['id'];?>">
		<input type="checkbox" id="moderator_roller_text_<?=$hyst_get['id'];?>">
		<label id="visual_ch_slideroler_<?=$hyst_get['id'];?>" for="moderator_roller_text_<?=$hyst_get['id'];?>"><?=htmlspecialchars($hyst_get['name'], ENT_QUOTES, 'UTF-8');?> [<?=htmlspecialchars($hyst_get['key_id'], ENT_QUOTES, 'UTF-8');?>]</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Редактировать текстовый блок</div>
			<interfaceform target="hyst/mods/page_content/proces">
				<input type="hidden" name="comand" value="simple_texts_red">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input value="<?=htmlspecialchars($hyst_get['name'], ENT_QUOTES, 'UTF-8');?>" class="width100" error="Содержит не корректные символы!" type="text" name="simple_texts_name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Ключ для вывода<i>*</i><br><iw><input value="<?=htmlspecialchars($hyst_get['key_id'], ENT_QUOTES, 'UTF-8');?>" class="width100" error="Содержит не корректные символы (только А-z0-9 и - _)!" type="text" name="simple_texts_key" check="nick_tag" length=">2" mandatory></iw></label>
					</div>
					<div class="width100">
						<label>Текст<i>*</i><br><iw><textarea style="width: 100%; min-height: 120px;" name="simple_texts_text" placeholder="Введите текст"><?=htmlspecialchars($hyst_get['text'], ENT_QUOTES, 'UTF-8');?></textarea></iw></label>
					</div>
					<input type="hidden" name="simple_texts_id" value="<?=$hyst_get['id'];?>">
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="simple_texts_red" value="Сохранить">
					</div>
				</div>
			</interfaceform>
			
			<interfaceform target="hyst/mods/page_content/proces" style="display: inline-block; margin-top: 15px;">
				<input type="hidden" name="comand" value="simple_texts_del">
				<input type="hidden" name="simple_texts_id" value="<?=$hyst_get['id'];?>">
				<input confirm-yesno="Вы действительно хотите удалить текстовый блок?" type="button" role="submit" name="simple_texts_del" value="Удалить" style="background: #fe0000; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
			</interfaceform>
		</div>
	</div>
<?php
endwhile;
}
?>
</div>

<div class="admin_blog_field_group" style="margin: 40px 0 20px 0; padding: 20px; background: rgba(254, 0, 0, 0.05); border-radius: 10px; border: 1px solid rgba(254, 0, 0, 0.2);">
	<div class="admin_blog_field_group_title" style="font-size: 18px; margin-bottom: 10px;">📄 Контентные блоки (с форматированием)</div>
	<div style="color: #bbb; font-size: 13px;">Управление контентными блоками с форматированием (WYSIWYG редактор), которые можно использовать на любых страницах сайта</div>
</div>

<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_add_customtext">
	<label for="moderator_roller_add_customtext">➕ Добавить контентный блок</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">Добавить контентный блок</div>
		<interfaceform target="hyst/mods/page_content/proces">
			<input type="hidden" name="comand" value="customtexts_add">
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="customtexts_name" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Ключ для вывода<i>*</i><br><iw><input class="width100" error="Содержит не корректные символы (только А-z0-9 и - _)!" type="text" name="customtexts_key" check="nick_tag" length=">2" mandatory></iw></label>
				</div>
				<div class="width100">
					<label>Текст<i>*</i><br><iw><wysiwygarea class="width100" name="customtexts_text" style="min-height: 300px;"></wysiwygarea></iw></label>
				</div>
				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="customtexts_add" value="Добавить">
				</div>
			</div>
		</interfaceform>
	</div>
</div>

<div>
<?php
$hyst_tmp_custom = $_DB_CONECT->query("SELECT * FROM customtexts ORDER BY id DESC");
if (mysqli_num_rows($hyst_tmp_custom) != 0) {
while($hyst_get_custom = mysqli_fetch_array($hyst_tmp_custom)):
?>
	<div class="admin_roller_menu admin_roller100 delet_customtexts_block<?=$hyst_get_custom['id'];?>">
		<input type="checkbox" id="moderator_roller_customtexts_<?=$hyst_get_custom['id'];?>">
		<label id="visual_ch_customtexts_<?=$hyst_get_custom['id'];?>" for="moderator_roller_customtexts_<?=$hyst_get_custom['id'];?>"><?=htmlspecialchars($hyst_get_custom['name'], ENT_QUOTES, 'UTF-8');?> [<?=htmlspecialchars($hyst_get_custom['key_id'], ENT_QUOTES, 'UTF-8');?>]</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Редактировать контентный блок</div>
			<interfaceform target="hyst/mods/page_content/proces">
				<input type="hidden" name="comand" value="customtexts_red">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input value="<?=htmlspecialchars($hyst_get_custom['name'], ENT_QUOTES, 'UTF-8');?>" class="width100" error="Содержит не корректные символы!" type="text" name="customtexts_name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Ключ для вывода<i>*</i><br><iw><input value="<?=htmlspecialchars($hyst_get_custom['key_id'], ENT_QUOTES, 'UTF-8');?>" class="width100" error="Содержит не корректные символы (только А-z0-9 и - _)!" type="text" name="customtexts_key" check="nick_tag" length=">2" mandatory></iw></label>
					</div>
					<div class="width100">
						<label>Текст<i>*</i><br><iw><wysiwygarea class="width100" name="customtexts_text" style="min-height: 300px;"><?=$hyst_get_custom['text'];?></wysiwygarea></iw></label>
					</div>
					<input type="hidden" name="customtexts_id" value="<?=$hyst_get_custom['id'];?>">
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="customtexts_red" value="Сохранить">
					</div>
				</div>
			</interfaceform>
			
			<interfaceform target="hyst/mods/page_content/proces" style="display: inline-block; margin-top: 15px;">
				<input type="hidden" name="comand" value="customtexts_del">
				<input type="hidden" name="customtexts_id" value="<?=$hyst_get_custom['id'];?>">
				<input confirm-yesno="Вы действительно хотите удалить контентный блок?" type="button" role="submit" name="customtexts_del" value="Удалить" style="background: #fe0000; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
			</interfaceform>
		</div>
	</div>
<?php
endwhile;
}
?>
</div>
