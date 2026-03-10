<?php
/**
 * Шаблон блока "О компании" для главной страницы
 */

$settings = get_option('legerebeaute_about_settings', array());
$settings_defaults = array(
   'title' => 'О компании',
   'text' => '',
   'image_1' => array('id' => 0, 'url' => ''),
   'image_2' => array('id' => 0, 'url' => ''),
   'page_link' => '',
   'button_text' => 'Больше о нас',
   'form_shortcode' => ''
);
$settings = wp_parse_args($settings, $settings_defaults);

$image_1_has_content = !empty($settings['image_1']['id']) || !empty($settings['image_1']['url']);
$image_2_has_content = !empty($settings['image_2']['id']) || !empty($settings['image_2']['url']);

if (empty($settings['text']) && !$image_1_has_content && !$image_2_has_content) {
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

            <?php
            // Обновлено: получаем данные из массива image_1
            $image_1_data = $settings['image_1'] ?? array('id' => 0, 'url' => '');
            $image_1_id = absint($image_1_data['id'] ?? 0);
            $image_1_url = esc_url($image_1_data['url'] ?? '');

            if ($image_1_id || $image_1_url): ?>
               <div class="about__image about__image--1">
                  <?php
                  if ($image_1_id) {
                     echo wp_get_attachment_image($image_1_id, 'large', false, array(
                        'alt' => esc_attr($settings['title'] ?? ''),
                        'loading' => 'lazy',
                        'class' => 'about__image-src'
                     ));
                  } else {
                     // Используем URL, если ID недоступен (например, для старых данных, не прошедших миграцию до конца)
                     echo '<img src="' . $image_1_url . '" 
                                  alt="' . esc_attr($settings['title'] ?? '') . '" 
                                  loading="lazy" 
                                  class="about__image-src">';
                  }
                  ?>
               </div>
            <?php endif; ?>
         </div>

         <div class="about__col about__col--secondary">
            <?php
            // Обновлено: получаем данные из массива image_2
            $image_2_data = $settings['image_2'] ?? array('id' => 0, 'url' => '');
            $image_2_id = absint($image_2_data['id'] ?? 0);
            $image_2_url = esc_url($image_2_data['url'] ?? '');

            if ($image_2_id || $image_2_url): ?>
               <div class="about__image about__image--2">
                  <?php
                  if ($image_2_id) {
                     // Используем ID для генерации изображения через WordPress
                     echo wp_get_attachment_image($image_2_id, 'large', false, array(
                        'alt' => esc_attr($settings['title'] ?? 'Процедура в Legere Beaute'),
                        'loading' => 'lazy',
                        'class' => 'about__image-src'
                     ));
                  } else {
                     // Используем URL, если ID недоступен (например, для старых данных, не прошедших миграцию до конца)
                     echo '<img src="' . $image_2_url . '" 
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