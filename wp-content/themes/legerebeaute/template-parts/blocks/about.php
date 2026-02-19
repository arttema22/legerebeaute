<?php
/**
 * Шаблон блока "О компании" для главной страницы
 */

$settings = get_option('legerebeaute_about_settings', array());
$settings = wp_parse_args($settings, array(
   'title' => 'О компании',
   'text' => '',
   'image_1' => '',
   'image_2' => '',
   'page_link' => '',
   'button_text' => 'Больше о нас',
   'form_shortcode' => ''
));

// Не выводим блок если нет контента
if (empty($settings['text']) && empty($settings['image_1']) && empty($settings['image_2'])) {
   return;
}
?>

<section class="section-about" id="about" aria-labelledby="about-title">
   <div class="container">
      <div class="about__grid">

         <div class="about__col about__col--primary">
            <?php if (!empty($settings['title'])): ?>
               <h2 class="section-header">
                  <?php echo esc_html($settings['title']); ?>
               </h2>
            <?php endif; ?>

            <?php if (!empty($settings['text'])): ?>
               <div class="about__text">
                  <?php echo wp_kses_post(wpautop($settings['text'])); ?>
               </div>
            <?php endif; ?>

            <?php if (!empty($settings['image_1'])): ?>
               <div class="about__image about__image--1">
                  <?php
                  $image_id = absint($settings['image_1_id'] ?? 0);
                  if ($image_id) {
                     echo wp_get_attachment_image($image_id, 'large', false, array(
                        'alt' => esc_attr($settings['title'] ?? 'Интерьер Legere Beaute'),
                        'loading' => 'lazy',
                        'class' => 'about__image-src'
                     ));
                  } else {
                     echo '<img src="' . esc_url($settings['image_1']) . '" 
                                  alt="' . esc_attr($settings['title'] ?? 'Интерьер Legere Beaute') . '" 
                                  loading="lazy" 
                                  class="about__image-src">';
                  }
                  ?>
               </div>
            <?php endif; ?>
         </div>

         <div class="about__col about__col--secondary">
            <?php if (!empty($settings['image_2'])): ?>
               <div class="about__image about__image--2">
                  <?php
                  $image_id = absint($settings['image_2_id'] ?? 0);
                  if ($image_id) {
                     echo wp_get_attachment_image($image_id, 'large', false, array(
                        'alt' => esc_attr($settings['title'] ?? 'Процедура в Legere Beaute'),
                        'loading' => 'lazy',
                        'class' => 'about__image-src'
                     ));
                  } else {
                     echo '<img src="' . esc_url($settings['image_2']) . '" 
                                  alt="' . esc_attr($settings['title'] ?? 'Процедура в Legere Beaute') . '" 
                                  loading="lazy" 
                                  class="about__image-src">';
                  }
                  ?>
               </div>
            <?php endif; ?>

            <!-- Кнопка "Больше о нас" -->
            <?php if (!empty($settings['page_link']) && !empty($settings['button_text'])): ?>
               <div class="about__actions">
                  <a href="<?php echo esc_url($settings['page_link']); ?>" class="btn btn--primary about__btn"
                     aria-label="<?php echo esc_attr($settings['button_text']); ?>">
                     <?php echo esc_html($settings['button_text']); ?>
                  </a>
               </div>
            <?php endif; ?>

            <!-- Форма записи -->
            <?php if (!empty($settings['form_shortcode'])): ?>
               <div class="about__form">
                  <?php echo do_shortcode($settings['form_shortcode']); ?>
               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</section>