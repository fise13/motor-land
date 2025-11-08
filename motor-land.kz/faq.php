<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги для страницы FAQ
$SITE_TITLE = 'Часто задаваемые вопросы (FAQ) | Контрактные Двигатели | Моторленд';
$SITE_DESCRIPTION = 'Ответы на часто задаваемые вопросы о контрактных двигателях, гарантии, доставке и установке. Всё что нужно знать о покупке контрактного двигателя в Алматы.';
$SITE_KEYWORDS = 'FAQ контрактные двигатели, вопросы о двигателях, гарантия на двигатель, доставка двигателей, установка контрактного двигателя';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<!-- SEO: Canonical URL -->
<link rel="canonical" href="https://motor-land.kz/faq"/>
<!-- SEO: Meta keywords -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/faq">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<!-- SEO: Twitter Cards -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<!-- SEO: Schema.org FAQPage разметка -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [{
    "@type": "Question",
    "name": "Что такое контрактный двигатель?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Контрактный двигатель - это бывший в употреблении двигатель, снятый с автомобиля в рабочем состоянии. Обычно такие двигатели снимаются с автомобилей после ДТП или в связи с другими обстоятельствами, когда сам автомобиль не подлежит восстановлению, но двигатель находится в отличном техническом состоянии."
    }
  }, {
    "@type": "Question",
    "name": "Какой срок гарантии на контрактные двигатели?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "На все контрактные двигатели, кроме турбированных Subaru, мы предоставляем срок на проверку от 3 до 25 календарных дней со дня покупки без ограничения пробега. На спортивные авто срок проверки составляет 5 дней с момента покупки."
    }
  }, {
    "@type": "Question",
    "name": "Откуда привозятся контрактные двигатели?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Мы привозим контрактные двигатели из Малайзии и других стран Азии. Все двигатели проходят тщательную проверку перед отправкой и соответствуют заявленным параметрам."
    }
  }]
}
</script>
<!-- SEO: BreadcrumbList -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "Главная",
    "item": "https://motor-land.kz/"
  }, {
    "@type": "ListItem",
    "position": 2,
    "name": "FAQ",
    "item": "https://motor-land.kz/faq"
  }]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<!-- SEO: Семантический тег <main> -->
<main>
<br><br>
<!-- SEO: Семантический тег <nav> для хлебных крошек -->
<nav class="generalw" aria-label="Навигационная цепочка">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name">FAQ</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
	</div>
</nav>

<!-- SEO: Семантический тег <section> для заголовка -->
<section class="generalw" aria-labelledby="faq-title">
	<div class="shirina zgolovorleft">
		<h1 id="faq-title" class="sttitle"><span>Часто задаваемые вопросы</span></h1>
	</div>
</section>

