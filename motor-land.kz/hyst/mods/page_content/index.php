<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/page_content/proces.php');

// Получаем список только разрешенных страниц (автосервис, оплата, гарантия)
$stmt = $_DB_CONECT->query("SELECT * FROM page_content WHERE page_key IN ('service_page', 'pay_page', 'guarantees_page') ORDER BY id ASC");
$pages_list = [];
while ($row = $stmt->fetch_assoc()) {
	$pages_list[] = $row;
}

// Определяем иконки для страниц
$page_icons = [
	'service_page' => '🔧',
	'pay_page' => '💳',
	'guarantees_page' => '🛡️'
];
?>

<?php foreach ($pages_list as $page): ?>
<div class="admin_roller_menu admin_roller100">
	<input type="checkbox" id="moderator_roller_page_<?=$page['id'];?>">
	<label id="visual_ch_page_<?=$page['id'];?>" for="moderator_roller_page_<?=$page['id'];?>">
		<?=isset($page_icons[$page['page_key']]) ? $page_icons[$page['page_key']] : '📄';?> <?=htmlspecialchars($page['page_name'], ENT_QUOTES, 'UTF-8');?>
		<span style="color: #888; font-size: 12px; font-weight: normal;">[<?=htmlspecialchars($page['page_key'], ENT_QUOTES, 'UTF-8');?>]</span>
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

