/**
 * Main JavaScript file
 * Vanilla JS only - no jQuery dependency
 */

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
  initPageLoad();
  initScrollAnimations();
  initMobileMenu();
  initForms();
  initDropdowns();
  initLazyLoading();
});

/**
 * Плавное появление страницы
 */
function initPageLoad() {
  setTimeout(() => {
    document.body.classList.add('page-loaded');
  }, 50);
}

/**
 * Анимации появления элементов при скролле
 * Использует Intersection Observer для производительности
 */
function initScrollAnimations() {
  if (!('IntersectionObserver' in window)) {
    // Fallback для старых браузеров
    document.querySelectorAll('.reveal').forEach(el => {
      el.classList.add('revealed');
    });
    return;
  }

  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px',
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.reveal').forEach(el => {
    observer.observe(el);
  });
}

/**
 * Мобильное меню
 */
function initMobileMenu() {
  const menuButton = document.querySelector('.mobile-menu-button');
  const menu = document.querySelector('.mobile-menu');
  const overlay = document.querySelector('.menu-overlay');

  if (!menuButton || !menu) return;

  menuButton.addEventListener('click', () => {
    const isOpen = menu.classList.contains('open');
    
    if (isOpen) {
      closeMobileMenu(menu, menuButton, overlay);
    } else {
      openMobileMenu(menu, menuButton, overlay);
    }
  });

  // Закрытие по клику на overlay
  if (overlay) {
    overlay.addEventListener('click', () => {
      closeMobileMenu(menu, menuButton, overlay);
    });
  }

  // Закрытие по ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && menu.classList.contains('open')) {
      closeMobileMenu(menu, menuButton, overlay);
    }
  });

  // Закрытие при клике на ссылку
  menu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      setTimeout(() => closeMobileMenu(menu, menuButton, overlay), 100);
    });
  });
}

function openMobileMenu(menu, button, overlay) {
  menu.classList.add('open');
  button.classList.add('active');
  if (overlay) overlay.classList.add('active');
  button.setAttribute('aria-expanded', 'true');
  document.body.style.overflow = 'hidden';
}

function closeMobileMenu(menu, button, overlay) {
  menu.classList.remove('open');
  button.classList.remove('active');
  if (overlay) overlay.classList.remove('active');
  button.setAttribute('aria-expanded', 'false');
  document.body.style.overflow = '';
}

/**
 * Обработка форм
 */
function initForms() {
  // Форма обратной связи
  const consultForms = document.querySelectorAll('.consult-form, .callback-form');
  
  consultForms.forEach(form => {
    form.addEventListener('submit', handleFormSubmit);
  });
}

async function handleFormSubmit(e) {
  e.preventDefault();
  
  const form = e.target;
  const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
  const originalText = submitButton?.textContent || 'Отправить';
  
  // Валидация
  const nameInput = form.querySelector('input[name="name"]');
  const phoneInput = form.querySelector('input[name="phon"], input[name="phone"]');
  
  if (!nameInput?.value.trim() || !phoneInput?.value.trim()) {
    showFormError(form, 'Пожалуйста, заполните все обязательные поля');
    return;
  }

  // Блокируем кнопку
  if (submitButton) {
    submitButton.disabled = true;
    submitButton.textContent = 'Отправка...';
  }

  try {
    const formData = new FormData(form);
    formData.append('form_time', Math.floor(Date.now() / 1000));
    
    const response = await fetch('/send_form.php', {
      method: 'POST',
      body: formData,
    });

    const result = await response.json();

    if (!result.error) {
      showFormSuccess(form, result.message || 'Спасибо! Мы свяжемся с вами в ближайшее время.');
      
      // Google Analytics событие
      if (typeof gtag === 'function') {
        gtag('event', 'conversion', {
          'send_to': 'AW-17661940869/u-y4CIO6zLQbEIWp7-VB',
        });
      }
    } else {
      showFormError(form, result.message || 'Произошла ошибка. Попробуйте позже.');
    }
  } catch (error) {
    showFormError(form, 'Произошла ошибка. Попробуйте позже.');
  } finally {
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.textContent = originalText;
    }
  }
}

