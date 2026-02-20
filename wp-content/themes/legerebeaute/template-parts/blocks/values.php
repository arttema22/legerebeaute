<?php
$values_data = legerebeaute_get_values_block_data();
$title = $values_data['title'] ?? '';
$cards = $values_data['cards'] ?? [];

global $card;

if (!empty($cards)):
   ?>

   <section class="features">
      <div class="container">
         <h2 class="section-header">
            <?php echo esc_html($title); ?>
         </h2>
         <div class="swiper values-swiper">
            <div class="swiper-wrapper">
               <?php
               $benefits_per_slide = 3;
               $chunks = array_chunk($cards, $benefits_per_slide);
               foreach ($chunks as $slide_benefits): ?>
                  <div class="swiper-slide">
                     <div class="features__slide-inner">
                        <?php foreach ($slide_benefits as $card): ?>
                           <?php get_template_part('template-parts/content', 'values-card'); ?>
                        <?php endforeach; ?>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </section>

   <script>
      document.addEventListener('DOMContentLoaded', function () {
         const swiper = new Swiper('.values-swiper', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
               delay: 5000,
            },
         });
      });
   </script>

   <?php
endif;
?>