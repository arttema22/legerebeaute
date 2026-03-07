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
         $price_options = legerebeaute_get_service_meta(get_the_ID(), 'price_options');
         $duration = legerebeaute_get_service_meta(get_the_ID(), 'duration');
         $booking_enabled = legerebeaute_get_service_meta(get_the_ID(), 'booking_enabled');
         $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
         $image_2_id = legerebeaute_get_service_meta(get_the_ID(), 'image_2');
         $image_2_url = wp_get_attachment_image_url($image_2_id, 'full');
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

            <?php if ($price_options): ?>
               <section class="service-prices">
                  <h2 class="section-header">Стоимость услуги</h2>
                  <div class="service-single__price">
                     <div class="service-single__items">
                        <h5><?php the_title() ?></h5>
                        <?php foreach ($price_options as $option): ?>
                           <div class="service-single__item">

                              <div class="service-single__price-name">
                                 <p><?php echo esc_html($option['name']); ?></p>


                                 <?php if (!empty($option['description'])): ?>
                                    <div class="btn btn-open-description-modal">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" fill="none">
                                          <circle cx="10.5121" cy="10.4233" r="9.60394" stroke="#1D1D1B" stroke-width="0.746566">
                                          </circle>
                                          <path
                                             d="M9.85409 12.5394C9.85409 12.1194 9.96609 11.7321 10.1901 11.3774C10.4141 11.0228 10.7548 10.5888 11.2121 10.0754C11.6508 9.57144 11.9728 9.15611 12.1781 8.82944C12.3928 8.49344 12.5001 8.13411 12.5001 7.75144C12.5001 7.21944 12.2901 6.82277 11.8701 6.56144C11.4594 6.30011 10.8808 6.16944 10.1341 6.16944C9.25675 6.16944 8.39809 6.42144 7.55808 6.92544V6.12744C7.93142 5.89411 8.34675 5.71211 8.80409 5.58144C9.26142 5.44144 9.74208 5.37144 10.2461 5.37144C11.1701 5.37144 11.9168 5.57211 12.4861 5.97344C13.0554 6.37477 13.3401 6.94411 13.3401 7.68144C13.3401 8.14811 13.2188 8.57744 12.9761 8.96944C12.7428 9.35211 12.3834 9.81877 11.8981 10.3694C11.4874 10.8268 11.1748 11.2188 10.9601 11.5454C10.7548 11.8628 10.6521 12.1941 10.6521 12.5394H9.85409ZM9.68609 14.8914C9.68609 14.7234 9.74209 14.5928 9.85409 14.4994C9.96609 14.3968 10.1014 14.3454 10.2601 14.3454C10.4188 14.3454 10.5494 14.3968 10.6521 14.4994C10.7641 14.5928 10.8201 14.7234 10.8201 14.8914C10.8201 15.0594 10.7641 15.1948 10.6521 15.2974C10.5494 15.3908 10.4188 15.4374 10.2601 15.4374C10.1014 15.4374 9.96609 15.3908 9.85409 15.2974C9.74209 15.1948 9.68609 15.0594 9.68609 14.8914Z"
                                             fill="#1D1D1B">
                                          </path>
                                       </svg>
                                    </div>
                                    <!-- Модальное окно для описания -->
                                    <div id="description-modal" class="modal-overlay" style="display: none;">
                                       <div class="modal-content">
                                          <span class="close">&times;</span>
                                          <p id="modal-description-text"></p>
                                          <p class="service-single__price-description">
                                             <?php echo esc_html($option['description']); ?>
                                          </p>
                                       </div>
                                    </div>
                                 <?php endif; ?>
                              </div>

                              <div>
                                 <p>Цена<br>
                                    <strong><span class="service-single__price-value"><?php echo esc_html($option['price']); ?>
                                          руб.</span></strong>
                                 </p>
                              </div>

                              <?php if ($booking_enabled) {
                                 lb_booking_button();
                              } ?>

                           </div>
                        <?php endforeach; ?>
                     </div>
                  </div>
               </section>
            <?php endif; ?>

            <?php if ($price_current || $price_old): ?>
               <section class="service-prices">
                  <div class="service-single__price">
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