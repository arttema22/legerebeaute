<?php
/**
 * CPT "Услуги" + таксономия "Категории услуг" + метаполя
 * _legerebeaute_main_title, _legerebeaute_short_description, _legerebeaute_gallery,
 * _legerebeaute_benefits, _legerebeaute_effects_txt, _legerebeaute_effects_img,
 * _legerebeaute_price_current, _legerebeaute_price_old, _legerebeaute_duration,
 * _legerebeaute_booking_enabled, _legerebeaute_show_on_home, _legerebeaute_image_2
 */

if (!defined('ABSPATH')) {
   exit;
}

// === Регистрация CPT "services" ===
function legerebeaute_register_services_cpt()
{
   $labels = [
      'name' => 'Услуги',
      'singular_name' => 'Услуга',
      'menu_name' => 'Услуги',
      'name_admin_bar' => 'Услуга',
      'add_new' => 'Добавить новую',
      'add_new_item' => 'Добавить новую услугу',
      'new_item' => 'Новая услуга',
      'edit_item' => 'Редактировать услугу',
      'view_item' => 'Просмотр услуги',
      'all_items' => 'Все услуги',
      'search_items' => 'Искать услуги',
      'not_found' => 'Услуг не найдено.',
      'not_found_in_trash' => 'В корзине услуг нет.',
   ];

   $args = [
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'services'],
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-universal-access',
      'supports' => ['title', 'editor', 'thumbnail'],
   ];

   register_post_type('services', $args);
}
add_action('init', 'legerebeaute_register_services_cpt');

// === Регистрация таксономии "service_category" ===
function legerebeaute_register_service_category()
{
   $labels = [
      'name' => 'Категории услуг',
      'singular_name' => 'Категория услуг',
      'search_items' => 'Искать категории',
      'all_items' => 'Все категории',
      'parent_item' => 'Родительская категория',
      'parent_item_colon' => 'Родительская категория:',
      'edit_item' => 'Редактировать категорию',
      'update_item' => 'Обновить категорию',
      'add_new_item' => 'Добавить новую категорию',
      'new_item_name' => 'Новое имя категории',
      'menu_name' => 'Категории услуг',
   ];

   $args = [
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'service-category'],
   ];

   register_taxonomy('service_category', ['services'], $args);
}
add_action('init', 'legerebeaute_register_service_category', 0);

// === Добавление метаполей в редактор услуги (разделение по блокам) ===
function legerebeaute_add_service_meta_boxes()
{
   add_meta_box('legerebeaute_service_details', 'Детали услуги', 'legerebeaute_service_details_meta_box_callback', 'services', 'normal', 'high');
   add_meta_box('legerebeaute_service_benefits', 'Преимущества', 'legerebeaute_service_benefits_meta_box_callback', 'services', 'normal', 'high');
   add_meta_box('legerebeaute_service_effects_txt', 'Эффекты в тексте', 'legerebeaute_service_effects_txt_meta_box_callback', 'services', 'normal', 'default');
   add_meta_box('legerebeaute_service_effects_img', 'Эффекты на фото', 'legerebeaute_service_effects_img_meta_box_callback', 'services', 'normal', 'default');
   add_meta_box('legerebeaute_service_prices', 'Цены', 'legerebeaute_service_prices_meta_box_callback', 'services', 'side', 'default');
   add_meta_box('legerebeaute_service_features', 'Характеристики', 'legerebeaute_service_features_meta_box_callback', 'services', 'side', 'default');
   add_meta_box('legerebeaute_service_image_2', 'Изображение 2', 'legerebeaute_service_image_2_meta_box_callback', 'services', 'side', 'default');
}
add_action('add_meta_boxes', 'legerebeaute_add_service_meta_boxes');

// === Подключение скриптов для галереи ===
function legerebeaute_enqueue_media_uploader($hook)
{
   global $post;
   if (($hook == 'post-new.php' || $hook == 'post.php') && $post && $post->post_type == 'services') {
      wp_enqueue_media();
      wp_enqueue_script('legerebeaute-media-uploader-js', get_template_directory_uri() . '/assets/js/admin-media-uploader.js', array('jquery'), '1.0', true);
      wp_enqueue_script('legerebeaute-benefits-media-js', get_template_directory_uri() . '/assets/js/admin-benefits-media.js', array('jquery'), '1.0', true);
      wp_enqueue_script('legerebeaute-img2-media-js', get_template_directory_uri() . '/assets/js/admin-img2-media.js', array('jquery'), '1.0', true);
   }
}
add_action('admin_enqueue_scripts', 'legerebeaute_enqueue_media_uploader');

