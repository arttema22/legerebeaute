<?php
/**
 * Template part for displaying the 'Effects in Text' block
 *
 * @package LegereBeaute
 */

if (!defined('ABSPATH')) {
   exit;
}

// Ensure $effects_txt is defined and is an array
if (!isset($effects_txt) || !is_array($effects_txt) || empty($effects_txt)) {
   return;
}
?>

<div class="effects-in-text-list">
   <?php foreach ($effects_txt as $effect): ?>
      <?php if (isset($effect['text']) && !empty(trim($effect['text']))): ?>
         <div class="effect-in-text-item">
            <div class="effect-in-text-dot"></div>
            <div class="effect-in-text-data">
               <?php echo esc_html($effect['text']); ?>
            </div>
         </div>
      <?php endif; ?>
   <?php endforeach; ?>
</div>