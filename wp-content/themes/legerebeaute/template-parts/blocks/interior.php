<?php
$interior_data = legerebeaute_get_interior_data();
$title = $interior_data['title'] ?? '';
$cards = $interior_data['cards'] ?? [];

global $card;

if (!empty($cards)):
   ?>

   <section class="interior-section">
      <div class="container">
         <h2 class="section-header">
            <?php echo esc_html($title); ?>
         </h2>
         <div class="swiper interior-swiper">
            <div class="swiper-wrapper">
               <?php
               $items_per_slide = 5;
               $chunks = array_chunk($cards, $items_per_slide);
               foreach ($chunks as $slide_items): ?>
                  <div class="swiper-slide">
                     <div class="features__slide-inner">
                        <?php foreach ($slide_items as $card): ?>
                           <?php get_template_part('template-parts/content', 'interior-card'); // Используем новый шаблон карточки ?>
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
         const swiper = new Swiper('.interior-swiper', {
            direction: 'horizontal',
            loop: true,
            // autoplay: {
            //    delay: 5000,
            // },

         });
      });
   </script>

   <?php
endif;
?>