// === Вывод полей в блоке "Детали услуги" ===
function legerebeaute_service_details_meta_box_callback($post)
{
   wp_nonce_field('legerebeaute_save_service_meta', 'legerebeaute_service_meta_nonce');
   $main_title = get_post_meta($post->ID, '_legerebeaute_main_title', true);
   $short_description = get_post_meta($post->ID, '_legerebeaute_short_description', true);
   $gallery_ids = maybe_unserialize(get_post_meta($post->ID, '_legerebeaute_gallery', true));
   if (!is_array($gallery_ids))
      $gallery_ids = [];

   echo '<style>#legerebeaute-gallery-container{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:10px}.gallery-image-preview{position:relative;flex-shrink:0;width:150px;height:150px;border:1px solid #ddd;border-radius:4px;overflow:hidden;display:flex;align-items:center;justify-content:center}.gallery-image-preview img{max-width:100%;max-height:100%;object-fit:cover}.gallery-image-preview .remove-image{position:absolute;top:2px;right:2px;width:20px;height:20px;padding:0;background-color:#d63638;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;opacity:.8}</style>';
   echo '<div><label for="legerebeaute_main_title">Заголовок 2 (если отличается от названия):</label><input type="text" id="legerebeaute_main_title" name="legerebeaute_main_title" value="' . esc_attr($main_title) . '" style="width:100%"></div>';
   echo '<div><label for="legerebeaute_short_description">Краткое описание:</label><textarea id="legerebeaute_short_description" name="legerebeaute_short_description" rows="4" style="width:100%">' . esc_textarea($short_description) . '</textarea></div>';
   echo '<div><h4>Галерея:</h4><div id="legerebeaute-gallery-container">';
   foreach ($gallery_ids as $id) {
      $src = wp_get_attachment_image_src($id, 'thumbnail');
      if ($src)
         echo '<div class="gallery-image-preview" data-id="' . $id . '"><img src="' . esc_url($src[0]) . '"><button type="button" class="button remove-image">X</button><input type="hidden" name="legerebeaute_gallery[]" value="' . $id . '"></div>';
   }
   echo '</div><button type="button" id="legerebeaute-add-gallery-images" class="button">Добавить изображения</button><p><small>Нажмите кнопку, чтобы выбрать изображения из медиатеки.</small></p></div>';
}

// === Вывод полей в блоке "Преимущества" ===
function legerebeaute_service_benefits_meta_box_callback($post)
{
   $benefits = maybe_unserialize(get_post_meta($post->ID, '_legerebeaute_benefits', true));
   if (!is_array($benefits))
      $benefits = [];

   echo '<table id="benefits-table" style="margin-bottom:10px;width:100%;border-collapse:collapse"><thead><tr><th style="border:1px solid #ccc;padding:5px">Изображение</th><th style="border:1px solid #ccc;padding:5px">Заголовок</th><th style="border:1px solid #ccc;padding:5px">Текст</th><th style="border:1px solid #ccc;padding:5px"></th></tr></thead><tbody>';
   foreach ($benefits as $i => $b) {
      $img_id = isset($b['image_id']) ? $b['image_id'] : '';
      $img_src = $img_id ? wp_get_attachment_image_src($img_id, 'thumbnail') : null;
      $img_html = $img_src ? '<img src="' . esc_url($img_src[0]) . '" style="width:100%;height:auto">' : '';
      echo '<tr><td style="border:1px solid #ccc;padding:5px;width:150px"><div class="benefit-image-preview" data-id="' . $img_id . '">' . $img_html . '</div><input type="hidden" name="legerebeaute_benefits[' . $i . '][image_id]" value="' . $img_id . '" class="benefit-image-id-field"><button type="button" class="button button-small select-benefit-image-btn">Выбрать изображение</button>' . ($img_id ? '<button type="button" class="button button-small remove-benefit-image-btn">Удалить</button>' : '') . '</td><td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[' . $i . '][title]" value="' . esc_attr($b['title'] ?? '') . '" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[' . $i . '][text]" value="' . esc_attr($b['text'] ?? '') . '" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeBenefitRow(this)">Удалить</button></td></tr>';
   }
   echo '</tbody></table><button type="button" class="button button-small" onclick="addBenefitRow()">Добавить преимущество</button><script>let benefitIndex=' . count($benefits) . ';function addBenefitRow(){const t=document.querySelector("#benefits-table tbody");const r=document.createElement("tr");r.innerHTML=\'<td style="border:1px solid #ccc;padding:5px;width:150px"><div class="benefit-image-preview"></div><input type="hidden" name="legerebeaute_benefits[\'+benefitIndex+\'][image_id]" value="" class="benefit-image-id-field"><button type="button" class="button button-small select-benefit-image-btn">Выбрать изображение</button></td><td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[\'+benefitIndex+\'][title]" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[\'+benefitIndex+\'][text]" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeBenefitRow(this)">Удалить</button></td>\';t.appendChild(r);benefitIndex++;initializeBenefitMediaHandlers()}function removeBenefitRow(t){t.closest("tr").remove()}document.addEventListener("DOMContentLoaded",function(){initializeBenefitMediaHandlers()})</script>';
}

