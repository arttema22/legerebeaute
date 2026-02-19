<?php
/**
 * Настройки героя
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_hero_settings_init()
{
   register_setting('legerebeaute_hero_settings_group', 'legerebeaute_hero_settings');

   add_settings_section(
      'legerebeaute_hero_content',
      'Контент героя',
      null,
      'legerebeaute-hero-settings'
   );

   add_settings_field(
      'title',
      'Заголовок (h1)',
      'legerebeaute_render_hero_title_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_content'
   );

   add_settings_field(
      'subtitle',
      'Подзаголовок (h2)',
      'legerebeaute_render_hero_subtitle_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_content'
   );

   add_settings_field(
      'description',
      'Описание',
      'legerebeaute_render_hero_description_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_content'
   );

   add_settings_field(
      'booking_label',
      'Текст кнопки "Онлайн-запись"',
      'legerebeaute_render_hero_booking_label_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_content'
   );

   add_settings_section(
      'legerebeaute_hero_image',
      'Фоновое изображение',
      null,
      'legerebeaute-hero-settings'
   );

   add_settings_field(
      'bg_desktop',
      'Изображение (десктоп, ID)',
      'legerebeaute_render_hero_bg_desktop_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_image'
   );

   add_settings_field(
      'bg_mobile',
      'Изображение (мобильное, ID)',
      'legerebeaute_render_hero_bg_mobile_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_image'
   );
}
add_action('admin_init', 'legerebeaute_hero_settings_init');

function legerebeaute_render_hero_title_field()
{
   $options = get_option('legerebeaute_hero_settings');
   printf(
      '<input type="text" name="legerebeaute_hero_settings[title]" value="%s" class="large-text">',
      esc_attr($options['title'] ?? 'Студия детокса')
   );
}

function legerebeaute_render_hero_subtitle_field()
{
   $options = get_option('legerebeaute_hero_settings');
   printf(
      '<input type="text" name="legerebeaute_hero_settings[subtitle]" value="%s" class="large-text">',
      esc_attr($options['subtitle'] ?? 'LégÈre beauté')
   );
}

function legerebeaute_render_hero_description_field()
{
   $options = get_option('legerebeaute_hero_settings');
   printf(
      '<textarea name="legerebeaute_hero_settings[description]" rows="4" class="large-text">%s</textarea>',
      esc_textarea($options['description'] ?? 'Мы создали премиальное пространство, где наука детоксикации и искусство заботы работают вместе, чтобы вернуть вам природную энергию и сияние, освободив от токсической нагрузки современной жизни.')
   );
}

function legerebeaute_render_hero_booking_label_field()
{
   $options = get_option('legerebeaute_hero_settings');
   printf(
      '<input type="text" name="legerebeaute_hero_settings[booking_label]" value="%s" class="regular-text">',
      esc_attr($options['booking_label'] ?? 'Онлайн-запись')
   );
}

function legerebeaute_render_hero_bg_desktop_field()
{
   $options = get_option('legerebeaute_hero_settings');
   printf(
      '<input type="number" name="legerebeaute_hero_settings[bg_desktop]" value="%s" class="small-text" placeholder="ID изображения">',
      esc_attr($options['bg_desktop'] ?? '')
   );
   echo '<p class="description">ID изображения из медиатеки для десктопов (ширина ≥768px). Чтобы узнать ID — откройте изображение в медиатеке и посмотрите URL: <code>?post=123</code></p>';
}

function legerebeaute_render_hero_bg_mobile_field()
{
   $options = get_option('legerebeaute_hero_settings');
   printf(
      '<input type="number" name="legerebeaute_hero_settings[bg_mobile]" value="%s" class="small-text" placeholder="ID изображения">',
      esc_attr($options['bg_mobile'] ?? '')
   );
   echo '<p class="description">ID изображения из медиатеки для мобильных устройств.</p>';
}

function legerebeaute_hero_settings_page()
{
   ?>
   <div class="wrap">
      <h1>Настройки героя</h1>
      <form action="options.php" method="post">
         <?php
         settings_fields('legerebeaute_hero_settings_group');
         do_settings_sections('legerebeaute-hero-settings');
         submit_button();
         ?>
      </form>
   </div>
   <?php
}