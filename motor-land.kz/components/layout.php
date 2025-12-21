<?php
/**
 * Base Layout Component
 * Общий шаблон для всех страниц
 */
if (!isset($SITE_TITLE)) $SITE_TITLE = 'Motor Land - Контрактные двигатели';
if (!isset($SITE_DESCRIPTION)) $SITE_DESCRIPTION = 'Купить контрактный мотор в Алматы. Контрактные двигатели Казахстан, Россия, Беларусь, Украина, СНГ';
if (!isset($SITE_KEYWORDS)) $SITE_KEYWORDS = 'контрактные двигатели, привозные моторы';
?>
<!doctype html>
<html lang="ru">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MCG7EP4276"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-MCG7EP4276');
</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<a href="#main-content" class="skip-link">Перейти к основному содержимому</a>
<?php include("hyst/head.php"); ?>
<?php if (isset($canonical_url)): ?>
<link rel="canonical" href="<?=$canonical_url;?>"/>
<?php endif; ?>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<?php if (isset($og_url)): ?>
<meta property="og:url" content="<?=$og_url;?>">
<?php endif; ?>
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="<?=isset($og_image) ? $og_image : 'https://motor-land.kz/img/logo.webp';?>">
<meta property="og:site_name" content="Motor Land">

<!-- Tailwind CSS -->
<link href="/assets/css/output.css" rel="stylesheet" type="text/css" />

<?php if (isset($additional_head)) echo $additional_head; ?>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("components/header.php"); ?>

<main id="main-content" role="main" class="pt-20 lg:pt-24">
<?php if (isset($breadcrumbs) && $breadcrumbs): ?>
  <!-- Breadcrumbs -->
  <nav class="container-custom py-4" aria-label="Навигационная цепочка">
    <div class="flex items-center space-x-2 text-sm text-primary-600">
      <?php foreach ($breadcrumbs as $index => $crumb): ?>
        <?php if ($index > 0): ?>
          <span class="text-primary-400">/</span>
        <?php endif; ?>
        <?php if (isset($crumb['url']) && !$crumb['is_last']): ?>
          <a href="<?=$crumb['url'];?>" class="hover:text-primary-900 transition-colors"><?=$crumb['name'];?></a>
        <?php else: ?>
          <span class="text-primary-900 font-medium"><?=$crumb['name'];?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </nav>
<?php endif; ?>

<?php echo $content; ?>

</main>

<?php include("components/footer.php"); ?>
<?php include("hyst/fbody.php"); ?>

<!-- Main JS -->
<script src="/assets/js/main.js" defer></script>
<?php if (isset($additional_scripts)) echo $additional_scripts; ?>
</body>
</html>

