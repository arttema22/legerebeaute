<?php
/**
 * Кастомные метаполя для страницы "О студии" (ID = 4855)
 * 
 */

if (!defined('ABSPATH')) {
   exit;
}

// === 1. Добавляем метабокс только на страницу "О студии" ===
add_action('add_meta_boxes', 'legerebeaute_add_about_page_meta_box');

function legerebeaute_add_about_page_meta_box()
{
   $screen = get_current_screen();

   // Проверяем, что мы на редактировании страницы
   if ($screen->post_type !== 'page') {
      return;
   }

   // Получаем ID редактируемой страницы
   global $post;
   if ($post && $post->ID == 4855) { // ID страницы "О студии"
      add_meta_box(
         'legerebeaute_page_about_details',
         'Дополнительные поля страницы "О студии"',
         'legerebeaute_page_about_meta_box_callback',
         'page',
         'normal',
         'high'
      );
   }
}

// === 2. Вывод полей в админке ===
function legerebeaute_page_about_meta_box_callback($post)
{
   // Nonce для безопасности
   wp_nonce_field('legerebeaute_save_page_about_meta', 'legerebeaute_page_about_meta_nonce');

   $title_1 = get_post_meta($post->ID, '_legerebeaute_about_title_1', true);
   $title_2 = get_post_meta($post->ID, '_legerebeaute_about_title_2', true);
   $intro_text = get_post_meta($post->ID, '_legerebeaute_about_intro_text', true);
   $equipment_title = get_post_meta($post->ID, '_legerebeaute_about_equipment_title', true);
   $equipment_text = get_post_meta($post->ID, '_legerebeaute_about_equipment_text', true);

   ?>
   <div style="margin-bottom: 20px;">
      <label><strong>Заголовок 1:</strong></label><br>
      <input type="text" name="legerebeaute_about_title_1" value="<?php echo esc_attr($title_1); ?>" style="width:100%;">
   </div>

   <div style="margin-bottom: 20px;">
      <label><strong>Заголовок 2:</strong></label><br>
      <input type="text" name="legerebeaute_about_title_2" value="<?php echo esc_attr($title_2); ?>" style="width:100%;">
   </div>

   <div style="margin-bottom: 20px;">
      <label><strong>Вводный текст:</strong></label><br>
      <textarea name="legerebeaute_about_intro_text" rows="4"
         style="width:100%;"><?php echo esc_textarea($intro_text); ?></textarea>
   </div>

   <div style="margin-bottom: 20px;">
      <label><strong>Заголовок блока оборудования:</strong></label><br>
      <input type="text" name="legerebeaute_about_equipment_title" value="<?php echo esc_attr($equipment_title); ?>"
         style="width:100%;">
   </div>

   <div style="margin-bottom: 20px;">
      <label><strong>Текст блока оборудования:</strong></label><br>
      <?php
      wp_editor(
         $equipment_text,
         'legerebeaute_about_equipment_text',
         ['textarea_name' => 'legerebeaute_about_equipment_text', 'media_buttons' => false]
      );
      ?>
   </div>

   <!-- Здесь можно добавить больше полей по аналогии -->
   <?php
}

// === 3. Сохранение метаполей ===
add_action('save_post_page', 'legerebeaute_save_page_about_meta');

function legerebeaute_save_page_about_meta($post_id)
{
   // Проверяем nonce
   if (!isset($_POST['legerebeaute_page_about_meta_nonce']) || !wp_verify_nonce($_POST['legerebeaute_page_about_meta_nonce'], 'legerebeaute_save_page_about_meta')) {
      return;
   }

   // Проверка автосохранения
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }

   // Проверка прав пользователя
   if (!current_user_can('edit_post', $post_id)) {
      return;
   }

   // Проверяем, что это страница "О студии"
   if (get_post_type($post_id) !== 'page' || $post_id != 4855) {
      return;
   }

   // Сохраняем поля
   update_post_meta($post_id, '_legerebeaute_about_title_1', sanitize_text_field($_POST['legerebeaute_about_title_1'] ?? ''));
   update_post_meta($post_id, '_legerebeaute_about_title_2', sanitize_text_field($_POST['legerebeaute_about_title_2'] ?? ''));
   update_post_meta($post_id, '_legerebeaute_about_intro_text', sanitize_textarea_field($_POST['legerebeaute_about_intro_text'] ?? ''));
   update_post_meta($post_id, '_legerebeaute_about_equipment_title', sanitize_text_field($_POST['legerebeaute_about_equipment_title'] ?? ''));
   update_post_meta($post_id, '_legerebeaute_about_equipment_text', wp_kses_post($_POST['legerebeaute_about_equipment_text'] ?? ''));
}

// === 4. Хелпер для получения данных в шаблоне ===
if (!function_exists('legerebeaute_get_page_about_meta')) {
   function legerebeaute_get_page_about_meta($key = '', $post_id = null)
   {
      if (!$post_id) {
         $post_id = get_option('page_on_front') == 4855 ? 4855 : get_queried_object_id();
      }

      // Проверяем, что это страница "О студии"
      if ($post_id != 4855) {
         return null;
      }

      return get_post_meta($post_id, '_legerebeaute_about_' . $key, true);
   }
}