<!-- SEO: Семантический тег <section> для FAQ -->
<section class="faq-section">
	<div class="shirina">
		<div class="faq-container">
			
			<!-- Категория: Общие вопросы -->
			<div class="faq-category">
				<h2 class="faq-category-title">Общие вопросы</h2>
				
				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Что такое контрактный двигатель?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Контрактный двигатель — это бывший в употреблении двигатель, снятый с автомобиля в рабочем состоянии. Обычно такие двигатели снимаются с автомобилей после ДТП или в связи с другими обстоятельствами, когда сам автомобиль не подлежит восстановлению, но двигатель находится в отличном техническом состоянии.</p>
						<p>Преимущества контрактных двигателей:</p>
						<ul>
							<li>Значительно ниже стоимость по сравнению с новым двигателем</li>
							<li>Оригинальное качество от производителя</li>
							<li>Полная совместимость с вашим автомобилем</li>
							<li>Экономия времени и денег</li>
						</ul>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Откуда привозятся контрактные двигатели?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Мы привозим контрактные двигатели из Малайзии и других стран Азии, где автомобили используются в хороших условиях и имеют меньший износ. Все двигатели проходят тщательную проверку перед отправкой и соответствуют заявленным параметрам.</p>
						<p>Преимущества двигателей из Малайзии:</p>
						<ul>
							<li>Умеренный климат способствует меньшему износу</li>
							<li>Качественное топливо и регулярное обслуживание</li>
							<li>Меньший пробег по сравнению с европейскими автомобилями</li>
							<li>Строгий контроль качества при снятии</li>
						</ul>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Как проверить состояние контрактного двигателя перед покупкой?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>При покупке контрактного двигателя мы рекомендуем:</p>
						<ul>
							<li>Проверить компрессию в цилиндрах</li>
							<li>Осмотреть двигатель на наличие подтеков масла и антифриза</li>
							<li>Проверить состояние масла (отсутствие эмульсии и металлической стружки)</li>
							<li>Убедиться в наличии всех необходимых комплектующих</li>
							<li>Проверить номер двигателя на соответствие</li>
						</ul>
						<p>Наши специалисты помогут вам провести все необходимые проверки и ответят на все вопросы.</p>
					</div>
				</div>

			</div>

			<!-- Категория: Гарантия и возврат -->
			<div class="faq-category">
				<h2 class="faq-category-title">Гарантия и возврат</h2>
				
				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Какой срок гарантии на контрактные двигатели?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>На все контрактные двигатели, кроме турбированных Subaru, мы предоставляем срок на проверку от 3 до 25 календарных дней со дня покупки без ограничения пробега. На спортивные авто срок проверки составляет 5 дней с момента покупки.</p>
						<p>Важно помнить:</p>
						<ul>
							<li>Гарантия действует только при установке в сертифицированных сервисах</li>
							<li>Необходимо соблюдать условия эксплуатации</li>
							<li>При возврате требуется наличие всех документов</li>
						</ul>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">В каких случаях гарантия не действует?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Гарантия не действует при:</p>
						<ul>
							<li>Потере масла в двигателе, КПП</li>
							<li>Любом внешнем повреждении при установке, доставке или неправильной эксплуатации</li>
							<li>Перегреве двигателя, КПП</li>
							<li>Переделках и использовании нештатных агрегатов</li>
							<li>Участии в гонках</li>
							<li>Использовании неоригинальных запчастей</li>
							<li>Неисправности системы охлаждения</li>
							<li>Повреждении вследствие разрыва ремня ГРМ</li>
							<li>Коммерческом использовании авто</li>
							<li>При повреждении или отсутствии меток</li>
							<li>В случаях пропуска срока данного на проверку</li>
						</ul>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Что делать, если двигатель не подошел?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>В случае, если двигатель не соответствует заявленным параметрам, мы:</p>
						<ul>
							<li>Производим замену на другой двигатель</li>
							<li>Если аналогичного двигателя нет в наличии, привозим под заказ</li>
							<li>Возвращаем деньги за товар (только при отсутствии аналогичного двигателя на складе)</li>
						</ul>
						<p>Для возврата необходимо предоставить:</p>
						<ul>
							<li>Документ, подтверждающий приобретение запасной части у компании «Motor Land»</li>
							<li>Наличие сертификата СТО на проведение данного вида работ</li>
							<li>Заключение о неработоспособности детали</li>
						</ul>
					</div>
				</div>

			</div>

			<!-- Категория: Доставка и оплата -->
			<div class="faq-category">
				<h2 class="faq-category-title">Доставка и оплата</h2>
				
				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Как осуществляется доставка контрактных двигателей?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Доставка контрактных двигателей осуществляется несколькими способами:</p>
						<ul>
							<li><strong>Транспортные компании:</strong> Доставка по всей территории Казахстана и в страны СНГ. Доставка до терминала ТК или до двери. Возможно отслеживание груза.</li>
							<li><strong>Самовывоз:</strong> Забрать товар можно самостоятельно из наших офисов в Алматы (РВ-90, 7-линия, 29 или ул. Свердлова, 38)</li>
							<li><strong>Курьерская доставка:</strong> Доставка по городу Алматы курьерской службой. Доставка в день заказа или на следующий день. Стоимость от 2000 тенге.</li>
						</ul>
						<p>Все товары тщательно упаковываются для безопасной транспортировки. Двигатели упаковываются в защитные пленки.</p>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Какие способы оплаты доступны?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Мы принимаем оплату следующими способами:</p>
						<ul>
							<li><strong>Наличный расчет:</strong> Оплата наличными при получении товара в пункте выдачи или при доставке курьером</li>
							<li><strong>Банковский перевод:</strong> Перечисление на расчетный счет компании. Реквизиты предоставляются после оформления заказа</li>
							<li><strong>Картой онлайн:</strong> Безопасная оплата банковской картой через платежные системы</li>
							<li><strong>Kaspi.kz / Kaspi Gold:</strong> Оплата через Kaspi.kz или рассрочка через Kaspi Gold</li>
						</ul>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Какие сроки доставки?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Сроки доставки зависят от региона:</p>
						<ul>
							<li><strong>Доставка в Алматы:</strong> 1-2 рабочих дня</li>
							<li><strong>По Казахстану:</strong> 3-7 рабочих дней</li>
							<li><strong>В страны СНГ:</strong> 7-14 рабочих дней</li>
						</ul>
						<p>Точные сроки доставки уточняйте у менеджера. Стоимость доставки рассчитывается индивидуально в зависимости от веса, габаритов и региона доставки.</p>
					</div>
				</div>

			</div>

			<!-- Категория: Установка и обслуживание -->
			<div class="faq-category">
				<h2 class="faq-category-title">Установка и обслуживание</h2>
				
				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Где можно установить контрактный двигатель?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Мы рекомендуем устанавливать контрактные двигатели в сертифицированных автосервисах. Это гарантирует:</p>
						<ul>
							<li>Правильную установку и настройку</li>
							<li>Соблюдение всех технических требований</li>
							<li>Сохранение гарантии на двигатель</li>
							<li>Профессиональную диагностику после установки</li>
						</ul>
						<p>Также мы предоставляем услуги по установке контрактных двигателей в нашем автосервисе. Опытные мастера с более чем 10-летним стажем работы.</p>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Что входит в услугу установки двигателя?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>При установке контрактного двигателя мы выполняем:</p>
						<ul>
							<li>Демонтаж старого двигателя</li>
							<li>Подготовку и проверку нового двигателя</li>
							<li>Установку двигателя с подключением всех систем</li>
							<li>Замену масла и фильтров</li>
							<li>Замену ремней и других расходных материалов</li>
							<li>Диагностику и настройку</li>
							<li>Проверку работоспособности всех систем</li>
						</ul>
						<p>Также возможно техническое обслуживание установленного двигателя: замена масла, фильтров, ремней и других расходников.</p>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Сколько стоит установка контрактного двигателя?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Стоимость установки контрактного двигателя зависит от:</p>
						<ul>
							<li>Марки и модели автомобиля</li>
							<li>Объема и типа двигателя</li>
							<li>Сложности работ</li>
							<li>Необходимости дополнительных работ (замена КПП, ремней и т.д.)</li>
						</ul>
						<p>Точную стоимость установки уточняйте у наших специалистов. Мы предоставляем прозрачное ценообразование без скрытых доплат.</p>
					</div>
				</div>

			</div>

			<!-- Категория: Подбор и совместимость -->
			<div class="faq-category">
				<h2 class="faq-category-title">Подбор и совместимость</h2>
				
				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Как подобрать контрактный двигатель для моего автомобиля?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Для подбора контрактного двигателя нам необходима следующая информация:</p>
						<ul>
							<li>Марка и модель автомобиля</li>
							<li>Год выпуска</li>
							<li>Объем и тип двигателя (бензин/дизель)</li>
							<li>Номер VIN автомобиля (для точного подбора)</li>
							<li>Номер текущего двигателя</li>
						</ul>
						<p>Наши специалисты помогут подобрать подходящий контрактный двигатель с учетом всех параметров вашего автомобиля. Вы также можете воспользоваться формой поиска на главной странице или в каталоге.</p>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Совместим ли контрактный двигатель с моим автомобилем?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>Все контрактные двигатели, которые мы предлагаем, полностью совместимы с указанными моделями автомобилей. Мы проверяем:</p>
						<ul>
							<li>Соответствие типа и объема двигателя</li>
							<li>Совместимость с системой управления</li>
							<li>Соответствие точек крепления</li>
							<li>Совместимость с трансмиссией</li>
							<li>Соответствие систем охлаждения и смазки</li>
						</ul>
						<p>Если у вас возникли сомнения, наши специалисты помогут подобрать правильный двигатель для вашего автомобиля.</p>
					</div>
				</div>

				<div class="faq-item">
					<div class="faq-question" role="button" tabindex="0" aria-expanded="false">
						<span class="faq-question-text">Есть ли в наличии двигатель для моей модели?</span>
						<span class="faq-icon">+</span>
					</div>
					<div class="faq-answer">
						<p>У нас большой выбор контрактных двигателей для различных марок и моделей автомобилей:</p>
						<ul>
							<li>Toyota (Camry, Corolla, RAV4, Land Cruiser и др.)</li>
							<li>Honda (CR-V, Accord, Civic и др.)</li>
							<li>Nissan (Almera, X-Trail, Pathfinder и др.)</li>
							<li>Mazda (CX-5, 6, 3 и др.)</li>
							<li>Mitsubishi (Outlander, L200, Pajero и др.)</li>
							<li>И многие другие марки</li>
						</ul>
						<p>Если нужного двигателя нет в наличии, мы можем привезти его под заказ. Срок поставки составляет от 7 до 14 дней.</p>
					</div>
				</div>

			</div>

		</div>
		
		<!-- Блок для связи -->
		<div class="faq-contact-block">
			<h3 class="faq-contact-title">Не нашли ответ на свой вопрос?</h3>
			<p class="faq-contact-text">Свяжитесь с нами, и мы с радостью ответим на все ваши вопросы</p>
			<div class="faq-contact-actions">
				<a href="/contacts" class="faq-contact-btn">Связаться с нами</a>
				<a href="tel:+77771445445" class="faq-contact-btn faq-contact-btn-phone">Позвонить</a>
			</div>
		</div>
		
	</div>
