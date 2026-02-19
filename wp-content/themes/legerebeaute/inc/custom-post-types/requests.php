<?php
/**
 * Служебный CPT "Заявки" — для хранения данных из CF7
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_register_requests_cpt()
{
   $args = [
      'label' => 'Заявки',
      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'show_in_admin_bar' => false,
      'show_in_nav_menus' => false,
      'can_export' => true,
      'has_archive' => false,
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'capability_type' => 'post',
      'capabilities' => ['create_posts' => 'do_not_allow',],
      'map_meta_cap' => true,
      'supports' => ['title'],
      'menu_icon' => 'dashicons-email-alt',
      'menu_position' => 100,
   ];

   register_post_type('requests', $args);
}

/**
 * Добавление кастомных колонок в список заявок (CPT 'requests')
 */
add_filter('manage_requests_posts_columns', 'legerebeaute_requests_columns');
function legerebeaute_requests_columns($columns)
{
   // Удаляем ненужные колонки
   unset($columns['date']);

   // Добавляем нужные
   $new_columns = [
      'cb' => $columns['cb'], // чекбокс
      'title' => 'Заявка',
      'name' => 'Имя',
      'phone' => 'Телефон',
      'service' => 'Услуга',
      'date_visit' => 'Дата',
      'time_visit' => 'Время',
      'ip' => 'IP',
      'submitted' => 'Отправлена',
   ];

   return $new_columns;
}

/**
 * Вывод значений в кастомных колонках
 */
add_action('manage_requests_posts_custom_column', 'legerebeaute_requests_column_content', 10, 2);
function legerebeaute_requests_column_content($column, $post_id)
{
   switch ($column) {
      case 'name':
         echo get_post_meta($post_id, 'lb-name-01', true) ?: '—';
         break;
      case 'phone':
         echo get_post_meta($post_id, 'lb-tel-01', true) ?: '—';
         break;
      case 'service':
         echo get_post_meta($post_id, 'lb-service-01', true) ?: '—';
         break;
      case 'date_visit':
         $date = get_post_meta($post_id, 'lb-date-01', true);
         echo $date ? wp_date('d.m.Y', strtotime($date)) : '—';
         break;
      case 'time_visit':
         echo get_post_meta($post_id, 'lb-time-01', true) ?: '—';
         break;
      case 'ip':
         echo get_post_meta($post_id, '_user_ip', true) ?: '—';
         break;
      case 'submitted':
         echo get_the_date('d.m.Y H:i', $post_id);
         break;
   }
}

/**
 * Сортировка по дате отправки (по умолчанию — новые сверху)
 */
add_action('pre_get_posts', 'legerebeaute_requests_default_order');
function legerebeaute_requests_default_order($query)
{
   if (!is_admin() || !$query->is_main_query()) {
      return;
   }

   if ($query->get('post_type') === 'requests') {
      $query->set('orderby', 'date');
      $query->set('order', 'DESC');
   }
}

add_action('init', 'legerebeaute_register_requests_cpt');

/**
 * Добавление метабокса "Данные заявки" в карточку CPT 'requests'
 */
add_action('add_meta_boxes', 'legerebeaute_add_requests_metabox');
function legerebeaute_add_requests_metabox()
{
   add_meta_box(
      'requests_data_metabox',
      'Данные заявки',
      'legerebeaute_render_requests_metabox',
      'requests',
      'normal',
      'high'
   );
}

/**
 * Вывод данных заявки (только для чтения)
 */
function legerebeaute_render_requests_metabox($post)
{
   // Запрет редактирования
   wp_nonce_field('requests_view_only', 'requests_view_only_nonce');

   $fields = [
      'lb-service-01' => 'Услуга',
      'lb-date-01' => 'Дата визита',
      'lb-time-01' => 'Время',
      'lb-name-01' => 'Имя',
      'lb-tel-01' => 'Телефон',
      'lb-consent-01' => 'Согласие на обработку',
      '_user_ip' => 'IP-адрес',
   ];

   echo '<table class="form-table" style="margin-top: 10px;">';
   foreach ($fields as $meta_key => $label) {
      $value = get_post_meta($post->ID, $meta_key, true);

      if ($meta_key === 'lb-consent-01') {
         $value = ($value === '1') ? 'Да' : 'Нет';
      } elseif ($meta_key === 'lb-date-01' && $value) {
         $value = wp_date('d.m.Y', strtotime($value));
      } elseif (empty($value)) {
         $value = '—';
      }

      echo '<tr>';
      echo '<th scope="row" style="width: 200px; vertical-align: top;">' . esc_html($label) . '</th>';
      echo '<td>' . esc_html($value) . '</td>';
      echo '</tr>';
   }
   echo '</table>';

}
