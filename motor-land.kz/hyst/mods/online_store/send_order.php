<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

$mods_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
array_splice($mods_folders, 0, 2);
for ($q = 0; $q < count($mods_folders); $q++) {
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/proces.php')) {
include($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/proces.php');	
	}
}

if (isset($_POST['comand']) && $_POST['comand'] == 'internet_magazin_sendorder') {
	if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['city']) && !empty($_POST['address'])) {
	if (!empty($_POST['comment'])) { $comment = '<br>Комментарий к заказу: '.$_POST['comment'].'<br>'; $commentt = '  *Комментарий к заказу:* '.$_POST['comment']; } else { $comment = ' '; }
	if (!empty($_POST['phone'])) { $phone = $_POST['phone']; } else { $phone = 'Не указан'; }
	$subject = "New order";
	
	$r = internet_magazin_get_orderstopost ((!$users_core_user['id']?$_SERVER['REMOTE_ADDR']:$users_core_user['id']));
	
	$message = '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><html>
             <head><title>Новый заказ</title></head>
             <body>
			 <table border="0">
			 <tr>
			 <td align="left">
				<table border="0">
				<tr>
				<td align="left" width="395"><span style="font-size: 20px;">Новый заказ</span></td>
				<td align="right" width="395"><span style="font-size: 14px;">'.date("Y-m-d H:i:s").'</span></td>
				</tr>
				</table><br>
				<hr width="800">
				<h2>Получатель:</h2>
				 <b>Имя получателя:</b>'.$_POST['name'].'<br><b>Телефон:</b>'.$phone.'<br><b>Email:</b>'.$_POST['email'].'<br>
				<hr width="800">
				<h2>Состав заказа</h2>
				<hr width="800"><br>
				'.$r['text'].'<br>
				<hr width="800"><br>';
	
	$itogo = $r['cash'];
	
	if (!empty($_POST['delivery']) && preg_match("/^0-9/",$_POST['delivery']) == 0) {
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_delivery WHERE id='".$_POST['delivery']."'");
		if (mysqli_num_rows($sql) != 0) {
		$delivery = $_POST['delivery'];
		$get=mysqli_fetch_array($sql);
	$message .= '<span style="font-size: 18x;"> Доставка: '.$get['name'].'  '.($get['cash']!='noting'?'Цена: '.$get['cash'].' тг.':'').'</span><br>';
			if ($get['cash']!='noting') { $itogo += $get['cash']; } 
		} else {
		$delivery = 'noting';
	$message .= '<span style="font-size: 18x;">Тип доставки не нейден в базе сайта</span><br>';	
		}
	} else {
		$delivery = 'noting';
	$message .= '';	
	}			
	$message .= '<span style="font-size: 20px;"> Общая цена: <span style="font-size: 20px; color: red;">'.$itogo.' тг.</span><br>
				Тип оплаты: '.$_POST['oplata'].'<br>
				Адрес доставки: <br>
				<b>Город:</b>'.$_POST['city'].'<br><b>Адрес:</b>'.$_POST['address'].'<br>'.$comment.'
				</span>
			 </td>
			 </tr>
			 </body>
           </html>';

		   
		   $send = new send_message(get_simple_texts('orders_email'), 
				$subject, 
				$message);
				$sending = $send->send();
	
		if ($send) {
			$sql = $_DB_CONECT->query("INSERT INTO internet_magazin_orders (idp,name,email,phone,city,address,delivery,payment,comment,date,orderittems) 
			VALUES ('".(!$USER['id']?$_SERVER['REMOTE_ADDR']:$USER['id'])."','".$_POST['name']."','".$_POST['email']."','".$phone."','".$_POST['city']."','".$_POST['address']."','".$delivery."','N/A','".$comment."','".date("Y-m-d H:i:s")."','".$r['fororder']."')");
			$sql = $_DB_CONECT->query("DELETE FROM internet_magazin_basket WHERE idp='".(!$USER['id']?$_SERVER['REMOTE_ADDR']:$USER['id'])."'");
			$report['error'] = 3;
			$report['message'] = 'Заказ успешно принят!';
			$report['visual_changes'] = array('.basketlaft'=>'Ваша корзина пуста','.itosgo'=>'','.orderform'=>'','.head_basket_counter'=>'0');
		} else {
		$report['error'] = 2;
		$report['message'] = 'Ошибка отправки заказа!';
		}
	} else {
	$report['error'] = 2;
	$report['message'] = 'Ошибка не все обязательные поля заполнены верно!';
	}
	echo json_encode($report,JSON_UNESCAPED_UNICODE);
}
?>