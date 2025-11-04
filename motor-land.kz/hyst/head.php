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
<!-- Performance: Resource hints для ускорения загрузки внешних ресурсов -->
<!-- Performance: Preconnect для собственного домена - критично для быстрой загрузки CSS -->
<link rel="preconnect" href="https://motor-land.kz" crossorigin>
<link rel="dns-prefetch" href="https://motor-land.kz">
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
<link rel="dns-prefetch" href="https://www.googletagmanager.com">
<link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
<link rel="dns-prefetch" href="https://www.google-analytics.com">
<!-- Performance: Preconnect для критических доменов -->
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">

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
<meta property="og:image" content="https://motor-land.kz/img/logo.jpg">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Motor Land">

<!-- Performance: Preload критических шрифтов для устранения блокировки рендеринга -->
<link rel="preload" href="./des/roboto.ttf" as="font" type="font/ttf" crossorigin="anonymous">
<link rel="preload" href="./des/robotob.ttf" as="font" type="font/ttf" crossorigin="anonymous">

<!-- Performance: Inline Critical CSS для улучшения SI (Speed Index) и LCP -->
<!-- Critical CSS для слайдера и hero-секции - рендерится сразу без ожидания основного CSS -->
<style>
/* Critical CSS для LCP элемента (слайдер) */
.slider{width:100%;height:600px;min-height:600px;display:block;text-align:center;position:relative;contain:layout style paint}
.sliderslid{position:absolute;top:0;left:0;display:block;background-size:cover;background-position:center center;width:100%;height:100%;object-fit:cover;min-height:600px}
.sliderslid img{width:100%;height:100%;object-fit:cover;display:block;position:absolute;top:0;left:0}
.slidercoun{position:relative;height:100%;display:inline-block}
.titlephon{color:#fff;font-family:robotob,sans-serif;text-transform:uppercase;font-size:40px;position:absolute;left:0;top:100px;width:500px;text-align:left;min-height:60px}
.sliderbtns{position:absolute;bottom:100px;left:0}
.phone{text-decoration:none;padding:10px 30px;border:solid 2px #fff;border-radius:30px;font-size:22px;color:#fff;display:inline-block}
.atalogb{padding:10px 30px;border:solid 2px #fff;border-radius:30px;font-size:20px;color:#fff;text-decoration:none;display:inline-block;margin-top:15px}
/* Performance: Критические стили для формы поиска */
.sliderform{padding:25px;background:rgba(255,255,255,0.18);border-radius:20px;display:inline-block;position:absolute;bottom:80px;left:0;font-size:40px;color:#fff;font-family:robotob;text-align:left;backdrop-filter:blur(6px) saturate(180%);-webkit-backdrop-filter:blur(6px) saturate(180%);border:1px solid rgba(255,255,255,0.26);box-shadow:0 8px 32px 0 rgba(31,38,135,0.18);z-index:999999}
.maipttee{display:flex;flex-wrap:wrap;justify-content:center;z-index:999998}
.meinputer{display:inline-block;border-radius:15px;border:solid 1px #fff;padding:8px 30px 8px 10px;font-size:18px;color:#5b5b5b;width:170px;margin:5px;position:relative;height:20px;z-index:999998}
/* Улучшение FCP - базовые стили для body */
body{margin:0;padding:0;width:100%;height:100%;font-family:roboto,sans-serif;font-size:14px;color:#404554}
/* Performance: Предотвращение layout shift для header */
.headercon{position:relative;width:100%;min-height:80px}
.shirina{max-width:1200px;margin:0 auto;position:relative}
</style>

<!-- Performance: Оптимизация критического пути - загружаем CSS параллельно, не блокируя рендеринг -->
<!-- Performance: Критические стили загружаем с preload для параллельной загрузки -->
<link rel="preload" href="/hyst/visual/admin.css?<?=$INTERFACE_VERSION;?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/hyst/visual/admin.css?<?=$INTERFACE_VERSION;?>" type="text/css"/></noscript>
<link rel="preload" href="/hyst/visual/admin_mob.css?<?=$INTERFACE_VERSION;?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/hyst/visual/admin_mob.css?<?=$INTERFACE_VERSION;?>" type="text/css"/></noscript>

<!-- Performance: Основные стили загружаем асинхронно для улучшения SI (Speed Index) -->
<!-- Non-critical CSS загружаем после рендеринга критического контента -->
<link rel="preload" href="css.css?<?=$INTERFACE_VERSION;?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="css.css?<?=$INTERFACE_VERSION;?>" type="text/css" /></noscript>
<link rel="preload" href="tab.css?<?=$INTERFACE_VERSION;?>" as="style" onload="this.onload=null;this.rel='stylesheet'" media="(min-width: 768px)">
<noscript><link rel="stylesheet" href="tab.css?<?=$INTERFACE_VERSION;?>" type="text/css" media="(min-width: 768px)" /></noscript>
<link rel="preload" href="mob.css?<?=$INTERFACE_VERSION;?>" as="style" onload="this.onload=null;this.rel='stylesheet'" media="(max-width: 767px)">
<noscript><link rel="stylesheet" href="mob.css?<?=$INTERFACE_VERSION;?>" type="text/css" media="(max-width: 767px)" /></noscript>
<!-- Performance: Revealator CSS загружаем асинхронно -->
<link rel="preload" href="des/fm.revealator.jquery.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="des/fm.revealator.jquery.min.css"></noscript>

<!-- Performance: JavaScript загружаем с defer для неблокирующей загрузки -->
<!-- Performance: Добавляем скрипт для загрузки CSS через preload (polyfill для старых браузеров) -->
<script>
/*! loadCSS rel=preload polyfill. [c]2017 @zachleat, Filament Group, Inc. Licensed MIT */
(function(w){"use strict";if(!w.loadCSS){w.loadCSS=function(){}}
var loadCSS=function(href,before,media){var doc=w.document;var ss=doc.createElement("link");var ref;if(before){ref=before}else{var refs=(doc.body||doc.getElementsByTagName("head")[0]).childNodes;ref=refs[refs.length-1]}
var sheets=doc.styleSheets;ss.rel="stylesheet";ss.href=href;ss.media="only x";function ready(cb){if(doc.body){return cb()}
setTimeout(function(){ready(cb)},1)}
ready(function(){ref.parentNode.insertBefore(ss,before?ref:ref.nextSibling)});var onloadcssdefined=function(cb){var resolvedHref=ss.href;var i=sheets.length;while(i--){if(sheets[i].href===resolvedHref){return cb()}}
setTimeout(function(){onloadcssdefined(cb)})};function loadCB(){if(ss.addEventListener){ss.removeEventListener("load",loadCB)}ss.media=media||"all"}
if(ss.addEventListener){ss.addEventListener("load",loadCB)}
ss.onloadcssdefined=onloadcssdefined;onloadcssdefined(loadCB);return ss};w.loadCSS=loadCSS})(typeof global!=="undefined"?global:this);
</script>
<!-- Важно: jQuery должен загрузиться первым, но используем defer для неблокирующей загрузки -->
<script src="/hyst/visual/jquery.js" defer></script>
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