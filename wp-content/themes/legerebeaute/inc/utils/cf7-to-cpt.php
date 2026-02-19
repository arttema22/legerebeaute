<?php
/**
 * Сохранение данных Contact Form 7 в CPT "requests"
 */

add_action('wpcf7_mail_sent', 'legerebeaute_save_cf7_to_requests');

function legerebeaute_save_cf7_to_requests($contact_form)
{

   $form_id = $contact_form->id();
   $options = get_option('legerebeaute_settings');
   $allowed_form_id = isset($options['сf7_id']) ? (int) $options['сf7_id'] : 0;
   if ($form_id !== $allowed_form_id) {
      return;
   }

   // Получаем данные формы
   $submission = WPCF7_Submission::get_instance();
   if (!$submission)
      return;

   $posted_data = $submission->get_posted_data();

   // Формируем заголовок
   $title = !empty($posted_data['lb-name-01'])
      ? 'Заявка от ' . sanitize_text_field($posted_data['lb-name-01'])
      : 'Новая заявка';

   // Создаём запись
   $request_id = wp_insert_post([
      'post_type' => 'requests',
      'post_title' => $title,
      'post_status' => 'publish',
      'post_author' => get_current_user_id() ?: 1,
   ]);

   // Список полей для сохранения как метаданных
   $fields_to_save = [
      'lb-service-01',
      'lb-date-01',
      'lb-time-01',
      'lb-name-01',
      'lb-tel-01',
      'lb-consent-01', // будет "1", если согласие дано
   ];

   if ($request_id && !is_wp_error($request_id)) {
      foreach ($fields_to_save as $field_name) {
         if (isset($posted_data[$field_name])) {
            $value = $posted_data[$field_name];
            if (is_array($value)) {
               $value = implode(', ', array_map('sanitize_text_field', $value));
            } else {
               $value = sanitize_text_field($value);
            }
            update_post_meta($request_id, $field_name, $value);
         }
      }

      // Служебные метаданные
      update_post_meta($request_id, '_user_ip', sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''));

      // Флаг, что есть новая заявка
      set_transient('legerebeaute_new_request_notice', true, 60 * 60); // 1 час
   }
}

add_action('admin_notices', 'legerebeaute_new_request_admin_notice');
function legerebeaute_new_request_admin_notice()
{
   if (!current_user_can('edit_posts'))
      return;

   if (get_transient('legerebeaute_new_request_notice')) {
      echo '<div class="notice notice-info is-dismissible">
                <p><strong>Новая заявка!</strong> Поступила новая запись в разделе <a href="' . admin_url('edit.php?post_type=requests') . '">«Заявки»</a>.</p>
              </div>';
      delete_transient('legerebeaute_new_request_notice'); // показываем один раз
   }
}