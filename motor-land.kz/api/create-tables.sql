-- SQL скрипт для создания таблиц для заявок на цену и вопросов
-- Выполните этот скрипт в вашей базе данных

-- Таблица для запросов цены
CREATE TABLE IF NOT EXISTS `product_price_requests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT(11) NOT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `date` DATETIME NOT NULL,
  `ip` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'new' COMMENT 'new, processed, archived',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_product_id` (`product_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица для вопросов о товарах
CREATE TABLE IF NOT EXISTS `product_questions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT(11) NOT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `question` TEXT NOT NULL,
  `date` DATETIME NOT NULL,
  `ip` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'new' COMMENT 'new, answered, archived',
  `answer` TEXT DEFAULT NULL,
  `answered_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_product_id` (`product_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
