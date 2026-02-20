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
   // Подключение скриптов хелпера обязательно для работы полей на странице настроек
   Legerebeaute_Image_Helper::enqueue_admin_scripts();

   if (!current_user_can('manage_options')) {
      return;
   }

   // --- Определяем $defaults до условия if ---
   $defaults = array(
      'title' => 'О компании',
      'text' => '',
      'image_1' => array('id' => 0, 'url' => ''), // Теперь гарантируется массив
      'image_2' => array('id' => 0, 'url' => ''), // Теперь гарантируется массив
      'page_link' => '',
      'button_text' => 'Больше о нас',
      'form_shortcode' => ''
   );
   // --- Конец определения $defaults ---

   // Обработка сохранения
   if (isset($_POST['legerebeaute_about_settings_nonce']) && wp_verify_nonce($_POST['legerebeaute_about_settings_nonce'], 'legerebeaute_about_settings')) {
      $data = array(
         'title' => sanitize_text_field($_POST['title'] ?? ''),
         'text' => wp_kses_post($_POST['text'] ?? ''),
         // Обработка изображений через хелпер
         'image_1' => Legerebeaute_Image_Helper::process_image_field_from_post('image_1'),
         'image_2' => Legerebeaute_Image_Helper::process_image_field_from_post('image_2'),
         'page_link' => esc_url_raw($_POST['page_link'] ?? ''),
         'button_text' => sanitize_text_field($_POST['button_text'] ?? ''),
         'form_shortcode' => sanitize_text_field($_POST['form_shortcode'] ?? '')
      );

      update_option('legerebeaute_about_settings', $data);
      add_settings_error('legerebeaute_about_settings', 'settings_updated', 'Настройки сохранены.', 'updated');
      
      // Подготовим $settings для отображения с только что сохранёнными значениями
      // Используем $data и $defaults, которые доступны в этой области
      $settings = wp_parse_args($data, $defaults);
   } else {
       // Если сохранения не было, получаем данные из базы
       $settings = get_option('legerebeaute_about_settings', array());
       $settings = wp_parse_args($settings, $defaults); // Используем $defaults, определённый выше

       // --- Добавим миграцию данных ---
       // Проверяем, являются ли image_1 и image_2 строками (старый формат)
       foreach (['image_1', 'image_2'] as $img_key) {
           if (isset($settings[$img_key]) && is_string($settings[$img_key])) {
               // Предполагаем, что строка - это URL
               $url = $settings[$img_key];
               $id = isset($settings[$img_key . '_id']) && is_numeric($settings[$img_key . '_id']) ? (int)$settings[$img_key . '_id'] : 0;

               // Получаем URL из ID, если ID валидный и URL пуст
               if ($id && !$url) {
                   $url = wp_get_attachment_url($id);
               }

               // Заменяем строку на массив
               $settings[$img_key] = array(
                   'id' => $id,
                   'url' => esc_url_raw($url) // Санитизируем URL
               );

               // Удаляем старое поле ID, если оно было
               unset($settings[$img_key . '_id']);
           } elseif (!isset($settings[$img_key]) || !is_array($settings[$img_key])) {
               // Если ключа нет или значение не массив, устанавливаем по умолчанию
               $settings[$img_key] = $defaults[$img_key];
           }
       }
       // --- Конец миграции ---
   }

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
                   <?php
                   echo Legerebeaute_Image_Helper::render_image_field('image_1', array(
                       'value_id' => $settings['image_1']['id'],
                       'value_url' => $settings['image_1']['url'],
                       'label' => 'Изображение 1',
                       'description' => 'Выберите первое изображение для блока "О компании".',
                   ));
                   ?>
               </td>
            </tr>

            <tr>
               <th scope="row">Изображение 2</th>
               <td>
                   <?php
                   echo Legerebeaute_Image_Helper::render_image_field('image_2', array(
                       'value_id' => $settings['image_2']['id'],
                       'value_url' => $settings['image_2']['url'],
                       'label' => 'Изображение 2',
                       'description' => 'Выберите второе изображение для блока "О компании".',
                   ));
                   ?>
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
   <?php
}