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
         $second_title = legerebeaute_get_service_meta(get_the_ID(), 'second_title');
         $benefits = legerebeaute_get_service_meta(get_the_ID(), 'benefits');
         $short_description = legerebeaute_get_service_meta(get_the_ID(), 'short_description');
         $price_options = legerebeaute_get_service_meta(get_the_ID(), 'price_options');
         $duration = legerebeaute_get_service_meta(get_the_ID(), 'duration');
         $booking_enabled = legerebeaute_get_service_meta(get_the_ID(), 'booking_enabled');
         $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
         $image_2_data = legerebeaute_get_service_meta(get_the_ID(), 'image_2');
         $perfect_match_ids = get_post_meta(get_the_ID(), '_legerebeaute_perfect_matches', true);
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

               <?php if ($image_url): ?>
                  <div class="single__image-container" style="background-image: url(<?php echo esc_url($image_url); ?>);">
                  <?php else: ?>
                     <div class="single__image-container">
                     <?php endif; ?>

                     <?php
                     $effects_img = legerebeaute_get_service_meta(get_the_ID(), 'effects_img');
                     if (!empty($effects_img)) {
                        $first_effect = array_shift($effects_img);
                        ?>
                        <div class="single__sub-description">
                           <?= $first_effect['text'] ?>
                        </div>
                        <?php
                        $remaining_effects = $effects_img;
                        get_template_part('template-parts/blocks/effects-img', '', array('effects_data' => $remaining_effects));
                     }
                     ?>
                  </div>
            </header>

            <div class="single__body">

               <?php if (is_array($image_2_data) && isset($image_2_data['url'])): ?>
                  <div class="single__image-container-2"
                     style="background-image: url(<?php echo esc_url($image_2_data['url']); ?>);">
                  <?php else: ?>
                     <div class="single__image-container-2">
                     <?php endif;
               $effects_img_2 = legerebeaute_get_service_meta(get_the_ID(), 'effects_img_2');
               if (!empty($effects_img_2))
                  get_template_part('template-parts/blocks/effects-img', '', array('effects_data' => $effects_img_2));
               ?>
                  </div>
                  <div class="single__content">
                     <?php the_content(); ?>
                  </div>
               </div>

               <?php
               if (!empty($benefits)) {
                  $benefits_section_title = '';
                  if (!empty($second_title)) {
                     $benefits_section_title = $second_title;
                  }
                  $params = [
                     'benefits' => $benefits,
                     'benefits_section_title' => $benefits_section_title
                  ];
                  get_template_part('template-parts/blocks/benefits', '', $params);
               }
               ?>

               <?php if ($price_options): ?>
                  <section class="lb-accordeon service-prices" data-close-others="false">
                     <div class="container">
                        <h2 class="section-header">Стоимость услуги</h2>
                        <div class="accordeon-item">
                           <button class="lb-accordeon-trigger" aria-expanded="false">
                              <span class="accordeon-title"><?php echo esc_html($title_to_display); ?></span>
                              <span class="accordeon-icon"></span>
                           </button>
                           <div class="accordeon-content">
                              <div class="accordeon-inner">
                                 <div class="accordeon-card__grid">
                                    <?php foreach ($price_options as $option): ?>

                                       <article class="accordeon-card">
                                          <div class="accordeon-card__item">
                                             <div class="accordeon-card__head">
                                                <h3 class="accordeon-card__title">
                                                   <?php echo esc_html($option['name']); ?>
                                                </h3>
                                                <?php if (!empty($option['description'])): ?>
                                                   <div class="service-card__more">
                                                      <div class="service-card__description">
                                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" fill="none">
                                                            <circle cx="10.5121" cy="10.4233" r="9.60394" stroke="#1D1D1B"
                                                               stroke-width="0.746566">
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
                                                   </div>
                                                <?php endif; ?>
                                             </div>
                                             <div class="accordeon-card__price">
                                                <p>Цена<br>
                                                   <strong><span
                                                         class="service-single__price-value"><?php echo esc_html($option['price']); ?>
                                                         руб.</span></strong>
                                                </p>
                                             </div>

                                             <?php if ($booking_enabled) { ?>
                                                <div class="accordeon-card__button">
                                                   <?php lb_booking_button(); ?>
                                                </div>
                                             <?php } ?>
                                          </div>
                                       </article>
                                    <?php endforeach; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </section>
               <?php endif; ?>


               <?php if (!empty($perfect_match_ids) && is_array($perfect_match_ids)) {
                  // Загружаем посты связанных услуг
                  $perfect_match_posts = get_posts(array(
                     'post_type' => 'services',
                     'post__in' => $perfect_match_ids,
                     'numberposts' => -1,
                     'post_status' => 'publish',
                     'orderby' => 'post__in',
                  ));

                  if (!empty($perfect_match_posts)) { ?>
                     <section class="lb-accordeon service-prices" data-close-others="false">
                        <div class="container">
                           <h2 class="section-header">Идеально сочетается</h2>
                           <div class="accordeon-item">
                              <button class="lb-accordeon-trigger" aria-expanded="false">
                                 <span class="accordeon-title"><?php echo esc_html($title_to_display); ?></span>
                                 <span class="accordeon-icon"></span>
                              </button>
                              <div class="accordeon-content">
                                 <div class="accordeon-inner">
                                    <div class="accordeon-card__grid">
                                       <?php

                                       foreach ($perfect_match_posts as $match_post) {
                                          setup_postdata($match_post); // Устанавливаем данные цикла для текущей услуги
                                          ?>
                                          <article class="accordeon-card">
                                             <div class="accordeon-card__item">
                                                <div class="accordeon-card__head">
                                                   <h3 class="accordeon-card__title">
                                                      <a href="<?php the_permalink($match_post->ID); ?>">
                                                         <?php echo esc_html($match_post->post_title); ?>
                                                      </a>
                                                   </h3>
                                                   <div class="service-card__more">
                                                      <?php
                                                      // Попробуем получить краткое описание или начало контента
                                                      $short_desc = get_post_meta($match_post->ID, '_legerebeaute_short_description', true);
                                                      if ($short_desc) {
                                                         echo '<p class="perfect-match-excerpt">' . esc_html($short_desc) . '</p>';
                                                      } else {
                                                         // Альтернатива: выводить начало контента
                                                         $excerpt = wp_trim_words(strip_tags($match_post->post_content), 15, '...');
                                                         if ($excerpt) {
                                                            echo '<p class="perfect-match-excerpt">' . esc_html($excerpt) . '</p>';
                                                         }
                                                      }
                                                      ?>
                                                   </div>
                                                </div>
                                                <div class="accordeon-card__price">
                                                   <p>Цена<br>
                                                      <strong><span class="service-single__price-value">

                                                            руб.</span></strong>
                                                   </p>
                                                </div>

                                                <?php if ($booking_enabled) { ?>
                                                   <div class="accordeon-card__button">
                                                      <?php lb_booking_button(); ?>
                                                   </div>
                                                <?php } ?>
                                             </div>
                                             111
                                          </article>
                                       <?php } ?>

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                     <?php wp_reset_postdata();
                  }
               }
               ?>

         </article>
      <?php endwhile; ?>

   </main>
</div>

<?php if ($booking_enabled) {
   get_template_part('template-parts/modal/booking-modal');
} ?>

<?php get_footer(); ?>