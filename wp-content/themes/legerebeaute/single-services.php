<?php
/**
 * The template for displaying single service posts.
 *
 * @package legerebeaute
 */

get_header(); ?>

<div id="primary" class="content-area">
   <main id="main" class="site-main">

      <?php while (have_posts()):
         the_post();

         $the_title_value = get_the_title();
         $main_title_value = legerebeaute_get_meta(get_the_ID(), 'main_title'); // Метаполе 'main_title'
         // Определяем, что выводить
         if (!empty($main_title_value) && $main_title_value !== $the_title_value) {
            // Если $main_title заполнен и НЕ совпадает с $the_title, выводим $main_title
            $title_to_display = $main_title_value;
         } else {
            // В остальных случаях (пустой $main_title или совпадение) выводим $the_title
            $title_to_display = $the_title_value;
         }
         $benefits = legerebeaute_get_service_meta(get_the_ID(), 'benefits');
         $short_description = legerebeaute_get_service_meta(get_the_ID(), 'short_description');
         $price_current = legerebeaute_get_service_meta(get_the_ID(), 'price_current');
         $price_old = legerebeaute_get_service_meta(get_the_ID(), 'price_old');
         $duration = legerebeaute_get_service_meta(get_the_ID(), 'duration');
         $booking_enabled = legerebeaute_get_service_meta(get_the_ID(), 'booking_enabled');
         $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); // Или другой размер
         $image_2_id = legerebeaute_get_service_meta(get_the_ID(), 'image_2'); // Получаем ID изображения 2
         $image_2_url = wp_get_attachment_image_url($image_2_id, 'full'); // Получаем URL изображения (замените 'full' на нужный размер)
         ?>
         <article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>

            <header class="single__header">
               <div class="single__info">
                  <h1 class="single__title"><?php echo esc_html($title_to_display); ?></h1>

                  <?php if ($short_description): ?>
                     <div class="single__short-description">
                        <p><?php echo esc_html($short_description); ?></p>
                     </div>
                  <?php endif; ?>
                  <?php
                  $effects_txt = legerebeaute_get_service_meta(get_the_ID(), 'effects_txt');
                  if (!empty($effects_txt)) {
                     $template_args = [
                        'effects_txt' => $effects_txt,
                     ];
                     $template_file = locate_template('template-parts/blocks/effects-txt.php');
                     if ($template_file) {
                        extract($template_args, EXTR_SKIP);
                        include $template_file;
                     }
                  }
                  ?>
                  <?php if ($booking_enabled) {
                     lb_booking_button();
                  } ?>
               </div>
               <figure class="single__image-container">
                  <?php if ($image_url): ?>
                     <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="single__image">
                  <?php endif; ?>
                  <?php
                  $effects_img = legerebeaute_get_service_meta(get_the_ID(), 'effects_img');
                  if (!empty($effects_img)) {
                     $template_args = [
                        'effects_img' => $effects_img,
                     ];
                     $template_file = locate_template('template-parts/blocks/effects-img.php');
                     if ($template_file) {
                        extract($template_args, EXTR_SKIP);
                        include $template_file;
                     }
                  }
                  ?>
               </figure>
            </header>

            <div class="single__body">
               <?php if ($image_2_url): ?>
                  <figure class="single__image-container-2">
                     <img src="<?php echo esc_url($image_2_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="single__image-2">
                     <?php if ($duration): ?>
                        <span class="service-single__duration">
                           Длительность: <?php echo esc_html($duration); ?>
                        </span>
                     <?php endif; ?>
                  </figure>
               <?php endif; ?>
               <div class="single__content">
                  <?php the_content(); ?>
               </div>
            </div>

            <?php
            if (!empty($benefits)) {
               $template_args = [
                  'benefits' => $benefits,
               ];
               $template_file = locate_template('template-parts/blocks/benefits.php');
               if ($template_file) {
                  extract($template_args, EXTR_SKIP); // EXTR_SKIP не перезаписывает существующие переменные
                  include $template_file;
               }
            }
            ?>

            <?php if ($price_current || $price_old): ?>
               <section class="service-prices">
                  <h2>Стоимость Услуги</h2>
                  <div class="service-single__price">

                     <?php if ($price_current): ?>
                        <div>
                           <span class="price-current"><?php echo esc_html($price_current); ?> ₽</span>
                           <?php if ($price_old && $price_current != $price_old): ?>
                              <span class="price-old"><?php echo esc_html($price_old); ?> ₽</span>
                           <?php endif; ?>
                        </div>
                     <?php endif; ?>
                     <?php if ($booking_enabled) {
                        lb_booking_button();
                     } ?>
                  </div>
               </section>
            <?php endif; ?>
         </article>
      <?php endwhile; ?>

   </main>
</div>

<?php if ($booking_enabled) {
   get_template_part('template-parts/modal/booking-modal');
} ?>

<?php get_footer(); ?>