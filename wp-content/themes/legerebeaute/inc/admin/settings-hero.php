<?php
/**
 * Настройки героя
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_hero_settings_init()
{
   register_setting('legerebeaute_hero_settings_group', 'legerebeaute_hero_settings', 'legerebeaute_validate_hero_settings'); // Добавлен callback валидации

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
      'Изображение (десктоп)',
      'legerebeaute_render_hero_bg_desktop_field',
      'legerebeaute-hero-settings',
      'legerebeaute_hero_image'
   );

   add_settings_field(
      'bg_mobile',
      'Изображение (мобильное)',
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
   $options = get_option('legerebeaute_hero_settings', array());
   // --- Добавим миграцию данных для bg_desktop ---
   if (isset($options['bg_desktop']) && !is_array($options['bg_desktop'])) {
      $old_value = $options['bg_desktop'];
      $id = is_numeric($old_value) ? (int) $old_value : 0;
      $url = is_numeric($old_value) ? '' : $old_value; // Если значение не число, предполагаем, что это URL

      // Если ID был числом, но URL пуст, попробуем получить его
      if ($id && !$url) {
         $url = wp_get_attachment_url($id);
      }

      $options['bg_desktop'] = array(
         'id' => $id,
         'url' => esc_url_raw($url)
      );
   }
   // --- Конец миграции для bg_desktop ---

   $image_data = isset($options['bg_desktop']) ? $options['bg_desktop'] : array('id' => 0, 'url' => '');

   echo Legerebeaute_Image_Helper::render_image_field('legerebeaute_hero_settings[bg_desktop]', array(
      'value_id' => $image_data['id'],
      'value_url' => $image_data['url'],
      'label' => 'Фоновое изображение (десктоп)',
      'description' => 'Выберите изображение для фона героя на десктопах.',
   ));
}

function legerebeaute_render_hero_bg_mobile_field()
{
   $options = get_option('legerebeaute_hero_settings', array());
   // --- Добавим миграцию данных для bg_mobile ---
   if (isset($options['bg_mobile']) && !is_array($options['bg_mobile'])) {
      $old_value = $options['bg_mobile'];
      $id = is_numeric($old_value) ? (int) $old_value : 0;
      $url = is_numeric($old_value) ? '' : $old_value; // Если значение не число, предполагаем, что это URL

      // Если ID был числом, но URL пуст, попробуем получить его
      if ($id && !$url) {
         $url = wp_get_attachment_url($id);
      }

      $options['bg_mobile'] = array(
         'id' => $id,
         'url' => esc_url_raw($url)
      );
   }
   // --- Конец миграции для bg_mobile ---

   $image_data = isset($options['bg_mobile']) ? $options['bg_mobile'] : array('id' => 0, 'url' => '');

   echo Legerebeaute_Image_Helper::render_image_field('legerebeaute_hero_settings[bg_mobile]', array(
      'value_id' => $image_data['id'],
      'value_url' => $image_data['url'],
      'label' => 'Фоновое изображение (мобильное)',
      'description' => 'Выберите изображение для фона героя на мобильных устройствах.',
   ));
}

// Функция валидации для обработки данных изображений через хелпер
function legerebeaute_validate_hero_settings($input)
{
   $options = get_option('legerebeaute_hero_settings', array());

   // --- ВРЕМЕННО: Простое сохранение ID из нового формата ---
   $new_desktop_data = $input['bg_desktop'] ?? array();
   $new_mobile_data = $input['bg_mobile'] ?? array();

   // Сохраняем только ID в старом формате для теста
   $options['bg_desktop'] = absint($new_desktop_data['id'] ?? 0);
   $options['bg_mobile'] = absint($new_mobile_data['id'] ?? 0);
   // ----------------------------------------------------------

   // Валидация и сохранение других полей
   $options['title'] = sanitize_text_field($input['title'] ?? $options['title']);
   $options['subtitle'] = sanitize_text_field($input['subtitle'] ?? $options['subtitle']);
   $options['description'] = wp_kses_post($input['description'] ?? $options['description']);
   $options['booking_label'] = sanitize_text_field($input['booking_label'] ?? $options['booking_label']);

   return $options;
}

function legerebeaute_hero_settings_page()
{
   // Подключение скриптов хелпера обязательно для работы полей на странице настроек
   Legerebeaute_Image_Helper::enqueue_admin_scripts();

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