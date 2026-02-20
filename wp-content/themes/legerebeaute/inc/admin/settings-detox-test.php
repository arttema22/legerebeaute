<?php
/**
 * Настройки блока "Детокс-тест" (Насколько зашлакован ваш организм?)
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_detox_test_settings_init()
{
   // Регистрируем настройку с callback для валидации
   register_setting('legerebeaute_detox_test_settings_group', 'legerebeaute_detox_test_settings', 'legerebeaute_validate_detox_test_settings');

   // Секция: Контент блока
   add_settings_section(
      'legerebeaute_detox_test_content',
      'Контент блока "Детокс-тест"',
      'legerebeaute_render_detox_test_section_info',
      'legerebeaute-detox-test'
   );

   add_settings_field(
      'title',
      'Заголовок блока',
      'legerebeaute_render_detox_test_title_field',
      'legerebeaute-detox-test',
      'legerebeaute_detox_test_content'
   );

   add_settings_field(
      'cards',
      'Карточки',
      'legerebeaute_render_detox_test_cards_field',
      'legerebeaute-detox-test',
      'legerebeaute_detox_test_content'
   );
}
add_action('admin_init', 'legerebeaute_detox_test_settings_init');

function legerebeaute_render_detox_test_section_info()
{
   echo '<p>Настройте заголовок и карточки для блока "Насколько зашлакован ваш организм?".</p>';
}

function legerebeaute_render_detox_test_title_field()
{
   $options = get_option('legerebeaute_detox_test_settings', []);
   printf(
      '<input type="text" name="legerebeaute_detox_test_settings[title]" value="%s" class="large-text">',
      esc_attr($options['title'] ?? '')
   );
}

function legerebeaute_render_detox_test_cards_field()
{
   $options = get_option('legerebeaute_detox_test_settings', []);
   $cards = isset($options['cards']) && is_array($options['cards']) ? $options['cards'] : [];

   // --- Загрузка скриптов и стилей TinyMCE ---
   // wp_editor('', 'detox_test_hidden_editor_for_loading', array(...)); // Не используем напрямую, но ensure scripts are loaded
   // wp_enqueue_editor(); // Это загрузит TinyMCE и QuickTags, но инициализирует только поля с определёнными именами/классами по умолчанию.
   // -----------------------------------------

   echo '<style>
       #detox-test-cards-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
       #detox-test-cards-table th, #detox-test-cards-table td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
       .remove-card-row, .select-card-image-btn, .remove-card-image-btn { margin-top: 5px; }
       /* Попытка стилизовать textarea до инициализации */
       textarea.detox-test-wysiwyg-textarea {
           min-height: 150px; /* Установим минимальную высоту */
           width: 100%;
       }
   </style>';
   echo '<table id="detox-test-cards-table">';
   echo '<thead><tr><th>Изображение</th><th>Текст (WYSIWYG)</th><th></th></tr></thead>';
   echo '<tbody>';

   foreach ($cards as $index => $card) {
      // Обработка изображения: пытаемся получить из нового формата 'image' => ['id', 'url'], иначе из старого 'image_id'
      $image_data = isset($card['image']) && is_array($card['image']) ? $card['image'] : array('id' => isset($card['image_id']) ? (int) $card['image_id'] : 0, 'url' => '');
      $current_image_id = $image_data['id'];
      $text_value = isset($card['text']) ? $card['text'] : '';

      $textarea_id = 'detox_test_card_text_' . $index;
      echo '<tr>';
      echo '<td style="width: 20%;">';
      echo Legerebeaute_Image_Helper::render_image_field("legerebeaute_detox_test_settings[cards][$index][image]", array(
         'value_id' => $current_image_id,
         'value_url' => $image_data['url'], // Если нужно хранить URL
         'label' => 'Изображение карточки',
         'preview_size' => 'thumbnail',
      ));
      echo '</td>';
      echo '<td>';
      // Используем textarea с уникальным ID и классом для инициализации TinyMCE
      echo '<textarea id="' . esc_attr($textarea_id) . '" name="legerebeaute_detox_test_settings[cards][' . $index . '][text]" class="detox-test-wysiwyg-textarea">' . esc_textarea($text_value) . '</textarea>';
      echo '</td>';
      echo '<td style="width: 10%;"><button type="button" class="button button-small remove-card-row">Удалить карточку</button></td>';
      echo '</tr>';
   }

   // Шаблон новой строки (использует универсальный хелпер и textarea для WYSIWYG)
   echo '<tr class="card-template" style="display: none;">';
   echo '<td style="width: 20%;">';
   echo Legerebeaute_Image_Helper::render_image_field("legerebeaute_detox_test_settings[cards][NEW_INDEX][image]", array(
      'value_id' => 0,
      'value_url' => '',
      'label' => 'Изображение карточки',
      'preview_size' => 'thumbnail',
   ));
   echo '</td>';
   echo '<td>';
   // Шаблон textarea с плейсхолдером для ID
   echo '<textarea id="detox_test_card_text_NEW_INDEX" name="legerebeaute_detox_test_settings[cards][NEW_INDEX][text]" class="detox-test-wysiwyg-textarea"></textarea>';
   echo '</td>';
   echo '<td style="width: 10%;"><button type="button" class="button button-small remove-card-row">Удалить карточку</button></td>';
   echo '</tr>';

   echo '</tbody>';
   echo '</table>';
   echo '<button type="button" id="add-detox-test-card-row" class="button">Добавить карточку</button>';

   // --- JavaScript для добавления строк и инициализации TinyMCE ---
   echo '<script type="text/javascript">
   let cardIndex = ' . count($cards) . ';

   function addDetoxCard() {
       const tbody = document.querySelector("#detox-test-cards-table tbody");
       const templateRow = document.querySelector(".card-template").cloneNode(true);
       templateRow.style.display = "";
       // Заменяем плейсхолдер NEW_INDEX на текущий индекс
       const newHtml = templateRow.innerHTML.replace(/NEW_INDEX/g, cardIndex);
       templateRow.innerHTML = newHtml;
       // Обновляем ID textarea
       const newTextareaId = "detox_test_card_text_" + cardIndex;
       const newTextarea = templateRow.querySelector("textarea.detox-test-wysiwyg-textarea");
       if (newTextarea) {
           newTextarea.id = newTextareaId;
       }
       tbody.appendChild(templateRow);

       // Инициализируем TinyMCE для новой textarea
       if (typeof tinymce !== "undefined" && typeof wp !== "undefined" && wp.editor && wp.editor.initialize) {
           // Ждём, пока DOM обновится
           setTimeout(function() {
               // Проверим, не инициализирован ли редактор уже (например, если DOM был клонирован с инициализированным редактором)
               if (!tinymce.get(newTextareaId)) {
                   wp.editor.initialize(newTextareaId, {
                       tinymce: {
                           plugins: "lists link image media charmap hr paste fullscreen",
                           menubar: false,
                           toolbar1: "formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv",
                           toolbar2: "styleselect,fontselect,fontsizeselect,forecolor,backcolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
                           // --- Добавим явную высоту ---
                           height: 150, // Установите желаемую высоту в пикселях
                           // ------------------------
                       },
                       quicktags: true,
                   });
                   console.log("TinyMCE initialized for: " + newTextareaId); // Отладка
               } else {
                   console.log("TinyMCE already exists for: " + newTextareaId); // Отладка
               }
           }, 100); // Небольшая задержка для уверенности
       } else {
           console.error("TinyMCE или wp.editor не доступны для инициализации.");
       }

       // Увеличиваем индекс для следующей строки
       cardIndex++;
   }

   function removeDetoxCard(button) {
       const row = button.closest("tr");
       const textareaId = row.querySelector("textarea.detox-test-wysiwyg-textarea")?.id;
       // Удаляем редактор, если он был инициализирован
       if (textareaId && typeof tinymce !== "undefined") {
           const editor = tinymce.get(textareaId);
           if (editor) {
               editor.remove();
               console.log("TinyMCE removed for: " + textareaId); // Отладка
           }
       }
       row.remove();
   }

   // Привязываем обработчики к кнопкам
   document.getElementById("add-detox-test-card-row").addEventListener("click", addDetoxCard);
   document.addEventListener("click", function(e) {
       if (e.target.classList.contains("remove-card-row")) {
           removeDetoxCard(e.target);
       }
   });

   // --- Инициализация существующих редакторов при загрузке страницы ---
   document.addEventListener("DOMContentLoaded", function() {
       if (typeof tinymce !== "undefined" && typeof wp !== "undefined" && wp.editor && wp.editor.initialize) {
           // Найдём все textarea с классом detox-test-wysiwyg-textarea
           document.querySelectorAll("textarea.detox-test-wysiwyg-textarea").forEach(function(textarea) {
               const id = textarea.id;
               if (id && !tinymce.get(id)) { // Проверим, не инициализирован ли уже
                   // Используем тот же конфиг, что и для новых
                   wp.editor.initialize(id, {
                       tinymce: {
                           plugins: "lists link image media charmap hr paste fullscreen",
                           menubar: false,
                           toolbar1: "formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv",
                           toolbar2: "styleselect,fontselect,fontsizeselect,forecolor,backcolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
                           height: 150,
                       },
                       quicktags: true,
                   });
                   console.log("TinyMCE initialized on load for: " + id); // Отладка
               }
           });
       } else {
           console.error("TinyMCE или wp.editor не доступны при загрузке для инициализации существующих.");
       }
   });
   </script>';
   // -----------------------------------

}

