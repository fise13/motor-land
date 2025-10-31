<ul class="hyst_twodown_control_buttons">
	<a href="?displayed=online_store&a=o" <?=(($_GET['a']=='o'||empty($_GET['a']))?' class="active"':'');?>><li>Заказы</li></a>
	<a href="?displayed=online_store&a=c" <?=($_GET['a']=='c'?' class="active"':'');?>><li>Категории</li></a>
	<a href="?displayed=online_store&a=a" <?=($_GET['a']=='a'?' class="active"':'');?>><li>Атрибуты</li></a>
	<a href="?displayed=online_store&a=t" <?=($_GET['a']=='t'?' class="active"':'');?>><li>Товары</li></a>
	<a href="?displayed=online_store&a=s" <?=($_GET['a']=='s'?' class="active"':'');?>><li>Акции</li></a>
	<a href="?displayed=online_store&a=d" <?=($_GET['a']=='d'?' class="active"':'');?>><li>Доставка и оплата</li></a>
</ul>
<?php if ($_GET['a']=='o'||empty($_GET['a'])) { ?>
<h2>Заказы</h2>
	<?php
	$limit = 10;
	if (hyst_test_id($_GET['page'])) {
		if ($_GET['page'] != 1) {
		$pp = $_GET['page']*10;
		$limit = ' '.($pp-10).', 10';
		}
	}
	
	$hyst_tmp_v = $_DB_CONECT->query("SELECT * FROM internet_magazin_orders ORDER BY id DESC LIMIT ".$limit);
	if (mysqli_num_rows($hyst_tmp_v) != 0) {
	?>
	<?php
		while($hyst_get_v = mysqli_fetch_array($hyst_tmp_v)):
		?>
			<div class="admin_inline_ittem deleted_item<?=$hyst_get_v['id'];?>">
				<div class="w50">#<?=$hyst_get_v['id'];?></div>
				<div class="w100"><?=date('Y-m-d H:i',$hyst_get_v['id']);?></div>
				<div>
					<b>Имя:</b><?=$hyst_get_v['name'];?><br>
					<b>Email:</b><?=$hyst_get_v['email'];?><br>
					<b>Телефон:</b><?=$hyst_get_v['phone'];?>
				</div>
				<div>
					<b>Город:</b><?=$hyst_get_v['city'];?><br>
					<b>Адрес:</b><?=$hyst_get_v['address'];?><br>
					<b>Коментарий:</b><?=$hyst_get_v['comment'];?>
				</div>
				<div>
					<?php
					$e = explode('][',$hyst_get_v['orderittems']);
					foreach ($e as $v) {
						$v = str_ireplace("]", "", $v);
						$v = str_ireplace("[", "", $v);
						$c = explode('-',$v);
						$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari WHERE id='".$c[0]."'");
						if (mysqli_num_rows($hyst_tmp) != 0) {
						$hyst_get = mysqli_fetch_array($hyst_tmp);
						echo $hyst_get['name'].' ('.$hyst_get['arti'].') - '.$c[1].' шт.<br>';
						} else {
						echo 'Товар не нейден в базе данных сайта - '.$c[1].' шт.<br>';
						}
					}
					?>
				</div>
				<interfaceform target="hyst/mods/online_store/proces">
					<input type="hidden" name="internet_magazin_id" value="<?=$hyst_get_v['id'];?>">
					<select name="sst">
						<option value="1"<?=($hyst_get_v['sst']==1?' selected':'');?>>Не обработан</option>
						<option value="2"<?=($hyst_get_v['sst']==2?' selected':'');?>>Отправлен</option>
						<option value="3"<?=($hyst_get_v['sst']==3?' selected':'');?>>Отменен</option>
					</select>
					<input type="button" role="submit" name="internet_magazin_order_change" value="Изменить">
				</interfaceform>
				<interfaceform target="hyst/mods/online_store/proces">
					<input type="hidden" name="internet_magazin_id" value="<?=$hyst_get_v['id'];?>">
					<input type="button" role="submit" confirm-prompt="Введите слово 'Удалить' для подтверждения" name="internet_magazin_order_del" value="Удалить">
				</interfaceform>
			</div>
		<?php
		endwhile;
		?>
		</div>
	<?php
	}
	?>
	<div class="admin_page_pagination">
	<?php
	$hyst_tmp_v = $_DB_CONECT->query("SELECT id FROM internet_magazin_orders ORDER BY id DESC");
	hyst_pagination(mysqli_num_rows($hyst_tmp_v),10,($_GET['page'] ? $_GET['page'] : 1));
	?>
	</div>
<?php 
} else if ($_GET['a']=='c') { 
?>
<h2>Категории</h2>
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add0">
		<label for="moderator_roller_add0">+</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить категорию</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
						<div class="admin_content_widht300">
							<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">1" mandatory></iw></label>
						</div>
						
						<div class="admin_content_widht300">
							<label>Приоритет<br><iw><input class="width100" type="text" name="internet_magazin_prio"></iw></label>
						</div>
						
						<?php 
						$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id DESC");
						?>
						<label>Родительская категория<br>
						<select name="internet_magazin_idparent"><option value="noting" selected>- Нет родтельской категории -</option>
						<?php
						if (mysqli_num_rows($hyst_tmp) != 0) {
						
						while($hyst_get = mysqli_fetch_array($hyst_tmp)):
						echo '<option value="'.$hyst_get['id'].'">'.$hyst_get['name'].'</option>';
						endwhile;
						} 
						?>
						</select></label><br>
						<div class="width100">
							<label>Описание<br><iw><textarea style="width: 100%;" name="internet_magazin_text" placeholder="Введите текст"></textarea></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Картинка категории (иконка)</label>
							<iw class="admin_file_label_wraper">
								<div class="admin_select_img_field">
									<input type="hidden" name="internet_magazin_image" check="none">
									<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="category_image">
										<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
									</div>
								</div>
							</iw>
						</div>

						<div class="admin_content_widht300">
							<label>Баннер</label>
							<iw class="admin_file_label_wraper">
								<div class="admin_select_img_field">
									<input type="hidden" name="internet_magazin_baner" check="none">
									<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="category_banner">
										<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
									</div>
								</div>
							</iw>
						</div>
						
						

						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="internet_magazin_category_add" value="Добавить">
						</div>
					
				</div>
			</interfaceform>
		</div>
	</div>
	<?php
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY prio DESC");
	if ($sql->num_rows != 0) {
	?>

	<sp class="admin_separator"></sp>
	<div class="admin_moderators_table">
	<?php
	while($item=$sql->fetch_array()):
	?>
		<div class="admin_roller_menu admin_roller100 deleted_item<?=$item['id'];?>">
			<input type="checkbox" id="moderator_roller<?=$item['id'];?>">
			<label id="visual_ch_slideroler_<?=$item['id'];?>" for="moderator_roller<?=$item['id'];?>"><?=$item['name'];?> [<?=$item['url'];?>]</label>
			<div class="admin_roller_container admin_roler_with_overflow">
				<div class="form_title">Редактировать категорию</div>
				<interfaceform target="hyst/mods/online_store/proces">
					<div class="admin_content_alignment">
							<div class="admin_content_widht300">
								<label>Название<i>*</i><br><iw><input value="<?=$item['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
							</div>

							<div class="admin_content_widht300">
								<label>Приоритет<br><iw><input value="<?=$item['prio'];?>" class="width100" type="text" name="internet_magazin_prio"></iw></label>
							</div>
							
							<?php 
							$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' AND id!='".$item['id']."' ORDER BY id DESC");
							?>
							<label>Родительская категория<br>
							<select name="internet_magazin_idparent"><option value="noting">- Нет родтельской категории -</option>
							<?php
							if (mysqli_num_rows($hyst_tmp) != 0) {
							
							while($hyst_get = mysqli_fetch_array($hyst_tmp)):
							echo '<option value="'.$hyst_get['id'].'"'.($hyst_get['id']==$item['idp']?' selected':'').'>'.$hyst_get['name'].'</option>';
							endwhile;
							} 
							?>
							</select></label><br>
							
							<div class="width100">
								<label>Описание<br><iw><textarea style="width: 100%;" name="internet_magazin_text" placeholder="Введите текст"><?=$item['text'];?></textarea></iw></label>
							</div>
							
							<div class="admin_content_widht300">
								<label>Картинка категории (иконка)</label>
								<iw class="admin_file_label_wraper">
									<div class="admin_select_img_field">
										<input type="hidden" name="internet_magazin_image" value="<?=$item['image'];?>" check="none" mandatory>
										<div class="admin_select_img_input" <?=($item['image']!='noting'?'style="background-image: url('.$item['image'].');"':'');?> data-tip="Выбрать изображение" unic-return="category_image<?=$item['id'];?>">
											<div class="admin_addimage_tip"><?=($item['image']=='noting'?'+<span>Выбрать изображение</span>':'');?></div>
										</div>
										<?=($item['image']!='noting'?'<div class="admin_file_cross"></div>':'');?>
									</div>
								</iw>
							</div>
							<div class="admin_content_widht300">
								<label>Баннер</label>
								<iw class="admin_file_label_wraper">
									<div class="admin_select_img_field">
										<input type="hidden" name="internet_magazin_baner" value="<?=$item['baner'];?>" check="none" mandatory>
										<div class="admin_select_img_input" <?=($item['baner']!='noting'?'style="background-image: url('.$item['baner'].');"':'');?> data-tip="Выбрать изображение" unic-return="category_baner<?=$item['id'];?>">
											<div class="admin_addimage_tip"><?=($item['baner']=='noting'?'+<span>Выбрать изображение</span>':'');?></div>
										</div>
										<?=($item['baner']!='noting'?'<div class="admin_file_cross"></div>':'');?>
									</div>
								</iw>
							</div>
							
							<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
							<div class="admin_content_widht300">
								<input class="width100" type="button" role="submit" name="internet_magazin_category_red" value="Сохранить">
							</div>
						
					</div>
				</interfaceform>
				
				<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
					<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
					<input confirm-yesno="Вы действительно хотите удалить категорию?" type="button" role="submit" name="internet_magazin_category_del" value="Удалить">
				</interfaceform>
				
				<?php
				$sql_pct = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='".$item['id']."' ORDER BY prio DESC");
				if ($sql_pct->num_rows != 0) {
				?>
				<sp class="admin_separator"></sp>
				<div style="padding: 0px 0px 0px 40px;">
				<h3>Подкатегории</h3>
				<?php
				while($item_pct=$sql_pct->fetch_array()):
				?>
				<div class="admin_roller_menu admin_roller100 deleted_item<?=$item_pct['id'];?>">
					<input type="checkbox" id="moderator_roller<?=$item_pct['id'];?>">
					<label id="visual_ch_slideroler_<?=$item_pct['id'];?>" for="moderator_roller<?=$item_pct['id'];?>"><?=$item_pct['name'];?> [<?=$item_pct['url'];?>]</label>
					<div class="admin_roller_container admin_roler_with_overflow">
						<div class="form_title">Редактировать категорию</div>
						<interfaceform target="hyst/mods/online_store/proces">
							<div class="admin_content_alignment">
									<div class="admin_content_widht300">
										<label>Название<i>*</i><br><iw><input value="<?=$item_pct['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
									</div>

									<div class="admin_content_widht300">
										<label>Приоритет<br><iw><input value="<?=$item_pct['prio'];?>" class="width100" type="text" name="internet_magazin_prio"></iw></label>
									</div>
									
									<?php 
									$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' AND id!='".$item_pct['id']."' ORDER BY id DESC");
									?>
									<label>Родительская категория<br>
									<select name="internet_magazin_idparent"><option value="noting">- Нет родтельской категории -</option>
									<?php
									if (mysqli_num_rows($hyst_tmp) != 0) {
									
									while($hyst_get = mysqli_fetch_array($hyst_tmp)):
									echo '<option value="'.$hyst_get['id'].'"'.($hyst_get['id']==$item_pct['idp']?' selected':'').'>'.$hyst_get['name'].'</option>';
									endwhile;
									} 
									?>
									</select></label><br>
									
									<div class="width100">
										<label>Описание<br><iw><textarea style="width: 100%;" name="internet_magazin_text" placeholder="Введите текст"><?=$item_pct['text'];?></textarea></iw></label>
									</div>
									
									<div class="admin_content_widht300">
										<label>Картинка категории (иконка)</label>
										<iw class="admin_file_label_wraper">
											<div class="admin_select_img_field">
												<input type="hidden" name="internet_magazin_image" value="<?=$item_pct['image'];?>" check="none" mandatory>
												<div class="admin_select_img_input" <?=($item_pct['image']!='noting'?'style="background-image: url('.$item_pct['image'].');"':'');?> data-tip="Выбрать изображение" unic-return="category_image<?=$item_pct['id'];?>">
													<div class="admin_addimage_tip"><?=($item_pct['image']=='noting'?'+<span>Выбрать изображение</span>':'');?></div>
												</div>
												<?=($item_pct['image']!='noting'?'<div class="admin_file_cross"></div>':'');?>
											</div>
										</iw>
									</div>
									<div class="admin_content_widht300">
										<label>Баннер</label>
										<iw class="admin_file_label_wraper">
											<div class="admin_select_img_field">
												<input type="hidden" name="internet_magazin_baner" value="<?=$item_pct['baner'];?>" check="none" mandatory>
												<div class="admin_select_img_input" <?=($item_pct['baner']!='noting'?'style="background-image: url('.$item_pct['baner'].');"':'');?> data-tip="Выбрать изображение" unic-return="category_baner<?=$item_pct['id'];?>">
													<div class="admin_addimage_tip"><?=($item_pct['baner']=='noting'?'+<span>Выбрать изображение</span>':'');?></div>
												</div>
												<?=($item_pct['baner']!='noting'?'<div class="admin_file_cross"></div>':'');?>
											</div>
										</iw>
									</div>
									
									<input type="hidden" name="internet_magazin_id" value="<?=$item_pct['id'];?>">
									<div class="admin_content_widht300">
										<input class="width100" type="button" role="submit" name="internet_magazin_category_red" value="Сохранить">
									</div>
								
							</div>
						</interfaceform>
						
						<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
							<input type="hidden" name="internet_magazin_id" value="<?=$item_pct['id'];?>">
							<input confirm-yesno="Вы действительно хотите удалить категорию?" type="button" role="submit" name="internet_magazin_category_del" value="Удалить">
						</interfaceform>
					</div>
				</div>
				<?php
				endwhile;
				?>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	endwhile;
	?>
	</div>
	<?php
	}
	?>
	

<?php 
} else if ($_GET['a']=='a') { 
?>
<h2>Система атрибутов</h2>
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add0">
		<label for="moderator_roller_add0">+ группа</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить группу</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
						<div class="admin_content_widht300">
							<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Название для админ-панели (не обяз.)<br><iw><input class="width100" type="text" name="internet_magazin_aname"></iw></label>
						</div>
						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="internet_magazin_atributs_gr_add" value="Добавить">
						</div>
					
				</div>
			</interfaceform>
		</div>
	</div>
	<?php
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_group ORDER BY id DESC");
	if ($sql->num_rows != 0) {
	?>

	<sp class="admin_separator"></sp>
	<div class="admin_moderators_table">
		<h3>Группы атрибутов</h3>
	<?php
	while($item=$sql->fetch_array()):
	?>
		<div class="admin_roller_menu admin_roller100 deleted_item_group<?=$item['id'];?>">
			<input type="checkbox" id="moderator_roller_group<?=$item['id'];?>">
			<label id="visual_ch_slideroler_<?=$item['id'];?>" for="moderator_roller_group<?=$item['id'];?>"><?=$item['name'];?><?=($item['aname']!='noting'?' ['.$item['aname'].']':'');?></label>
			<div class="admin_roller_container admin_roler_with_overflow">
				<div class="form_title">Редактировать группу</div>
				<interfaceform target="hyst/mods/online_store/proces">
					<div class="admin_content_alignment">
							<div class="admin_content_widht300">
								<label>Название<i>*</i><br><iw><input value="<?=$item['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
							</div>
							<div class="admin_content_widht300">
								<label>Название для админ-панели (не обяз.)<br><iw><input value="<?=($item['aname']!='noting'?$item['aname']:'');?>" class="width100" type="text" name="internet_magazin_aname"></iw></label>
							</div>
							<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
							<div class="admin_content_widht300">
								<input class="width100" type="button" role="submit" name="internet_magazin_atributs_gr_red" value="Изменить">
							</div>
						
					</div>
				</interfaceform>
				
				<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
					<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
					<input confirm-yesno="Вы действительно хотите удалить группу?" type="button" role="submit" name="internet_magazin_atributs_gr_del" value="Удалить">
				</interfaceform>
			</div>
		</div>
	<?php
	endwhile;
	?>
	</div>
	<?php
	}
	?>
	<sp class="admin_separator"></sp><br>
	
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add00">
		<label for="moderator_roller_add00">+ атрибут</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить атрибут</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
						<div class="admin_content_widht300">
							<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Название для админ-панели (не обяз.)<br><iw><input class="width100" type="text" name="internet_magazin_aname"></iw></label>
						</div>
						<?php 
						$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_group ORDER BY name ASC");
						if (mysqli_num_rows($hyst_tmp) != 0) {
						?>
						<select name="internet_magazin_idg"><option value="noting" selected>- Без группы -</option>
						<?php
						while($hyst_get = mysqli_fetch_array($hyst_tmp)):
						echo '<option value="'.$hyst_get['id'].'">'.$hyst_get['name'].'</option>';
						endwhile;
						?>
						</select><br>
						<?php 
						} 
						?>
						
						<?php
						$hyst_tmp_c = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id DESC");
						if (mysqli_num_rows($hyst_tmp_c) != 0) {
						?>

						<div class="width100 admin_group_checkboxes hust_general_user_roles" name="categorys">
							<div class="admin_group_checkboxes_title">Для категорий:<i>*</i></div>
						<?php
						while($hyst_get_c = mysqli_fetch_array($hyst_tmp_c)):
						?>
							<label class="admin_label_checkbox"><?=$hyst_get_c['name'];?> <input type="checkbox" value="<?=$hyst_get_c['id'];?>"></label>
						<?php
						endwhile;
						?>
						</div>
						<?php
						} 
						?>
						
						<div class="admin_content_widht300">
							<label class="admin_label_checkbox">Выбор нескольких <input type="checkbox" value="2" name="internet_magazin_multi"></label>
						</div>
						<div class="admin_content_widht300">
							<label class="admin_label_checkbox">Фильтрует <input type="checkbox" value="2" name="internet_magazin_filtr"></label>
						</div>
						
						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="internet_magazin_atributs_add" value="Добавить">
						</div>
					
				</div>
			</interfaceform>
		</div>
	</div>
	
	<?php
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs ORDER BY id DESC");
	if ($sql->num_rows != 0) {
	?>

	<sp class="admin_separator"></sp>
	<div class="admin_moderators_table">
		<h3>Атрибуты</h3>
	<?php
	while($item=$sql->fetch_array()):
	?>
	<div class="admin_roller_menu admin_roller100 deleted_item_atribut<?=$item['id'];?>">
			<input type="checkbox" id="moderator_roller_atribut<?=$item['id'];?>">
			<label id="visual_ch_slideroler_atribut<?=$item['id'];?>" for="moderator_roller_atribut<?=$item['id'];?>"><?=$item['name'];?> [<?=$item['id'];?>]</label>
			<div class="admin_roller_container admin_roler_with_overflow">
				<div class="form_title">Редактировать атрибут</div>
				<interfaceform target="hyst/mods/online_store/proces">
					<div class="admin_content_alignment">
						<div class="admin_content_widht300">
							<label>Название<i>*</i><br><iw><input value="<?=$item['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Название для админ-панели (не обяз.)<br><iw><input value="<?=($item['aname']!='noting'?$item['aname']:'');?>" class="width100" type="text" name="internet_magazin_aname"></iw></label>
						</div>
						<?php 
						$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_group ORDER BY name ASC");
						if (mysqli_num_rows($hyst_tmp) != 0) {
						?>
						<select name="internet_magazin_idg"><option value="noting"<?=($item['idg']==0?' selected':'');?>>- Без группы -</option>
						<?php
						while($hyst_get = mysqli_fetch_array($hyst_tmp)):
						echo '<option value="'.$hyst_get['id'].'"'.($item['idg']==$hyst_get['id']?' selected':'').'>'.$hyst_get['name'].'</option>';
						endwhile;
						?>
						</select><br>
						<?php 
						} 
						?>
						
						<?php
						if ($item['category'] != 'noting') {
							$cat_arr = get_farrimg($item['category']);
						} else {
							$cat_arr = [];
						}
						$hyst_tmp_c = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id DESC");
						if (mysqli_num_rows($hyst_tmp_c) != 0) {
						?>

						<div class="width100 admin_group_checkboxes hust_general_user_roles" name="categorys">
							<div class="admin_group_checkboxes_title">Для категорий:<i>*</i></div>
						<?php
						while($hyst_get_c = mysqli_fetch_array($hyst_tmp_c)):
						?>
							<label class="admin_label_checkbox"><?=$hyst_get_c['name'];?> <input type="checkbox" value="<?=$hyst_get_c['id'];?>"<?=(array_search($hyst_get_c['id'],$cat_arr)!==false?' checked':'');?>></label>
						<?php
						endwhile;
						?>
						</div>
						<?php
						} 
						?>
						
						<div class="admin_content_widht300">
							<label class="admin_label_checkbox">Выбор нескольких <input type="checkbox" value="2" name="internet_magazin_multi"<?=($item['mult']==2?' checked':'');?>></label>
						</div>
						<div class="admin_content_widht300">
							<label class="admin_label_checkbox">Фильтрует <input type="checkbox" value="2" name="internet_magazin_filtr"<?=($item['fltr']==2?' checked':'');?>></label>
						</div>
						<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="internet_magazin_atributs_red" value="Сохранить">
						</div>
					</div>
				</interfaceform>
				
				<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
					<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
					<input confirm-yesno="Вы действительно хотите удалить атрибут?" type="button" role="submit" name="internet_magazin_atributs_del" value="Удалить">
				</interfaceform>
				<div style="padding: 0px 0px 0px 40px;">
					<sp class="admin_separator"></sp>
					<div class="admin_roller_menu">
						<input type="checkbox" id="atribute_roller_add_<?=$item['id'];?>">
						<label for="atribute_roller_add_<?=$item['id'];?>">+ опция</label>
						<div class="admin_roller_container admin_roler_with_overflow">
							<div class="form_title">Добавить значение</div>
							<interfaceform target="hyst/mods/online_store/proces">
								<div class="admin_content_alignment">
									<input type="hidden" name="internet_magazin_idp" value="<?=$item['id'];?>">
									<div class="admin_content_widht300">
										<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
									</div>
									<div class="admin_content_widht300">
										<label>Наценка при выборе<br><iw><input class="width100" type="text" name="internet_magazin_cash"></iw></label>
									</div>
									
									<div class="admin_content_widht300">
										<label>Иконка</label>
										<iw class="admin_file_label_wraper">
											<div class="admin_select_img_field">
												<input type="hidden" name="internet_magazin_image" check="none">
												<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="atribute_add_val_img<?=$item['id'];?>">
													<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
												</div>
											</div>
										</iw>
									</div>
									
									<div class="admin_content_widht300">
										<label class="admin_label_checkbox">Цвет <input type="checkbox" value="2" name="internet_magazin_color_chk"></label>
										<input type="color" value="noting" name="internet_magazin_color">
									</div>
									
									<div class="admin_content_widht300">
										<input class="width100" type="button" role="submit" name="internet_magazin_atributs_options_add" value="Добавить">
									</div>
								</div>
							</interfaceform>
						</div>
					</div>
					<?php
					$sql_atrvals = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_options WHERE idp='".$item['id']."' ORDER BY name DESC");
					if ($sql_atrvals->num_rows != 0) {
					?>
					<sp class="admin_separator"></sp>
					<div style="padding: 0px 0px 0px 40px;">
					<?php
					while($item_value=$sql_atrvals->fetch_array()):
					?>
						<div class="admin_roller_menu admin_roller100 deleted_item_atributitem_value<?=$item_value['id'];?>">
							<input type="checkbox" id="moderator_roller_atribut_val<?=$item_value['id'];?>">
							<label id="visual_ch_slideroler_atribut_val<?=$item_value['id'];?>" for="moderator_roller_atribut_val<?=$item_value['id'];?>"><?=$item_value['name'];?></label>
							<div class="admin_roller_container admin_roler_with_overflow">
								<interfaceform target="hyst/mods/online_store/proces">
									<div class="admin_content_alignment">
										<div class="admin_content_widht300">
											<label>Название<i>*</i><br><iw><input value="<?=$item_value['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
										</div>
										<div class="admin_content_widht300">
											<label>Наценка при выборе<br><iw><input value="<?=($item_value['cash']!='noting'?$item_value['cash']:'');?>" class="width100" type="text" name="internet_magazin_cash"></iw></label>
										</div>
										
										<div class="admin_content_widht300">
											<label>Иконка</label>
											<iw class="admin_file_label_wraper">
												<div class="admin_select_img_field">
													<input type="hidden" name="internet_magazin_image" value="<?=$item_value['image'];?>" check="none">
													<div class="admin_select_img_input" <?=($item_value['image']!='noting'?'style="background-image: url('.$item_value['image'].');"':'');?>  data-tip="Выбрать изображение" unic-return="atribute_add_val_img<?=$item['id'];?>_<?=$item_value['id'];?>">
														<div class="admin_addimage_tip"><?=($item_value['image']=='noting'?'+<span>Выбрать изображение</span>':'');?></div>
													</div>
													<?=($item_value['image']!='noting'?'<div class="admin_file_cross"></div>':'');?>
												</div>
											</iw>
										</div>
										
										<div class="admin_content_widht300">
											<label class="admin_label_checkbox">Цвет <input type="checkbox" value="2" name="internet_magazin_color_chk"<?=($item_value['color']!='noting'?' checked':'');?>></label>
											<input type="color" value="<?=($item_value['color']!='noting'?$item_value['color']:'');?>" name="internet_magazin_color">
										</div>
										<input type="hidden" name="internet_magazin_id" value="<?=$item_value['id'];?>">
										<div class="admin_content_widht300">
											<input class="width100" type="button" role="submit" name="internet_magazin_atributs_options_red" value="Изменить">
										</div>
									</div>
								</interfaceform>
								
								<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
									<input type="hidden" name="internet_magazin_id" value="<?=$item_value['id'];?>">
									<input confirm-yesno="Вы действительно хотите удалить значение атрибута?" type="button" role="submit" name="internet_magazin_atributs_options_del" value="Удалить">
								</interfaceform>
							</div>
						</div>
					<?php
					endwhile;
					?>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	<?php
	endwhile;
	?>
	</div>
	<?php
	}
	?>
<?php } else if ($_GET['a']=='t') { ?>
	<?php
	$hyst_geti = FALSE;
	if (hyst_test_id($_GET['id'])) {
	$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari WHERE id='".$_GET['id']."'");
		if (mysqli_num_rows($hyst_tmp) != 0) {
		$hyst_geti = mysqli_fetch_array($hyst_tmp);
		}
	} 

	if ($hyst_geti == FALSE) {
	?>

<h2>Товары</h2>
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add">
		<label for="moderator_roller_add">+</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить товар</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Цена<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_cash" check="number" mandatory></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Скидка (будет зачеркнутой ценой)<br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_sale" check="number"></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Артикул<br><iw><input class="width100" error="" type="text" name="internet_magazin_arti" check="none"></iw></label>
					</div>
					<?php
					$hyst_tmp_c = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id DESC");
					if (mysqli_num_rows($hyst_tmp_c) != 0) {
					?>

					<div class="width100 admin_group_checkboxes hust_general_user_roles hyst_os_category_container" name="categorys">
						<div class="admin_group_checkboxes_title">Для категорий:</div>
					<?php
					while($hyst_get_c = mysqli_fetch_array($hyst_tmp_c)):
					?>
						<label class="admin_label_checkbox"><?=$hyst_get_c['name'];?> <input type="checkbox" data-name="<?=$hyst_get_c['name'];?>" value="<?=$hyst_get_c['id'];?>"></label>
					<?php
					endwhile;
					?>
					</div>
					<?php
					} 
					?>
					<div class="width100 admin_group_checkboxes hust_general_user_roles hyst_os_podcategory_container" name="podcategorys"></div>
					
					<div class="width100 hyst_margintop20">
						<label>Атрибуты</label><br>
						<div class="hyst_os_atributs_container"></div>
					</div>
					
					<div class="width100 admin_images_selector_block hyst_margintop20">
						<label>Изображения</label>
						<iw class="admin_file_label_wraper">
							<div class="admin_select_img_field multiple">
								<input type="hidden" name="images" check="none">
								<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="roduct_images" multiple>
									<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
								</div>
								
							</div>
							<div class="admin_img_field_sortable">
								
							</div>
						</iw>
					</div>
					
					<div class="width100 hyst_margintop20">
						<repeater name="harakteristik">
							<div class="admin_form_repeater_label"><label>Характеристики</label><div data-duble="[Название,parametr_name,text][Значение,parametr_val,text]">+</div></div>
							<repeats></repeats>
						</repeater>
					</div>
					
					<div class="width100 hyst_margintop20">
						<div><label>Текст</label><iw><wysiwygarea class="width100" name="internet_magazin_text"></wysiwygarea></iw></div>
					</div>
					
					<div class="width100">
						<label>Краткое описание<br><iw><textarea style="width: 100%;" name="internet_magazin_stext"></textarea></iw></label>
					</div>
					<div class="width100">
						<label>SEO заголовки<br><iw><textarea style="width: 100%;" name="internet_magazin_tmeta"></textarea></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Сопутствующее тов. ID через запятую<br><iw><input class="width100" error="" type="text" name="internet_magazin_sopo" placeholder="10,218,4..." check="none"></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Приоритет показа<br><iw><input class="width100" error="" type="text" name="internet_magazin_prio" check="number" value="1"></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Наличие<br><select name="internet_magazin_instock">
							<option value="1">В наличии</option>
							<option value="2">Ожидаем поступления</option>
							<option value="3">Только под заказ</option>
							<option value="4">Нет в наличии</option>
						</select></label>
					</div>
					
					<div class="admin_content_widht300">
						<label class="admin_label_checkbox">На главную <input type="checkbox" value="2" name="internet_magazin_spek"></label>
					</div>
					
					
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="internet_magazin_tovar_add" value="Добавить">
					</div>
			</interfaceform>
		</div>
	</div>
		<form method="get">
		<div class="admin_inline_ittem admin_sort_and_search" style="justify-content: start; align-items: end;">
			<div class="w300">
				<sup>Поиск товара</sup>
				
					<?php 
					$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id ASC");
					if (mysqli_num_rows($hyst_tmp) != 0) {
					?>
					<select name="category" style="width: 100%;">
					<option value="all" selected>Все категории</option>
					<?php
					while($hyst_get = mysqli_fetch_array($hyst_tmp)):
					echo '<option value="'.$hyst_get['id'].'"'.($hyst_get['id']==$hyst_geti['idr']?' selected':'').'>'.$hyst_get['name'].'</option>';
					endwhile;
					?>
					</select><br>
					<?php 
					} 
					?>
			</div>	
			<div class="w300">	
					<input type="hidden" name="displayed" value="online_store">
					<input type="hidden" name="a" value="t">
					<input type="text" name="find" placeholder="Ключевое слово"<?=(isset($_GET['find'])?' value="'.$_GET['find'].'"':'');?>>
					<input type="submit" name="search" value=" ">
				
			</div>
		</div>
		</form>
		<?php
	
		$where = '';
		
		if (isset($_GET['find']) && $_GET['find']!='') {
			$f = trim($_GET['find']);
			if ($f[0] === '@') {
			$f = substr($f, 1);
			}
			$where = "WHERE (LOCATE(LOWER('".$f."'),LOWER(name)) OR LOCATE(LOWER('".$f."'),LOWER(text)) OR LOCATE(LOWER('".$f."'),LOWER(arti)))";
		}
		
		
		if (isset($_GET['category']) && $_GET['category']!='all') {
			if ($where == '') {
				$where .= "WHERE LOCATE(LOWER('[".$_GET['category']."]'),LOWER(category))";
			} else {
				$where .= "AND LOCATE(LOWER('[".$_GET['category']."]'),LOWER(category))";
			}
		}

		$sort_by = ' id DESC';

		$limit = 10;
		if (hyst_test_id($_GET['page'])) {
			if ($_GET['page'] != 1) {
			$pp = $_GET['page']*10;
			$limit = ' '.($pp-10).', 10';
			}
		}
		
		$hyst_tmp_v = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari ".$where." ORDER BY ".$sort_by." LIMIT ".$limit);
		if (mysqli_num_rows($hyst_tmp_v) != 0) {
		?>
		<sp class="admin_separator"></sp>
		<div class="admin_moderators_table">
		<?php
		while($hyst_get_v = mysqli_fetch_array($hyst_tmp_v)):
		?>
			<div class="admin_inline_ittem deleted_item<?=$hyst_get_v['id'];?>">
				<div class="w50">#<?=$hyst_get_v['id'];?></div>
				<div class="w100"><?=($hyst_get_v['arti']!='noting'?$hyst_get_v['arti']:'');?></div>
				<div><a class="admin_items_href" target="_blank" href="/adm?displayed=online_store&a=t&id=<?=$hyst_get_v['id'];?>"><?=$hyst_get_v['name'];?><peni></peni></a></div>

				<interfaceform target="hyst/mods/online_store/proces">
					<input type="hidden" name="internet_magazin_id" value="<?=$hyst_get_v['id'];?>">
					<input type="button" role="submit" confirm-prompt="Введите слово 'Удалить' для подтверждения" name="internet_magazin_tovari_del" value="Удалить">
				</interfaceform>
			</div>
		<?php
		endwhile;
		?>
		</div>
		<?php
		}
		?>
			<div class="admin_page_pagination">
			<?php
			$hyst_tmp_v = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari ORDER BY id DESC");
			hyst_pagination(mysqli_num_rows($hyst_tmp_v),10,($_GET['page'] ? $_GET['page'] : 1));
			?>
			</div>
	<?php
	} else {
	?>
<h2><?=$hyst_geti['name'];?></h2>
		<interfaceform target="hyst/mods/online_store/proces">
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Название<i>*</i><br><iw><input value="<?=$hyst_geti['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Цена<i>*</i><br><iw><input value="<?=$hyst_geti['cash'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_cash" check="number" mandatory></iw></label>
				</div>
				
				<div class="admin_content_widht300">
					<label>Скидка (будет зачеркнутой ценой)<br><iw><input value="<?=($hyst_geti['sale']!='noting'?$hyst_geti['sale']:'');?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_sale" check="number"></iw></label>
				</div>
				
				<div class="admin_content_widht300">
					<label>Артикул<br><iw><input value="<?=($hyst_geti['arti']!='noting'?$hyst_geti['arti']:'');?>" class="width100" error="" type="text" name="internet_magazin_arti" check="none"></iw></label>
				</div>
				<?php
				$hyst_tmp_c = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id DESC");
				if (mysqli_num_rows($hyst_tmp_c) != 0) {
				?>

				<div class="width100 admin_group_checkboxes hust_general_user_roles hyst_os_category_container" name="categorys">
					<div class="admin_group_checkboxes_title">Для категорий:</div>
				<?php
				while($hyst_get_c = mysqli_fetch_array($hyst_tmp_c)):
				?>
					<label class="admin_label_checkbox"><?=$hyst_get_c['name'];?> 
					<input type="checkbox" data-name="<?=$hyst_get_c['name'];?>" value="<?=$hyst_get_c['id'];?>"<?=(strpos ($hyst_geti['category'],'['.$hyst_get_c['id'].']')!==false?' checked':'');?>></label>
				<?php
				endwhile;
				?>
				</div>
				<?php
				} 
				?>
				<?php
				if ($hyst_geti['category']!='noting') {
				$cat = get_farrimg ($hyst_geti['category']);
				$cat_val = '';
				$attr_val = '';
					foreach($cat as $c) {
						$hyst_cat = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE id='".$c."'");
						
						if (mysqli_num_rows($hyst_cat) != 0) {
							$hyst_cat = mysqli_fetch_array($hyst_cat);
							$hyst_pct = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='".$c."' ORDER BY id DESC");
							if (mysqli_num_rows($hyst_pct) != 0) {
							$cat_val .= '<div class="admin_highlitedblock_bg" data-id="'.$c.'"><label style="padding: 5px 10px;">'.$hyst_cat['name'].'</label>';
							while($hyst_get_pct = mysqli_fetch_array($hyst_pct)):
							$cat_val .= '<label class="admin_label_checkbox">'.$hyst_get_pct['name'].' <input type="checkbox" value="'.$hyst_get_pct['id'].'"'.(strpos ($hyst_geti['podegory'],'['.$hyst_get_pct['id'].']')!==false?' checked':'').'></label>';
							endwhile;
							$cat_val .= '</div>';
							}
							
						}

					}
					
					$lc = '';
					foreach ($cat as $v) {
						if ($lc == '') {
						$lc .=  "LOCATE(LOWER('[".$v."]'),LOWER(category))";
						} else {
						$lc .=  " OR LOCATE(LOWER('[".$v."]'),LOWER(category))";
						}
					}
					
					if ($lc != '') {
						$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs WHERE ".$lc." ORDER BY id DESC");
						if (mysqli_num_rows($hyst_sql) != 0) {
	
						while($get_sql = mysqli_fetch_array($hyst_sql)):
						
						$attr_val .= '<div class="OS_atribute_col"><label class="admin_label_checkbox">'.$get_sql['name'].' <input type="checkbox" name="atributs[]" value="'.$get_sql['id'].'"'.(strpos ($hyst_geti['atributs'],'['.$get_sql['id'].']')!==false?' checked':'').'></label>';

								$hyst_sql0 = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_options WHERE idp='".$get_sql['id']."' ORDER BY id DESC");
								if (mysqli_num_rows($hyst_sql0) != 0) {
						$attr_val .= '<div class="OS_atribute_options_col">';
								while($get_sql0 = mysqli_fetch_array($hyst_sql0)):

						$attr_val .= '<label class="admin_label_checkbox">'.$get_sql0['name'].' <input type="checkbox" name="atribut_option[]" value="'.$get_sql0['id'].'"'.(strpos ($hyst_geti['atributs_opt'],'['.$get_sql0['id'].']')!==false?' checked':'').'></label>';
						
								endwhile;
						$attr_val .= '</div>';
								}
						$attr_val .= '</div>';

						endwhile;
						}
					}
				} else {
				$attr_val = '';
				$cat_val = '';
				}
				?>
				<div class="width100 admin_group_checkboxes hust_general_user_roles hyst_os_podcategory_container" name="podcategorys"><?=$cat_val;?></div>
				
				<div class="width100 hyst_margintop20">
					<label>Атрибуты</label><br>
					<div class="hyst_os_atributs_container"><?=$attr_val;?></div>
				</div>
				<?php
				if ($hyst_geti['images']!='noting') {
				$img = get_farrimg ($hyst_geti['images']);
				$img_val = '';
					foreach($img as $i) {
				$img_val .= ($img_val==''?$i:','.$i);	
					}
				} else {
				$img_val = '';
				$img = [];
				}
				?>
				<div class="width100 admin_images_selector_block hyst_margintop20">
					<label>Изображения</label>
					<iw class="admin_file_label_wraper">
						<div class="admin_select_img_field multiple">
							<input type="hidden" name="images" check="none" value="<?=$img_val;?>">
							<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="roduct_images" multiple>
								<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
							</div>
							
						</div>
						<div class="admin_img_field_sortable">
						<?php
						foreach($img as $i) {
						?>
						<div style="background-image: url(<?=$i;?>);" class="admin_multiple_image_select"><div data-delet="<?=$i;?>" class="admin_file_cross_multiple"></div></div>
						<?php
						}
						?>
						</div>
					</iw>
				</div>
				
				<div class="width100 hyst_margintop20">
					<repeater name="harakteristik">
						<div class="admin_form_repeater_label"><label>Характеристики</label><div data-duble="[Название,parametr_name,text][Значение,parametr_val,text]">+</div></div>
						<repeats>
							<?php
							if ($hyst_geti['harakter']!='noting' && $hyst_geti['harakter']!='') {
								$har = explode('|',$hyst_geti['harakter']);
								foreach($har as $val) {
									$v = explode('^',$val);
									echo '<div class="admin_highlitedblock_bg admin_repeat_items_flex">
									<div class="admin_content_widht300">
										<label>Название <br><iw><input class="width100" type="text" name="parametr_name" check="none" value="'.$v[0].'"></iw></label>
									</div>
									<div class="admin_content_widht300">
										<label>Значение <br><iw><input class="width100" type="text" name="parametr_val" check="none" value="'.$v[1].'"></iw></label>
									</div>
									<div class="admin_repeater_cros"></div></div>';
								}
							}
							?>
						</repeats>
					</repeater>
				</div>
				
				<div class="width100 hyst_margintop20">
					<div><label>Текст</label><iw><wysiwygarea class="width100" name="internet_magazin_text"><?=($hyst_geti['text']!='noting'?$hyst_geti['text']:'');?></wysiwygarea></iw></div>
				</div>
				
				<div class="width100">
					<label>Краткое описание<br><iw><textarea style="width: 100%;" name="internet_magazin_stext"><?=($hyst_geti['stext']!='noting'?$hyst_geti['stext']:'');?></textarea></iw></label>
				</div>
				<div class="width100">
					<label>SEO заголовки<br><iw><textarea style="width: 100%;" name="internet_magazin_tmeta"><?=($hyst_geti['tmeta']!='noting'?$hyst_geti['tmeta']:'');?></textarea></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Сопутствующее тов. ID через запятую<br><iw><input value="<?=($hyst_geti['sopo']!='noting'?$hyst_geti['sopo']:'');?>" class="width100" error="" type="text" name="internet_magazin_sopo" placeholder="10,218,4..." check="none"></iw></label>
				</div>
				
				<div class="admin_content_widht300">
					<label>Приоритет показа<br><iw><input class="width100" error="" type="text" name="internet_magazin_prio" check="number" value="<?=($hyst_geti['prio']!='noting'?$hyst_geti['prio']:'1');?>"></iw></label>
				</div>
				
				<div class="admin_content_widht300">
					<label>Наличие<br><select name="internet_magazin_instock">
						<option value="1"<?=($hyst_geti['instock']=='1'?' selected':'');?>>В наличии</option>
						<option value="2"<?=($hyst_geti['instock']=='2'?' selected':'');?>>Ожидаем поступления</option>
						<option value="3"<?=($hyst_geti['instock']=='3'?' selected':'');?>>Только под заказ</option>
						<option value="4"<?=($hyst_geti['instock']=='4'?' selected':'');?>>Нет в наличии</option>
					</select></label>
				</div>
				
				<div class="admin_content_widht300">
					<label class="admin_label_checkbox">На главную <input type="checkbox" value="2" name="internet_magazin_spek"<?=($hyst_geti['spek']=='2'?' checked':'');?>></label>
				</div>
				
				<input type="hidden" name="internet_magazin_id" value="<?=$hyst_geti['id'];?>">
				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="internet_magazin_tovar_red" value="Сохранить">
				</div>
		</interfaceform>
	<?php
	}
	?>
<?php } else if ($_GET['a']=='s') { ?>
	<script>
	function hyst_getajxsalesrng (el) {
		$('.hyst_ajaxform_container').html('');
		if ($(el).val()!='all') {
			if ($(el).val() == 'cat') { var rng = 'cat'; } else if ($(el).val() == 'sub') { var rng = 'sub'; } else if ($(el).val() == 'cas') { var rng = 'cas'; } else { var rng = 'tov'; }
			
			$.ajax({
				type: "POST",
				url: 'hyst/mods/online_store/getforsal',
				data: "typ="+rng,
				success: function(html){ 
				$('.hyst_ajaxform_container').html('<div>'+html+'</div>');
				}
			});
			}
	}

	function hyst_getajxsalesrngtov(el) {
		if ($(el).val().length > 2) {
			$.ajax({
				type: "POST",
				url: 'hyst/mods/online_store/getforsal',
				data: "typ=tova&nam="+$(el).val(),
				success: function(html){ 
				$(el).parent('.hyst_psevdodatalistsel').children('div').detach();
				$(el).parent('.hyst_psevdodatalistsel').append(html);
				}
			});
			
		}
	}

	function hyst_getajxsalesrngtovar(el) {
		$(el).parent('div').parent('.hyst_psevdodatalistsel').children('input[name="internet_magazin_tovarid"]').val($(el).attr('data-id'));
		$(el).parent('div').parent('.hyst_psevdodatalistsel').children('input[name="sval"]').val($(el).html());
		$(el).parent('div').parent('.hyst_psevdodatalistsel').children('div').detach();
	}
	</script>
	<?php
	$hyst_geti = FALSE;
	if (hyst_test_id($_GET['id'])) {
	$hyst_tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_sales WHERE id='".$_GET['id']."'");
		if (mysqli_num_rows($hyst_tmp) != 0) {
		$hyst_geti = mysqli_fetch_array($hyst_tmp);
		}
	} 

	if ($hyst_geti == FALSE) {
	?>
<h2>Акции</h2>
	
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add">
		<label for="moderator_roller_add">+</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить акцию</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Процент скидки<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_sale" check="number" mandatory></iw></label>
					</div>
				</div>
				<div>
					<label class="admin_label_checkbox">На все товары <input onchange="hyst_getajxsalesrng (this);" type="radio" value="all" name="internet_magazin_rng" checked></label>
					<label class="admin_label_checkbox">На категорию <input onchange="hyst_getajxsalesrng (this);" type="radio" value="cat" name="internet_magazin_rng"></label>
					<label class="admin_label_checkbox">На подкатегорию <input onchange="hyst_getajxsalesrng (this);" type="radio" value="sub" name="internet_magazin_rng"></label>
					<label class="admin_label_checkbox">На товар <input onchange="hyst_getajxsalesrng (this);" type="radio" value="tov" name="internet_magazin_rng"></label>
					<label class="admin_label_checkbox">На общую цену заказа <input onchange="hyst_getajxsalesrng (this);" type="radio" value="cas" name="internet_magazin_rng"></label>
				</div>
				
				<div class="admin_sale_target_block hyst_ajaxform_container"></div>
				
				<div class="admin_content_widht300 hyst_margintop20">
					<label>Картинка</label>
					<iw class="admin_file_label_wraper">
						<div class="admin_select_img_field">
							<input type="hidden" name="internet_magazin_image" check="none">
							<div class="admin_select_img_input"  data-tip="Выбрать изображение" unic-return="sale_image">
								<div class="admin_addimage_tip">+<span>Выбрать изображение</span></div>
							</div>
						</div>
					</iw>
				</div>
				
				<div class="width100 hyst_margintop20">
						<div><label>Текст</label><iw><wysiwygarea class="width100" name="internet_magazin_text"></wysiwygarea></iw></div>
				</div>
					
				<div class="width100">
					<label>Краткое описание<br><iw><textarea style="width: 100%;" name="internet_magazin_stext"></textarea></iw></label>
				</div>
				
				<div class="admin_content_widht300">
					<label class="admin_label_checkbox">Запустить сразу <input type="checkbox" value="2" name="internet_magazin_sst"></label>
				</div>

				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="internet_magazin_sales_add" value="Добавить акцию">
				</div>
				
			</interfaceform>
		</div>
	</div>
	
	<?php
	
		$where = '';
		

		$sort_by = ' id DESC';

		$limit = 10;
		if (hyst_test_id($_GET['page'])) {
			if ($_GET['page'] != 1) {
			$pp = $_GET['page']*10;
			$limit = ' '.($pp-10).', 10';
			}
		}
		
		$hyst_tmp_v = $_DB_CONECT->query("SELECT * FROM internet_magazin_sales ".$where." ORDER BY ".$sort_by." LIMIT ".$limit);
		if (mysqli_num_rows($hyst_tmp_v) != 0) {
		?>
		<sp class="admin_separator"></sp>
		<div class="admin_moderators_table">
		<?php
		while($hyst_get_v = mysqli_fetch_array($hyst_tmp_v)):
		?>
			<div class="admin_inline_ittem deleted_item<?=$hyst_get_v['id'];?>">
				<div class="w50">#<?=$hyst_get_v['id'];?></div>
				<div class="w100"><?=($hyst_get_v['sst']==2?'Запущена':'');?></div>
				<div class="w300">
				<?php
				if ($hyst_get_v['rng'] == 'cat') {
					$id = get_farrimg ($hyst_get_v['rngid'])[0];
					$hyst_tmp = $_DB_CONECT->query("SELECT name FROM internet_magazin_category WHERE id='".$id."'");
					$hyst_tmp = mysqli_fetch_array($hyst_tmp);
				echo 'На категорию товаров: '.$hyst_tmp['name'];
				} else if ($hyst_get_v['rng'] == 'sub') {
					$id = get_farrimg ($hyst_get_v['rngid'])[0];
					$hyst_tmp = $_DB_CONECT->query("SELECT name FROM internet_magazin_category WHERE id='".$id."'");
					$hyst_tmp = mysqli_fetch_array($hyst_tmp);
				echo 'На подкатегорию товаров: '.$hyst_tmp['name'];
				} else if ($hyst_get_v['rng'] == 'tov') {
					$id = get_farrimg ($hyst_get_v['rngid'])[0];
					$hyst_tmp = $_DB_CONECT->query("SELECT name FROM internet_magazin_tovari WHERE id='".$id."'");
					$hyst_tmp = mysqli_fetch_array($hyst_tmp);
				echo 'На товар: '.$hyst_tmp['name'];
				} else if ($hyst_get_v['rng'] == 'cas') {
				echo 'На общую цену в '.$hyst_get_v['rngid'].' тг. '.$hyst_get_v['sale'].'%';
				} else {
				echo 'На все товары: '.$hyst_get_v['sale'].'%';
				}
				?>		
				</div>
				<div><a class="admin_items_href" target="_blank" href="/adm?displayed=online_store&a=s&id=<?=$hyst_get_v['id'];?>"><?=$hyst_get_v['name'];?><peni></peni></a></div>
				
				<interfaceform target="hyst/mods/online_store/proces">
					<input type="hidden" name="internet_magazin_id" value="<?=$hyst_get_v['id'];?>">
					<input type="hidden" name="internet_magazin_sst" value="<?=$hyst_get_v['sst'];?>">
					<input type="button" role="submit" confirm-yesno="Вы действительно хотите <?=($hyst_get_v['sst']==1?'активировать':'деактивировать');?> акцию?" name="internet_magazin_sales_act" value="<?=($hyst_get_v['sst']==1?'Вкл':'Выкл');?>">
				</interfaceform>
				
				<interfaceform target="hyst/mods/online_store/proces">
					<input type="hidden" name="internet_magazin_id" value="<?=$hyst_get_v['id'];?>">
					<input type="button" role="submit" confirm-prompt="Введите слово 'Удалить' для подтверждения" name="internet_magazin_sales_del" value="Удалить">
				</interfaceform>
			</div>
		<?php
		endwhile;
		?>
		</div>
		<?php
		}
		?>
			<div class="admin_page_pagination">
			<?php
			$hyst_tmp_v = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari ORDER BY id DESC");
			hyst_pagination(mysqli_num_rows($hyst_tmp_v),10,($_GET['page'] ? $_GET['page'] : 1));
			?>
			</div>
	<?php
	} else {
	?>
	<h2><?=$hyst_geti['name'];?></h2>
		<interfaceform target="hyst/mods/online_store/proces">
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Название<i>*</i><br><iw><input value="<?=$hyst_geti['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Процент скидки<i>*</i><br><iw><input value="<?=$hyst_geti['sale'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_sale" check="number" mandatory></iw></label>
				</div>
			</div>
			<div>
				<label class="admin_label_checkbox">На все товары <input onchange="hyst_getajxsalesrng (this);" type="radio" value="all" name="internet_magazin_rng"<?=($hyst_geti['rng']=='all'?' checked':'');?>></label>
				<label class="admin_label_checkbox">На категорию <input onchange="hyst_getajxsalesrng (this);" type="radio" value="cat" name="internet_magazin_rng"<?=($hyst_geti['rng']=='cat'?' checked':'');?>></label>
				<label class="admin_label_checkbox">На подкатегорию <input onchange="hyst_getajxsalesrng (this);" type="radio" value="sub" name="internet_magazin_rng"<?=($hyst_geti['rng']=='sub'?' checked':'');?>></label>
				<label class="admin_label_checkbox">На товар <input onchange="hyst_getajxsalesrng (this);" type="radio" value="tov" name="internet_magazin_rng"<?=($hyst_geti['rng']=='tov'?' checked':'');?>></label>
				<label class="admin_label_checkbox">На общую цену заказа <input onchange="hyst_getajxsalesrng (this);" type="radio" value="cas" name="internet_magazin_rng"<?=($hyst_geti['rng']=='cas'?' checked':'');?>></label>
			</div>
			
			<div class="admin_sale_target_block hyst_ajaxform_container">
				<?php
				if ($hyst_geti['rng'] == 'cat') {
					$id = get_farrimg ($hyst_geti['rngid'])[0];
					$hyst_tmp = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_category WHERE idp='noting'");
					
					echo '<div><select name="internet_magazin_cat">';
					while($hyst_tmp = mysqli_fetch_array($hyst_tmp)):
					echo '<option value="'.$hyst_tmp['id'].'">'.$hyst_tmp['name'].'</option>';
					endwhile;
					echo '</select></div>';
				} else if ($hyst_geti['rng'] == 'sub') {
					$id = get_farrimg ($hyst_geti['rngid'])[0];
					$hyst_tmp = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_category WHERE idp!='noting'");
					
					echo '<div><select name="internet_magazin_sub">';
					while($hyst_tmp = mysqli_fetch_array($hyst_tmp)):
					echo '<option value="'.$hyst_tmp['id'].'">'.$hyst_tmp['name'].'</option>';
					endwhile;
					echo '</select></div>';
				} else if ($hyst_geti['rng'] == 'tov') {
					$id = get_farrimg ($hyst_geti['rngid'])[0];
					$hyst_tmp = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_tovari WHERE id='".$id."'");
					$hyst_tmp = mysqli_fetch_array($hyst_tmp);
					echo '<div><div class="hyst_psevdodatalistsel">
					<input type="hidden" name="internet_magazin_tovarid" val="'.$id.'">
					<input type="text" name="sval" value="'.$hyst_tmp['name'].'" oninput="hyst_getajxsalesrngtov(this);" placeholder="Введите название товара">
					</div></div>';
				} else if ($hyst_geti['rng'] == 'cas') {
					echo '<div><div class="hyst_psevdodatalistsel"><input type="text" name="sval" value="'.$hyst_geti['rngid'].'" oninput="this.value = this.value.replace(/\D/g, \'\')" placeholder="Введите порог цены для скидки"></div></div>';
				} 
				?>	
			</div>

			<div class="admin_content_widht300">
				<label>Картинка</label>
				<iw class="admin_file_label_wraper">
					<div class="admin_select_img_field">
						<input type="hidden" name="internet_magazin_image" value="<?=$hyst_geti['image'];?>" check="none">
						<div class="admin_select_img_input" <?=($hyst_geti['image']!='noting'?'style="background-image: url('.$hyst_geti['image'].');"':'');?>  data-tip="Выбрать изображение" unic-return="sale_image">
							<div class="admin_addimage_tip"><?=($hyst_geti['image']=='noting'?'+<span>Выбрать изображение</span>':'');?></div>
						</div>
						<?=($hyst_geti['image']!='noting'?'<div class="admin_file_cross"></div>':'');?>
					</div>
				</iw>
			</div>
			
			<div class="width100 hyst_margintop20">
				<div><label>Текст</label><iw><wysiwygarea class="width100" name="internet_magazin_text"><?=($hyst_geti['text']!='noting'?$hyst_geti['text']:'');?></wysiwygarea></iw></div>
			</div>
				
			<div class="width100">
				<label>Краткое описание<br><iw><textarea style="width: 100%;" name="internet_magazin_stext"><?=($hyst_geti['stext']!='noting'?$hyst_geti['stext']:'');?></textarea></iw></label>
			</div>
			
			<div class="admin_content_widht300">
				<label class="admin_label_checkbox">Запущена <input type="checkbox" value="2" name="internet_magazin_sst"<?=($hyst_geti['sst']=='2'?' checked':'');?>></label>
			</div>
			<input type="hidden" name="internet_magazin_id" value="<?=$hyst_geti['id'];?>">
			<div class="admin_content_widht300">
				<input class="width100" type="button" role="submit" name="internet_magazin_sales_red" value="Сохранить">
			</div>
			
		</interfaceform>
	
	<?php
	}
	?>
<?php } else if ($_GET['a']=='d') { ?>
<h2>Доставка и оплата</h2>
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add">
		<label for="moderator_roller_add">+ доставка</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить доставку</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Наценка<br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_cash" check="number"></iw></label>
					</div>
					<div class="width100">
						<label>Описание<br><iw><textarea style="width: 100%;" name="internet_magazin_text"></textarea></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label class="admin_label_checkbox">Деактивировать адрес <input type="checkbox" value="2" name="internet_magazin_nadr"></label>
					</div>
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="internet_magazin_delivery_add" value="Сохранить">
					</div>
				</div>
			</interfaceform>
		</div>
	</div>
	<?php
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_delivery ORDER BY id DESC");
	if ($sql->num_rows != 0) {
	?>

	<sp class="admin_separator"></sp>
	<div class="admin_moderators_table">
	<?php
	while($item=$sql->fetch_array()):
	?>
		<div class="admin_roller_menu admin_roller100 deleted_item<?=$item['id'];?>">
			<input type="checkbox" id="moderator_roller<?=$item['id'];?>">
			<label id="visual_ch_slideroler_<?=$item['id'];?>" for="moderator_roller<?=$item['id'];?>"><?=$item['name'];?></label>
			<div class="admin_roller_container admin_roler_with_overflow">
				<div class="form_title">Редактировать доставку</div>
				<interfaceform target="hyst/mods/online_store/proces">
					<div class="admin_content_alignment">
						<div class="admin_content_widht300">
							<label>Название<i>*</i><br><iw><input value="<?=$item['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Наценка<br><iw><input value="<?=($item['cash']!='noting'?$item['cash']:'');?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_cash" check="number"></iw></label>
						</div>
						<div class="width100">
							<label>Описание<br><iw><textarea style="width: 100%;" name="internet_magazin_text"><?=($item['text']!='noting'?$item['text']:'');?></textarea></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label class="admin_label_checkbox">Деактивировать адрес <input type="checkbox" value="2" name="internet_magazin_nadr"<?=($item['nadr']=='2'?' checked':'');?>></label>
						</div>
						<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="internet_magazin_delivery_red" value="Сохранить">
						</div>
					</div>
				</interfaceform>
				
				<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
					<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
					<input confirm-yesno="Вы действительно хотите удалить доставку?" type="button" role="submit" name="internet_magazin_delivery_del" value="Удалить">
				</interfaceform>
				
				
			</div>
		</div>
	<?php
	endwhile;
	?>
	</div>
	<?php
	}
	?>
	
	<sp class="admin_separator"></sp>
	
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller_add_pay">
		<label for="moderator_roller_add_pay">+ оплата</label>
		<div class="admin_roller_container admin_roler_with_overflow">
			<div class="form_title">Добавить вид оплаты</div>
			<interfaceform target="hyst/mods/online_store/proces">
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Название для тех-панели<br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_aname" check="name" length=">2"></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Введите имя скрипта<br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_aname" check="none" length=">2"></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="internet_magazin_payment_add" value="Сохранить">
					</div>
				</div>
			</interfaceform>
		</div>
	</div>
	
	<?php
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_payments ORDER BY id DESC");
	if ($sql->num_rows != 0) {
	?>

	<sp class="admin_separator"></sp>
	<div class="admin_moderators_table">
	<?php
	while($item=$sql->fetch_array()):
	?>
		<div class="admin_roller_menu admin_roller100 deleted_item_paym<?=$item['id'];?>">
			<input type="checkbox" id="moderator_roller_paym<?=$item['id'];?>">
			<label id="visual_ch_slideroler_paym<?=$item['id'];?>" for="moderator_roller_paym<?=$item['id'];?>"><?=$item['name'];?></label>
			<div class="admin_roller_container admin_roler_with_overflow">
				<div class="form_title">Редактировать оплату</div>
				<interfaceform target="hyst/mods/online_store/proces">
					<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название<i>*</i><br><iw><input value="<?=$item['name'];?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_name" check="name" length=">2" mandatory></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Название для тех-панели<br><iw><input value="<?=($item['aname']!='noting'?$item['aname']:'');?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_aname" check="name" length=">2"></iw></label>
					</div>
					
					<div class="admin_content_widht300">
						<label>Введите имя скрипта<br><iw><input value="<?=($item['srcname']!='noting'?$item['srcname']:'');?>" class="width100" error="Содержит не корреткные символы!" type="text" name="internet_magazin_aname" check="none" length=">2"></iw></label>
					</div>
					<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="internet_magazin_payment_red" value="Сохранить">
					</div>
				</div>
				</interfaceform>
				
				<interfaceform target="hyst/mods/online_store/proces" style="display: inline-block;">
					<input type="hidden" name="internet_magazin_id" value="<?=$item['id'];?>">
					<input confirm-yesno="Вы действительно хотите удалить оплату?" type="button" role="submit" name="internet_magazin_payment_del" value="Удалить">
				</interfaceform>
				
				
			</div>
		</div>
	<?php
	endwhile;
	?>
	</div>
	<?php
	}
	?>
<?php } ?>