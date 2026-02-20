<?php
/**
 * Централизованная регистрация админ-меню
 */

if (!defined('ABSPATH'))
   exit;

function legerebeaute_register_admin_menu()
{
   // Основное меню
   add_menu_page(
      'Настройки сайта Legère Beauté',
      'Настройки сайта',
      'manage_options',
      'legerebeaute-settings',
      'legerebeaute_settings_page',
      'dashicons-admin-generic',
      30
   );

   // Подменю "Контакты"
   add_submenu_page(
      'legerebeaute-settings',
      'Общие настройки сайта',
      'Контакты',
      'manage_options',
      'legerebeaute-settings',
      'legerebeaute_settings_page'
   );

   // Подменю "Герой"
   add_submenu_page(
      'legerebeaute-settings',
      'Настройки героя',
      'Герой',
      'manage_options',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_settings_page'
   );

   // Подменю: Детокс-тест
   add_submenu_page(
      'legerebeaute-settings',
      'Детокс-тест',
      'Детокс-тест',
      'manage_options',
      'legerebeaute-detox-test',
      'legerebeaute_detox_test_settings_page'
   );

   // Подменю: О компании
   add_submenu_page(
      'legerebeaute-settings',
      'О компании',
      'О компании',
      'manage_options',
      'legerebeaute-about-settings',
      'legerebeaute_render_about_settings_page'
   );

   // Подменю: Наши ценности
   add_submenu_page(
      'legerebeaute-settings',
      'Наши ценности',
      'Наши ценности',
      'manage_options',
      'legerebeaute-values',
      'legerebeaute_values_settings_page'
   );

   // Подменю: Интерьер студии
   add_submenu_page(
      'legerebeaute-settings',
      'Интерьер студии',
      'Интерьер студии',
      'manage_options',
      'legerebeaute-interior',
      'legerebeaute_interior_settings_page'
   );

}
add_action('admin_menu', 'legerebeaute_register_admin_menu');