</section>

<br><br>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

<!-- Performance: JavaScript для FAQ аккордеона загружаем с defer -->
<script defer>
// FAQ Accordion функциональность
(function() {
	function initFAQ() {
		const faqItems = document.querySelectorAll('.faq-item');
		
		if (faqItems.length === 0) {
			return; // Если элементов нет, выходим
		}
		
		faqItems.forEach(item => {
			const question = item.querySelector('.faq-question');
			const answer = item.querySelector('.faq-answer');
			const icon = item.querySelector('.faq-icon');
			
			if (!question || !answer || !icon) {
				return; // Пропускаем если элементы не найдены
			}
			
			question.addEventListener('click', function() {
				const isExpanded = this.getAttribute('aria-expanded') === 'true';
				
				// Закрываем все открытые элементы
				faqItems.forEach(otherItem => {
					if (otherItem !== item) {
						const otherQuestion = otherItem.querySelector('.faq-question');
						const otherAnswer = otherItem.querySelector('.faq-answer');
						const otherIcon = otherItem.querySelector('.faq-icon');
						
						if (otherQuestion && otherAnswer && otherIcon) {
							otherQuestion.setAttribute('aria-expanded', 'false');
							otherAnswer.style.maxHeight = null;
							otherIcon.textContent = '+';
							otherItem.classList.remove('active');
						}
					}
				});
				
				// Открываем/закрываем текущий элемент
				if (isExpanded) {
					this.setAttribute('aria-expanded', 'false');
					answer.style.maxHeight = null;
					icon.textContent = '+';
					item.classList.remove('active');
				} else {
					this.setAttribute('aria-expanded', 'true');
					answer.style.maxHeight = answer.scrollHeight + 'px';
					icon.textContent = '−';
					item.classList.add('active');
				}
			});
			
			// Поддержка клавиатуры
			question.addEventListener('keydown', function(e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					this.click();
				}
			});
		});
	}
	
	// Инициализация после загрузки DOM
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initFAQ);
	} else {
		initFAQ();
	}
})();
</script>

</body>
</html>

