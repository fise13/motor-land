<?php
/**
 * Глобальная JSON-LD разметка: Organization + WebSite (SearchAction).
 * Подключается из hyst/head.php один раз на страницу.
 */
if (!empty($SEO_SKIP_GLOBAL_SCHEMA)) {
	return;
}
$org_json = [
	'@context' => 'https://schema.org',
	'@type' => 'Organization',
	'@id' => 'https://motor-land.kz/#org',
	'name' => 'Motor Land',
	'alternateName' => 'Моторленд',
	'url' => 'https://motor-land.kz',
	'logo' => [
		'@type' => 'ImageObject',
		'url' => 'https://motor-land.kz/img/logo.webp',
	],
	'sameAs' => [
		'https://2gis.kz/almaty/geo/70000001083496996',
		'https://2gis.kz/almaty/geo/70000001024156353',
	],
];
$site_json = [
	'@context' => 'https://schema.org',
	'@type' => 'WebSite',
	'@id' => 'https://motor-land.kz/#website',
	'name' => 'Motor Land',
	'url' => 'https://motor-land.kz',
	'publisher' => ['@id' => 'https://motor-land.kz/#org'],
	'potentialAction' => [
		'@type' => 'SearchAction',
		'target' => [
			'@type' => 'EntryPoint',
			'urlTemplate' => 'https://motor-land.kz/catalog?mk={search_term_string}',
		],
		'query-input' => 'required name=search_term_string',
	],
];
echo '<script type="application/ld+json">' . "\n";
echo json_encode($org_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
echo '</script>' . "\n";
echo '<script type="application/ld+json">' . "\n";
echo json_encode($site_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
echo '</script>' . "\n";