// === Вывод полей в блоке "Эффекты в тексте" ===
function legerebeaute_service_effects_txt_meta_box_callback($post)
{
   $effects = maybe_unserialize(get_post_meta($post->ID, '_legerebeaute_effects_txt', true));
   if (!is_array($effects))
      $effects = [];

   echo '<table id="effects-txt-table" style="margin-bottom:10px;width:100%;border-collapse:collapse"><thead><tr><th style="border:1px solid #ccc;padding:5px">Эффект</th><th style="border:1px solid #ccc;padding:5px"></th></tr></thead><tbody>';
   foreach ($effects as $i => $e) {
      echo '<tr><td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_effects_txt[' . $i . '][text]" value="' . esc_attr($e['text'] ?? '') . '" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeEffectTxtRow(this)">Удалить</button></td></tr>';
   }
   echo '</tbody></table><button type="button" class="button button-small" onclick="addEffectTxtRow()">Добавить эффект</button><script>let effectIndex=' . count($effects) . ';function addEffectTxtRow(){const t=document.querySelector("#effects-txt-table tbody");const r=document.createElement("tr");r.innerHTML=\'<td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_effects_txt[\'+effectIndex+\'][text]" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeEffectTxtRow(this)">Удалить</button></td>\';t.appendChild(r);effectIndex++}function removeEffectTxtRow(t){t.closest("tr").remove()}</script>';
}

// === Вывод полей в блоке "Эффекты на фото" ===
function legerebeaute_service_effects_img_meta_box_callback($post)
{
   $effects = maybe_unserialize(get_post_meta($post->ID, '_legerebeaute_effects_img', true));
   if (!is_array($effects))
      $effects = [];

   echo '<table id="effects-img-table" style="margin-bottom:10px;width:100%;border-collapse:collapse"><thead><tr><th style="border:1px solid #ccc;padding:5px">Эффект</th><th style="border:1px solid #ccc;padding:5px"></th></tr></thead><tbody>';
   foreach ($effects as $i => $e) {
      echo '<tr><td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_effects_img[' . $i . '][text]" value="' . esc_attr($e['text'] ?? '') . '" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeEffectImgRow(this)">Удалить</button></td></tr>';
   }
   echo '</tbody></table><button type="button" class="button button-small" onclick="addEffectImgRow()">Добавить эффект</button><script>let effectImgIndex=' . count($effects) . ';function addEffectImgRow(){const t=document.querySelector("#effects-img-table tbody");const r=document.createElement("tr");r.innerHTML=\'<td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_effects_img[\'+effectImgIndex+\'][text]" style="width:100%"></td><td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeEffectImgRow(this)">Удалить</button></td>\';t.appendChild(r);effectImgIndex++}function removeEffectImgRow(t){t.closest("tr").remove()}</script>';
}

// === Вывод полей в блоке "Цены" ===
function legerebeaute_service_prices_meta_box_callback($post)
{
   $price_current = get_post_meta($post->ID, '_legerebeaute_price_current', true);
   $price_old = get_post_meta($post->ID, '_legerebeaute_price_old', true);

   echo '<div><label for="legerebeaute_price_current">Текущая цена:</label><input type="text" id="legerebeaute_price_current" name="legerebeaute_price_current" value="' . esc_attr($price_current) . '" placeholder="4500" style="width:100%"></div>';
   echo '<div><label for="legerebeaute_price_old">Старая цена:</label><input type="text" id="legerebeaute_price_old" name="legerebeaute_price_old" value="' . esc_attr($price_old) . '" placeholder="5500" style="width:100%"></div>';
}

// === Вывод полей в блоке "Характеристики" ===
function legerebeaute_service_features_meta_box_callback($post)
{
   $duration = get_post_meta($post->ID, '_legerebeaute_duration', true);
   $booking_enabled = get_post_meta($post->ID, '_legerebeaute_booking_enabled', true);
   $show_on_home = get_post_meta($post->ID, '_legerebeaute_show_on_home', true);

   echo '<p><label for="legerebeaute_duration">Длительность (например, "60 мин"):</label><input type="text" id="legerebeaute_duration" name="legerebeaute_duration" value="' . esc_attr($duration) . '" style="width:100%"></p>';
   echo '<p><label><input type="checkbox" name="legerebeaute_booking_enabled" value="1" ' . checked($booking_enabled, '1', false) . '> Включить онлайн-запись для этой услуги</label></p>';
   echo '<p><label><input type="checkbox" name="legerebeaute_show_on_home" value="1" ' . checked($show_on_home, '1', false) . '> Отображать на главной странице</label></p>';
}

