<?php
/**
 * Настройки блока "О компании" для главной страницы
 */

if (!defined('ABSPATH')) {
   exit;
}

/**
 * Рендер страницы настроек
 */
function legerebeaute_render_about_settings_page()
{
   if (!current_user_can('manage_options')) {
      return;
   }

   // Обработка сохранения
   if (isset($_POST['legerebeaute_about_settings_nonce']) && wp_verify_nonce($_POST['legerebeaute_about_settings_nonce'], 'legerebeaute_about_settings')) {
      $data = array(
         'title' => sanitize_text_field($_POST['title'] ?? ''),
         'text' => wp_kses_post($_POST['text'] ?? ''),
         'image_1' => esc_url_raw($_POST['image_1'] ?? ''),
         'image_1_id' => absint($_POST['image_1_id'] ?? 0),
         'image_2' => esc_url_raw($_POST['image_2'] ?? ''),
         'image_2_id' => absint($_POST['image_2_id'] ?? 0),
         'page_link' => esc_url_raw($_POST['page_link'] ?? ''),
         'button_text' => sanitize_text_field($_POST['button_text'] ?? ''),
         'form_shortcode' => sanitize_text_field($_POST['form_shortcode'] ?? '')
      );

      update_option('legerebeaute_about_settings', $data);
      add_settings_error('legerebeaute_about_settings', 'settings_updated', 'Настройки сохранены.', 'updated');
   }

   $settings = get_option('legerebeaute_about_settings', array());
   $settings = wp_parse_args($settings, array(
      'title' => 'О компании',
      'text' => '',
      'image_1' => '',
      'image_1_id' => 0,
      'image_2' => '',
      'image_2_id' => 0,
      'page_link' => '',
      'button_text' => 'Больше о нас',
      'form_shortcode' => ''
   ));
   ?>
   <div class="wrap">
      <h1>Настройки блока «О компании»</h1>
      <?php settings_errors('legerebeaute_about_settings'); ?>

      <form method="post" action="">
         <?php wp_nonce_field('legerebeaute_about_settings', 'legerebeaute_about_settings_nonce'); ?>

         <table class="form-table" role="presentation">
            <tr>
               <th scope="row"><label for="title">Заголовок блока</label></th>
               <td>
                  <input type="text" id="title" name="title" value="<?php echo esc_attr($settings['title']); ?>"
                     class="regular-text">
               </td>
            </tr>

            <tr>
               <th scope="row"><label for="text">Текст блока</label></th>
               <td>
                  <?php
                  wp_editor(
                     $settings['text'],
                     'about_text',
                     array(
                        'textarea_name' => 'text',
                        'textarea_rows' => 10,
                        'media_buttons' => false,
                        'teeny' => false,
                        'quicktags' => false,
                        'tinymce' => array(
                           'toolbar1' => 'bold,italic,underline,link,unlink,bullist,numlist,undo,redo',
                           'toolbar2' => ''
                        )
                     )
                  );
                  ?>
               </td>
            </tr>

            <tr>
               <th scope="row">Изображение 1</th>
               <td>
                  <div class="legerebeaute-media-field">
                     <img src="<?php echo esc_url($settings['image_1']); ?>"
                        class="legerebeaute-preview-image <?php echo empty($settings['image_1']) ? 'hidden' : ''; ?>"
                        style="max-width: 200px; margin-bottom: 10px;">
                     <input type="hidden" id="image_1" name="image_1" value="<?php echo esc_url($settings['image_1']); ?>">
                     <input type="hidden" id="image_1_id" name="image_1_id"
                        value="<?php echo esc_attr($settings['image_1_id']); ?>">
                     <button type="button" class="button legerebeaute-upload-btn" data-field="image_1">Выбрать
                        изображение</button>
                     <button type="button"
                        class="button legerebeaute-remove-btn <?php echo empty($settings['image_1']) ? 'hidden' : ''; ?>"
                        data-field="image_1">Удалить</button>
                  </div>
               </td>
            </tr>

            <tr>
               <th scope="row">Изображение 2</th>
               <td>
                  <div class="legerebeaute-media-field">
                     <img src="<?php echo esc_url($settings['image_2']); ?>"
                        class="legerebeaute-preview-image <?php echo empty($settings['image_2']) ? 'hidden' : ''; ?>"
                        style="max-width: 200px; margin-bottom: 10px;">
                     <input type="hidden" id="image_2" name="image_2" value="<?php echo esc_url($settings['image_2']); ?>">
                     <input type="hidden" id="image_2_id" name="image_2_id"
                        value="<?php echo esc_attr($settings['image_2_id']); ?>">
                     <button type="button" class="button legerebeaute-upload-btn" data-field="image_2">Выбрать
                        изображение</button>
                     <button type="button"
                        class="button legerebeaute-remove-btn <?php echo empty($settings['image_2']) ? 'hidden' : ''; ?>"
                        data-field="image_2">Удалить</button>
                  </div>
               </td>
            </tr>

            <tr>
               <th scope="row"><label for="page_link">Ссылка на страницу «О студии»</label></th>
               <td>
                  <input type="url" id="page_link" name="page_link" value="<?php echo esc_url($settings['page_link']); ?>"
                     class="regular-text">
                  <p class="description">URL страницы с подробной информацией о студии</p>
               </td>
            </tr>

            <tr>
               <th scope="row"><label for="button_text">Текст кнопки</label></th>
               <td>
                  <input type="text" id="button_text" name="button_text"
                     value="<?php echo esc_attr($settings['button_text']); ?>" class="regular-text">
                  <p class="description">Например: «Больше о нас»</p>
               </td>
            </tr>

            <tr>
               <th scope="row"><label for="form_shortcode">Шорткод формы CF7</label></th>
               <td>
                  <input type="text" id="form_shortcode" name="form_shortcode"
                     value="<?php echo esc_attr($settings['form_shortcode']); ?>" class="regular-text">
                  <p class="description">Пример: <code>[contact-form-7 id="123" title="Запись"]</code></p>
               </td>
            </tr>
         </table>

         <?php submit_button('Сохранить настройки'); ?>
      </form>
   </div>

   <script>
      jQuery(document).ready(function ($) {
         // Медиа-фрейм для выбора изображений
         var legerebeaute_media_frame;

         $('.legerebeaute-upload-btn').on('click', function (e) {
            e.preventDefault();

            var $btn = $(this);
            var field = $btn.data('field');
            var $preview = $btn.closest('.legerebeaute-media-field').find('.legerebeaute-preview-image');
            var $input = $('#' + field);
            var $idInput = $('#' + field + '_id');

            // Если фрейм уже существует, открываем его
            if (legerebeaute_media_frame) {
               legerebeaute_media_frame.open();
               return;
            }

            // Создаем новый фрейм
            legerebeaute_media_frame = wp.media.frames.legerebeauteMedia = wp.media({
               title: 'Выберите изображение',
               button: {
                  text: 'Использовать это изображение'
               },
               multiple: false
            });

            // При выборе изображения
            legerebeaute_media_frame.on('select', function () {
               var attachment = legerebeaute_media_frame.state().get('selection').first().toJSON();

               $input.val(attachment.url);
               $idInput.val(attachment.id);
               $preview.attr('src', attachment.url).removeClass('hidden');
               $btn.siblings('.legerebeaute-remove-btn').removeClass('hidden');
            });

            legerebeaute_media_frame.open();
         });

         // Удаление изображения
         $('.legerebeaute-remove-btn').on('click', function (e) {
            e.preventDefault();

            var $btn = $(this);
            var field = $btn.data('field');
            var $preview = $btn.closest('.legerebeaute-media-field').find('.legerebeaute-preview-image');
            var $input = $('#' + field);
            var $idInput = $('#' + field + '_id');

            $input.val('');
            $idInput.val('');
            $preview.attr('src', '').addClass('hidden');
            $btn.addClass('hidden');
         });
      });
   </script>
   <style>
      .legerebeaute-media-field {
         margin: 10px 0;
      }

      .legerebeaute-preview-image.hidden {
         display: none;
      }

      .legerebeaute-remove-btn.hidden {
         display: none;
      }
   </style>
   <?php
}