<?php

$args_terms = array(
   'taxonomy' => 'service_category',
   'hide_empty' => true,
   'orderby' => 'name',
   'order' => 'ASC',
);

$categories = get_terms($args_terms);

if ($categories && !is_wp_error($categories)):

   wp_enqueue_style('lb-accordeon', get_template_directory_uri() . '/assets/css/components/accordeon.css', [], $version);
   wp_enqueue_script('lb-accordeon', get_template_directory_uri() . '/assets/js/accordeon.js', [], $version, true);

   ?>

   <section class="lb-accordeon services-accordeon" data-close-others="false">
      <div class="container">
         <?php foreach ($categories as $category):

            $args_services = array(
               'post_type' => 'services',
               'posts_per_page' => -1,
               'tax_query' => array(
                  array(
                     'taxonomy' => 'service_category',
                     'field' => 'term_id',
                     'terms' => $category->term_id,
                  ),
               ),
               'orderby' => 'title',
               'order' => 'ASC',
            );

            $services_query = new WP_Query($args_services);

            if ($services_query->have_posts()): ?>
               <div class="accordeon-item">
                  <button class="lb-accordeon-trigger" aria-expanded="false">
                     <span class="accordeon-title"><?php echo esc_html($category->name); ?></span>
                     <span class="accordeon-icon"></span>
                  </button>

                  <div class="accordeon-content">
                     <div class="accordeon-inner">
                        <div class="accordeon-card__grid">
                           <?php while ($services_query->have_posts()):
                              $services_query->the_post();
                              $short_desc = get_post_meta(get_the_ID(), '_legerebeaute_short_description', true);
                              ?>

                              <article class="accordeon-card">
                                 <a href="<?php the_permalink(); ?>">
                                    <div class="accordeon-card__item">
                                       <h3 class="accordeon-card__title">
                                          <?php the_title(); ?>
                                       </h3>
                                       <p class="service-card__more">Подробнее</p>
                                    </div>
                                    <?php if ($short_desc): ?>
                                       <div class="service-card__desc"><?php echo esc_html($short_desc); ?></div>
                                    <?php endif; ?>
                                 </a>
                              </article>
                           <?php endwhile;
                           wp_reset_postdata(); ?>
                        </div>
                        <div class="accordeon-card__img">
                           <?php if (function_exists('z_taxonomy_image'))
                              z_taxonomy_image($category->term_id); ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
         <?php endforeach; ?>
      </div>
   </section>

<?php endif; ?>