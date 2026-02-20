<?php
/**
 * Шаблон главной страницы
 */

get_header();
?>

<main class="site-main" role="main">

   <?php get_template_part('template-parts/hero'); ?>

   <?php get_template_part('template-parts/services'); ?>

   <?php get_template_part('template-parts/blocks/detox-test'); ?>

   <?php get_template_part('template-parts/blocks/about'); ?>

   <?php get_template_part('template-parts/blocks/values'); ?>

   <?php get_template_part('template-parts/blocks/interior'); ?>

</main>

<?php
get_footer();