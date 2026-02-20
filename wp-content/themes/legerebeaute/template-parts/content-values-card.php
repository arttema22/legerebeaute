<?php

global $card;
$image_url = $card['image_url'] ?? '';
$text = $card['text'] ?? '';
?>

<article class="features__item--slide round-card">
   <?php if ($image_url): ?>
      <div class="round-card__image">
         <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($text); ?>" class="round-card__img">
      </div>
   <?php endif; ?>
   <div class="round-card__content">
      <?php echo wp_kses_post($text); ?>
   </div>
</article>