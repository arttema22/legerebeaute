<?php
/**
 * Template part for displaying a single service card in archive views.
 *
 * @package legerebeaute
 */

$service_id = get_the_ID();
$the_title_value = get_the_title();
$main_title_value = legerebeaute_get_meta(get_the_ID(), 'main_title');

// Определяем, что выводить
if (!empty($main_title_value) && $main_title_value !== $the_title_value) {
   // Если $main_title заполнен и НЕ совпадает с $the_title, выводим $main_title
   $title_to_display = $main_title_value;
} else {
   // В остальных случаях (пустой $main_title или совпадение) выводим $the_title
   $title_to_display = $the_title_value;
}
$short_description = legerebeaute_get_meta($service_id, 'short_description');
?>

<a href="<?php the_permalink(); ?>">
   <article id="post-<?php the_ID(); ?>" <?php post_class('simple-card'); ?>>
      <div class="simple-card__content">
         <p class="entry-title">
            <?php echo esc_html($title_to_display); ?>
         </p>
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none">
            <circle cx="31.7127" cy="31.7471" r="31.544" fill="#D4A869"></circle>
            <path fill-rule="evenodd" clip-rule="evenodd"
               d="M22.4334 41.0263C22.2256 40.8186 22.2256 40.4817 22.4334 40.2739L39.3311 23.3762H34.8496C34.5557 23.3762 34.3175 23.138 34.3175 22.8442C34.3175 22.5504 34.5557 22.3122 34.8496 22.3122H40.5689C40.5766 22.3122 40.5842 22.3123 40.5918 22.3127C40.7358 22.3063 40.8819 22.358 40.9918 22.468C41.1076 22.5838 41.1589 22.7397 41.1456 22.891C41.147 22.9073 41.1478 22.9238 41.1478 22.9404L41.1477 28.6105C41.1477 28.9043 40.9095 29.1425 40.6156 29.1425C40.3218 29.1425 40.0836 28.9043 40.0836 28.6105L40.0837 24.1284L23.1858 41.0263C22.978 41.2341 22.6412 41.2341 22.4334 41.0263Z"
               fill="#FEFEFE"></path>
         </svg>
      </div>
   </article>
</a>