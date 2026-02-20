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

// === Подключение скриптов для галереи и универсального хелпера ===
// function legerebeaute_enqueue_media_uploader($hook) { /* УДАЛЕНО */ }
// add_action('admin_enqueue_scripts', 'legerebeaute_enqueue_media_uploader'); /* УДАЛЕНО */

// Новый способ подключения скриптов
function legerebeaute_enqueue_services_admin_scripts($hook)
{
   global $post;
   if (($hook == 'post-new.php' || $hook == 'post.php') && $post && $post->post_type == 'services') {
      Legerebeaute_Image_Helper::enqueue_admin_scripts();
      // Подключить другие специфичные для CPT services скрипты, если есть
      wp_enqueue_script('legerebeaute-services-benefits-js', get_template_directory_uri() . '/assets/js/admin/services-benefits-init.js', array('jquery'), '1.0', true);
   }
}
add_action('admin_enqueue_scripts', 'legerebeaute_enqueue_services_admin_scripts');

// === Вывод полей в блоке "Детали услуги" ===
function legerebeaute_service_details_meta_box_callback($post)
{
   wp_nonce_field('legerebeaute_save_service_meta', 'legerebeaute_service_meta_nonce');
   $main_title = get_post_meta($post->ID, '_legerebeaute_main_title', true);
   $short_description = get_post_meta($post->ID, '_legerebeaute_short_description', true);
   $gallery_ids = maybe_unserialize(get_post_meta($post->ID, '_legerebeaute_gallery', true)); // Старое поле
   if (!is_array($gallery_ids))
      $gallery_ids = [];

   echo '<style>#legerebeaute-gallery-container{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:10px}.gallery-image-preview{position:relative;flex-shrink:0;width:150px;height:150px;border:1px solid #ddd;border-radius:4px;overflow:hidden;display:flex;align-items:center;justify-content:center}.gallery-image-preview img{max-width:100%;max-height:100%;object-fit:cover}.gallery-image-preview .remove-image{position:absolute;top:2px;right:2px;width:20px;height:20px;padding:0;background-color:#d63638;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;opacity:.8}</style>';
   echo '<div><label for="legerebeaute_main_title">Заголовок 2 (если отличается от названия):</label><input type="text" id="legerebeaute_main_title" name="legerebeaute_main_title" value="' . esc_attr($main_title) . '" style="width:100%"></div>';
   echo '<div><label for="legerebeaute_short_description">Краткое описание:</label><textarea id="legerebeaute_short_description" name="legerebeaute_short_description" rows="4" style="width:100%">' . esc_textarea($short_description) . '</textarea></div>';
   // --- ВАЖНО: Поле галереи пока оставлено в старом формате ---
   echo '<div><h4>Галерея (старый формат):</h4><div id="legerebeaute-gallery-container">';
   foreach ($gallery_ids as $id) {
      $src = wp_get_attachment_image_src($id, 'thumbnail');
      if ($src)
         echo '<div class="gallery-image-preview" data-id="' . $id . '"><img src="' . esc_url($src[0]) . '"><button type="button" class="button remove-image">X</button><input type="hidden" name="legerebeaute_gallery[]" value="' . $id . '"></div>';
   }
   echo '</div><button type="button" id="legerebeaute-add-gallery-images" class="button">Добавить изображения</button><p><small>Нажмите кнопку, чтобы выбрать изображения из медиатеки. (Пока не использует хелпер)</small></p></div>';
}