// Функция валидации
function legerebeaute_validate_detox_test_settings($input)
{
   $options = get_option('legerebeaute_detox_test_settings', array());

   // Валидация заголовка
   $options['title'] = sanitize_text_field($input['title'] ?? $options['title']);

   // Обработка карточек
   $processed_cards = array();
   if (isset($input['cards']) && is_array($input['cards'])) {
      foreach ($input['cards'] as $card_data) {
         // Проверяем, содержит ли карточка хоть какие-то данные
         $has_text = !empty(trim($card_data['text'] ?? ''));
         $has_image = isset($card_data['image']) && is_array($card_data['image']) && !empty($card_data['image']['id']);

         // Если есть текст или изображение, обрабатываем карточку
         if ($has_text || $has_image) {
            $processed_card = array();
            // Валидация текста через wp_kses_post, как это делает wp_editor при сохранении
            $processed_card['text'] = wp_kses_post($card_data['text']);

            // --- ПРАВИЛЬНО: Обрабатываем $card_data['image'] напрямую ---
            $image_input = $card_data['image'] ?? array();
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

            $processed_card['image'] = $processed_image;
            $processed_cards[] = $processed_card;
         }
         // Если ни текст, ни изображение не указаны, карточка игнорируется.
      }
   }
   $options['cards'] = $processed_cards;

   return $options;
}

