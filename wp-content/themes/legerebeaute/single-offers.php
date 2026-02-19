<?php
// wp-content/themes/legerebeaute/single-offers.php
/**
 * Шаблон одиночной записи для CPT "Специальные предложения" (offers)
 * Использует стили и структуру, аналогичные CPT "Услуги".
 */

get_header(); ?>

<div id="primary" class="content-area">
   <main id="main" class="site-main">

      <?php while (have_posts()):
         the_post(); ?>
         <?php
         // Получаем главное изображение
         $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
         // Если будут ACF-поля для цены, описания и т.д., их можно получить здесь
         // $some_acf_field = get_field('field_name');
         ?>
         <article id="post-<?php the_ID(); ?>" <?php post_class('offer-single'); ?>>
            <header class="entry-header offer-single__header">
               <?php if ($image_url): ?>
                  <div class="offer-single__image-container">
                     <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="offer-single__image">
                  </div>
               <?php endif; ?>
               <div class="offer-single__info">
                  <h1 class="entry-title offer-single__title"><?php the_title(); ?></h1>
                  <!-- Если будут ACF-поля (например, цена), их можно добавить сюда -->
                  <!-- <div class="offer-single__meta">...</div> -->
               </div>
            </header>

            <div class="entry-content offer-single__content">
               <?php the_content(); ?>
               <!-- Если будут ACF-поля (например, подробное описание), их можно добавить сюда -->
            </div>

            <footer class="entry-footer">
               <!-- Пример CTA - можно кастомизировать через ACF или просто оставить как есть -->
               <div class="offer-single__cta">
                  <a href="#contact-form" class="btn btn--primary"><?php _e('Записаться', 'legerebeaute'); ?></a>
               </div>
            </footer>
         </article>
      <?php endwhile; ?>

   </main>
</div>

<?php get_footer(); ?>