<?php
/**
 * Очистка и оптимизация WordPress
 *
 * Удаляет ненужные скрипты, метатеги, эмодзи и добавляет favicon.
 */

if (!defined('ABSPATH')) {
   exit;
}

// === Удаление ненужных метатегов и скриптов из <head> ===
remove_action('wp_head', 'rsd_link');                          // RSD link
remove_action('wp_head', 'wlwmanifest_link');                  // Windows Live Writer
remove_action('wp_head', 'rest_output_link_wp_head');          // REST API link
remove_action('wp_head', 'wp_oembed_add_discovery_links');     // oEmbed discovery
remove_action('wp_head', 'wp_generator');                      // Версия WordPress
remove_action('wp_head', 'print_emoji_detection_script', 7);   // Эмодзи (скрипт)
remove_action('wp_print_styles', 'print_emoji_styles');        // Эмодзи (стили)

// === Favicon ===
// function legerebeaute_favicon()
// {
//    echo '<link rel="icon" href="' . esc_url(get_template_directory_uri() . '/assets/images/favicon.ico') . '" type="image/x-icon">' . "\n";
// }
// add_action('wp_head', 'legerebeaute_favicon');

// === Отключение эмодзи ===
function legerebeaute_disable_emojis()
{
   remove_action('wp_head', 'print_emoji_detection_script', 7);
   remove_action('admin_print_scripts', 'print_emoji_detection_script');
   remove_action('wp_print_styles', 'print_emoji_styles');
   remove_action('admin_print_styles', 'print_emoji_styles');
   remove_filter('the_content_feed', 'wp_staticize_emoji');
   remove_filter('comment_text_rss', 'wp_staticize_emoji');
   remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
   add_filter('tiny_mce_plugins', 'legerebeaute_disable_emojis_tinymce');
}
add_action('init', 'legerebeaute_disable_emojis');

function legerebeaute_disable_emojis_tinymce($plugins)
{
   if (is_array($plugins)) {
      return array_diff($plugins, ['wpemoji']);
   }
   return [];
}

// === (Опционально) Отключить jQuery на фронтенде ===
// Раскомментируйте, если вы используете vanilla JS и не нуждаетесь в jQuery
/*
function legerebeaute_deregister_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'legerebeaute_deregister_jquery', 100);
*/