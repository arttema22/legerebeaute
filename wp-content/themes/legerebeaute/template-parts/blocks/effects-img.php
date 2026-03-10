<?php
/**
 * Template part for displaying the 'Effects in Image' block
 *
 * @package LegereBeaute
 */

if (!defined('ABSPATH')) {
   exit;
}

if (isset($args['effects_data']) && is_array($args['effects_data'])) {

   $effects_data_to_render = $args['effects_data'];

   if (!empty($effects_data_to_render)) { ?>

      <div class="effects-in-img-block">
         <?php foreach ($effects_data_to_render as $effect) {
            if (isset($effect['text'])) {
               echo '<div class="effect-in-img-item">';
               echo $effect['text'];
               echo '</div>';
            }
         } ?>
      </div>

   <?php }
} ?>