function showFormSuccess(form, message) {
  const successDiv = document.createElement('div');
  successDiv.className = 'bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mt-4';
  successDiv.textContent = message;
  form.appendChild(successDiv);
  
  // Удаляем через 5 секунд
  setTimeout(() => {
    successDiv.remove();
  }, 5000);
}

function showFormError(form, message) {
  const errorDiv = document.createElement('div');
  errorDiv.className = 'bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mt-4';
  errorDiv.textContent = message;
  form.appendChild(errorDiv);
  
  // Удаляем через 5 секунд
  setTimeout(() => {
    errorDiv.remove();
  }, 5000);
}

/**
 * Выпадающие списки для фильтров
 */
function initDropdowns() {
  const dropdowns = document.querySelectorAll('.dropdown');
  
  dropdowns.forEach(dropdown => {
    const trigger = dropdown.querySelector('.dropdown-trigger');
    const menu = dropdown.querySelector('.dropdown-menu');
    
    if (!trigger || !menu) return;

    // Проверка доступности поля
    const hiddenInput = trigger.querySelector('input[type="hidden"]');
    const fieldName = hiddenInput?.name;
    
    // Блокировка зависимых полей
    if (fieldName === 'ml' || fieldName === 'yr') {
      updateFieldAvailability(dropdown, fieldName);
    }

    trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      
      // Проверка валидации
      if (fieldName === 'ml') {
        const markValue = document.querySelector('input[name="mk"]')?.value;
        if (!markValue || markValue === '') {
          showFieldError(trigger, 'Сначала выберите марку');
          return;
        }
      } else if (fieldName === 'yr') {
        const modelValue = document.querySelector('input[name="ml"]')?.value;
        if (!modelValue || modelValue === '') {
          showFieldError(trigger, 'Сначала выберите модель');
          return;
        }
      }
      
      toggleDropdown(dropdown);
    });

    // Обработка выбора элемента
    menu.querySelectorAll('.dropdown-item').forEach(item => {
      item.addEventListener('click', function(e) {
        e.stopPropagation();
        selectDropdownItem(dropdown, this);
      });
    });

    // Закрытие при клике вне
    document.addEventListener('click', (e) => {
      if (!dropdown.contains(e.target)) {
        closeDropdown(dropdown);
      }
    });
  });

  // Обновление доступности полей при изменении марки/модели
  document.addEventListener('change', (e) => {
    if (e.target.name === 'mk') {
      updateDependentFields('ml');
      clearField('ml');
      clearField('yr');
    } else if (e.target.name === 'ml') {
      updateDependentFields('yr');
      clearField('yr');
    }
  });
}

function updateFieldAvailability(dropdown, fieldName) {
  const trigger = dropdown.querySelector('.dropdown-trigger');
  
  if (fieldName === 'ml') {
    const markValue = document.querySelector('input[name="mk"]')?.value;
    if (!markValue || markValue === '') {
      trigger.disabled = true;
      trigger.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
      trigger.disabled = false;
      trigger.classList.remove('opacity-50', 'cursor-not-allowed');
    }
  } else if (fieldName === 'yr') {
    const modelValue = document.querySelector('input[name="ml"]')?.value;
    if (!modelValue || modelValue === '') {
      trigger.disabled = true;
      trigger.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
      trigger.disabled = false;
      trigger.classList.remove('opacity-50', 'cursor-not-allowed');
    }
  }
}

function updateDependentFields(fieldName) {
  const dropdown = document.querySelector(`input[name="${fieldName}"]`)?.closest('.dropdown');
  if (dropdown) {
    updateFieldAvailability(dropdown, fieldName);
  }
}

