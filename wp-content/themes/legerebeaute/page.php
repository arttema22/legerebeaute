<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package legerebeaute
 */

get_header(); ?>

<main id="primary" class="site-main">

   <div class="container">

      <?php
      // Запуск цикла WordPress
      if (have_posts()):

         // Начало цикла
         while (have_posts()):
            the_post();

            // Подключаем шаблон для содержимого страницы.
            // Стандартный файл для этого - content-page.php
            get_template_part('template-parts/content', 'page');

         endwhile; // Конец цикла.
      
         // Пагинация (редко используется на простых страницах, но можно оставить)
         // the_posts_navigation();
      
      else:  // Если постов нет
      
         // Подключаем шаблон для случая, когда ничего не найдено
         get_template_part('template-parts/content', 'none');

      endif; // Конец проверки цикла.
      ?>

   </div> <!-- .container -->

</main><!-- #main -->

<?php
get_footer();