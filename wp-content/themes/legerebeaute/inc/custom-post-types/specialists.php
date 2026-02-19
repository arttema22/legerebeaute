<?php
/**
 * CPT "Специалисты" + таксономия "Роли" + метаполя
 */

if (!defined('ABSPATH')) {
   exit;
}

// === 1. Регистрация CPT "specialists" ===
function legerebeaute_register_specialists_cpt()
{
   $labels = [
      'name' => _x('Специалисты', 'Post type general name', 'legerebeaute'),
      'singular_name' => _x('Специалист', 'Post type singular name', 'legerebeaute'),
      'menu_name' => _x('Специалисты', 'Admin Menu text', 'legerebeaute'),
      'name_admin_bar' => _x('Специалист', 'Add New on Toolbar', 'legerebeaute'),
      'add_new' => __('Добавить нового', 'legerebeaute'),
      'add_new_item' => __('Добавить нового специалиста', 'legerebeaute'),
      'new_item' => __('Новый специалист', 'legerebeaute'),
      'edit_item' => __('Редактировать специалиста', 'legerebeaute'),
      'view_item' => __('Просмотр специалиста', 'legerebeaute'),
      'all_items' => __('Все специалисты', 'legerebeaute'),
      'search_items' => __('Искать специалистов', 'legerebeaute'),
      'not_found' => __('Специалистов не найдено.', 'legerebeaute'),
      'not_found_in_trash' => __('В корзине специалистов нет.', 'legerebeaute'),
   ];

   $args = [
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'specialists'],
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-businessperson',
      'supports' => ['title', 'editor', 'thumbnail'],
   ];

   register_post_type('specialists', $args);
}
add_action('init', 'legerebeaute_register_specialists_cpt');

// === 2. Регистрация таксономии "specialist_role" ===
function legerebeaute_register_specialist_role()
{
   $labels = [
      'name' => _x('Роли специалистов', 'taxonomy general name', 'legerebeaute'),
      'singular_name' => _x('Роль специалиста', 'taxonomy singular name', 'legerebeaute'),
      'search_items' => __('Искать роли', 'legerebeaute'),
      'all_items' => __('Все роли', 'legerebeaute'),
      'edit_item' => __('Редактировать роль', 'legerebeaute'),
      'update_item' => __('Обновить роль', 'legerebeaute'),
      'add_new_item' => __('Добавить новую роль', 'legerebeaute'),
      'new_item_name' => __('Новое имя роли', 'legerebeaute'),
      'menu_name' => __('Роли специалистов', 'legerebeaute'),
   ];

   $args = [
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'specialist-role'],
   ];

   register_taxonomy('specialist_role', ['specialists'], $args);
}
add_action('init', 'legerebeaute_register_specialist_role', 0);

// === 3. Метабокс для полей специалиста ===
function legerebeaute_add_specialist_meta_box()
{
   add_meta_box(
      'legerebeaute_specialist_details',
      'Детали специалиста',
      'legerebeaute_specialist_meta_box_callback',
      'specialists',
      'normal',
      'high'
   );
}
add_action('add_meta_boxes', 'legerebeaute_add_specialist_meta_box');