// === Вывод полей в блоке "Преимущества" ===
function legerebeaute_service_benefits_meta_box_callback($post)
{
   $benefits = maybe_unserialize(get_post_meta($post->ID, '_legerebeaute_benefits', true)); // Старое поле
   if (!is_array($benefits)) {
      $benefits = [];
   }

   echo '<table id="benefits-table" style="margin-bottom:10px;width:100%;border-collapse:collapse"><thead><tr><th style="border:1px solid #ccc;padding:5px">Изображение</th><th style="border:1px solid #ccc;padding:5px">Заголовок</th><th style="border:1px solid #ccc;padding:5px">Текст</th><th style="border:1px solid #ccc;padding:5px"></th></tr></thead><tbody>';

   foreach ($benefits as $i => $b) {
      // Обработка старого формата ('image_id') и нового ('image' => ['id'])
      $image_data = isset($b['image']) && is_array($b['image']) ? $b['image'] : array('id' => isset($b['image_id']) ? (int) $b['image_id'] : 0, 'url' => '');
      $current_image_id = $image_data['id'];

      echo '<tr>';
      echo '<td style="border:1px solid #ccc;padding:5px;width:150px">';
      echo Legerebeaute_Image_Helper::render_image_field("legerebeaute_benefits[{$i}][image]", array(
         'value_id' => $current_image_id,
         'value_url' => $image_data['url'], // Если нужно хранить URL
         'preview_size' => 'thumbnail',
         'wrapper_class' => 'legerebeaute-image-field-wrapper legerebeaute-benefit-image-field',
      ));
      echo '</td>';
      echo '<td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[' . $i . '][title]" value="' . esc_attr($b['title'] ?? '') . '" style="width:100%"></td>';
      echo '<td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[' . $i . '][text]" value="' . esc_attr($b['text'] ?? '') . '" style="width:100%"></td>';
      echo '<td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeBenefitRow(this)">Удалить</button></td>';
      echo '</tr>';
   }

   echo '</tbody></table>';
   echo '<button type="button" class="button button-small" onclick="addBenefitRow()">Добавить преимущество</button>';

   // Шаблон новой строки
   echo '<tr class="benefit-row-template" style="display: none;">';
   echo '<td style="border:1px solid #ccc;padding:5px;width:150px">';
   echo Legerebeaute_Image_Helper::render_image_field("legerebeaute_benefits[NEW_INDEX][image]", array(
      'value_id' => 0,
      'value_url' => '',
      'preview_size' => 'thumbnail',
      'wrapper_class' => 'legerebeaute-image-field-wrapper legerebeaute-benefit-image-field',
   ));
   echo '</td>';
   echo '<td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[NEW_INDEX][title]" style="width:100%"></td>';
   echo '<td style="border:1px solid #ccc;padding:5px"><input type="text" name="legerebeaute_benefits[NEW_INDEX][text]" style="width:100%"></td>';
   echo '<td style="border:1px solid #ccc;padding:5px"><button type="button" class="button button-small" onclick="removeBenefitRow(this)">Удалить</button></td>';
   echo '</tr>';

   echo '<script type="text/javascript">
    let benefitIndex = ' . count($benefits) . ';

    function addBenefitRow() {
        const tbody = document.querySelector("#benefits-table tbody");
        const templateRow = document.querySelector(".benefit-row-template").cloneNode(true);
        templateRow.style.display = ""; // Показываем клон
        templateRow.innerHTML = templateRow.innerHTML.replace(/NEW_INDEX/g, benefitIndex); // Заменяем плейсхолдер
        templateRow.setAttribute("data-index", benefitIndex); // Добавляем атрибут для отслеживания
        tbody.appendChild(templateRow);

        // Инициализируем хелпер для нового поля изображения (предполагаем, что функция будет в отдельном JS файле)
        if (typeof initializeNewBenefitImageField === "function") {
            initializeNewBenefitImageField(benefitIndex);
        }

        benefitIndex++;
    }

    function removeBenefitRow(button) {
        button.closest("tr").remove();
    }
    </script>';
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
   $image_data = get_post_meta($post->ID, '_legerebeaute_image_2', true);
   $image_id = isset($image_data['id']) ? (int) $image_data['id'] : 0;
   $image_url = isset($image_data['url']) ? esc_url($image_data['url']) : '';

   echo '<div><label>Изображение 2:</label>';
   echo Legerebeaute_Image_Helper::render_image_field('_legerebeaute_image_2', array(
      'value_id' => $image_id,
      'value_url' => $image_url,
      'label' => 'Изображение 2 (через универсальный хелпер)',
      'description' => 'Выберите изображение 2 для услуги.'
   ));
   echo '</div>';
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

   // Галерея (старое поле, пока не трогаем)
   $gallery_ids = [];
   if (isset($_POST['legerebeaute_gallery']) && is_array($_POST['legerebeaute_gallery'])) {
      foreach ($_POST['legerebeaute_gallery'] as $id) {
         if (is_numeric($id) && wp_attachment_is_image($id)) {
            $gallery_ids[] = (int) $id;
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_gallery', serialize($gallery_ids)); // Остается serialized

   // Чекбоксы
   $checkboxes = ['booking_enabled', 'show_on_home'];
   foreach ($checkboxes as $field) {
      $value = isset($_POST["legerebeaute_{$field}"]) ? '1' : '0';
      update_post_meta($post_id, "_legerebeaute_{$field}", $value);
   }

   // Repeater: Преимущества (обновлено для нового формата)
   $benefits = array();
   if (isset($_POST['legerebeaute_benefits']) && is_array($_POST['legerebeaute_benefits'])) {
      foreach ($_POST['legerebeaute_benefits'] as $data) {
         if (isset($data['title'], $data['text'])) {
            // --- ПРАВИЛЬНО: Обрабатываем $data['image'] напрямую ---
            $image_input = $data['image'] ?? array();
            $processed_image = array('id' => 0, 'url' => '');

            // Проверяем, является ли $image_input массивом (ожидаемый формат)
            if (is_array($image_input)) {
               $id = absint($image_input['id'] ?? 0);

               // Проверяем ID и тип вложения (копируем логику из is_attachment_of_allowed_types)
               if ($id && get_post_type($id) === 'attachment') {
                  $mime_type = get_post_mime_type($id);
                  // Проверяем, является ли это изображением
                  if ($mime_type && strpos($mime_type, 'image/') === 0) {
                     $processed_image['id'] = $id;
                     $url = wp_get_attachment_url($id);
                     $processed_image['url'] = $url ? esc_url_raw($url) : '';
                  }
               }
            }
            // ---

            $benefits[] = array(
               'title' => sanitize_text_field($data['title']),
               'text' => sanitize_text_field($data['text']),
               'image' => $processed_image // Сохраняем обработанную структуру
            );
         }
      }
   }
   update_post_meta($post_id, '_legerebeaute_benefits', $benefits); // Теперь НЕ serialize, а обычный массив

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

   // Изображение 2 (обновлено)
   $image_2_data = Legerebeaute_Image_Helper::process_image_field_from_post('_legerebeaute_image_2');
   update_post_meta($post_id, '_legerebeaute_image_2', $image_2_data); // Теперь НЕ serialize, а обычный массив
}
add_action('save_post_services', 'legerebeaute_save_service_meta');

// === Хелпер для получения данных в шаблонах ===
if (!function_exists('legerebeaute_get_service_meta')) {
   function legerebeaute_get_service_meta($post_id = null, $key = '')
   {
      if (!$post_id)
         $post_id = get_the_ID();
      $value = get_post_meta($post_id, '_legerebeaute_' . $key, true);

      // Обновленный список ключей, которые нужно десериализовать (старые поля)
      $serialized_keys = ['booking_time_slots', 'gallery', 'effects_txt', 'effects_img'];
      // Ключи, которые НЕ нужно десериализовать (новые поля, хранящиеся как массивы)
      $array_keys = ['benefits', 'image_2'];

      if (in_array($key, $serialized_keys)) {
         $unserialized = maybe_unserialize($value);
         if ($unserialized !== false)
            return $unserialized;
      }
      // Для новых массивов просто возвращаем значение
      if (in_array($key, $array_keys)) {
         return $value; // $value уже должен быть массивом
      }

      return $value;
   }
}