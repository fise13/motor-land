<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/seo_queries/proces.php');

// Получаем список запросов
$stmt = $_DB_CONECT->query("SELECT * FROM seo_queries ORDER BY cluster, priority DESC, date_added DESC");
$queries_list = [];
while ($row = $stmt->fetch_assoc()) {
	$queries_list[] = $row;
}

// Получаем кластеры
$clusters = get_seo_clusters();
?>

<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_import">
	<label for="moderator_roller_import">📥 Массовый импорт SEO-запросов</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">📥 Импорт SEO-запросов</div>
		<interfaceform target="hyst/mods/seo_queries/proces">
			<div class="admin_content_alignment">
				<div class="width100">
					<label>Список запросов (по одному на строку)<i>*</i><span class="admin_blog_hint">(вставьте список запросов из таблицы, каждый запрос с новой строки)</span><br>
					<iw><textarea style="width: 100%; min-height: 300px;" name="seo_queries_text" placeholder="Двигатель ММЗ Д-245
Двигатель ММЗ Д-245.12С-1
Двигатель ММЗ Д-245.12С-2
..."></textarea></iw></label>
				</div>
				<div class="admin_content_widht300" style="margin-top: 20px;">
					<input class="width100" type="button" role="submit" name="seo_queries_import" value="✅ Импортировать запросы">
				</div>
			</div>
		</interfaceform>
	</div>
</div>

<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_add">
	<label for="moderator_roller_add">➕ Добавить SEO-запрос</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">➕ Добавить SEO-запрос</div>
		<interfaceform target="hyst/mods/seo_queries/proces">
			<div class="admin_content_alignment">
				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">📋 Основная информация</div>
					<div class="width100">
						<label>Текст запроса<i>*</i><span class="admin_blog_hint">(например: Двигатель ММЗ Д-245.12С-1)</span><br>
						<iw><input class="width100" error="Запрос должен содержать минимум 3 символа!" type="text" name="query_text" check="name" length=">2" mandatory placeholder="Двигатель ММЗ Д-245.12С-1"></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Кластер<span class="admin_blog_hint">(будет определен автоматически, если оставить пустым)</span><br>
						<iw><input class="width100" type="text" name="cluster" placeholder="ММЗ Д-245.12С"></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Приоритет (1-10)<br>
						<iw><input class="width100" type="number" name="priority" value="5" min="1" max="10"></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Статус<i>*</i><br>
						<iw>
							<select class="width100" name="status" mandatory>
								<option value="active">✅ Активен</option>
								<option value="draft">📝 Черновик</option>
								<option value="archived">📦 Архивирован</option>
							</select>
						</iw></label>
					</div>
				</div>

				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">🔍 SEO настройки</div>
					<div class="width100">
						<label>Meta Title<i>*</i><span class="admin_blog_hint">(заголовок для поисковых систем, 50-60 символов)</span><br>
						<iw><input class="width100" type="text" name="meta_title" mandatory placeholder="Купить Двигатель ММЗ Д-245.12С-1 в Алматы | Motor Land"></iw></label>
					</div>
					<div class="width100">
						<label>Meta Description<i>*</i><span class="admin_blog_hint">(описание для поисковых систем, 150-160 символов)</span><br>
						<iw><textarea style="width: 100%; min-height: 80px;" name="meta_description" mandatory placeholder="Купить Двигатель ММЗ Д-245.12С-1 в Алматы. Контрактные двигатели из Малайзии с гарантией."></textarea></iw></label>
					</div>
					<div class="width100">
						<label>Meta Keywords<span class="admin_blog_hint">(ключевые слова через запятую)</span><br>
						<iw><input class="width100" type="text" name="meta_keywords" placeholder="двигатель ммз д-245, контрактный двигатель алматы"></iw></label>
					</div>
					<div class="width100">
						<label>H1 заголовок<i>*</i><br>
						<iw><input class="width100" type="text" name="h1_text" mandatory placeholder="Купить Двигатель ММЗ Д-245.12С-1 в Алматы"></iw></label>
					</div>
				</div>

				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">✍️ Контент страницы</div>
					<div class="width100">
						<label>Текст страницы<i>*</i><span class="admin_blog_hint">(используйте редактор для форматирования)</span><br>
						<iw><wysiwygarea class="width100" name="content" style="min-height: 400px;"></wysiwygarea></iw></label>
					</div>
				</div>

				<div class="admin_content_widht300" style="margin-top: 20px;">
					<input class="width100" type="button" role="submit" name="seo_query_add" value="✅ Добавить запрос">
				</div>
			</div>
		</interfaceform>
	</div>
</div>

<?php if (count($queries_list) > 0): ?>
<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller_stats">
	<label for="moderator_roller_stats">📊 Статистика запросов</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">📊 Статистика по кластерам</div>
		<div class="admin_content_alignment">
			<?php foreach ($clusters as $cluster): ?>
			<div class="admin_inline_ittem">
				<div class="w200">
					<strong><?=htmlspecialchars($cluster['cluster'], ENT_QUOTES, 'UTF-8');?></strong>
				</div>
				<div class="w100">
					<span>Запросов: <?=$cluster['count'];?></span>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php foreach ($queries_list as $query): ?>
