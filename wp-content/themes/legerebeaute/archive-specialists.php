<?php
/**
 * The template for displaying specialists archive pages.
 *
 * @package legerebeaute
 */

get_header(); ?>

<div id="primary" class="content-area">
   <main id="main" class="site-main">
      <div class="container">
         <header class="page-header specialists-heading">
            <h1>Наши Специалисты</h1>
         </header>

         <?php
         $roles = get_terms([
            'taxonomy' => 'specialist_role',
            'hide_empty' => true,
         ]);

         if (!is_wp_error($roles) && !empty($roles)):
            foreach ($roles as $role):

               $specialists_query = new WP_Query([
                  'post_type' => 'specialists',
                  'posts_per_page' => -1,
                  'tax_query' => [
                     [
                        'taxonomy' => 'specialist_role',
                        'field' => 'term_id',
                        'terms' => $role->term_id,
                     ],
                  ],
                  'orderby' => 'title',
                  'order' => 'ASC',
               ]);

               if ($specialists_query->have_posts()): ?>
                  <div class="specialists-group">
                     <h2 class="specialists-group__title"><?php echo esc_html($role->name); ?></h2>
                     <div class="specialists-grid">
                        <?php while ($specialists_query->have_posts()):
                           $specialists_query->the_post();
                           get_template_part('template-parts/content', 'round-card');
                        endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                     </div>
                  </div>
               <?php endif; ?>
            <?php endforeach; ?>

         <?php else: ?>

            <p><?php _e('Специалистов пока нет.', 'legerebeaute'); ?></p>

         <?php endif; ?>
      </div>
   </main>
</div>

<?php get_footer(); ?>