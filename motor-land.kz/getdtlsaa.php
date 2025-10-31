<?php
session_start();
include("./hyst/hyst.php");
include("./hyst/functions.php");
$e = '"';
if (!empty($_POST['tex']) && hystnempnumb ($_POST['typ'])) {
	if ($_POST['typ'] == 1) { $tbnam = 'marks'; } 
	else if ($_POST['typ'] == 2) { $tbnam = 'models'; $loc = "idm='".$_POST['tex']."'"; $nm = "mode"; $t = "onchange=".$e."chanadm(this,'3');".$e; } 
	else if ($_POST['typ'] == 3) { $tbnam = 'years'; $loc = "LOCATE('[".$_POST['tex']."]', lower(idm))"; $nm = "year"; $t = ''; }
	$db = new mysqli($hystbdserver,$hystbduser,$hystbdpassword,$hystbdname);
	$db->set_charset("utf8");
	$tmp = $db->query("SELECT * FROM ".$tbnam." WHERE ".$loc." ");
	mysqli_close($db);
	if ($tmp->num_rows != 0) {
	$res['report'] = "<select name='".$nm."' ".$t."><option disabled selected>- выбрать -</option>";
	while($get=$tmp->fetch_array()):
	$res['report'] .= "<option value='".$get['id']."'>".$get['name']."</option>";
	endwhile;
	$res['report'] .= "</select>";
	}
	echo json_encode($res);
}
?>