<?php
/**
 * Modern Header Component
 * Tailwind CSS + Vanilla JS
 */
?>
<header class="fixed top-0 left-0 right-0 z-50 bg-primary-900/95 backdrop-blur-md border-b border-primary-800 transition-all duration-300" role="banner">
  <div class="container-custom">
    <div class="flex items-center justify-between h-20 lg:h-24">
      <!-- Logo -->
      <a href="/" class="flex items-center space-x-3 group" aria-label="Motor Land - Главная страница">
        <div class="w-12 h-12 lg:w-14 lg:h-14 bg-accent rounded-lg flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
          <span class="text-white font-bold text-xl lg:text-2xl">ML</span>
        </div>
        <div class="hidden sm:block">
          <div class="text-white font-bold text-lg lg:text-xl">Motor Land</div>
          <div class="text-primary-400 text-xs lg:text-sm">Контрактные двигатели</div>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center space-x-1" role="navigation" aria-label="Основная навигация">
        <a href="/" class="px-4 py-2 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-white bg-primary-800' : '' ?>">
          Главная
        </a>
        <a href="/catalog.php" class="px-4 py-2 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) == 'catalog.php' ? 'text-white bg-primary-800' : '' ?>">
          Каталог
        </a>
        <a href="/service.php" class="px-4 py-2 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) == 'service.php' ? 'text-white bg-primary-800' : '' ?>">
          Автосервис
        </a>
        <a href="/pay.php" class="px-4 py-2 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) == 'pay.php' ? 'text-white bg-primary-800' : '' ?>">
          Оплата / Доставка
        </a>
        <a href="/guarantees.php" class="px-4 py-2 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) == 'guarantees.php' ? 'text-white bg-primary-800' : '' ?>">
          Гарантии
        </a>
        <a href="/contacts.php" class="px-4 py-2 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) == 'contacts.php' ? 'text-white bg-primary-800' : '' ?>">
          Контакты
        </a>
      </nav>

      <!-- Phone & Mobile Menu Button -->
      <div class="flex items-center space-x-4">
        <a href="tel:+77771445445" class="hidden md:flex items-center space-x-2 px-4 py-2 bg-accent hover:bg-accent-dark text-white rounded-lg transition-all duration-200 transform hover:scale-105" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
          </svg>
          <span class="font-medium">+7 777 144 5445</span>
        </a>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-button lg:hidden relative w-10 h-10 flex flex-col items-center justify-center space-y-1.5 focus:outline-none" aria-label="Открыть меню" aria-expanded="false" type="button">
          <span class="block w-6 h-0.5 bg-white transition-all duration-300"></span>
          <span class="block w-6 h-0.5 bg-white transition-all duration-300"></span>
          <span class="block w-6 h-0.5 bg-white transition-all duration-300"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="mobile-menu fixed inset-0 z-40 bg-primary-900 transform translate-x-full transition-transform duration-300 ease-out lg:hidden" style="top: 80px;">
    <div class="container-custom py-8">
      <nav class="flex flex-col space-y-2" role="navigation" aria-label="Мобильная навигация">
        <a href="/" class="px-4 py-3 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 text-lg <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-white bg-primary-800' : '' ?>">
          Главная
        </a>
        <a href="/catalog.php" class="px-4 py-3 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 text-lg <?= basename($_SERVER['PHP_SELF']) == 'catalog.php' ? 'text-white bg-primary-800' : '' ?>">
          Каталог
        </a>
        <a href="/service.php" class="px-4 py-3 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 text-lg <?= basename($_SERVER['PHP_SELF']) == 'service.php' ? 'text-white bg-primary-800' : '' ?>">
          Автосервис
        </a>
        <a href="/pay.php" class="px-4 py-3 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 text-lg <?= basename($_SERVER['PHP_SELF']) == 'pay.php' ? 'text-white bg-primary-800' : '' ?>">
          Оплата / Доставка
        </a>
        <a href="/guarantees.php" class="px-4 py-3 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 text-lg <?= basename($_SERVER['PHP_SELF']) == 'guarantees.php' ? 'text-white bg-primary-800' : '' ?>">
          Гарантии
        </a>
        <a href="/contacts.php" class="px-4 py-3 text-primary-200 hover:text-white hover:bg-primary-800 rounded-lg transition-all duration-200 text-lg <?= basename($_SERVER['PHP_SELF']) == 'contacts.php' ? 'text-white bg-primary-800' : '' ?>">
          Контакты
        </a>
        <a href="tel:+77771445445" class="mt-4 px-4 py-3 bg-accent hover:bg-accent-dark text-white rounded-lg transition-all duration-200 text-center font-medium" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
          +7 777 144 5445
        </a>
      </nav>
    </div>
  </div>

  <!-- Menu Overlay -->
  <div class="menu-overlay fixed inset-0 bg-black/50 opacity-0 invisible transition-all duration-300 z-30 lg:hidden" style="top: 80px;"></div>
</header>

<style>
  /* Mobile menu animations */
  .mobile-menu-button.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
  }
  
  .mobile-menu-button.active span:nth-child(2) {
    opacity: 0;
  }
  
  .mobile-menu-button.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
  }

  .mobile-menu.open {
    transform: translateX(0);
  }

  .menu-overlay.active {
    opacity: 1;
    visibility: visible;
  }
</style>

