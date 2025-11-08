<!-- Google Tag Manager - отложенная загрузка для улучшения FCP -->
<script>
  // Отложенная загрузка GTM после загрузки страницы
  window.addEventListener('load', function() {
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TV26F96Q');
  });
</script>
<!-- End Google Tag Manager -->

<?php
$INTERFACE_VERSION = 0.91;
// SEO: Убеждаемся что мета-описание определено - всегда должно быть значение
// Проверяем не только isset и empty, но и что значение не состоит только из пробелов
$default_description = 'Купить контрактный мотор в Алматы. Контрактные двигатели Казахстан - привозные моторы из Малайзии. Контрактный двигатель Toyota, Honda, Nissan, Mazda, Mitsubishi. Двигатель бу Малайзия Алматы с гарантией. Двигатель 1NZ, 2AZ, 3S, K24A, QR25DE. Контрактный двигатель Camry, CRV. Огромный выбор контрактных двигателей. Доставка по всему Казахстану.';

if (!isset($SITE_DESCRIPTION) || empty($SITE_DESCRIPTION) || trim($SITE_DESCRIPTION) === '') {
	$SITE_DESCRIPTION = $default_description;
} else {
	// Убеждаемся что описание не пустое после trim
	$SITE_DESCRIPTION = trim($SITE_DESCRIPTION);
	if ($SITE_DESCRIPTION === '') {
		$SITE_DESCRIPTION = $default_description;
	}
}

if (!isset($SITE_TITLE) || empty($SITE_TITLE) || trim($SITE_TITLE) === '') {
	$SITE_TITLE = 'Купить Контрактный Мотор Алматы | Привозные Моторы Малайзия | Двигатель БУ | Моторленд';
} else {
	$SITE_TITLE = trim($SITE_TITLE);
	if ($SITE_TITLE === '') {
		$SITE_TITLE = 'Купить Контрактный Мотор Алматы | Привозные Моторы Малайзия | Двигатель БУ | Моторленд';
	}
}

// SEO: Гарантируем что метаописание не пустое и имеет минимальную длину (минимум 50 символов для SEO)
if (mb_strlen($SITE_DESCRIPTION) < 50) {
	$SITE_DESCRIPTION = $default_description;
}
?>

<!-- SEO: Meta description всегда должен быть в head (обязательно для SEO) -->
<!-- Performance: Убеждаемся что метаописание всегда выводится и не пустое -->
<meta name="description" content="<?=htmlspecialchars($SITE_DESCRIPTION, ENT_QUOTES, 'UTF-8');?>">
<title><?=htmlspecialchars($SITE_TITLE ?? 'Купить Контрактный Мотор Алматы | Моторленд', ENT_QUOTES, 'UTF-8');?></title>
<!-- Accessibility: Убираем maximum-scale для разрешения масштабирования (требование PageSpeed) -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="shortcut icon" href="favicon.ico?<?=$INTERFACE_VERSION;?>" />
<link rel="apple-touch-icon" href="favicon_apple.png?<?=$INTERFACE_VERSION;?>">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Motor Land">

<link rel="stylesheet" href="/hyst/visual/admin.css?<?=$INTERFACE_VERSION;?>" type="text/css"/>
<link rel="stylesheet" href="/hyst/visual/admin_mob.css?<?=$INTERFACE_VERSION;?>" type="text/css"/>

<link rel="stylesheet" href="css.css?<?=$INTERFACE_VERSION;?>" type="text/css"/>
<link href="tab.css?<?=$INTERFACE_VERSION;?>" rel="stylesheet" type="text/css" media="(min-width: 768px)" />
<link href="mob.css?<?=$INTERFACE_VERSION;?>" rel="stylesheet" type="text/css" media="(max-width: 767px)" />
<link rel="stylesheet" href="des/fm.revealator.jquery.min.css">

<script src="/hyst/visual/jquery.js"></script>
<script src="/hyst/visual/jquery-ui.js"></script>
<script src="/hyst/visual/main.js?<?=$INTERFACE_VERSION?>"></script>
<script src="des/myjs.js?<?=$INTERFACE_VERSION;?>"></script>
<script src="des/fm.revealator.jquery.js"></script>

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
		echo '<script src="/hyst/mods/'.$mods_folders[$q].'/js.js?'.$INTERFACE_VERSION.'"></script>';
		}
	}
}


if (count($_HYST_METAINCUDES) != 0) {
	foreach ($_HYST_METAINCUDES as $q) {
		$inc_type = explode('/',$q);
		$type = explode('.',$inc_type[count($inc_type)-1]);
		if ($type[count($type)-1] == 'js') {
		echo '<script src="'.$q.'"></script>';
		} else if ($type[count($type)-1] == 'css') {
		echo '<link href="'.$q.'" rel="stylesheet" type="text/css" />';
		}		
	}
}
?>

<!-- Performance: Google Analytics загружаем асинхронно с низким приоритетом (отложенная загрузка) -->
<script>
  // Отложенная загрузка Google Analytics для улучшения FCP
  // Создаем функцию gtag сразу, чтобы избежать ошибок "gtag is not defined"
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  
  window.addEventListener('load', function() {
    try {
      var script = document.createElement('script');
      script.async = true;
      script.src = 'https://www.googletagmanager.com/gtag/js?id=AW-17661940869';
      document.head.appendChild(script);
      
      gtag('config', 'AW-17661940869');
    } catch(e) {
      console.warn('Google Analytics loading error:', e);
    }
  });
</script>