// === 4. Вывод полей в админке ===
function legerebeaute_specialist_meta_box_callback($post)
{
   wp_nonce_field('legerebeaute_save_specialist_meta', 'legerebeaute_specialist_meta_nonce');

   $position_short = get_post_meta($post->ID, '_legerebeaute_position_short', true);
   $education = get_post_meta($post->ID, '_legerebeaute_education', true);
   $experience = get_post_meta($post->ID, '_legerebeaute_experience', true);
   $problems_list = get_post_meta($post->ID, '_legerebeaute_problems_list', true);
   $consultation_formats = get_post_meta($post->ID, '_legerebeaute_consultation_formats', true);
   $cta_label = get_post_meta($post->ID, '_legerebeaute_cta_label', true);
   $cta_url = get_post_meta($post->ID, '_legerebeaute_cta_url', true);
   ?>
   <p>
      <label>Краткая должность:</label><br>
      <input type="text" name="legerebeaute_position_short" value="<?php echo esc_attr($position_short); ?>"
         placeholder="Гастроэнтеролог" style="width: 100%;">
   </p>

   <p>
      <label>Образование:</label><br>
      <?php
      wp_editor(
         $education,
         'legerebeaute_education',
         ['textarea_name' => 'legerebeaute_education']
      );
      ?>
   </p>

   <p>
      <label>Опыт работы:</label><br>
      <?php
      wp_editor(
         $experience,
         'legerebeaute_experience',
         ['textarea_name' => 'legerebeaute_experience']
      );
      ?>
   </p>

   <p>
      <label>Проблемы, с которыми работает (по одной на строку):</label><br>
      <textarea name="legerebeaute_problems_list" rows="4" style="width: 100%;"><?php
      if ($problems_list) {
         echo esc_textarea(implode("\n", $problems_list));
      }
      ?></textarea>
   </p>

   <p>
      <label>Форматы консультаций (формат: "Название | Описание | Цена"):</label><br>
      <textarea name="legerebeaute_consultation_formats" rows="6" style="width: 100%;"><?php
      if ($consultation_formats) {
         echo esc_textarea(implode("\n", array_map(function ($item) {
            return $item['title'] . ' | ' . $item['description'] . ' | ' . $item['price'];
         }, $consultation_formats)));
      }
      ?></textarea>
      <small>Пример:<br>Первичная консультация | Диагностика и план | 3500<br>Повторная | Коррекция программы |
         2500</small>
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
function legerebeaute_save_specialist_meta($post_id)
{
   if (!isset($_POST['legerebeaute_specialist_meta_nonce']) || !wp_verify_nonce($_POST['legerebeaute_specialist_meta_nonce'], 'legerebeaute_save_specialist_meta')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;
   if (!current_user_can('edit_post', $post_id))
      return;

   // Простые поля
   update_post_meta($post_id, '_legerebeaute_position_short', sanitize_text_field($_POST['legerebeaute_position_short'] ?? ''));

   // WYSIWYG
   update_post_meta($post_id, '_legerebeaute_education', wp_kses_post($_POST['legerebeaute_education'] ?? ''));
   update_post_meta($post_id, '_legerebeaute_experience', wp_kses_post($_POST['legerebeaute_experience'] ?? ''));

   // CTA
   update_post_meta($post_id, '_legerebeaute_cta_label', sanitize_text_field($_POST['legerebeaute_cta_label'] ?? ''));
   update_post_meta($post_id, '_legerebeaute_cta_url', esc_url_raw($_POST['legerebeaute_cta_url'] ?? ''));

   // Problems list
   $problems = [];
   if (!empty($_POST['legerebeaute_problems_list'])) {
      $lines = explode("\n", trim($_POST['legerebeaute_problems_list']));
      foreach ($lines as $line) {
         if (!empty(trim($line))) {
            $problems[] = sanitize_text_field(trim($line));
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_problems_list', $problems);

   // Consultation formats
   $formats = [];
   if (!empty($_POST['legerebeaute_consultation_formats'])) {
      $lines = explode("\n", trim($_POST['legerebeaute_consultation_formats']));
      foreach ($lines as $line) {
         $parts = explode('|', $line, 3);
         if (count($parts) == 3) {
            $formats[] = [
               'title' => sanitize_text_field(trim($parts[0])),
               'description' => sanitize_text_field(trim($parts[1])),
               'price' => sanitize_text_field(trim($parts[2]))
            ];
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_consultation_formats', $formats);
}
add_action('save_post_specialists', 'legerebeaute_save_specialist_meta');

// === 6. Хелпер для получения данных в шаблонах ===
if (!function_exists('legerebeaute_get_specialist_meta')) {
   function legerebeaute_get_specialist_meta($post_id = null, $key = '')
   {
      if (!$post_id)
         $post_id = get_the_ID();
      return get_post_meta($post_id, '_legerebeaute_' . $key, true);
   }
}