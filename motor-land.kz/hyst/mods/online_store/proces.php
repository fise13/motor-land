<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

function get_categories ($i='noting') {
	global $_DB_CONECT;
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='".$i."' ORDER BY id ASC");
	if (mysqli_num_rows($hyst_sql) != 0) { return $hyst_sql; } else { return FALSE; }
}


function internet_magazin_getsales($id) {
	global $_DB_CONECT;
	$sql = $_DB_CONECT->query("SELECT id FROM internet_magazin_sales WHERE sst='2'");
	if (mysqli_num_rows($sql) != 0) {
		$sql =$_DB_CONECT->query("SELECT id,category,podegory FROM internet_magazin_tovari WHERE id='".$id."'");
		if (mysqli_num_rows($sql) != 0) {
		$tov = mysqli_fetch_array($sql);
			$sql = $_DB_CONECT->query("SELECT id,sale FROM internet_magazin_sales WHERE sst='2' AND rng='tov' AND LOCATE('".$tov['id']."',rngid)");
			if (mysqli_num_rows($sql) != 0) {
			$sql = mysqli_fetch_array($sql);
			$sale[$sql['id']] = $sql['sale'];
			}
			$sql = $_DB_CONECT->query("SELECT id,sale FROM internet_magazin_sales WHERE sst='2' AND rng='sub' AND LOCATE('".$tov['podegory']."',rngid)");
			if (mysqli_num_rows($sql) != 0) {
			$sql = mysqli_fetch_array($sql);
			$sale[$sql['id']] = $sql['sale'];
			}
			$sql = $_DB_CONECT->query("SELECT id,sale FROM internet_magazin_sales WHERE sst='2' AND rng='cat' AND LOCATE('".$tov['category']."',rngid)");
			if (mysqli_num_rows($sql) != 0) {
			$sql = mysqli_fetch_array($sql);
			$sale[$sql['id']] = $sql['sale'];
			}
			$sql = $_DB_CONECT->query("SELECT id,sale FROM internet_magazin_sales WHERE sst='2' AND rng='all'");
			if (mysqli_num_rows($sql) != 0) {
			$sql = mysqli_fetch_array($sql);
			$sale[$sql['id']] = $sql['sale'];
			}
			return isset($sale)?$sale:FALSE;
		} else {
		return FALSE;
		}
	} else {
	return FALSE;
	}
}

function internet_magazin_saleMath($c,$s) {
	$c = str_replace(' ', '',$c);
	$p = round($c*$s/100);
	return ($c-$p);
}

function internet_magazin_get_filtres ($c=1) {
	global $_DB_CONECT;
	$h = '<form method="get">';
	
		if ($c == 1) {
	$h .= '<label>Категория товара</label><br>
			<select name="cat"><option value="n"'.($_GET['cat']=='n'?' selected':'').'>- Нет -</option>';
			$sql = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_category WHERE idp='noting'");
			if (mysqli_num_rows($sql) != 0) {
			while($get = mysqli_fetch_array($sql)):
				$h .= '<option  value="'.$get['id'].'"'.($_GET['cat']==$get['id']?' selected':'').'>'.$get['name'].'</option>';
			endwhile;
			}
	$h.= '</select>
			<br>';
		} else {
	$h .= '<label>Категория товара</label><br>
			<label class="hyst_singlecneckboxs">Любая<input name="cat" type="radio" value="n"'.($_GET['cat']=='n'?' checked':'').'></label>';
			$sql = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_category WHERE idp='noting'");
			if (mysqli_num_rows($sql) != 0) {
			while($get = mysqli_fetch_array($sql)):
				$h .= '<label class="hyst_singlecneckboxs">'.$get['name'].'<input name="cat" type="radio" value="'.$get['id'].'"'.($_GET['cat']==$get['id']?' checked':'').'></label>';
			endwhile;
			}
	$h.= '</select>
			<br>';	
		}
		
		if ($_GET['cat']!='n' && hyst_test_id ($_GET['cat'])) {
			$sql = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_category WHERE idp='".$_GET['cat']."'");
			if (mysqli_num_rows($sql) != 0) {
		$h .= '<label>Подкатегория товара</label><br>
			<select name="pct"><option value="n"'.($_GET['pct']=='n'?' selected':'').'>- Нет -</option>';	
			while($get = mysqli_fetch_array($sql)):
			$h .= '<option  value="'.$get['id'].'"'.($_GET['pct']==$get['id']?' selected':'').'>'.$get['name'].'</option>';
			endwhile;
		$h.= '</select>
			<br>';
			}
		}
		
		if ($_GET['cat']!='n' && hyst_test_id ($_GET['cat'])) {
		
			$sql = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_atributs WHERE fltr='2'");
			if (mysqli_num_rows($sql) != 0) {
			while($get = mysqli_fetch_array($sql)):
			
		$dsql = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari WHERE category='[".$_GET['cat']."]' AND LOCATE('[".$get['id']."]',atributs) LIMIT 1");
					if (mysqli_num_rows($dsql) != 0) {
			
		$h.= '<label>'.$get['name'].'</label><br>
				<select name="ftr'.$get['id'].'">
					<option value="n"'.($_GET['ftr'.$get['id']]=='n'?' selected':'').'>- Нет -</option>';
				$sql0 = $_DB_CONECT->query("SELECT id,name FROM internet_magazin_atributs_options WHERE idp='".$get['id']."'");
				if (mysqli_num_rows($sql0) != 0) {
				while($get0 = mysqli_fetch_array($sql0)):
			$h.= '<option value="'.$get0['id'].'"'.($_GET['ftr'.$get['id']]==$get0['id']?' selected':'').'>'.$get0['name'].'</option>';
				endwhile;
				}
		$h.= '</select>
				<br>';
					}
				
			endwhile;
			}
		}
		
	$h .= '<label>Сортировка</label><br>
	<select name="orderby">
				<option value="n"'.($_GET['orderby']=='n'?' selected':'').'>- Нет -</option>
				<option value="1"'.($_GET['orderby']==1?' selected':'').'>Сначало дорогие</option>
				<option value="2"'.($_GET['orderby']==12?' selected':'').'>Сначало дешевые</option>
			</select>
	<br><input type="submit" name="sort" value="Показать">
		</form>';
	echo $h;
}