// === Вывод полей в блоке "Изображение 2" ===
function legerebeaute_service_image_2_meta_box_callback($post)
{
   $image_id = get_post_meta($post->ID, '_legerebeaute_image_2', true);
   $image_src = wp_get_attachment_image_src($image_id, 'full');

   echo '<div id="legerebeaute-image-2-container">';
   if ($image_src)
      echo '<img src="' . esc_url($image_src[0]) . '" width="150"><button type="button" class="button" id="remove-image-2">X</button>';
   echo '<input type="hidden" id="legerebeaute-image-2-id" name="legerebeaute_image_2" value="' . esc_attr($image_id) . '"></div>';
   echo '<button type="button" id="select-image-2" class="button">Выбрать изображение</button>';
}

// === Сохранение метаполей ===
function legerebeaute_save_service_meta($post_id)
{
   if (!isset($_POST['legerebeaute_service_meta_nonce']) || !wp_verify_nonce($_POST['legerebeaute_service_meta_nonce'], 'legerebeaute_save_service_meta')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;
   if (!current_user_can('edit_post', $post_id))
      return;

   // Простые текстовые поля
   $text_fields = ['main_title', 'short_description', 'price_current', 'price_old', 'duration'];
   foreach ($text_fields as $field) {
      if (isset($_POST["legerebeaute_{$field}"])) {
         update_post_meta($post_id, "_legerebeaute_{$field}", sanitize_text_field($_POST["legerebeaute_{$field}"]));
      }
   }

   // Галерея
   $gallery_ids = [];
   if (isset($_POST['legerebeaute_gallery']) && is_array($_POST['legerebeaute_gallery'])) {
      foreach ($_POST['legerebeaute_gallery'] as $id) {
         if (is_numeric($id) && wp_attachment_is_image($id)) {
            $gallery_ids[] = (int) $id;
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_gallery', serialize($gallery_ids));

   // Чекбоксы
   $checkboxes = ['booking_enabled', 'show_on_home'];
   foreach ($checkboxes as $field) {
      $value = isset($_POST["legerebeaute_{$field}"]) ? '1' : '0';
      update_post_meta($post_id, "_legerebeaute_{$field}", $value);
   }

   // Repeater: Преимущества
   $benefits = [];
   if (isset($_POST['legerebeaute_benefits']) && is_array($_POST['legerebeaute_benefits'])) {
      foreach ($_POST['legerebeaute_benefits'] as $data) {
         if (isset($data['title'], $data['text'])) {
            $benefits[] = [
               'title' => sanitize_text_field($data['title']),
               'text' => sanitize_text_field($data['text']),
               'image_id' => isset($data['image_id']) ? absint($data['image_id']) : 0
            ];
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_benefits', serialize($benefits));

   // Repeater: Эффекты в тексте
   $effects_txt = [];
   if (isset($_POST['legerebeaute_effects_txt']) && is_array($_POST['legerebeaute_effects_txt'])) {
      foreach ($_POST['legerebeaute_effects_txt'] as $data) {
         if (isset($data['text'])) {
            $effects_txt[] = ['text' => sanitize_text_field($data['text'])];
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_effects_txt', serialize($effects_txt));

   // Repeater: Эффекты на фото
   $effects_img = [];
   if (isset($_POST['legerebeaute_effects_img']) && is_array($_POST['legerebeaute_effects_img'])) {
      foreach ($_POST['legerebeaute_effects_img'] as $data) {
         if (isset($data['text'])) {
            $effects_img[] = ['text' => sanitize_text_field($data['text'])];
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_effects_img', serialize($effects_img));

   // Изображение 2
   if (isset($_POST['legerebeaute_image_2'])) {
      $image_id = absint($_POST['legerebeaute_image_2']);
      if (wp_attachment_is_image($image_id)) {
         update_post_meta($post_id, '_legerebeaute_image_2', $image_id);
      } else {
         delete_post_meta($post_id, '_legerebeaute_image_2');
      }
   } else {
      delete_post_meta($post_id, '_legerebeaute_image_2');
   }
}
add_action('save_post_services', 'legerebeaute_save_service_meta');

// === Хелпер для получения данных в шаблонах ===
if (!function_exists('legerebeaute_get_service_meta')) {
   function legerebeaute_get_service_meta($post_id = null, $key = '')
   {
      if (!$post_id)
         $post_id = get_the_ID();
      $value = get_post_meta($post_id, '_legerebeaute_' . $key, true);

      $serialized_keys = ['benefits', 'booking_time_slots', 'gallery', 'effects_txt', 'effects_img'];
      if (in_array($key, $serialized_keys)) {
         $unserialized = maybe_unserialize($value);
         if ($unserialized !== false)
            return $unserialized;
      }
      return $value;
   }
}