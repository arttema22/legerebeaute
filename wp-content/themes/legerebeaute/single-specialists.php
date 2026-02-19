<?php
/**
 * The template for displaying single specialist posts.
 *
 * @package legerebeaute
 */

get_header(); ?>

<div id="primary" class="content-area">
   <main id="main" class="site-main">

      <?php while (have_posts()):
         the_post(); ?>
         <?php
         $position_short = legerebeaute_get_specialist_meta(get_the_ID(), 'position_short');
         $education = legerebeaute_get_specialist_meta(get_the_ID(), 'education');
         $experience = legerebeaute_get_specialist_meta(get_the_ID(), 'experience');
         $problems_list = legerebeaute_get_specialist_meta(get_the_ID(), 'problems_list');
         $consultation_formats = legerebeaute_get_specialist_meta(get_the_ID(), 'consultation_formats');
         $cta_label = legerebeaute_get_specialist_meta(get_the_ID(), 'cta_label');
         $cta_url = legerebeaute_get_specialist_meta(get_the_ID(), 'cta_url');
         $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
         ?>

         <article id="post-<?php the_ID(); ?>" <?php post_class('specialist-single'); ?>>
            <header class="entry-header specialist-single__header">
               <?php if ($image_url): ?>
                  <div class="specialist-single__image-container">
                     <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="specialist-single__image">
                  </div>
               <?php endif; ?>
               <div class="specialist-single__info">
                  <h1 class="entry-title specialist-single__title">
                     <?php echo esc_html($position_short ?: get_the_title()); ?></h1>
                  <div class="specialist-single__meta">
                     <p class="specialist-name specialist-single__name"><?php the_title(); ?></p>
                  </div>
               </div>
            </header>

            <div class="entry-content specialist-single__content">
               <?php if ($education): ?>
                  <div class="specialist-education specialist-single__education">
                     <h3 class="specialist-single__education-title"><?php _e('Образование', 'legerebeaute'); ?></h3>
                     <div class="specialist-single__education-content">
                        <?php echo wp_kses_post($education); ?>
                     </div>
                  </div>
               <?php endif; ?>

               <?php if ($experience): ?>
                  <div class="specialist-experience specialist-single__experience">
                     <h3 class="specialist-single__experience-title"><?php _e('Опыт работы', 'legerebeaute'); ?></h3>
                     <div class="specialist-single__experience-content">
                        <?php echo wp_kses_post($experience); ?>
                     </div>
                  </div>
               <?php endif; ?>

               <?php if ($problems_list && is_array($problems_list) && !empty($problems_list)): ?>
                  <div class="specialist-problems specialist-single__problems">
                     <h3 class="specialist-single__problems-title">
                        <?php _e('Проблемы, с которыми можно прийти', 'legerebeaute'); ?></h3>
                     <ul class="specialist-single__problems-list">
                        <?php foreach ($problems_list as $problem): ?>
                           <li class="specialist-single__problem-item"><?php echo esc_html($problem); ?></li>
                        <?php endforeach; ?>
                     </ul>
                  </div>
               <?php endif; ?>

               <?php if ($consultation_formats && is_array($consultation_formats) && !empty($consultation_formats)): ?>
                  <div class="specialist-consultations specialist-single__consultations">
                     <h3 class="specialist-single__consultations-title"><?php _e('Форматы консультаций', 'legerebeaute'); ?>
                     </h3>
                     <div class="specialist-single__consultations-wrapper">
                        <?php foreach ($consultation_formats as $format): ?>
                           <div class="specialist-single__consultation-item">
                              <h4 class="specialist-single__consultation-title"><?php echo esc_html($format['title']); ?></h4>
                              <p class="specialist-single__consultation-desc"><?php echo esc_html($format['description']); ?></p>
                              <p class="specialist-single__consultation-price"><?php echo esc_html($format['price']); ?></p>
                           </div>
                        <?php endforeach; ?>
                     </div>
                  </div>
               <?php endif; ?>

               <!-- Вставка формы онлайн-записи -->
               <?php echo do_shortcode('[legerebeaute_online_record_form]'); ?>
            </div>

            <footer class="entry-footer specialist-single__footer">
               <?php if ($cta_url && $cta_label): ?>
                  <a href="<?php echo esc_url($cta_url); ?>"
                     class="btn btn-primary specialist-single__footer-btn"><?php echo esc_html($cta_label); ?></a>
               <?php endif; ?>
            </footer>
         </article>
      <?php endwhile; ?>

   </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>