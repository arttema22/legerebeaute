<?php
/**
 * Настройки блока "Детокс-тест" (Насколько зашлакован ваш организм?)
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_detox_test_settings_init()
{
   register_setting('legerebeaute_detox_test_settings_group', 'legerebeaute_detox_test_settings');

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

   echo '<div style="display:none;">';
   wp_editor('', 'detox_test_hidden_editor_for_loading', array(
      'quicktags' => true,
      'media_buttons' => true,
      'teeny' => false,
      'tinymce' => array(
         'toolbar1' => 'formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
         'toolbar2' => 'styleselect,fontselect,fontsizeselect,forecolor,backcolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
      )
   ));
   echo '</div>';
   echo '<style>
       #detox-test-cards-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
       #detox-test-cards-table th, #detox-test-cards-table td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
       .card-image-preview { width: 100px; height: auto; max-height: 100px; object-fit: cover; display: block; margin-bottom: 5px; }
       .remove-card-row, .select-card-image-btn, .remove-card-image-btn { margin-top: 5px; }
   </style>';
   echo '<table id="detox-test-cards-table">';
   echo '<thead><tr><th>Изображение</th><th>Текст (WYSIWYG)</th><th></th></tr></thead>';
   echo '<tbody>';

   foreach ($cards as $index => $card) {
      $image_id = isset($card['image_id']) ? absint($card['image_id']) : 0;
      $image_src = $image_id ? wp_get_attachment_image_src($image_id, 'thumbnail') : false;
      $image_html = $image_src ? '<img src="' . esc_url($image_src[0]) . '" class="card-image-preview" alt="Предпросмотр">' : '';
      $text_value = isset($card['text']) ? esc_textarea($card['text']) : '';

      echo '<tr>';
      echo '<td style="width: 20%;">';
      echo '<div class="card-image-preview-container">' . $image_html . '</div>';
      echo '<input type="hidden" name="legerebeaute_detox_test_settings[cards][' . $index . '][image_id]" class="card-image-id-field" value="' . $image_id . '">';
      echo '<button type="button" class="button button-small select-card-image-btn">Выбрать изображение</button>';
      if ($image_id) {
         echo '<button type="button" class="button button-small remove-card-image-btn">Удалить изображение</button>';
      }
      echo '</td>';
      echo '<td>';
      $textarea_id = 'detox_test_card_text_' . uniqid();
      echo '<textarea id="' . $textarea_id . '" name="legerebeaute_detox_test_settings[cards][' . $index . '][text]" style="width:100%; height: 100px;">' . $text_value . '</textarea>';

      $base_config = array(
         'selector' => '#' . $textarea_id,
         'plugins' => 'lists link image media charmap hr paste fullscreen',
         'menubar' => false,
         'toolbar1' => 'formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
         'toolbar2' => 'styleselect,fontselect,fontsizeselect,forecolor,backcolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
         'height' => 150,
      );

      $config_json_string = wp_json_encode($base_config);

      echo '<script type="text/template" class="tinymce-config-template" data-target-id="' . $textarea_id . '">';
      echo 'var config = ' . $config_json_string . ';';
      echo 'config.setup = function(editor) {';
      echo '  editor.on("change", function() {';
      echo '    editor.save();';
      echo '  });';
      echo '};';
      echo '</script>';

      echo '</td>';
      echo '<td style="width: 10%;"><button type="button" class="button button-small remove-card-row">Удалить карточку</button></td>';
      echo '</tr>';
   }
   echo '<tr class="card-template" style="display: none;">';
   echo '<td style="width: 20%;">';
   echo '<div class="card-image-preview-container"></div>';
   echo '<input type="hidden" name="" class="card-image-id-field" value="">';
   echo '<button type="button" class="button button-small select-card-image-btn">Выбрать изображение</button>';
   echo '<button type="button" class="button button-small remove-card-image-btn" style="display:none;">Удалить изображение</button>';
   echo '</td>';
   echo '<td>';
   $textarea_id = 'detox_test_card_text_NEW';
   echo '<textarea id="' . $textarea_id . '" name="" style="width:100%; height: 100px;"></textarea>';

   $base_config_new = array(
      'selector' => '#REPLACE_WITH_NEW_ID',
      'plugins' => 'lists link image media charmap hr paste fullscreen',
      'menubar' => false,
      'toolbar1' => 'formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
      'toolbar2' => 'styleselect,fontselect,fontsizeselect,forecolor,backcolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
      'height' => 150,
   );
   $config_json_string_new = wp_json_encode($base_config_new);
   echo '<script type="text/template" class="tinymce-config-template" data-target-id="' . $textarea_id . '">';
   echo 'var config = ' . $config_json_string_new . ';';
   echo 'config.setup = function(editor) {';
   echo '  editor.on("change", function() {';
   echo '    editor.save();';
   echo '  });';
   echo '};';
   echo '</script>';
   echo '</td>';
   echo '<td style="width: 10%;"><button type="button" class="button button-small remove-card-row">Удалить карточку</button></td>';
   echo '</tr>';

   echo '</tbody>';
   echo '</table>';
   echo '<button type="button" id="add-detox-test-card-row" class="button">Добавить карточку</button>';

   wp_enqueue_media();
   $script_url = get_template_directory_uri() . '/assets/js/admin-detox-test-repeater.js';
   wp_enqueue_script('admin-detox-test-repeater', $script_url, array('jquery'), '1.0', true);

   wp_localize_script('admin-detox-test-repeater', 'DetoxTestRepeater', array(
      'fieldNamePrefix' => 'legerebeaute_detox_test_settings[cards]',
      'imageFieldName' => '[image_id]',
      'textFieldName' => '[text]'
   ));
}

function legerebeaute_detox_test_settings_page()
{
   wp_enqueue_media();
   $script_url = get_template_directory_uri() . '/assets/js/admin-detox-test-repeater.js';
   wp_enqueue_script('admin-detox-test-repeater', $script_url, array('jquery'), '1.0', true);

   wp_localize_script('admin-detox-test-repeater', 'DetoxTestRepeater', array(
      'fieldNamePrefix' => 'legerebeaute_detox_test_settings[cards]',
      'imageFieldName' => '[image_id]',
      'textFieldName' => '[text]'
   ));

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
            if (isset($card['image_id']) && $card['image_id']) {
               $img_src = wp_get_attachment_image_src(absint($card['image_id']), 'full');
               $image_url = $img_src ? $img_src[0] : '';
            } else {
               $image_url = '';
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