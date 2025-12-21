<?php
/**
 * Modern Footer Component
 * Tailwind CSS
 */
?>
<footer class="bg-primary-900 text-primary-200 mt-20">
  <!-- Main Footer Content -->
  <div class="container-custom py-16 lg:py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
      <!-- Company Info -->
      <div class="reveal">
        <div class="flex items-center space-x-3 mb-6">
          <div class="w-12 h-12 bg-accent rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-xl">ML</span>
          </div>
          <div>
            <div class="text-white font-bold text-lg">Motor Land</div>
            <div class="text-primary-400 text-sm">Контрактные двигатели</div>
          </div>
        </div>
        <p class="text-primary-400 text-sm leading-relaxed">
          Профессиональная поставка контрактных двигателей из Малайзии. Гарантия качества и быстрая доставка по всему СНГ.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="reveal">
        <h3 class="text-white font-bold text-lg mb-6">Навигация</h3>
        <ul class="space-y-3">
          <li><a href="/" class="text-primary-400 hover:text-white transition-colors duration-200">Главная</a></li>
          <li><a href="/catalog.php" class="text-primary-400 hover:text-white transition-colors duration-200">Каталог</a></li>
          <li><a href="/service.php" class="text-primary-400 hover:text-white transition-colors duration-200">Автосервис</a></li>
          <li><a href="/guarantees.php" class="text-primary-400 hover:text-white transition-colors duration-200">Гарантии</a></li>
          <li><a href="/pay.php" class="text-primary-400 hover:text-white transition-colors duration-200">Оплата / Доставка</a></li>
          <li><a href="/contacts.php" class="text-primary-400 hover:text-white transition-colors duration-200">Контакты</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="reveal">
        <h3 class="text-white font-bold text-lg mb-6">Контакты</h3>
        <div class="space-y-4">
          <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <div>
              <a href="https://2gis.kz/almaty/geo/70000001083496996" target="_blank" class="text-primary-400 hover:text-white transition-colors duration-200 block">
                РВ-90, 7-линия, 29
              </a>
              <a href="https://2gis.kz/almaty/geo/70000001024156353" target="_blank" class="text-primary-400 hover:text-white transition-colors duration-200 block mt-2">
                ул. Свердлова, 38
              </a>
            </div>
          </div>
          
          <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <div>
              <a href="tel:+77771445445" class="text-primary-400 hover:text-white transition-colors duration-200 block" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
                +7 777 144 5445
              </a>
              <a href="tel:+77011445445" class="text-primary-400 hover:text-white transition-colors duration-200 block mt-1" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
                +7 701 144 5445
              </a>
            </div>
          </div>

          <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-primary-400 text-sm">
              <div>пн-пт: 9:00-18:00</div>
              <div>суббота: 10:00-15:00</div>
              <div>воскресенье: выходной</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Callback Form -->
      <div class="reveal">
        <h3 class="text-white font-bold text-lg mb-6">Обратный звонок</h3>
        <form class="callback-form space-y-4" method="post">
          <input type="text" name="website" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;z-index:-1;" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_time" value="<?=time();?>" aria-hidden="true">
          
          <div>
            <input type="text" name="name" placeholder="Ваше имя" required maxlength="100" class="form-input bg-primary-800 border-primary-700 text-white placeholder-primary-400 focus:border-accent">
          </div>
          
          <div>
            <input type="tel" name="phon" placeholder="Телефон" required maxlength="20" class="form-input bg-primary-800 border-primary-700 text-white placeholder-primary-400 focus:border-accent">
          </div>
          
          <input type="hidden" name="send_one" value="send">
          <button type="submit" class="btn btn-primary w-full">
            Отправить
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-primary-800">
    <div class="container-custom py-6">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
        <div class="text-primary-400 text-sm">
          &copy; <?= date('Y'); ?> Motor Land. Все права защищены.
        </div>
        <div class="flex items-center space-x-6 text-sm">
          <a href="/faq.php" class="text-primary-400 hover:text-white transition-colors duration-200">FAQ</a>
          <span class="text-primary-600">|</span>
          <a href="/blog.php" class="text-primary-400 hover:text-white transition-colors duration-200">Блог</a>
          <span class="text-primary-600">|</span>
          <a href="/guarantees.php" class="text-primary-400 hover:text-white transition-colors duration-200">Гарантии</a>
        </div>
      </div>
    </div>
  </div>
</footer>

