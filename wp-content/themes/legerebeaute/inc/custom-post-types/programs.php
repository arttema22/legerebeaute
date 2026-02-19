<?php
/**
 * CPT "Комплексные программы" + таксономия "Метки программ" + метаполя
 */

if (!defined('ABSPATH')) {
   exit;
}

// === 1. Регистрация CPT "programs" ===
function legerebeaute_register_programs_cpt()
{
   $labels = [
      'name' => _x('Комплексные программы', 'Post type general name', 'legerebeaute'),
      'singular_name' => _x('Программа', 'Post type singular name', 'legerebeaute'),
      'menu_name' => _x('Программы', 'Admin Menu text', 'legerebeaute'),
      'name_admin_bar' => _x('Программа', 'Add New on Toolbar', 'legerebeaute'),
      'add_new' => __('Добавить новую', 'legerebeaute'),
      'add_new_item' => __('Добавить новую программу', 'legerebeaute'),
      'new_item' => __('Новая программа', 'legerebeaute'),
      'edit_item' => __('Редактировать программу', 'legerebeaute'),
      'view_item' => __('Просмотр программы', 'legerebeaute'),
      'all_items' => __('Все программы', 'legerebeaute'),
      'search_items' => __('Искать программы', 'legerebeaute'),
      'not_found' => __('Программ не найдено.', 'legerebeaute'),
      'not_found_in_trash' => __('В корзине программ нет.', 'legerebeaute'),
   ];

   $args = [
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'programs'],
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-list-view',
      'supports' => ['title', 'editor', 'thumbnail'],
   ];

   register_post_type('programs', $args);
}
add_action('init', 'legerebeaute_register_programs_cpt');

// === 2. Регистрация таксономии "program_tag" ===
function legerebeaute_register_program_tag()
{
   $labels = [
      'name' => _x('Метки программ', 'taxonomy general name', 'legerebeaute'),
      'singular_name' => _x('Метка программы', 'taxonomy singular name', 'legerebeaute'),
      'search_items' => __('Искать метки', 'legerebeaute'),
      'all_items' => __('Все метки', 'legerebeaute'),
      'edit_item' => __('Редактировать метку', 'legerebeaute'),
      'update_item' => __('Обновить метку', 'legerebeaute'),
      'add_new_item' => __('Добавить новую метку', 'legerebeaute'),
      'new_item_name' => __('Новое имя метки', 'legerebeaute'),
      'menu_name' => __('Метки программ', 'legerebeaute'),
   ];

   $args = [
      'hierarchical' => false,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'program-tag'],
   ];

   register_taxonomy('program_tag', ['programs'], $args);
}
add_action('init', 'legerebeaute_register_program_tag', 0);

// === 3. Метабокс для полей программы ===
function legerebeaute_add_program_meta_box()
{
   add_meta_box(
      'legerebeaute_program_details',
      'Детали программы',
      'legerebeaute_program_meta_box_callback',
      'programs',
      'normal',
      'high'
   );
}
add_action('add_meta_boxes', 'legerebeaute_add_program_meta_box');

// === 4. Вывод полей в админке ===
function legerebeaute_program_meta_box_callback($post)
{
   wp_nonce_field('legerebeaute_save_program_meta', 'legerebeaute_program_meta_nonce');

   $short_description = get_post_meta($post->ID, '_legerebeaute_short_description', true);
   $duration_text = get_post_meta($post->ID, '_legerebeaute_duration_text', true);
   $procedures_count = get_post_meta($post->ID, '_legerebeaute_procedures_count', true);
   $price_current = get_post_meta($post->ID, '_legerebeaute_price_current', true);
   $price_old = get_post_meta($post->ID, '_legerebeaute_price_old', true);
   $what_included = get_post_meta($post->ID, '_legerebeaute_what_included', true);
   $cta_label = get_post_meta($post->ID, '_legerebeaute_cta_label', true);
   $cta_url = get_post_meta($post->ID, '_legerebeaute_cta_url', true);
   ?>
   <p>
      <label>Краткое описание:</label><br>
      <textarea name="legerebeaute_short_description" rows="3"
         style="width: 100%;"><?php echo esc_textarea($short_description); ?></textarea>
   </p>

   <p>
      <label>Длительность:</label><br>
      <input type="text" name="legerebeaute_duration_text" value="<?php echo esc_attr($duration_text); ?>"
         placeholder="7 дней" style="width: 200px;">
   </p>

   <p>
      <label>Количество процедур:</label><br>
      <input type="text" name="legerebeaute_procedures_count" value="<?php echo esc_attr($procedures_count); ?>"
         placeholder="3 процедуры" style="width: 200px;">
   </p>

   <p>
      <label>Цены:</label><br>
      Текущая: <input type="text" name="legerebeaute_price_current" value="<?php echo esc_attr($price_current); ?>"
         placeholder="15 000"> ₽<br>
      Старая: <input type="text" name="legerebeaute_price_old" value="<?php echo esc_attr($price_old); ?>"
         placeholder="18 000"> ₽
   </p>

   <p>
      <label>Что включено (по одному на строку):</label><br>
      <textarea name="legerebeaute_what_included" rows="4" style="width: 100%;"><?php
      if ($what_included) {
         echo esc_textarea(implode("\n", $what_included));
      }
      ?></textarea>
      <small>Пример:<br>Консультация врача<br>3 процедуры детокса<br>Индивидуальный план питания</small>
   </p>

   <p>
      <label>CTA кнопка:</label><br>
      Текст: <input type="text" name="legerebeaute_cta_label" value="<?php echo esc_attr($cta_label); ?>"
         placeholder="Записаться"><br>
      Ссылка: <input type="url" name="legerebeaute_cta_url" value="<?php echo esc_url($cta_url); ?>" style="width: 100%;"
         placeholder="https://yclients.com/...">
   </p>
   <?php
}

// === 5. Сохранение метаполей ===
function legerebeaute_save_program_meta($post_id)
{
   if (!isset($_POST['legerebeaute_program_meta_nonce']) || !wp_verify_nonce($_POST['legerebeaute_program_meta_nonce'], 'legerebeaute_save_program_meta')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;
   if (!current_user_can('edit_post', $post_id))
      return;

   // Простые поля
   $fields = ['short_description', 'duration_text', 'procedures_count', 'price_current', 'price_old', 'cta_label', 'cta_url'];
   foreach ($fields as $field) {
      if (isset($_POST["legerebeaute_{$field}"])) {
         update_post_meta($post_id, "_legerebeaute_{$field}", sanitize_text_field($_POST["legerebeaute_{$field}"]));
      }
   }

   // What included (repeater)
   $what_included = [];
   if (!empty($_POST['legerebeaute_what_included'])) {
      $lines = explode("\n", trim($_POST['legerebeaute_what_included']));
      foreach ($lines as $line) {
         if (!empty(trim($line))) {
            $what_included[] = sanitize_text_field(trim($line));
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_what_included', $what_included);
}
add_action('save_post_programs', 'legerebeaute_save_program_meta');

// === 6. Хелпер для получения данных в шаблонах ===
if (!function_exists('legerebeaute_get_program_meta')) {
   function legerebeaute_get_program_meta($post_id = null, $key = '')
   {
      if (!$post_id)
         $post_id = get_the_ID();
      return get_post_meta($post_id, '_legerebeaute_' . $key, true);
   }
}