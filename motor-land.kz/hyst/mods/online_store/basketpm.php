<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');


$id = $_POST['id'];
$idp = $_POST['idp'];

if (hyst_test_id ($id) && (hyst_test_id ($idp) || preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/",$idp))) {


$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_basket WHERE id='".$id."'");
	if (mysqli_num_rows($hyst_sql) != 0) {
	$gett = mysqli_fetch_array($hyst_sql);
		
	if ($_POST['t'] == 'p') { $num = $gett['num'] + 1; } else { if ($gett['num'] != 1) { $num = $gett['num'] - 1; } else { $num = 1; } }

	$hyst_sql = $_DB_CONECT->query("UPDATE internet_magazin_basket SET num='".$num."' WHERE id='".$id."'");
	

	$all = 0;

$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_basket WHERE idp='".$idp."'");
while($get=mysqli_fetch_array($hyst_sql)):
	$tmpto = $_DB_CONECT->query("SELECT id,cash FROM internet_magazin_tovari WHERE id='".$get['idt']."'");
	$getto =  mysqli_fetch_array($tmpto);
	
	$cash =  $getto['cash'];
	
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
					
						if ($get['attributs'] != 'noting') {    
							$tmpb = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_options WHERE idp='".$ai."' AND (".$wher.")");
							while($getb = mysqli_fetch_array($tmpb)):
							echo $getb['name'].';';
								if ($getb['cash'] != 'noting') {
								$cash+=$getb['cash'];
								}
							endwhile;
						}
					
					}
				}
	if ($get['id'] == $id) { $cas = $cash*$get['num']; }
	$all = $all + $cash*$get['num'];
		
endwhile;

$res['par1'] = $num;
$res['par2'] = $all;
$res['par3'] = $cas;

echo json_encode($res);

	}
}
?>