<?php
/**
 * Template part for displaying benefits/features block.
 *
 * @package legerebeaute
 *
 */

if (empty($benefits)) {
   return;
}
?>

<section class="features">
   <h3 class="features__title">Преимущества приема в Legere Beaute</h3>
   <div class="swiper features-swiper">
      <div class="swiper-wrapper">
         <?php
         $benefits_per_slide = 3; // Количество преимуществ на один слайд
         $chunks = array_chunk($benefits, $benefits_per_slide);
         foreach ($chunks as $slide_benefits): ?>
            <div class="swiper-slide">
               <div class="features__slide-inner">
                  <?php foreach ($slide_benefits as $benefit): ?>
                     <article class="features__item--slide round-card">
                        <?php if (!empty($benefit['image_id'])): ?>
                           <?php $image_src = wp_get_attachment_image_src($benefit['image_id'], 'full'); ?>
                           <?php if ($image_src): ?>
                              <div class="round-card__image">
                                 <img src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo esc_attr($benefit['title']); ?>"
                                    class="round-card__img">
                              </div>
                           <?php endif; ?>
                        <?php endif; ?>
                        <div class="round-card__content">
                           <h4 class="features-title">
                              <?php echo esc_html($benefit['title']); ?>:
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