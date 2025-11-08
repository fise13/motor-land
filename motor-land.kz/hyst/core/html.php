<?php
/*
function hyst_setup_admin_menue() {
	global $hystadmin;
	
	$folders = scandir('hyst/comp');
	array_splice($folders, 0, 2);
	$h = '<ul class="hyst_adm_menu"> <a href="/adm.php"><li>Контрольная панель</li></a>';
		if (array_search('general',explode(',',$hystadmin[$hystadmtabcprefix."4"]))!==false) {
	$h .= '<a href="/adm.php?d=general_users"><li>Учетные записи</li></a>';
		}
	for ($q = 0; $q < count($folders); $q++) {
	
		if (array_search('general',explode(',',$hystadmin[$hystadmtabcprefix."4"]))!==false || array_search($folders[$q],explode(',',$hystadmin[$hystadmtabcprefix."4"]))!==false) {
			if (file_exists('hyst/comp/'.$folders[$q].'/info.ini') && $module_info = parse_ini_file('hyst/comp/'.$folders[$q].'/info.ini')) {
			$module_name = $module_info['name'];
			} else {
			$module_name = $folders[$q];
			}
			$h .= '<a href="/adm.php?d='.$folders[$q].'"><li>'.$module_name.'</li></a>';
		}
	}
	$h .= '</ul>';
	echo $h;
}*/


function hyst_show_adm () {

	global $_HYST_ADMIN_SETUP;
	global $_HYST_ADMIN;
	global $_DB_CONECT;
	
	$html = '';
	if ($_HYST_ADMIN_SETUP) {
		$html .= '<adm_header></adm_header>';
		$html .= '<adm_content>';
		$html .= '<content>';
		
		$html .= file_get_contents($_SERVER['DOCUMENT_ROOT'].'/hyst/visual/html/setup_form.php');
			
		$html .= '</content>';
		$html .= '</adm_content>';
		echo $html;
	} else { 
		if (!$_HYST_ADMIN) {
		$html .= '<adm_header></adm_header>';
		$html .= '<adm_content>';
		$html .= '<content>';
		
		$html .= file_get_contents($_SERVER['DOCUMENT_ROOT'].'/hyst/visual/html/authorization.php');
		
		$html .= '</content>';
		$html .= '</adm_content>';
		echo $html;
		} else {
		$html .= '<input type="checkbox" id="sidebarbutton"'.((empty($_COOKIE['sidebarbutton'])||$_COOKIE['sidebarbutton']=='false')?'':' checked').'>';
		$html .= '<adm_header>
			<label for="sidebarbutton"><i></i></label>
			<div class="admin_header_profile">
				<div class="admin_header_name">'.$_HYST_ADMIN[AUC_PREFIX.'_name'].'</div>
				<a class="admin_header_exit" href="?exit_admin">
					<button class="Btn">
						<div class="sign">
							<svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg>
						</div>
						<div class="text">Logout</div>
					</button>
				</a>
			</div>
		</adm_header>';
		$html .= '<adm_content>';
		$html .= '<sidebar>
			<a class="admin_sidebar_menu" style="background-image: url(/hyst/visual/images/index_icon.svg);" href="/adm"><span>Контрольная панель</span></a>';
			if (array_search('general',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('all',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false) {
		$html .= '<a class="admin_sidebar_menu" style="background-image: url(/hyst/visual/images/moderators_icon.svg);" href="/adm?moderators"><span>Модераторы</span></a>';
			}
			if (array_search('general',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('all',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('mediafiles',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false) {
		$html .= '<a class="admin_sidebar_menu" style="background-image: url(/hyst/visual/images/images_icon.svg);" href="/adm?mediafiles"><span>Медиафайлы</span></a>';
			}
		$mods_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
		array_splice($mods_folders, 0, 2);
		$hidden_modules = array('seo_queries', 'page_content');
		for ($q = 0; $q < count($mods_folders); $q++) {
			if (!in_array($mods_folders[$q], $hidden_modules)) {
				if (array_search('general',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('all',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search($mods_folders[$q],explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false) {
					if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/info.ini') && $module_info = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/info.ini')) {
					$module_name = $module_info['name'];
					} else {
					$module_name = $mods_folders[$q];
					}
			$html .= '<a class="admin_sidebar_menu" style="background-image: url(/hyst/mods/'.$mods_folders[$q].'/menu_icon.svg);" href="/adm?displayed='.$mods_folders[$q].'"><span>'.$module_name.'</span></a>';
				}
			}
		}
		
		$html .= '</sidebar>';
		$html .= '<content>';
		echo $html;
			
			if (isset($_GET['moderators']) && (array_search('general',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('all',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
		include($_SERVER['DOCUMENT_ROOT'].'/hyst/visual/html/moderators.php');
			} else if (isset($_GET['mediafiles']) && (array_search('general',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('all',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('mediafiles',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
		include($_SERVER['DOCUMENT_ROOT'].'/hyst/visual/html/mediafiles.php');		
			} else if (isset($_GET['displayed']) && !in_array($_GET['displayed'], array('seo_queries', 'page_content')) && (array_search('general',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('all',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search($_GET['displayed'],explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
				if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$_GET['displayed'].'/index.php')) {
		include($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$_GET['displayed'].'/index.php');			
				} else {
		include($_SERVER['DOCUMENT_ROOT'].'/hyst/visual/html/index.php');		
				}
			} else {
		include($_SERVER['DOCUMENT_ROOT'].'/hyst/visual/html/index.php');
			}
		
		$html = '</content>';
		$html .= '</adm_content>';
		echo $html;
		}
	}
	
	
}

/*
function hyst_getcomp ($c) {
	global $hyst_db;
	$h .= '<div class="hyst_adm_container">';
	$h .= file_get_contents('hyst/dsgn/menu.php');
	echo $h;
	include('hyst/comp/'.$c.'/index.php');
	$h = '</div>';
	echo $h;
}*/
?>