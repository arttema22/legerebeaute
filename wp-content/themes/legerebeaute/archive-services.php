<?php
/**
 * The template for displaying service archive pages.
 *
 * @package legerebeaute
 */

get_header(); ?>

<main id="main" class="site-main">
   <div class="container">
      <header class="page-header">
         <h1><?php post_type_archive_title(); ?></h1>
      </header>


      <!-- Блок фильтра -->
      <!-- <div class="services-filter">
         <button type="button" class="filter-btn active" data-category="all">Все услуги</button>
         <?php
         $categories = get_terms(array(
            'taxonomy' => 'service_category',
            'hide_empty' => true,
         ));
         if (!is_wp_error($categories) && !empty($categories)) {
            foreach ($categories as $category) {
               $cat_slug_safe = esc_attr(sanitize_html_class($category->slug));
               echo '<button type="button" class="filter-btn" data-category="' . $cat_slug_safe . '">' . esc_html($category->name) . '</button>';
            }
         }
         ?>
      </div> -->
      <!-- Контейнер для услуг -->
      <!-- <div class="simple-grid" id="cards-grid">
         <?php
         $initial_query_args = array(
            'post_type' => 'services',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
         );

         $initial_query = new WP_Query($initial_query_args);

         if ($initial_query->have_posts()):
            while ($initial_query->have_posts()):
               $initial_query->the_post();
               get_template_part('template-parts/content', 'simple-card');
            endwhile;
            wp_reset_postdata();
         else:
            echo '<p class="no-services-message">Услуг пока нет</p>';
         endif;
         ?>
      </div> -->
   </div>
</main>

<?php get_template_part('template-parts/blocks/services'); ?>

<?php get_template_part('template-parts/blocks/detox-test'); ?>

<?php get_footer(); ?>