<?php
/**
 * Базовая настройка темы
 *
 * Регистрация поддержки функций WordPress, меню, миниатюр и т.д.
 */

if (!defined('ABSPATH')) {
   exit; // Запрет прямого доступа
}

/**
 * Настройка темы при инициализации
 */
function legerebeaute_theme_setup()
{
   // Поддержка title tag (управление <title> через WordPress)
   add_theme_support('title-tag');

   // Поддержка миниатюр записей (featured images)
   add_theme_support('post-thumbnails');

   // Поддержка HTML5 для форм и медиа
   add_theme_support('html5', [
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
   ]);

   // Поддержка кастомного логотипа (опционально, если понадобится)
   add_theme_support('custom-logo', [
      'height' => 200,
      'width' => 600,
      'flex-height' => true,
      'flex-width' => true,
      'header-text' => ['site-title', 'site-description'],
   ]);

   // Регистрация навигационных меню
   register_nav_menus([
      'main-menu' => esc_html__('Основное меню', 'legerebeaute'),
      'footer_menu_1' => esc_html__('Нижнее меню 1', 'legerebeaute'),
      'footer_menu_2' => esc_html__('Нижнее меню 2', 'legerebeaute'),
      'footer_menu_3' => esc_html__('Нижнее меню 3', 'legerebeaute'),
   ]);
}
add_action('after_setup_theme', 'legerebeaute_theme_setup');