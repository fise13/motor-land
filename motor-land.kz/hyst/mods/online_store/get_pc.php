<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');


if ($_POST['comand'] == 'adm_get_pc') {
	if (hyst_test_id ($_POST['id'])) {
		$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='".$_POST['id']."' ORDER BY id DESC");
		$result['podcategory'] = [];
		if (mysqli_num_rows($hyst_sql) != 0) {
		while($get_sql = mysqli_fetch_array($hyst_sql)):
		$current['id'] = $get_sql['id'];
		$current['name'] = $get_sql['name'];
		$result['podcategory'][] = $current;
		endwhile;
		}
		
		unset($current);
		
		if (isset($_POST['own'])) {
			
			$ids = json_decode($_POST['own'],1);
			$lc = '';
			foreach ($ids as $v) {
				if ($lc == '') {
				$lc .=  "LOCATE(LOWER('[".$v."]'),LOWER(category))";
				} else {
				$lc .=  " OR LOCATE(LOWER('[".$v."]'),LOWER(category))";
				}
			}
			
			if ($lc != '') {
				$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs WHERE ".$lc." ORDER BY id DESC");
				if (mysqli_num_rows($hyst_sql) != 0) {
					
			$result['atributs'] = [];		
					
				while($get_sql = mysqli_fetch_array($hyst_sql)):
				
				$current['id'] = $get_sql['id'];
				$current['name'] = $get_sql['name'];
				$current['values'] = [];
						$hyst_sql0 = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_options WHERE idp='".$get_sql['id']."' ORDER BY id DESC");
						if (mysqli_num_rows($hyst_sql0) != 0) {
						while($get_sql0 = mysqli_fetch_array($hyst_sql0)):
				$current['values'][] = array('id'=>$get_sql0['id'],'name'=>$get_sql0['name']);
						endwhile;
						}

				$result['atributs'][] = $current;
				endwhile;
				}
			}
		}

		echo json_encode($result);
	}
} else if ($_POST['typ'] == 'adm_get_atr') {
	if (hyst_test_id ($_POST['id'])) {
		$hyst_sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_atributs_options WHERE idp='".$_POST['id']."' ORDER BY id DESC");
		if (mysqli_num_rows($hyst_sql) != 0) {
		$result = [];
		while($get_sql = mysqli_fetch_array($hyst_sql)):
		$result['id'] = $get_sql['id'];
		$result['name'] = $get_sql['name'];
		endwhile;
		echo json_encode($result);
		}
	}
}

?>