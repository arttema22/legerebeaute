<?php
// wp-content/themes/legerebeaute/inc/ajax-handlers.php

if (!defined('ABSPATH')) {
   exit;
}

// Обработчик AJAX-запроса для фильтрации услуг
function legerebeaute_filter_services_ajax_handler()
{
   $category_slug = sanitize_text_field($_POST['category']);

   $query_args = array(
      'post_type' => 'services',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'title',
      'order' => 'ASC',
   );

   if ($category_slug !== 'all') {
      $query_args['tax_query'] = array(
         array(
            'taxonomy' => 'service_category',
            'field' => 'slug',
            'terms' => $category_slug,
         ),
      );
   }

   $query = new WP_Query($query_args);

   $html = '';
   if ($query->have_posts()) {
      while ($query->have_posts()) {
         $query->the_post();
         ob_start();
         get_template_part('template-parts/content', 'round-card');
         $html .= ob_get_clean();
      }
      wp_reset_postdata();
   } else {
      $html = '<p class="no-services-message">Услуги не найдены.</p>';
   }

   wp_send_json_success($html);
}
add_action('wp_ajax_legerebeaute_filter_services', 'legerebeaute_filter_services_ajax_handler');
add_action('wp_ajax_nopriv_legerebeaute_filter_services', 'legerebeaute_filter_services_ajax_handler'); // Если нужно для гостей