function legerebeaute_detox_test_settings_page()
{
   // Подключение скриптов хелпера обязательно для работы полей изображений на странице настроек
   Legerebeaute_Image_Helper::enqueue_admin_scripts();

   // --- Загрузка скриптов и стилей TinyMCE ---
   wp_enqueue_editor(); // Это должно быть вызвано до вывода HTML, чтобы TinyMCE и QuickTags были доступны
   // -------------------------------------------

   ?>
   <div class="wrap">
      <h1>Настройки блока «Детокс-тест»</h1>
      <form action="options.php" method="post">
            <?php
            settings_fields('legerebeaute_detox_test_settings_group');
            do_settings_sections('legerebeaute-detox-test');
            submit_button();
            ?>
            </form>
         </div>
         <?php
}

if (!function_exists('legerebeaute_get_detox_test_block_data')) {
   function legerebeaute_get_detox_test_block_data()
   {
      $options = get_option('legerebeaute_detox_test_settings', array());

      $data = array(
         'title' => isset($options['title']) ? $options['title'] : '',
         'cards' => array()
      );

      if (isset($options['cards']) && is_array($options['cards'])) {
         foreach ($options['cards'] as $card) {
            // Чтение изображения из нового формата 'image' => ['id', 'url']
            $image_url = '';
            if (isset($card['image']) && is_array($card['image']) && isset($card['image']['id'])) {
               $image_url = Legerebeaute_Image_Helper::get_image_url_by_id($card['image']['id'], 'full'); // Используем хелпер для получения URL
            } elseif (isset($card['image_id']) && $card['image_id']) { // Поддержка старого формата на всякий случай
               $img_src = wp_get_attachment_image_src(absint($card['image_id']), 'full');
               $image_url = $img_src ? $img_src[0] : '';
            }

            $data['cards'][] = array(
               'image_url' => $image_url,
               'text' => isset($card['text']) ? $card['text'] : ''
            );
         }
      }

      return $data;
   }
}