function internet_magazin_get_filtwhere () {
	global $_DB_CONECT;

	$w = '';
	if (isset($_GET['cat']) && preg_match("/^[0-9]+$/",$_GET['cat'])) {
	$w .= "LOCATE('[".$_GET['cat']."]',category)";
	}
	if (isset($_GET['pct']) && preg_match("/^[0-9]+$/",$_GET['pct'])) {
		if ($w != '') { $w .= " AND "; }
	$w .= "LOCATE('[".$_GET['pct']."]',podegory)";
	}
		$sql = $_DB_CONECT->query("SELECT id FROM internet_magazin_atributs WHERE fltr='2'");
		if (mysqli_num_rows($sql) != 0) {
		while($get = mysqli_fetch_array($sql)):
			if (isset($_GET['ftr'.$get['id']]) && preg_match("/^[0-9]+$/",$_GET['ftr'.$get['id']])) {
				if ($w != '') { $w .= " AND "; }
				$w .= "LOCATE('[".$_GET['ftr'.$get['id']]."]',atributs_opt)";
			}
		endwhile;
		}
	if (isset($_GET['orderby']) && preg_match("/^[0-9]+$/",$_GET['orderby'])) {
		if ($_GET['orderby'] == 1) {
		$w .= " ORDER BY cash DESC";
		} else {
		$w .= " ORDER BY cash ASC";
		}
	}
	return $w;
}


function internet_magazin_get_orderform () {
	global $USER;
	global $_DB_CONECT;
	$h = '<div class="hyst_sendorder_bform_block"><interfaceform target="hyst/mods/online_store/send_order">
			<div class="admin_content_widht300">
				<label>Ваше имя<i>*</i><br><iw><input class="width100" error="Содержит не корреткные символы!" type="text" name="name" check="name" length=">2" mandatory></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Email<i>*</i><br><iw><input class="width100" '.($USER['email']?'value="'.$USER['email'].'"':'').' error="Не корреткный Email!" type="text" name="email" check="email" length=">2" mandatory></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Телефон<br><iw><input class="width100" '.($USER['email']?'value="'.$USER['email'].'"':'').' error="Не корреткный телефон!" type="text" name="phone" check="none" length=">2"></iw></label>
			</div>';
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_delivery ORDER BY name ASC");
		if (mysqli_num_rows($sql) != 0) {
		$c = 0;
	$h .= '<select name="delivery" class="hyst_deliveryselector">';
		while($get=mysqli_fetch_array($sql)):
		if ($c == 0) { $cash = $get['cash']; $text = $get['text']; }
	$h .= '<option value="'.$get['id'].'" data-nadr="'.$get['nadr'].'" data-text="'.$get['text'].'" data-cash="'.$get['cash'].'">'.$get['name'].'</option>';	
		$c++;
		endwhile;
	$h .= '</select><br>
		<div class="hyst_ordebasketdeliverinf">'.($text!='noting'?$text.'<br>':'').($cash!='noting'?'<span style="hyst_delivsnnacenk">Стоимость доставки +'.$cash.' тг.</span>':'').'</div>';
		}
	$h .= '<div class="admin_content_widht300">
				<label>Ваш Город<i>*</i><br><iw><input class="width100" error="Содержит недопустимые символы!" type="text" name="city" check="title" length=">2" mandatory></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Адрес доставки<i>*</i><br><iw><input class="width100" error="Содержит недопустимые символы!" type="text" name="address" check="title" length=">2" mandatory></iw></label>
			</div>
			<div class="admin_content_widht300">
				<label>Адрес доставки<br><iw><textarea name="comment" placeholder="Коментарий (не обязательно)"></textarea>
			</div>

		<input type="button" role="submit" name="internet_magazin_sendorder" value="Оформить заказ"><br>
		</interfaceform></div>';
	echo $h;
}

