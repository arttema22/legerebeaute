<?php
// single-programs.php

get_header(); ?>

<div id="primary" class="content-area">
   <main id="main" class="site-main">
      <?php if (have_posts()): ?>
         <?php while (have_posts()):
            the_post(); ?>
            <?php
            // Получаем данные из метаполей, как в services
            $short_description = get_post_meta(get_the_ID(), '_legerebeaute_short_description', true);
            $duration_text = get_post_meta(get_the_ID(), '_legerebeaute_duration_text', true);
            $procedures_count = get_post_meta(get_the_ID(), '_legerebeaute_procedures_count', true);
            $price_current = get_post_meta(get_the_ID(), '_legerebeaute_price_current', true);
            $price_old = get_post_meta(get_the_ID(), '_legerebeaute_price_old', true);
            $cta_label = get_post_meta(get_the_ID(), '_legerebeaute_cta_label', true);
            $cta_url = get_post_meta(get_the_ID(), '_legerebeaute_cta_url', true);
            $what_included = get_post_meta(get_the_ID(), '_legerebeaute_what_included', true);
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('program-single'); ?>>
               <!-- Новый класс для одиночной программы -->
               <header class="entry-header program-single__header"> <!-- Новый класс -->
                  <?php if ($image_url): ?>
                     <div class="program-single__image-container"> <!-- Новый класс -->
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                           class="program-single__image"> <!-- Новый класс -->
                     </div>
                  <?php endif; ?>
                  <div class="program-single__info"> <!-- Новый класс -->
                     <h1 class="entry-title program-single__title"><?php the_title(); ?></h1> <!-- Новый класс -->
                     <div class="program-single__meta"> <!-- Новый класс -->
                        <?php if ($duration_text): ?>
                           <span class="program-duration program-single__duration"><?php echo esc_html($duration_text); ?></span>
                           <!-- Новые классы -->
                        <?php endif; ?>
                        <?php if ($procedures_count): ?>
                           <span class="program-count program-single__count"><?php echo esc_html($procedures_count); ?></span>
                           <!-- Новые классы -->
                        <?php endif; ?>
                        <?php if ($price_current || $price_old): ?>
                           <div class="program-prices program-single__prices"> <!-- Новые классы -->
                              <?php if ($price_old && $price_current != $price_old): ?>
                                 <span class="price-old"><?php echo esc_html(number_format((int) $price_old, 0, '', ' ')); ?>
                                    ₽</span>
                              <?php endif; ?>
                              <?php if ($price_current): ?>
                                 <span class="price-current"><?php echo esc_html(number_format((int) $price_current, 0, '', ' ')); ?>
                                    ₽</span>
                              <?php endif; ?>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
               </header>

               <div class="entry-content program-single__content"> <!-- Новый класс -->
                  <?php if ($short_description): ?>
                     <div class="program-short-description program-single__intro"> <!-- Новые классы -->
                        <p><?php echo esc_html($short_description); ?></p>
                     </div>
                  <?php endif; ?>

                  <?php the_content(); ?>

                  <?php if ($what_included && is_array($what_included) && !empty($what_included)): ?>
                     <div class="program-included program-single__included"> <!-- Новые классы -->
                        <h3 class="program-single__included-title"><?php _e('Что входит?', 'legerebeaute'); ?></h3>
                        <!-- Новый класс -->
                        <ul class="program-single__included-list"> <!-- Новый класс -->
                           <?php foreach ($what_included as $item): ?>
                              <li class="program-single__included-item"><?php echo esc_html($item); ?></li> <!-- Новый класс -->
                           <?php endforeach; ?>
                        </ul>
                     </div>
                  <?php endif; ?>
               </div>

               <footer class="entry-footer program-single__footer"> <!-- Новый класс -->
                  <?php if ($cta_url && $cta_label): ?>
                     <a href="<?php echo esc_url($cta_url); ?>"
                        class="btn btn-primary program-single__footer-btn"><?php echo esc_html($cta_label); ?></a>
                     <!-- Новый класс -->
                  <?php endif; ?>
               </footer>
            </article>
         <?php endwhile; ?>
      <?php else: ?>
         <p><?php _e('Программа не найдена.', 'legerebeaute'); ?></p>
      <?php endif; ?>
   </main>
</div>

<?php get_footer(); ?>