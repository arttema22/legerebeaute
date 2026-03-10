<?php
/**
 * Template part for displaying benefits/features block.
 *
 * @package legerebeaute
 *
 */

if (!defined('ABSPATH')) {
   exit;
}
?>

<section class="features">
   <h3 class="features__title"><?= esc_html($args['benefits_section_title']) ?></h3>
   <div class="swiper features-swiper">
      <div class="swiper-wrapper">
         <?php
         $benefits_per_slide = 3; // Количество преимуществ на один слайд
         $chunks = array_chunk($args['benefits'], $benefits_per_slide);
         foreach ($chunks as $slide_benefits): ?>
            <div class="swiper-slide">
               <div class="features__slide-inner">
                  <?php foreach ($slide_benefits as $benefit): ?>
                     <article class="features__item--slide round-card">
                        <div class="round-card__image">
                           <?php if (!empty($benefit['image']['url'])) { ?>
                              <img src="<?php echo $benefit['image']['url']; ?>" alt="<?php echo esc_attr($benefit['title']); ?>"
                                 class="round-card__img">
                           <?php } ?>
                        </div>
                        <div class="round-card__content">
                           <h4 class="features-title">
                              <?php echo esc_html($benefit['title']); ?>
                           </h4>
                           <p class="features-short-description">
                              <?php echo esc_html($benefit['text']); ?>
                           </p>
                        </div>
                     </article>
                  <?php endforeach; ?>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      const swiper = new Swiper('.features-swiper', {
         direction: 'horizontal',
         loop: true,
         autoplay: {
            delay: 5000,
         },
      });
   });
</script>