function internet_magazin_get_orderstopost ($id) {
	global $_DB_CONECT;
	$ordrsbody = '';
	$fororder = '';
	$allcash = 0;
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_basket WHERE idp='".$id."' ORDER BY id DESC");
	while($get=mysqli_fetch_array($sql)):
	$fororder .= '['.$get['idt'].'-'.$get['num'].']';
		$sql0 = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari WHERE id='".$get['idt']."'");
		if (mysqli_num_rows($sql0) != 0) {
		$get0=mysqli_fetch_array($sql0);
		$cash = $get0['cash'];
		
		
		$sls = internet_magazin_getsales($get0['id']);
		if ($sls != FALSE) { 
		arsort($sls);
		
		} else {
		$sls = 'noting';
		}
		
		
		$cash = str_replace(' ', '',($sls=='noting'?$get0['cash']:internet_magazin_saleMath($get0['cash'],current($sls))));
		
		$attrs = '';
			if ($get['attributs'] != 'noting') {
			$atrsp = explode('][',$get['attributs']);
				$wher = '';
				foreach ($atrsp as $vao) {
					$aio = str_ireplace("]", "", $vao);
					$aio = str_ireplace("[", "", $aio);
					if ($wher == '') {
					$wher = "id='".$aio."'";
					} else {
					$wher .= " OR id='".$aio."'";
					}
				}
			}
			$atrs = explode('][',$gett['atributs']);
				foreach ($atrs as $va) {
					$ai = str_ireplace("]", "", $va);
					$ai = str_ireplace("[", "", $ai);
					$tmpa = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs WHERE id='".$ai."'");
					if (mysqli_num_rows($tmpa) != 0) {
					$geta = mysqli_fetch_array($tmpa);
			$attrs .= '<b>'.$geta['name'].': </b>';
						if ($get['attributs'] != 'noting') {    
							$tmpb = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_options WHERE idp='".$ai."' AND (".$wher.")");
							while($getb = mysqli_fetch_array($tmpb)):
			$attrs .= $getb['name'].';';
								if ($getb['cash'] != 'noting') {
								$cash+=$getb['cash'];
								}
							endwhile;
						} else {
			$attrs .= '-';
						}
			$attrs .= '<br>';
					}
				}
			
	$ordrsbody .= "<table border='0'>
		<tr>
		<td width='110' align='left'><img src='".SITE_URL."/".str_ireplace("[", "", str_ireplace("]", "", explode('][',$get0['images'])[0]))."' width='100'></td>
		<td width='200' align='left'><h3>".$get0['name']." (".$get0['arti'].")</h3><br>".$attrs."
		</td>
		<td width='190' align='center'> Стоимость:<br>
		<span style='font-size: 16px; position: relative;'><span>".$cash." Тенге * ".$get['num']." шт.</span>
		</td>
		<td><span style='font-size: 17px; color: red;'>".($cash*$get['num'])." тг.</span></td>
		</tr>
		</table><hr width='800'><br>";
		
	$allcash += $cash*$get['num'];
		} else {
	$ordrsbody .= "<table border='0'>
		<tr>
		<td width='110' align='left'>Товар</td>
		<td width='200' align='left'>не найден в 
		</td>
		<td width='190' align='center'>базе данных
		</td>
		<td>сайта</td>
		</tr>
		</table><hr width='800'><br>";	
		}
	endwhile;
	$res['cash'] = $allcash;
	$res['text'] = $ordrsbody;
	$res['fororder'] = $fororder;
	return $res;
}

