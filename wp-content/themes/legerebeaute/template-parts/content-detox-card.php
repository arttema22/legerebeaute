<?php
global $current_detox_card, $total_detox_cards, $current_detox_card_index;
$card = $current_detox_card;
$total_cards = $total_detox_cards;
$card_index = $current_detox_card_index;
$image_url = isset($card['image_url']) ? $card['image_url'] : '';
$text = isset($card['text']) ? $card['text'] : '';
$total_cards = is_numeric($total_cards) ? (int) $total_cards : 0;
$card_index = is_numeric($card_index) ? (int) $card_index : 0;

if (!empty($text)):

   ?>
   <article class="detox-card">
      <?php if ($image_url): ?>
         <div class="detox-card__image">
            <img src="<?php echo esc_url($image_url); ?>" alt="">
         </div>
      <?php endif; ?>
      <div class="detox-card__content">
         <?php if ($total_cards > 0): ?>
            <div class="pagination-dots">
               <?php for ($i = 1; $i <= $total_cards; $i++): ?>
                  <span class="pagination-dot <?php echo ($i <= $card_index) ? 'active' : 'inactive'; ?>"></span>
               <?php endfor; ?>
            </div>
         <?php endif; ?>
         <?php echo wp_kses_post($text); ?>
      </div>
   </article>
   <?php
endif;
?>