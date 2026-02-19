<?php
/**
 * Template part for displaying a single service card in archive views.
 *
 * @package legerebeaute
 */

$service_id = get_the_ID();

// Получаем значения
$the_title_value = get_the_title(); // Заголовок поста
$main_title_value = legerebeaute_get_meta(get_the_ID(), 'main_title'); // Метаполе 'main_title'

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

<article id="post-<?php the_ID(); ?>" <?php post_class('round-card'); ?>>
   <?php if (has_post_thumbnail()) { ?>
      <div class="round-card__image">
         <?php the_post_thumbnail('full'); ?>
      </div>
   <?php } ?>
   <div class="round-card__content">
      <h3 class="entry-title">
         <a href="<?php the_permalink(); ?>"><?php echo esc_html($title_to_display); ?></a>
      </h3>
      <a href="<?php the_permalink(); ?>" class="btn btn-more">
         Подробнее
         <span class="btn-icon"></span>
      </a>
   </div>
</article>