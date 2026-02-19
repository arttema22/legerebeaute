<?php
/**
 * Шаблон модального окна онлайн-записи
 *
 * @package legerebeaute
 */

if (!defined('ABSPATH')) {
   exit;
}

$settings = get_option('legerebeaute_settings');
$cf7_form_id = isset($settings['сf7_form_id']) ? sanitize_text_field($settings['сf7_form_id']) : '';
?>

<div id="booking-modal" class="modal">
   <div class="modal__overlay"></div>
   <div class="modal__container">
      <button type="button" class="modal__close">
         <span class="screen-reader-text"><?php esc_html_e('Закрыть', 'legerebeaute'); ?></span>
         ×
      </button>

      <div class="modal__content">
         <h3 class="modal__title">
            Запись в Legere beaute
         </h3>

         <!-- Форма CF7 -->
         <?php if ($cf7_form_id): ?>
            <div class="modal__form">
               <?php echo do_shortcode('[contact-form-7 id="' . esc_attr($cf7_form_id) . '"]'); ?>
            </div>
         <?php else: ?>
            <p class="error"><?php esc_html_e('Форма не настроена. Обратитесь к администратору.', 'legerebeaute'); ?></p>
         <?php endif; ?>
      </div>
   </div>
</div>