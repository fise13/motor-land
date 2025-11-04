<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TV26F96Q');</script>
<!-- End Google Tag Manager -->

<?php
$INTERFACE_VERSION = 0.91;
?>
<!-- Performance: Resource hints для ускорения загрузки внешних ресурсов -->
<link rel="preconnect" href="https://www.googletagmanager.com">
<link rel="dns-prefetch" href="https://www.googletagmanager.com">
<link rel="preconnect" href="https://www.google-analytics.com">
<link rel="dns-prefetch" href="https://www.google-analytics.com">

<title><?=$SITE_TITLE;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="<?=$SITE_DESCRIPTION;?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="shortcut icon" href="favicon.ico?<?=$INTERFACE_VERSION;?>" />
<link rel="apple-touch-icon" href="favicon_apple.png?<?=$INTERFACE_VERSION;?>">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta property="og:image" content="https://motor-land.kz/img/logo.jpg">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Motor Land">

<!-- Performance: Preload критических шрифтов для устранения блокировки рендеринга -->
<link rel="preload" href="./des/roboto.ttf" as="font" type="font/ttf" crossorigin="anonymous">
<link rel="preload" href="./des/robotob.ttf" as="font" type="font/ttf" crossorigin="anonymous">

<!-- Performance: Критические стили загружаем первыми -->
<link rel="stylesheet" href="/hyst/visual/admin.css?<?=$INTERFACE_VERSION;?>" type="text/css"/>
<link rel="stylesheet" href="/hyst/visual/admin_mob.css?<?=$INTERFACE_VERSION;?>" type="text/css"/>

<!-- Performance: Основные стили -->
<link href="css.css?<?=$INTERFACE_VERSION;?>" rel="stylesheet" type="text/css" />
<link href="tab.css?<?=$INTERFACE_VERSION;?>" rel="stylesheet" type="text/css" media="(min-width: 768px)" />
<link href="mob.css?<?=$INTERFACE_VERSION;?>" rel="stylesheet" type="text/css" media="(max-width: 767px)" />
<!-- Performance: Revealator CSS загружаем асинхронно -->
<link rel="preload" href="des/fm.revealator.jquery.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="des/fm.revealator.jquery.min.css"></noscript>

<!-- Performance: JavaScript загружаем с defer для неблокирующей загрузки -->
<!-- Важно: jQuery должен загрузиться первым, поэтому используем defer в правильном порядке -->
<script src="/hyst/visual/jquery.js"></script>
<script src="/hyst/visual/jquery-ui.js" defer></script>
<script src="/hyst/visual/main.js?<?=$INTERFACE_VERSION?>" defer></script>
<script src="des/myjs.js?<?=$INTERFACE_VERSION;?>" defer></script>
<script src="des/fm.revealator.jquery.js" defer></script>

<?php
if ($_HYST_ADMIN) {
	$mods_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
	array_splice($mods_folders, 0, 2);
	for ($q = 0; $q < count($mods_folders); $q++) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/css.css')) {
	// Performance: CSS модулей загружаем синхронно (критично для админки)
	echo '<link rel="stylesheet" href="/hyst/mods/'.$mods_folders[$q].'/css.css?'.$INTERFACE_VERSION.'" type="text/css"/>';
		}
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/js.js')) {
	// Performance: JS модулей загружаем с defer
	echo '<script src="/hyst/mods/'.$mods_folders[$q].'/js.js?'.$INTERFACE_VERSION.'" defer></script>';
		}
	}
}


if (count($_HYST_METAINCUDES) != 0) {
	foreach ($_HYST_METAINCUDES as $q) {
		$inc_type = explode('/',$q);
		$type = explode('.',$inc_type[count($inc_type)-1]);
		if ($type[count($type)-1] == 'js') {
		// Performance: Динамические JS загружаем с defer
		echo '<script src="'.$q.'" defer></script>';
		} else if ($type[count($type)-1] == 'css') {
		// Performance: Динамические CSS загружаем асинхронно
		echo '<link href="'.$q.'" rel="stylesheet" type="text/css" media="print" onload="this.media=\'all\'" />';
		echo '<noscript><link href="'.$q.'" rel="stylesheet" type="text/css" /></noscript>';
		}		
	}
}
?>

<!-- Performance: Google Analytics загружаем асинхронно с низким приоритетом -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-17661940869"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'AW-17661940869');
</script>