<?php
/**
 * Template part for displaying the 'Effects in Image' block
 *
 * @package LegereBeaute
 */

if (!defined('ABSPATH')) {
   exit;
}

// Ensure $effects_img is defined and is an array
if (!isset($effects_img) || !is_array($effects_img) || empty($effects_img)) {
   return;
}
?>

<div class="effects-in-img-block">
   <?php foreach ($effects_img as $effect): ?>
      <?php if (isset($effect['text']) && !empty(trim($effect['text']))): ?>
         <div class="effect-in-img-item">
            <?php echo esc_html($effect['text']); ?>
         </div>
      <?php endif; ?>
   <?php endforeach; ?>
</div>