<div class="admin_roller_menu admin_roller100">
	<input type="checkbox" id="moderator_roller<?=$query['id'];?>">
	<label id="visual_ch_query_<?=$query['id'];?>" for="moderator_roller<?=$query['id'];?>">
		🔍 <?=htmlspecialchars($query['query_text'], ENT_QUOTES, 'UTF-8');?>
		<span style="color: #888; font-size: 12px; font-weight: normal;">[<?=htmlspecialchars($query['slug'], ENT_QUOTES, 'UTF-8');?>]</span>
		<span style="color: #888; font-size: 12px; font-weight: normal;">| Кластер: <?=htmlspecialchars($query['cluster'], ENT_QUOTES, 'UTF-8');?></span>
		<span class="<?=$query['status'] == 'active' ? 'admin_status_published' : ($query['status'] == 'draft' ? 'admin_status_draft' : 'admin_status_archived');?>">
			<?=$query['status'] == 'active' ? '✅ Активен' : ($query['status'] == 'draft' ? '📝 Черновик' : '📦 Архивирован');?>
		</span>
	</label>
	<div class="admin_roller_container admin_roler_with_overflow">
		<div class="form_title">✏️ Редактировать SEO-запрос</div>
		<interfaceform target="hyst/mods/seo_queries/proces">
			<div class="admin_content_alignment">
				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">📋 Основная информация</div>
					<div class="width100">
						<label>Текст запроса<i>*</i><br>
						<iw><input value="<?=htmlspecialchars($query['query_text'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="query_text" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Кластер<br>
						<iw><input value="<?=htmlspecialchars($query['cluster'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="cluster"></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Приоритет<br>
						<iw><input value="<?=$query['priority'];?>" class="width100" type="number" name="priority" min="1" max="10"></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Статус<i>*</i><br>
						<iw>
							<select class="width100" name="status" mandatory>
								<option value="active" <?=$query['status'] == 'active' ? 'selected' : '';?>>✅ Активен</option>
								<option value="draft" <?=$query['status'] == 'draft' ? 'selected' : '';?>>📝 Черновик</option>
								<option value="archived" <?=$query['status'] == 'archived' ? 'selected' : '';?>>📦 Архивирован</option>
							</select>
						</iw></label>
					</div>
				</div>

				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">🔍 SEO настройки</div>
					<div class="width100">
						<label>Meta Title<i>*</i><br>
						<iw><input value="<?=htmlspecialchars($query['meta_title'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="meta_title" mandatory></iw></label>
					</div>
					<div class="width100">
						<label>Meta Description<i>*</i><br>
						<iw><textarea style="width: 100%; min-height: 80px;" name="meta_description" mandatory><?=htmlspecialchars($query['meta_description'], ENT_QUOTES, 'UTF-8');?></textarea></iw></label>
					</div>
					<div class="width100">
						<label>Meta Keywords<br>
						<iw><input value="<?=htmlspecialchars($query['meta_keywords'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="meta_keywords"></iw></label>
					</div>
					<div class="width100">
						<label>H1 заголовок<i>*</i><br>
						<iw><input value="<?=htmlspecialchars($query['h1_text'], ENT_QUOTES, 'UTF-8');?>" class="width100" type="text" name="h1_text" mandatory></iw></label>
					</div>
				</div>

				<div class="admin_blog_field_group">
					<div class="admin_blog_field_group_title">✍️ Контент страницы</div>
					<div class="width100">
						<label>Текст страницы<i>*</i><br>
						<iw><wysiwygarea class="width100" name="content" style="min-height: 400px;"></wysiwygarea></iw></label>
					</div>
				</div>

				<input type="hidden" name="seo_query_id" value="<?=$query['id'];?>">
				<div class="admin_content_widht300" style="margin-top: 20px;">
					<input class="width100" type="button" role="submit" name="seo_query_edit" value="💾 Сохранить изменения">
				</div>
			</div>
		</interfaceform>

		<interfaceform target="hyst/mods/seo_queries/proces" style="display: inline-block; margin-top: 15px;">
			<input type="hidden" name="seo_query_id" value="<?=$query['id'];?>">
			<input confirm-yesno="⚠️ Вы действительно хотите удалить этот SEO-запрос? Это действие нельзя отменить!" type="button" role="submit" name="seo_query_delete" value="🗑️ Удалить запрос">
		</interfaceform>
	</div>
</div>
<?php endforeach; ?>

<style>
.admin_status_published {
	color: #4CAF50;
	font-weight: 600;
}
.admin_status_draft {
	color: #FF9800;
	font-weight: 600;
}
.admin_status_archived {
	color: #9E9E9E;
	font-weight: 600;
}
</style>

