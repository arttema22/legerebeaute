<?php
/**
 * The template for displaying archive pages.
 *
 * @package legerebeaute
 */

get_header(); ?>

<div id="primary" class="content-area">
   <main id="main" class="site-main">
      <div class="container">
         <header class="page-header">
            <h1><?php post_type_archive_title(); ?></h1>
         </header>

         <?php if (have_posts()): ?>
            <div class="cards-grid">
               <?php while (have_posts()):
                  the_post();
                  get_template_part('template-parts/content', 'round-card');
               endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

         <?php else: ?>

            <p><?php _e('Услуг пока нет.', 'legerebeaute'); ?></p>

         <?php endif; ?>
      </div>
   </main>
</div>

<?php get_footer(); ?>