if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('online_store',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_category'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_category
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			url VARCHAR(255) NOT NULL DEFAULT 'noting',
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			image VARCHAR(255) NOT NULL DEFAULT 'noting',
			baner VARCHAR(255) NOT NULL DEFAULT 'noting',
			text LONGTEXT NOT NULL,
			prio INT(9) NOT NULL DEFAULT '1',
			idp VARCHAR(255) NOT NULL DEFAULT 'noting'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_atributs_group'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_atributs_group
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			aname VARCHAR(255) NOT NULL DEFAULT 'noting'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_atributs'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_atributs
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			idg INT(9) NOT NULL DEFAULT '0',
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			aname VARCHAR(255) NOT NULL DEFAULT 'noting',
			category TEXT NOT NULL,
			podegory TEXT NOT NULL,
			mult INT(9) NOT NULL DEFAULT '1',
			fltr INT(9) NOT NULL DEFAULT '1'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_atributs_options'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_atributs_options
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			idp INT(9) NOT NULL,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			image VARCHAR(255) NOT NULL DEFAULT 'noting',
			color VARCHAR(255) NOT NULL DEFAULT 'noting',
			cash VARCHAR(255) NOT NULL DEFAULT 'noting'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_tovari'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_tovari
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			url VARCHAR(255) NOT NULL DEFAULT 'noting',
			category TEXT NOT NULL,
			podegory TEXT NOT NULL,
			text LONGTEXT NOT NULL,
			stext TEXT NOT NULL,
			tmeta TEXT NOT NULL,
			atributs TEXT NOT NULL,
			atributs_opt TEXT NOT NULL,
			images TEXT NOT NULL,
			harakter TEXT NOT NULL,
			cash INT(9) NOT NULL,
			arti VARCHAR(255) NOT NULL DEFAULT 'noting',
			sopo VARCHAR(255) NOT NULL DEFAULT 'noting',
			sale VARCHAR(255) NOT NULL DEFAULT 'noting',
			spek INT(9) NOT NULL DEFAULT '1',
			instock INT(9) NOT NULL DEFAULT '1',
			prio INT(9) NOT NULL DEFAULT '1'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_sales'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_sales
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			rng VARCHAR(255) NOT NULL,
			rngid VARCHAR(255) NOT NULL DEFAULT 'noting',
			name VARCHAR(255) NOT NULL,
			sale VARCHAR(255) NOT NULL,
			image VARCHAR(255) NOT NULL DEFAULT 'noting',
			text LONGTEXT NOT NULL,
			stext TEXT NOT NULL,
			sst INT(9) NOT NULL DEFAULT '1'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_payments'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_payments
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL,
			aname VARCHAR(255) NOT NULL,
			scrname VARCHAR(255) NOT NULL DEFAULT 'noting'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_delivery'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_delivery
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL,
			cash VARCHAR(255) NOT NULL DEFAULT 'noting',
			text LONGTEXT NOT NULL,
			nadr INT(9) NOT NULL DEFAULT '1'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_orders'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_orders
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			idp VARCHAR(255) NOT NULL,
			name VARCHAR(255) NOT NULL,
			email VARCHAR(255) NOT NULL,
			phone VARCHAR(255) NOT NULL,
			city VARCHAR(255) NOT NULL,
			address VARCHAR(255) NOT NULL,
			delivery VARCHAR(255) NOT NULL,
			payment VARCHAR(255) NOT NULL,
			comment TEXT NOT NULL,
			date VARCHAR(255) NOT NULL,
			orderittems LONGTEXT NOT NULL,
			sst INT(9) NOT NULL DEFAULT '1',
			psst INT(9) NOT NULL DEFAULT '1'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'internet_magazin_basket'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE internet_magazin_basket
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			idt VARCHAR(255) NOT NULL DEFAULT 'noting',
			idp VARCHAR(255) NOT NULL DEFAULT 'noting',
			attributs TEXT NOT NULL,
			num TEXT NOT NULL
		)");
	}
	
	//Категории ------------------------------------------------------------------------------------
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_category_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else { 
		
		if (hyst_test_id($_POST['internet_magazin_idparent'])) { $idp = $_POST['internet_magazin_idparent']; } else { $idp = 'noting'; }
		if (!empty($_POST['internet_magazin_image'])) { $img = $_POST['internet_magazin_image']; } else { $img = 'noting'; }
		if (!empty($_POST['internet_magazin_baner'])) { $baner = $_POST['internet_magazin_baner']; } else { $baner = 'noting'; }
		if (!empty($_POST['internet_magazin_prio'])) { $prio = $_POST['internet_magazin_prio']; } else { $prio = 1; }
			
			$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_category WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."'");
			if (mysqli_num_rows($check) == 0) {
				$url = hyst_translit_url(trim($_POST['internet_magazin_name']));
			} else {
				$c = 0;
				do {
					$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_category WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."_".$c."'");
					$url = hyst_translit_url(trim($_POST['internet_magazin_name'])).'_'.$c;
					$c++;
					
				} while (mysqli_num_rows($check) != 0);
			}
		
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_category (name,url,image,baner,text,prio,idp) 
			VALUES ('".$_POST['internet_magazin_name']."','".$url."','".$img."','".$baner."','".$_POST['internet_magazin_text']."','".$prio."','".$idp."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Категория добавлена';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_category_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (hyst_test_id($_POST['internet_magazin_idparent'])) { $idp = $_POST['internet_magazin_idparent']; } else { $idp = 'noting'; }
		if (!empty($_POST['internet_magazin_image'])) { $img = $_POST['internet_magazin_image']; } else { $img = 'noting'; }
		if (!empty($_POST['internet_magazin_baner'])) { $baner = $_POST['internet_magazin_baner']; } else { $baner = 'noting'; }
		if (!empty($_POST['internet_magazin_prio'])) { $prio = $_POST['internet_magazin_prio']; } else { $prio = 1; }
			
			$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_category WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."' AND id!='".$_REQUEST['internet_magazin_id']."'");
			if (mysqli_num_rows($check) == 0) {
				$url = hyst_translit_url(trim($_POST['internet_magazin_name']));
			} else {
				$c = 0;
				do {
					$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_category WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."_".$c."' AND id!='".$_REQUEST['internet_magazin_id']."'");
					$url = hyst_translit_url(trim($_POST['internet_magazin_name'])).'_'.$c;
					$c++;
					
				} while (mysqli_num_rows($check) != 0);
			}
			
			
			$reset = $_DB_CONECT->query("SELECT idp FROM internet_magazin_category WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if (mysqli_num_rows($reset) != 0) {
				$reset=$reset->fetch_array();
				if ($reset['idp'] == $_POST['internet_magazin_idparent']) {
				$reset = false;
				} else {
				$reset = true;
				}
			} else {
			$reset = false;
			}
		
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_category  SET name='".$_POST['internet_magazin_name']."',url='".$url."',image='".$img."',
			baner='".$baner."',text='".$_POST['internet_magazin_text']."',prio='".$prio."',idp='".$idp."' WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = $reset?1:3;
			$report['message'] = 'Изменения сохранены';
			$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['internet_magazin_id']=>$_REQUEST['internet_magazin_name'].' ['.$url.']');
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_category_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_category WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_category SET idp='noting' WHERE idp='".$_REQUEST['internet_magazin_id']."'");
			$reset = $_DB_CONECT->affected_rows;
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = $reset==0?3:1;
			$report['message'] = 'Категория удалена!';
			$report['delete_item'] = '.deleted_item'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	//Категории ------------------------------------------------------------------------------------
	//Атрибуты -------------------------------------------------------------------------------------
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_gr_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else { 
		
		if (!empty($_POST['internet_magazin_aname'])) { $aname  = $_POST['internet_magazin_aname']; } else { $aname = 'noting'; }
		
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_atributs_group (name,aname) 
			VALUES ('".$_POST['internet_magazin_name']."','".$aname."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Группа добавлена';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_gr_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (!empty($_POST['internet_magazin_aname'])) { $aname  = $_POST['internet_magazin_aname']; } else { $aname = 'noting'; }
		
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_atributs_group SET name='".$_POST['internet_magazin_name']."',aname='".$aname."' 
			WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Даннные обновлены';
			$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['internet_magazin_id']=>$_REQUEST['internet_magazin_name'].''.($aname!='noting'?' ['.$aname.']':'').'');
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_gr_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_atributs_group WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_atributs SET idg='0' WHERE idg='".$_REQUEST['internet_magazin_id']."'");
			$reset = $_DB_CONECT->affected_rows;
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = $reset==0?3:1;
			$report['message'] = 'Категория удалена!';
			$report['delete_item'] = '.deleted_item_group'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else { 
		
		if (!empty($_POST['internet_magazin_aname'])) { $aname  = $_POST['internet_magazin_aname']; } else { $aname = 'noting'; }
		if (hyst_test_id ($_POST['internet_magazin_idg'])) { $idg = $_POST['internet_magazin_idg']; } else { $idg = 0; }
		if (!empty($_POST['internet_magazin_multi'])) { $muli = 2; } else { $muli = 1; }
		if (!empty($_POST['internet_magazin_filtr'])) { $fltr  = 2; } else { $fltr = 1; }
		if (!empty($_POST['categorys'])) {
		$category = ''; foreach (explode(',',$_POST['categorys']) as $v) { $category .= '['.$v.']'; }
		} else { $category = 'noting'; }
		if (!empty($_POST['podcategorys'])) {
		$podegory = ''; foreach (explode(',',$_POST['podcategorys']) as $v) { $podegory .= '['.$v.']'; }
		} else { $podegory = 'noting'; }
			$sql = $_DB_CONECT->query("INSERT internet_magazin_atributs (idg,name,aname,category,podegory,mult,fltr) VALUES 
			('".$idg."','".$_POST['internet_magazin_name']."','".$aname."','".$category."','".$podegory."','".$muli."','".$fltr."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Атрибут добавлен';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (!empty($_POST['internet_magazin_aname'])) { $aname  = $_POST['internet_magazin_aname']; } else { $aname = 'noting'; }
		if (hyst_test_id ($_POST['internet_magazin_idg'])) { $idg = $_POST['internet_magazin_idg']; } else { $idg = 0; }
		if (!empty($_POST['internet_magazin_multi'])) { $muli = 2; } else { $muli = 1; }
		if (!empty($_POST['internet_magazin_filtr'])) { $fltr  = 2; } else { $fltr = 1; }
		if (!empty($_POST['categorys'])) {
		$category = ''; foreach (explode(',',$_POST['categorys']) as $v) { $category .= '['.$v.']'; }
		} else { $category = 'noting'; }
		if (!empty($_POST['podcategorys'])) {
		$podegory = ''; foreach (explode(',',$_POST['podcategorys']) as $v) { $podegory .= '['.$v.']'; }
		} else { $podegory = 'noting'; }
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_atributs SET idg='".$idg."',name='".$_POST['internet_magazin_name']."',aname='".$aname."',
			category='".$category."',podegory='".$podegory."',mult='".$muli."',fltr='".$fltr."' WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Даннные обновлены';
			$report['visual_changes'] = array ('#visual_ch_slideroler_atribut'.$_REQUEST['internet_magazin_id']=>$_REQUEST['internet_magazin_name'].''.($aname!='noting'?' ['.$aname.']':'').'');
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_atributs WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_atributs_options WHERE idp='".$_REQUEST['internet_magazin_id']."'");
			$reset = $_DB_CONECT->affected_rows;
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = $reset==0?3:1;
			$report['message'] = 'Атрибут удален!';
			$report['delete_item'] = '.deleted_item_atribut'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_options_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_idp'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (!empty($_POST['internet_magazin_cash'])) { $cash = $_POST['internet_magazin_cash']; } else { $cash = 'noting'; }
		if (!empty($_POST['internet_magazin_color_chk'])) { $color = $_POST['internet_magazin_color']; } else { $color = 'noting'; }
		if (!empty($_POST['internet_magazin_image'])) { $image = $_POST['internet_magazin_image']; } else { $image = 'noting'; }
	
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_atributs_options (idp,name,image,color,cash) 
			VALUES ('".$_POST['internet_magazin_idp']."','".$_POST['internet_magazin_name']."','".$image."','".$color."','".$cash."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Атрибут добавлен';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_options_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (!empty($_POST['internet_magazin_cash'])) { $cash = $_POST['internet_magazin_cash']; } else { $cash = 'noting'; }
		if (!empty($_POST['internet_magazin_color_chk'])) { $color = $_POST['internet_magazin_color']; } else { $color = 'noting'; }
		if (!empty($_POST['internet_magazin_image'])) { $image = $_POST['internet_magazin_image']; } else { $image = 'noting'; }
	
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_atributs_options SET name='".$_POST['internet_magazin_name']."',image='".$image."',
			color='".$color."',cash='".$cash."' WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Данные обновлены';
			$report['visual_changes'] = array ('#visual_ch_slideroler_atribut_val'.$_REQUEST['internet_magazin_id']=>$_REQUEST['internet_magazin_name']);
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_atributs_options_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_atributs_options WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Значение удалено!';
			$report['delete_item'] = '.deleted_item_atributitem_value'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	//Атрибуты -------------------------------------------------------------------------------------
	//Товары ---------------------------------------------------------------------------------------
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_tovar_add') { 
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['internet_magazin_cash'],REGEXP_INT)) {
		$report['error'] = 2;
		$report['message'] = 'Стоимость должны быть целым числом!';
		} else {
			if (!empty($_POST['internet_magazin_sale'])) { $sale = $_POST['internet_magazin_sale']; } else { $sale = 'noting'; }
			if (!empty($_POST['internet_magazin_arti'])) { $arti = $_POST['internet_magazin_arti']; } else { $arti = 'noting'; }
			if (!empty($_POST['categorys'])) {
			$category = ''; foreach (explode(',',$_POST['categorys']) as $v) { $category .= '['.$v.']'; }
			} else { $category = 'noting'; }
			if (!empty($_POST['podcategorys'])) {
			$podegory = ''; foreach (explode(',',$_POST['podcategorys']) as $v) { $podegory .= '['.$v.']'; }
			} else { $podegory = 'noting'; }
			if (!empty($_POST['images'])) { 
			$img = explode(',',$_POST['images']);
				foreach($img as $i) {
				$images .= '['.$i.']'; 
				}
			} else { $images = 'noting'; }
			
			$harakteristic = json_decode($_POST['harakteristik'],1); 			if (count($harakteristic) != 0) {
				$harakter = '';
				foreach($harakteristic as $v) {
					$harakter .= ($harakter==''?'':'|').$v['parametr_name'].'^'.$v['parametr_val'];
				}
			} else {
			$harakter = 'noting';
			}
			
			if (!empty($_POST['atributs'])) {
			$atributs = ''; foreach (explode(',',$_POST['atributs']) as $v) { $atributs .= '['.$v.']'; }
			} else { $atributs = 'noting'; }
			if (!empty($_POST['atribut_option'])) {
			$atributs_opt = ''; foreach (explode(',',$_POST['atribut_option']) as $v) { $atributs_opt .= '['.$v.']'; }
			} else { $atributs_opt = 'noting'; }
			
			if (!empty($_POST['internet_magazin_text'])) { $text = $_POST['internet_magazin_text']; } else { $text = 'noting'; }
			if (!empty($_POST['internet_magazin_stext'])) { $stext = $_POST['internet_magazin_stext']; } else { $stext = 'noting'; }
			if (!empty($_POST['internet_magazin_tmeta'])) { $tmeta = $_POST['internet_magazin_tmeta']; } else { $tmeta = 'noting'; }
			if (!empty($_POST['internet_magazin_sopo'])) { $sopo = $_POST['internet_magazin_sopo']; } else { $sopo = 'noting'; }
			if (!empty($_POST['internet_magazin_prio'])) { $prio = $_POST['internet_magazin_prio']; } else { $prio = 1; }
			if (!empty($_POST['internet_magazin_spek'])) { $spek = 2; } else { $spek = 1; }
			
			$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."' AND id!='".$_POST['internet_magazin_id']."'");
			if (mysqli_num_rows($check) == 0) {
				$url = hyst_translit_url(trim($_POST['internet_magazin_name']));
			} else {
				$c = 0;
				do {
					$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."_".$c."'");
					$url = hyst_translit_url(trim($_POST['internet_magazin_name'])).'_'.$c;
					$c++;
				} while (mysqli_num_rows($check) != 0);
			}
			
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_tovari (name,url,category,podegory,text,stext,atributs,atributs_opt,images,harakter,cash,sale,arti,sopo,spek,instock,tmeta,prio) VALUES 
			('".$_POST['internet_magazin_name']."','".$url."','".$category."','".$podegory."','".$text."','".$stext."','".$atributs."','".$atributs_opt."','".$images."','".$harakter."','".$_POST['internet_magazin_cash']."','".$sale."','".$arti."','".$sopo."','".$spek."','".$_POST['internet_magazin_instock']."','".$tmeta."','".$prio."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Товар добавлен';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_tovar_red') { 
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['internet_magazin_cash'],REGEXP_INT)) {
		$report['error'] = 2;
		$report['message'] = 'Стоимость должны быть целым числом!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else {
			if (!empty($_POST['internet_magazin_sale'])) { $sale = $_POST['internet_magazin_sale']; } else { $sale = 'noting'; }
			if (!empty($_POST['internet_magazin_arti'])) { $arti = $_POST['internet_magazin_arti']; } else { $arti = 'noting'; }
			if (!empty($_POST['categorys'])) {
			$category = ''; foreach (explode(',',$_POST['categorys']) as $v) { $category .= '['.$v.']'; }
			} else { $category = 'noting'; }
			if (!empty($_POST['podcategorys'])) {
			$podegory = ''; foreach (explode(',',$_POST['podcategorys']) as $v) { $podegory .= '['.$v.']'; }
			} else { $podegory = 'noting'; }
			if (!empty($_POST['images'])) { 
			$img = explode(',',$_POST['images']);
				foreach($img as $i) {
				$images .= '['.$i.']'; 
				}
			} else { $images = 'noting'; }
			
			$harakteristic = json_decode($_POST['harakteristik'],1); 			if (count($harakteristic) != 0) {
				$harakter = '';
				foreach($harakteristic as $v) {
					$harakter .= ($harakter==''?'':'|').$v['parametr_name'].'^'.$v['parametr_val'];
				}
			} else {
			$harakter = 'noting';
			}
			
			if (!empty($_POST['atributs'])) {
			$atributs = ''; foreach (explode(',',$_POST['atributs']) as $v) { $atributs .= '['.$v.']'; }
			} else { $atributs = 'noting'; }
			if (!empty($_POST['atribut_option'])) {
			$atributs_opt = ''; foreach (explode(',',$_POST['atribut_option']) as $v) { $atributs_opt .= '['.$v.']'; }
			} else { $atributs_opt = 'noting'; }
			
			if (!empty($_POST['internet_magazin_text'])) { $text = $_POST['internet_magazin_text']; } else { $text = 'noting'; }
			if (!empty($_POST['internet_magazin_stext'])) { $stext = $_POST['internet_magazin_stext']; } else { $stext = 'noting'; }
			if (!empty($_POST['internet_magazin_tmeta'])) { $tmeta = $_POST['internet_magazin_tmeta']; } else { $tmeta = 'noting'; }
			if (!empty($_POST['internet_magazin_sopo'])) { $sopo = $_POST['internet_magazin_sopo']; } else { $sopo = 'noting'; }
			if (!empty($_POST['internet_magazin_prio'])) { $prio = $_POST['internet_magazin_prio']; } else { $prio = 1; }
			if (!empty($_POST['internet_magazin_spek'])) { $spek = 2; } else { $spek = 1; }
			
			$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."' AND id!='".$_POST['internet_magazin_id']."'");
			if (mysqli_num_rows($check) == 0) {
				$url = hyst_translit_url(trim($_POST['internet_magazin_name']));
			} else {
				$c = 0;
				do {
					$check = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari WHERE url='".hyst_translit_url(trim($_POST['internet_magazin_name']))."_".$c."'");
					$url = hyst_translit_url(trim($_POST['internet_magazin_name'])).'_'.$c;
					$c++;
				} while (mysqli_num_rows($check) != 0);
			}
			
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_tovari SET name='".$_POST['internet_magazin_name']."',url='".$url."',category='".$category."',
			podegory='".$podegory."',text='".$text."',stext='".$stext."',atributs='".$atributs."',atributs_opt='".$atributs_opt."',images='".$images."',harakter='".$harakter."',
			cash='".$_POST['internet_magazin_cash']."',sale='".$sale."',arti='".$arti."',sopo='".$sopo."',spek='".$spek."',instock='".$_POST['internet_magazin_instock']."',
			tmeta='".$tmeta."',prio='".$prio."' WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Товар добавлен';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_tovari_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_tovari WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Товар удален!';
			$report['delete_item'] = '.deleted_item'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	//Товары ---------------------------------------------------------------------------------------
	//Акции ----------------------------------------------------------------------------------------
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_sales_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['internet_magazin_sale'],REGEXP_INT)) {
		$report['error'] = 2;
		$report['message'] = 'Скидка должна быть целым числом!';
		} else { 
		
		if ($_POST['internet_magazin_rng'] == 'cat') {
		$rngid = '['.$_POST['internet_magazin_cat'].']';
		} else if ($_POST['internet_magazin_rng'] == 'sub') {
		$rngid = '['.$_POST['internet_magazin_sub'].']';
		} else if ($_POST['internet_magazin_rng'] == 'tov') {
		$rngid = '['.$_POST['internet_magazin_tovarid'].']';
		} else if ($_POST['internet_magazin_rng'] == 'cas') {
		$rngid = $_POST['sval'];
		} else {
		$rngid = 'all';
		}
		if (!empty($_POST['internet_magazin_text'])) { $text = $_POST['internet_magazin_text']; } else { $text = 'noting'; }
		if (!empty($_POST['internet_magazin_stext'])) { $stext = $_POST['internet_magazin_stext']; } else { $stext = 'noting'; }
		if (!empty($_POST['internet_magazin_sst'])) { $sst = 2; } else { $sst = 1; }
	
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_sales (rng,rngid,name,sale,image,text,stext,sst) 
			VALUES ('".$_POST['internet_magazin_rng']."','".$rngid."','".$_POST['internet_magazin_name']."','".$_POST['internet_magazin_sale']."','".$_POST['internet_magazin_image']."','".$text."','".$stext."','".$sst."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Акция добавлена';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_sales_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['internet_magazin_sale'],REGEXP_INT)) {
		$report['error'] = 2;
		$report['message'] = 'Скидка должна быть целым числом!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if ($_POST['internet_magazin_rng'] == 'cat') {
		$rngid = '['.$_POST['internet_magazin_cat'].']';
		} else if ($_POST['internet_magazin_rng'] == 'sub') {
		$rngid = '['.$_POST['internet_magazin_sub'].']';
		} else if ($_POST['internet_magazin_rng'] == 'tov') {
		$rngid = '['.$_POST['internet_magazin_tovarid'].']';
		} else if ($_POST['internet_magazin_rng'] == 'cas') {
		$rngid = $_POST['sval'];
		} else {
		$rngid = 'all';
		}
		if (!empty($_POST['internet_magazin_text'])) { $text = $_POST['internet_magazin_text']; } else { $text = 'noting'; }
		if (!empty($_POST['internet_magazin_stext'])) { $stext = $_POST['internet_magazin_stext']; } else { $stext = 'noting'; }
		if (!empty($_POST['internet_magazin_sst'])) { $sst = 2; } else { $sst = 1; }
	
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_sales SET rng='".$_POST['internet_magazin_rng']."',rngid='".$rngid."',
			name='".$_POST['internet_magazin_name']."',sale='".$_POST['internet_magazin_sale']."',image='".$_POST['internet_magazin_image']."',
			text='".$text."',stext='".$stext."',sst='".$sst."' WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Акция изменена';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_sales_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_sales WHERE id='".$_REQUEST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Товар удален!';
			$report['delete_item'] = '.deleted_item'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_sales_act') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_sales SET sst='".($_POST['internet_magazin_sst']==2?1:2)."' WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Удалено!';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	//Акции ----------------------------------------------------------------------------------------
	//Доставка и оплата ----------------------------------------------------------------------------
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_delivery_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else { 
		
		if (!empty($_POST['internet_magazin_text'])) { $text = $_POST['internet_magazin_text']; } else { $text = 'noting'; }
		if (!empty($_POST['internet_magazin_cash'])) { $cash = $_POST['internet_magazin_cash']; } else { $cash = 'noting'; }
		if (!empty($_POST['internet_magazin_nadr'])) { $nadr = 2; } else { $nadr = 1; }
	
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_delivery (name,cash,text,nadr) VALUES ('".$_POST['internet_magazin_name']."','".$cash."','".$text."','".$nadr."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Доставка добавлена';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_delivery_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (!empty($_POST['internet_magazin_text'])) { $text = $_POST['internet_magazin_text']; } else { $text = 'noting'; }
		if (!empty($_POST['internet_magazin_cash'])) { $cash = $_POST['internet_magazin_cash']; } else { $cash = 'noting'; }
		if (!empty($_POST['internet_magazin_nadr'])) { $nadr = 2; } else { $nadr = 1; }
	
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_delivery SET name='".$_POST['internet_magazin_name']."',cash='".$cash."',text='".$text."',nadr='".$nadr."' 
			WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'СОхранено';
			$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['internet_magazin_id']=>$_REQUEST['internet_magazin_name']);
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_delivery_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_delivery WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$report['error'] = 3;
			$report['message'] = 'Удалено!';
			$report['delete_item'] = '.deleted_item'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_payment_add') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else { 
		
		if (!empty($_POST['internet_magazin_aname'])) { $aname = $_POST['internet_magazin_aname']; } else { $aname = 'noting'; }
		if (!empty($_POST['internet_magazin_scrurl'])) { $scrurl = $_POST['internet_magazin_scrurl']; } else { $scrurl = 'noting'; }
	
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_payments (name,aname,scrname) 
			VALUES ('".$_POST['internet_magazin_name']."','".$aname."','".$scrurl."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Оплата добавлена';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_payment_red') {
		if (!hyst_test_val($_REQUEST['internet_magazin_name'],REGEXP_TITLE)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
		
		if (!empty($_POST['internet_magazin_aname'])) { $aname = $_POST['internet_magazin_aname']; } else { $aname = 'noting'; }
		if (!empty($_POST['internet_magazin_scrurl'])) { $scrurl = $_POST['internet_magazin_scrurl']; } else { $scrurl = 'noting'; }
	
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_payments SET name='".$_POST['internet_magazin_name']."',aname='".$_POST['internet_magazin_aname']."',scrname='".$scrurl."' 
			WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Сохранено';
			$report['visual_changes'] = array ('#visual_ch_slideroler_paym'.$_REQUEST['internet_magazin_id']=>$_REQUEST['internet_magazin_name']);
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_payment_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_payments WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$report['error'] = 3;
			$report['message'] = 'Удалено!';
			$report['delete_item'] = '.deleted_item_paym'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	//Доставка и оплата ----------------------------------------------------------------------------
	//Заказы ---------------------------------------------------------------------------------------
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_order_del') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_orders WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$report['error'] = 3;
			$report['message'] = 'Удалено!';
			$report['delete_item'] = '.deleted_item'.$_REQUEST['internet_magazin_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'internet_magazin_order_change') { 
		if (!hyst_test_id($_REQUEST['internet_magazin_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else if (!hyst_test_id($_REQUEST['sst'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("UPDATE internet_magazin_orders SET sst='".$_REQUEST['sst']."' WHERE id='".$_POST['internet_magazin_id']."'");
			if ($sql != false) {
			$report['error'] = 3;
			$report['message'] = 'Обновлено!';
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	//Заказы ---------------------------------------------------------------------------------------


}
?>