<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');


if (hyst_test_id($_POST['nu']) && hyst_test_id($_POST['idt']) && (hyst_test_id ($_POST['idu']) || preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/",$_POST['idu']))) {

$hyst_sql = $_DB_CONECT->query("SELECT id FROM internet_magazin_tovari WHERE id='".$_POST['idt']."'");
if (mysqli_num_rows($hyst_sql) != 0) {

	$hyst_sql0 = $_DB_CONECT->query("SELECT id FROM internet_magazin_basket WHERE idt='".$_POST['idt']."' AND idp='".$_POST['idu']."'");
	if (mysqli_num_rows($hyst_sql0) == 0) {
		$hyst_sql = $_DB_CONECT->query("INSERT INTO internet_magazin_basket (idp,idt,attributs,num) VALUES ('".$_POST['idu']."','".$_POST['idt']."','".$_POST['ar']."','".$_POST['nu']."')");	
	} else {
		$get0 = mysqli_fetch_array($hyst_sql0);
		$hyst_sql = $_DB_CONECT->query("UPDATE internet_magazin_basket SET num = num+'1' WHERE id = '".$get0['id']."'");
	}
		if ($hyst_sql != FALSE) {
	$hyst_sql = $_DB_CONECT->query("SELECT id FROM internet_magazin_basket WHERE idp='".$_POST['idu']."'");
echo mysqli_num_rows($hyst_sql);
		}
	}
}
?>