function clearField(fieldName) {
  const dropdown = document.querySelector(`input[name="${fieldName}"]`)?.closest('.dropdown');
  if (dropdown) {
    const trigger = dropdown.querySelector('.dropdown-trigger');
    const selectedValue = trigger.querySelector('.selected-value');
    const hiddenInput = trigger.querySelector('input[type="hidden"]');
    
    selectedValue.textContent = fieldName === 'ml' ? 'Модель' : 'Год';
    hiddenInput.value = '';
  }
}

function selectDropdownItem(dropdown, item) {
  const trigger = dropdown.querySelector('.dropdown-trigger');
  const hiddenInput = trigger.querySelector('input[type="hidden"]');
  const selectedValue = trigger.querySelector('.selected-value');
  
  selectedValue.textContent = item.dataset.value;
  hiddenInput.value = item.dataset.value;
  
  // Триггерим событие change для обновления зависимых полей
  hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
  
  closeDropdown(dropdown);

  // Загрузка зависимых данных через AJAX
  const fieldName = hiddenInput.name;
  if (fieldName === 'mk') {
    loadModels(item.dataset.id);
  } else if (fieldName === 'ml') {
    loadYears(item.dataset.id);
  }
}

function loadModels(markId) {
  fetch('/getf.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `tex=${markId}&typ=2`
  })
  .then(r => r.json())
  .then(data => {
    const modelList = document.getElementById('modellist');
    if (modelList && data.report) {
      modelList.innerHTML = data.report;
      // Re-attach event listeners
      modelList.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.stopPropagation();
          const dropdown = this.closest('.dropdown');
          selectDropdownItem(dropdown, this);
        });
      });
      updateDependentFields('ml');
    }
  })
  .catch(err => console.error('Error loading models:', err));
}

function loadYears(modelId) {
  fetch('/getf.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `tex=${modelId}&typ=3`
  })
  .then(r => r.json())
  .then(data => {
    const yearList = document.getElementById('yearlist');
    if (yearList && data.report) {
      yearList.innerHTML = data.report;
      // Re-attach event listeners
      yearList.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.stopPropagation();
          const dropdown = this.closest('.dropdown');
          selectDropdownItem(dropdown, this);
        });
      });
      updateDependentFields('yr');
    }
  })
  .catch(err => console.error('Error loading years:', err));
}

function showFieldError(trigger, message) {
  trigger.style.animation = 'shake 0.5s ease';
  setTimeout(() => {
    trigger.style.animation = '';
  }, 500);
  
  // Можно добавить tooltip с сообщением
  console.warn(message);
}

function toggleDropdown(dropdown) {
  const isOpen = dropdown.classList.contains('open');
  
  // Закрываем все остальные
  document.querySelectorAll('.dropdown.open').forEach(d => {
    if (d !== dropdown) closeDropdown(d);
  });

  if (isOpen) {
    closeDropdown(dropdown);
  } else {
    openDropdown(dropdown);
  }
}

function openDropdown(dropdown) {
  dropdown.classList.add('open');
  const menu = dropdown.querySelector('.dropdown-menu');
  if (menu) {
    menu.style.display = 'block';
    setTimeout(() => menu.classList.add('open'), 10);
  }
}

function closeDropdown(dropdown) {
  dropdown.classList.remove('open');
  const menu = dropdown.querySelector('.dropdown-menu');
  if (menu) {
    menu.classList.remove('open');
    setTimeout(() => menu.style.display = 'none', 300);
  }
}

/**
 * Lazy loading для изображений
 */
function initLazyLoading() {
  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          const src = img.dataset.src || img.dataset.bgSrc;
          
          if (src) {
            if (img.dataset.bgSrc) {
              // Background image
              img.style.backgroundImage = `url(${src})`;
              img.classList.add('bg-loaded');
            } else {
              // Regular image
              img.src = src;
              img.classList.add('loaded');
            }
            
            img.removeAttribute('data-src');
            img.removeAttribute('data-bg-src');
            observer.unobserve(img);
          }
        }
      });
    }, {
      rootMargin: '200px 0px',
    });

    document.querySelectorAll('img[data-src], [data-bg-src]').forEach(img => {
      imageObserver.observe(img);
    });
  }
}

