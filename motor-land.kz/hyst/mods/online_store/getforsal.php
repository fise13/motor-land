<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

$hystquotes = '"';
if ($_POST['typ'] == 'cat') {
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY name DESC");
	if (mysqli_num_rows($hyst_sql) != 0) {
	$htm = '<select name="internet_magazin_cat">';
	while($get_sql = mysqli_fetch_array($hyst_sql)):
	$htm .= '<option value="'.$get_sql['id'].'">'.$get_sql['name'].'</option>';
	endwhile;
	$htm .= '</select>';
	echo $htm;
	}
} else if ($_POST['typ'] == 'sub') {
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp!='noting' ORDER BY name DESC");
	if (mysqli_num_rows($hyst_sql) != 0) {
	$htm = '<select name="internet_magazin_sub">';
	while($get_sql = mysqli_fetch_array($hyst_sql)):
	$htm .= '<option value="'.$get_sql['id'].'">'.$get_sql['name'].'</option>';
	endwhile;
	$htm .= '</select>';
	echo $htm;
	}
} else if ($_POST['typ'] == 'tov') {
	echo '<div class="hyst_psevdodatalistsel"><input type="hidden" name="internet_magazin_tovarid" val="noting"><input type="text" name="sval" oninput="hyst_getajxsalesrngtov(this);" placeholder="Введите название товара"></div>';
}  else if ($_POST['typ'] == 'cas') {
	echo "<div class='hyst_psevdodatalistsel'><input type='text' name='sval' oninput=".$hystquotes."this.value = this.value.replace(/\D/g, '')".$hystquotes." placeholder='Введите порог цены для скидки'></div>";
} else if ($_POST['typ'] == 'tova') {
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari WHERE LOCATE(LOWER('".$_POST['nam']."'),LOWER(name)) ORDER BY name DESC");
	if (mysqli_num_rows($hyst_sql) != 0) {
	$htm = '<div>';
	while($get_sql = mysqli_fetch_array($hyst_sql)):
	$htm .= '<div data-id="'.$get_sql['id'].'" class="os_sales_tover_pick" onclick="hyst_getajxsalesrngtovar(this);">'.$get_sql['name'].'</div>';
	endwhile;
	$htm .= '</div>';
	echo $htm;
	}
}
?>