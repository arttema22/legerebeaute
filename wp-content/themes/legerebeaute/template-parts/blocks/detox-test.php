<?php
$detox_data = legerebeaute_get_detox_test_block_data();
$title = $detox_data['title'];
$cards = $detox_data['cards'];

global $current_detox_card, $total_detox_cards, $current_detox_card_index;

if ($title || !empty($cards)):
   ?>

   <section class="detox-test-block">
      <div class="container">
         <?php if ($title): ?>
            <h2 class="section-header"><?php echo esc_html($title); ?></h2>
         <?php endif; ?>

         <?php if (!empty($cards)): ?>
            <div class="detox-grid">
               <?php
               $total_cards = count($cards);
               $index_counter = 0;
               foreach ($cards as $card):
                  $index_counter++;
                  $current_detox_card = $card;
                  $total_detox_cards = $total_cards;
                  $current_detox_card_index = $index_counter;
                  get_template_part('template-parts/content', 'detox-card');
                  $current_detox_card = null;
                  $current_detox_card_index = null;
                  ?>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>
      </div>
   </section>
   <?php
endif;
?>