<?php
if (!defined('ABSPATH'))
   exit;

function legerebeaute_enqueue_assets()
{
   $version = wp_get_theme()->get('Version');

   // Базовые стили
   wp_enqueue_style('legerebeaute-var', get_template_directory_uri() . '/assets/css/base/variables.css', [], $version);
   wp_enqueue_style('legerebeaute-reset', get_template_directory_uri() . '/assets/css/base/reset.css', [], $version);
   wp_enqueue_style('legerebeaute-typography', get_template_directory_uri() . '/assets/css/base/typography.css', [], $version);
   wp_enqueue_style('legerebeaute-utilities', get_template_directory_uri() . '/assets/css/base/utilities.css', [], $version);

   // Макеты
   wp_enqueue_style('legerebeaute-header', get_template_directory_uri() . '/assets/css/layout/header.css', [], $version);
   wp_enqueue_style('legerebeaute-containers', get_template_directory_uri() . '/assets/css/layout/containers.css', [], $version);
   wp_enqueue_style('legerebeaute-footer', get_template_directory_uri() . '/assets/css/layout/footer.css', [], $version);

   // Компоненты
   wp_enqueue_style('legerebeaute-menu', get_template_directory_uri() . '/assets/css/components/menu.css', [], $version);
   wp_enqueue_style('legerebeaute-modal', get_template_directory_uri() . '/assets/css/components/modal.css', [], $version);
   wp_enqueue_style('legerebeaute-cards', get_template_directory_uri() . '/assets/css/components/cards.css', [], $version);
   wp_enqueue_style('legerebeaute-buttons', get_template_directory_uri() . '/assets/css/components/buttons.css', [], $version);
   wp_enqueue_style('legerebeaute-socials', get_template_directory_uri() . '/assets/css/components/socials.css', [], $version);
   wp_enqueue_style('legerebeaute-archive', get_template_directory_uri() . '/assets/css/components/archive.css', [], $version);
   wp_enqueue_style('legerebeaute-single', get_template_directory_uri() . '/assets/css/components/single.css', [], $version);
   wp_enqueue_style('legerebeaute-specialists', get_template_directory_uri() . '/assets/css/components/specialists.css', [], $version);
   wp_enqueue_style('legerebeaute-hero', get_template_directory_uri() . '/assets/css/components/hero.css', [], $version);
   wp_enqueue_style('legerebeaute-features', get_template_directory_uri() . '/assets/css/components/features.css', [], $version);
   wp_enqueue_style('legerebeaute-sociallinks', get_template_directory_uri() . '/assets/css/components/sociallinks.css', [], $version);
   wp_enqueue_style('legerebeaute-booking-form', get_template_directory_uri() . '/assets/css/components/booking-form.css', [], $version);
   wp_enqueue_style('legerebeaute-toast', get_template_directory_uri() . '/assets/css/components/toast.css', [], $version);
   wp_enqueue_style('legerebeaute-about', get_template_directory_uri() . '/assets/css/components/about.css', [], $version);

   // Основной CSS (если нужен)
   //wp_enqueue_style('legerebeaute-main', get_template_directory_uri() . '/assets/css/main.css', [], $version);

   // Swiper
   wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/base/swiper.css', [], '11.2.10');
   wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper.js', [], '11.2.10', true);


   // Скрипты
   wp_enqueue_script('legerebeaute-booking-form', get_template_directory_uri() . '/assets/js/booking-form.js', [], $version, true);
   wp_enqueue_script('legerebeaute-main', get_template_directory_uri() . '/assets/js/main.js', [], $version, true);
   wp_enqueue_script('services-archive-filter-js', get_template_directory_uri() . '/assets/js/services-archive-filter.js', [], '1.0', true);



   wp_localize_script('services-archive-filter-js', 'legerebeaute_archive_vars', array(
      'ajax_url' => admin_url('admin-ajax.php'), // Передаём URL для AJAX-запросов
      // 'nonce' => wp_create_nonce('legerebeaute_filter_nonce') // Опционально, если будете использовать nonce
   ));

   wp_enqueue_script('legerebeaute-toast', get_template_directory_uri() . '/assets/js/toast.js', [], $version, true);
}
add_action('wp_enqueue_scripts', 'legerebeaute_enqueue_assets');
