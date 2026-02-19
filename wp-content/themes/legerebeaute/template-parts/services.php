<?php
/**
 * Блок "Услуги" 
 */

// Запрос всех услуг
$services = new WP_Query([
   'post_type' => 'services',
   'posts_per_page' => -1,
   'orderby' => 'title',
   'order' => 'ASC',
   'meta_query' => [
      [
         'key' => '_legerebeaute_show_on_home',
         'value' => '1',
         'compare' => '='
      ]
   ],
]);

if (!empty($services)):

   if ($services->have_posts()):
      ?>
      <section class="section services" aria-labelledby="page-header">
         <div class="container">
            <h2 class="page-header">Услуги</h2>
            <div class="cards-grid">
               <?php while ($services->have_posts()):
                  $services->the_post();
                  get_template_part('template-parts/content', 'round-card');
               endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
         </div>
      </section>

   <?php endif;
endif; ?>