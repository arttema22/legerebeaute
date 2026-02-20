<?php
/**
 * Настройки блока "Интерьер студии"
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_interior_settings_init()
{
   // Регистрируем настройку с callback для валидации
   register_setting('legerebeaute_interior_settings_group', 'legerebeaute_interior_settings', 'legerebeaute_validate_interior_settings');

   // Секция: Контент блока
   add_settings_section(
      'legerebeaute_interior_content',
      'Контент блока "Интерьер студии"',
      'legerebeaute_render_interior_section_info',
      'legerebeaute-interior'
   );

   add_settings_field(
      'title',
      'Заголовок блока',
      'legerebeaute_render_interior_title_field',
      'legerebeaute-interior',
      'legerebeaute_interior_content'
   );

   add_settings_field(
      'cards',
      'Карточки',
      'legerebeaute_render_interior_cards_field',
      'legerebeaute-interior',
      'legerebeaute_interior_content'
   );
}
add_action('admin_init', 'legerebeaute_interior_settings_init');

function legerebeaute_render_interior_section_info()
{
   echo '<p>Настройте заголовок и карточки для блока "Интерьер студии".</p>';
}

function legerebeaute_render_interior_title_field()
{
   $options = get_option('legerebeaute_interior_settings', []);
   printf(
      '<input type="text" name="legerebeaute_interior_settings[title]" value="%s" class="large-text">',
      esc_attr($options['title'] ?? '')
   );
}

function legerebeaute_render_interior_cards_field()
{
   $options = get_option('legerebeaute_interior_settings', []);
   $cards = isset($options['cards']) && is_array($options['cards']) ? $options['cards'] : [];

   // Загрузка скриптов и стилей TinyMCE
   wp_enqueue_editor();

   echo '<style>
        #interior-cards-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        #interior-cards-table th, #interior-cards-table td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
        .remove-card-row, .select-card-image-btn, .remove-card-image-btn { margin-top: 5px; }
        textarea.interior-wysiwyg-textarea {
            min-height: 150px;
        }
    </style>';
   echo '<table id="interior-cards-table">';
   echo '<thead><tr><th>Изображение</th><th>Текст (WYSIWYG)</th><th></th></tr></thead>';
   echo '<tbody>';

   foreach ($cards as $index => $card) {
      $image_data = isset($card['image']) && is_array($card['image']) ? $card['image'] : array('id' => isset($card['image_id']) ? (int) $card['image_id'] : 0, 'url' => '');
      $current_image_id = $image_data['id'];
      $text_value = isset($card['text']) ? $card['text'] : '';

      $textarea_id = 'interior_card_text_' . $index;
      echo '<tr>';
      echo '<td style="width: 20%;">';
      echo Legerebeaute_Image_Helper::render_image_field("legerebeaute_interior_settings[cards][$index][image]", array(
         'value_id' => $current_image_id,
         'value_url' => $image_data['url'],
         'label' => 'Изображение карточки',
         'preview_size' => 'thumbnail',
      ));
      echo '</td>';
      echo '<td>';
      echo '<textarea id="' . esc_attr($textarea_id) . '" name="legerebeaute_interior_settings[cards][' . $index . '][text]" class="interior-wysiwyg-textarea">' . esc_textarea($text_value) . '</textarea>';
      echo '</td>';
      echo '<td style="width: 10%;"><button type="button" class="button button-small remove-card-row">Удалить карточку</button></td>';
      echo '</tr>';
   }

   // Шаблон новой строки
   echo '<tr class="card-template" style="display: none;">';
   echo '<td style="width: 20%;">';
   echo Legerebeaute_Image_Helper::render_image_field("legerebeaute_interior_settings[cards][NEW_INDEX][image]", array(
      'value_id' => 0,
      'value_url' => '',
      'label' => 'Изображение карточки',
      'preview_size' => 'thumbnail',
   ));
   echo '</td>';
   echo '<td>';
   echo '<textarea id="interior_card_text_NEW_INDEX" name="legerebeaute_interior_settings[cards][NEW_INDEX][text]" class="interior-wysiwyg-textarea"></textarea>';
   echo '</td>';
   echo '<td style="width: 10%;"><button type="button" class="button button-small remove-card-row">Удалить карточку</button></td>';
   echo '</tr>';

   echo '</tbody>';
   echo '</table>';
   echo '<button type="button" id="add-interior-card-row" class="button">Добавить карточку</button>';

   // JavaScript для добавления строк и инициализации TinyMCE
   echo '<script type="text/javascript">
    let cardIndex = ' . count($cards) . ';

    function addInteriorCard() {
        const tbody = document.querySelector("#interior-cards-table tbody");
        const templateRow = document.querySelector(".card-template").cloneNode(true);
        templateRow.style.display = "";
        const newHtml = templateRow.innerHTML.replace(/NEW_INDEX/g, cardIndex);
        templateRow.innerHTML = newHtml;
        const newTextareaId = "interior_card_text_" + cardIndex;
        const newTextarea = templateRow.querySelector("textarea.interior-wysiwyg-textarea");
        if (newTextarea) {
            newTextarea.id = newTextareaId;
        }
        tbody.appendChild(templateRow);

        if (typeof tinymce !== "undefined" && typeof wp !== "undefined" && wp.editor && wp.editor.initialize) {
            setTimeout(function() {
                if (!tinymce.get(newTextareaId)) {
                    wp.editor.initialize(newTextareaId, {
                        tinymce: {
                            plugins: "lists link image media charmap hr paste fullscreen",
                            menubar: false,
                            toolbar1: "formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv",
                            toolbar2: "styleselect,fontselect,fontsizeselect,forecolor,backcolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
                            height: 150,
                        },
                        quicktags: true,
                    });
                }
            }, 100);
        }

        cardIndex++;
    }

    function removeInteriorCard(button) {
        const row = button.closest("tr");
        const textareaId = row.querySelector("textarea.interior-wysiwyg-textarea")?.id;
        if (textareaId && typeof tinymce !== "undefined") {
            const editor = tinymce.get(textareaId);
            if (editor) {
                editor.remove();
            }
        }
        row.remove();
    }

    document.getElementById("add-interior-card-row").addEventListener("click", addInteriorCard);
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-card-row")) {
            removeInteriorCard(e.target);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof tinymce !== "undefined" && typeof wp !== "undefined" && wp.editor && wp.editor.initialize) {
            document.querySelectorAll("textarea.interior-wysiwyg-textarea").forEach(function(textarea) {
                const id = textarea.id;
                if (id && !tinymce.get(id)) {
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
                }
            });
        }
    });
    </script>';
}

// Функция валидации
function legerebeaute_validate_interior_settings($input)
{
   $options = get_option('legerebeaute_interior_settings', array());

   // Валидация заголовка
   $options['title'] = sanitize_text_field($input['title'] ?? $options['title']);

   // Обработка карточек
   $processed_cards = array();
   if (isset($input['cards']) && is_array($input['cards'])) {
      foreach ($input['cards'] as $card_data) {
         $has_text = !empty(trim($card_data['text'] ?? ''));
         $has_image = isset($card_data['image']) && is_array($card_data['image']) && !empty($card_data['image']['id']);

         if ($has_text || $has_image) {
            $processed_card = array();
            $processed_card['text'] = wp_kses_post($card_data['text']);

            $image_input = $card_data['image'] ?? array();
            $processed_image = array('id' => 0, 'url' => '');

            if (is_array($image_input)) {
               $id = absint($image_input['id'] ?? 0);

               if ($id && get_post_type($id) === 'attachment') {
                  $mime_type = get_post_mime_type($id);
                  if ($mime_type && strpos($mime_type, 'image/') === 0) {
                     $processed_image['id'] = $id;
                     $url = wp_get_attachment_url($id);
                     $processed_image['url'] = $url ? esc_url_raw($url) : '';
                  }
               }
            }

            $processed_card['image'] = $processed_image;
            $processed_cards[] = $processed_card;
         }
      }
   }
   $options['cards'] = $processed_cards;

   return $options;
}

function legerebeaute_interior_settings_page()
{
   // Подключение скриптов хелпера обязательно для работы полей изображений на странице настроек
   Legerebeaute_Image_Helper::enqueue_admin_scripts();

   // Загрузка скриптов и стилей TinyMCE
   wp_enqueue_editor();

   ?>
   <div class="wrap">
      <h1>Настройки блока «Интерьер студии»</h1>
      <form action="options.php" method="post">
         <?php
         settings_fields('legerebeaute_interior_settings_group');
         do_settings_sections('legerebeaute-interior');
         submit_button();
         ?>
      </form>
   </div>
   <?php
}

if (!function_exists('legerebeaute_get_interior_data')) {
   function legerebeaute_get_interior_data()
   {
      $options = get_option('legerebeaute_interior_settings', array());

      $data = array(
         'title' => isset($options['title']) ? $options['title'] : '',
         'cards' => array()
      );

      if (isset($options['cards']) && is_array($options['cards'])) {
         foreach ($options['cards'] as $card) {
            $image_url = '';
            if (isset($card['image']) && is_array($card['image']) && isset($card['image']['id'])) {
               $image_url = Legerebeaute_Image_Helper::get_image_url_by_id($card['image']['id'], 'full');
            } elseif (isset($card['image_id']) && $card['image_id']) {
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