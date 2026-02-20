<?php
// wp-content/themes/legerebeaute/inc/helpers/image_helper.php

if (!class_exists('Legerebeaute_Image_Helper')) {
   class Legerebeaute_Image_Helper
   {

      public static function enqueue_admin_scripts()
      {
         wp_enqueue_media();
         wp_enqueue_script(
            'legerebeaute-universal-image-uploader',
            get_template_directory_uri() . '/assets/js/admin/universal-image-uploader.js',
            array('jquery'),
            '1.0.0',
            true
         );

         wp_localize_script('legerebeaute-universal-image-uploader', 'LegerebeauteImageHelper', array(
            'nonce' => wp_create_nonce('legerebeaute_image_upload_nonce'),
            'defaults' => array(
               'multiple' => false,
               'type' => 'image',
               'title' => 'Выберите изображение',
               'button_text' => 'Выбрать',
            )
         ));
      }

      /**
       * Генерирует HTML для поля загрузки изображения.
       *
       * @param string $field_name Имя поля (без []). Будет использовано для ID и имени скрытых полей.
       * @param array $args Аргументы конфигурации.
       * @return string HTML-код поля.
       */
      public static function render_image_field($field_name, $args = array())
      {
         $defaults = array(
            'value_id' => '', // Текущий ID изображения
            'value_url' => '', // Текущий URL изображения (опционально)
            'label' => '',
            'description' => '',
            'multiple' => false,
            'preview_size' => 'thumbnail',
            'wrapper_class' => 'legerebeaute-image-field-wrapper',
            'button_select_class' => 'legerebeaute-select-image-btn button',
            'button_remove_class' => 'legerebeaute-remove-image-btn button',
            'preview_container_class' => 'legerebeaute-image-preview-container',
            'preview_image_class' => 'legerebeaute-image-preview',
            'hidden_id_field_class' => 'legerebeaute-image-id-field',
            'hidden_url_field_class' => 'legerebeaute-image-url-field',
         );

         $args = wp_parse_args($args, $defaults);

         $image_html = '';
         if ($args['value_id']) {
            $src = wp_get_attachment_image_src($args['value_id'], $args['preview_size']);
            if ($src) {
               $image_html = '<img src="' . esc_url($src[0]) . '" class="' . esc_attr($args['preview_image_class']) . '" alt="Предпросмотр" style="max-width: 150px; height: auto;">';
            }
         }

         $output = '<div class="' . esc_attr($args['wrapper_class']) . '" data-field-name="' . esc_attr($field_name) . '" data-multiple="' . ($args['multiple'] ? 'true' : 'false') . '">';

         if ($args['label']) {
            $output .= '<label>' . esc_html($args['label']) . '</label>';
         }

         $output .= '<div class="' . esc_attr($args['preview_container_class']) . '">' . $image_html . '</div>';

         $output .= '<input type="hidden" name="' . esc_attr($field_name) . '[id]" value="' . esc_attr($args['value_id']) . '" class="' . esc_attr($args['hidden_id_field_class']) . '">';
         if ($args['value_url']) { // Если нужно хранить URL
            $output .= '<input type="hidden" name="' . esc_attr($field_name) . '[url]" value="' . esc_url($args['value_url']) . '" class="' . esc_attr($args['hidden_url_field_class']) . '">';
         }

         $output .= '<button type="button" class="' . esc_attr($args['button_select_class']) . '" data-field-name="' . esc_attr($field_name) . '">' . __('Выбрать изображение', 'legerebeaute') . '</button>';
         if ($args['value_id']) {
            $output .= '<button type="button" class="' . esc_attr($args['button_remove_class']) . '" data-field-name="' . esc_attr($field_name) . '">' . __('Удалить', 'legerebeaute') . '</button>';
         }

         if ($args['description']) {
            $output .= '<p class="description">' . esc_html($args['description']) . '</p>';
         }

         $output .= '</div>';

         return $output;
      }

      /**
       * Обрабатывает данные из POST для универсального поля изображения.
       * Пример ожидаемого $_POST[$field_name]: ['id' => 123, 'url' => '...']
       *
       * @param string $field_name Имя поля в $_POST.
       * @param array $allowed_types Разрешенные типы (по умолчанию ['image']).
       * @return array Массив с 'id' и 'url' или пустой массив.
       */
      public static function process_image_field_from_post($field_name, $allowed_types = array('image'))
      {
         $result = array('id' => 0, 'url' => '');

         if (isset($_POST[$field_name]) && is_array($_POST[$field_name])) {
            $data = $_POST[$field_name];
            $id = absint($data['id'] ?? 0);

            // Проверяем ID и тип вложения
            if ($id && self::is_attachment_of_allowed_types($id, $allowed_types)) { // Используем вспомогательный метод
               $result['id'] = $id;
               $url = wp_get_attachment_url($id);
               $result['url'] = $url ? esc_url_raw($url) : '';
            }
         }

         return $result;
      }

      /**
       * Обрабатывает данные для repeater-поля с изображениями.
       * Пример ожидаемого $_POST[$field_name]: [['id' => 123, 'url' => '...'], ['id' => 124, 'url' => '...']]
       *
       * @param string $field_name Имя repeater-поля в $_POST.
       * @param array $allowed_types Разрешенные типы (по умолчанию ['image']).
       * @return array Массив массивов ['id' => ..., 'url' => ...].
       */
      public static function process_repeater_image_field_from_post($field_name, $allowed_types = array('image'))
      {
         $result = array();

         if (isset($_POST[$field_name]) && is_array($_POST[$field_name])) {
            foreach ($_POST[$field_name] as $item_data) {
               if (is_array($item_data)) {
                  $id = absint($item_data['id'] ?? 0);
                  if ($id && self::is_attachment_of_allowed_types($id, $allowed_types)) { // Используем вспомогательный метод
                     $url = wp_get_attachment_url($id);
                     $result[] = array(
                        'id' => $id,
                        'url' => $url ? esc_url_raw($url) : ''
                     );
                  }
               }
            }
         }

         return $result;
      }

      /**
       * Вспомогательный метод для проверки типа вложения.
       *
       * @param int $attachment_id ID вложения.
       * @param array $allowed_types Массив разрешённых типов (например, ['image', 'video']).
       * @return bool True, если вложение соответствует одному из разрешённых типов, иначе False.
       */
      private static function is_attachment_of_allowed_types($attachment_id, $allowed_types)
      {
         // Проверяем, что это вообще ID вложения
         if (get_post_type($attachment_id) !== 'attachment') {
            return false;
         }

         $mime_type = get_post_mime_type($attachment_id);
         if (!$mime_type) {
            return false;
         }

         // Проверяем, соответствует ли MIME-тип одному из разрешённых
         foreach ($allowed_types as $allowed_type) {
            // Проверим, начинается ли mime_type с разрешённого типа (например, 'image/' для 'image/jpeg')
            // Или является ли он точным совпадением (например, 'image' для вложений типа 'image/')
            if (strpos($mime_type, $allowed_type . '/') === 0 || $mime_type === $allowed_type) {
               return true;
            }
         }

         return false;
      }


      /**
       * Вспомогательная функция для получения URL изображения по ID.
       * Может кэшировать результаты для оптимизации.
       */
      public static function get_image_url_by_id($id, $size = 'full')
      {
         if (!$id)
            return '';
         $src = wp_get_attachment_image_src($id, $size);
         return $src ? $src[0] : '';
      }

      // --- Дополнительные методы ---
      // Можно добавить методы для получения HTML-превью, генерации скрипта инициализации для конкретного поля и т.д.
   }
}