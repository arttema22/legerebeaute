<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package legerebeaute
 */

?>

<footer class="site-footer">
   <div class="container">
      <div class="footer-row">
         <div class="footer-column">
            <p class="work-hours">
               <?php echo esc_html(legerebeaute_get_option('work_hours', 'Ежедневно: 09:00 - 22:00')); ?>
            </p>
         </div>

         <div class="footer-column">
            <div class="social-icons">
               <?php if (!empty(legerebeaute_get_option('whatsapp_link'))): ?>
                  <a href="<?php echo esc_url(legerebeaute_get_option('whatsapp_link')); ?>" class="social-icons__item"
                     target="_blank" rel="noopener noreferrer" title="WhatsApp">
                     <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                           d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                        </path>
                     </svg>
                  </a>
               <?php endif; ?>
               <?php if (!empty(legerebeaute_get_option('vk_link'))): ?>
                  <a href="<?php echo esc_url(legerebeaute_get_option('vk_link')); ?>" class="social-icons__item"
                     target="_blank" rel="noopener noreferrer" title="VKontakte">
                     <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                           d="M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z">
                        </path>
                     </svg>
                  </a>
               <?php endif; ?>
               <?php if (!empty(legerebeaute_get_option('telegram_link'))): ?>
                  <a href="<?php echo esc_url(legerebeaute_get_option('telegram_link')); ?>" class="social-icons__item"
                     target="_blank" rel="noopener noreferrer" title="Telegram">
                     <svg viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
                        <path
                           d="M21.974 0.447411C22.2664 0.322145 22.5864 0.278941 22.9008 0.322297C23.2151 0.365652 23.5123 0.493983 23.7614 0.69393C24.0105 0.893877 24.2024 1.15813 24.3172 1.45919C24.4319 1.76025 24.4652 2.0871 24.4137 2.40573L21.7302 18.9744C21.4699 20.5726 19.7472 21.4891 18.3072 20.693C17.1027 20.027 15.3137 19.0009 13.7045 17.9302C12.8999 17.3942 10.4353 15.678 10.7382 14.4567C10.9985 13.4126 15.1398 9.48868 17.5062 7.1558C18.435 6.23927 18.0114 5.71055 16.9146 6.55361C14.1908 8.64682 9.81769 11.83 8.37181 12.7261C7.09632 13.5161 6.43135 13.651 5.63624 13.5161C4.18563 13.2704 2.84032 12.8899 1.7423 12.4262C0.25856 11.7999 0.330735 9.72354 1.74112 9.11894L21.974 0.447411Z"
                           fill="white"></path>
                     </svg>
                  </a>
               <?php endif; ?>
            </div>
            <div class="contact-info">
               <a
                  href="tel:<?php echo esc_attr(legerebeaute_sanitize_phone_for_href(legerebeaute_get_option('phone1', '+7 (916) 182-45-38'))); ?>"><?php echo esc_html(legerebeaute_get_option('phone1', '+7 (916) 182-45-38')); ?></a>

               <?php if (!empty(legerebeaute_get_option('phone2'))): ?>
                  <a
                     href="tel:<?php echo esc_attr(legerebeaute_sanitize_phone_for_href(legerebeaute_get_option('phone2'))); ?>"><?php echo esc_html(legerebeaute_get_option('phone2')); ?></a>

               <?php endif; ?>
               <a
                  href="mailto:<?php echo esc_attr(legerebeaute_get_option('email', 'info@legerebeaute.ru')); ?>"><?php echo esc_html(legerebeaute_get_option('email', 'info@legerebeaute.ru')); ?></a>
            </div>
         </div>

         <div class="footer-column">
            <?php
            if (has_nav_menu('footer_menu_1')) {
               wp_nav_menu(array(
                  'theme_location' => 'footer_menu_1',
                  'menu_class' => 'menu footer-menu footer-menu-1',
                  'container' => false,
                  'depth' => 1,
               ));
            } ?>
         </div>

         <div class="footer-column">
            <?php
            if (has_nav_menu('footer_menu_2')) {
               wp_nav_menu(array(
                  'theme_location' => 'footer_menu_2',
                  'menu_class' => 'menu footer-menu footer-menu-2',
                  'container' => false,
                  'depth' => 1,
               ));
            } ?>
         </div>
      </div>

      <div class="footer-row">
         <div class="location-map">
            <?php
            $map_iframe_code = legerebeaute_get_option('map_iframe_code');
            if ($map_iframe_code) {
                echo $map_iframe_code;
            } else {
               echo '<p>Карта временно недоступна.</p>';
            }
            ?>
         </div>
         <p class="location-address">
            <?php echo esc_html(legerebeaute_get_option('address', 'Москва, Ленинградский проспект, 29, корп. 1')); ?>
         </p>
      </div>

      <div class="footer-row">
         <div class="footer-column">
            <p class="med-info">
               <?php echo nl2br(esc_html(legerebeaute_get_option('medical_services_info', "Медицинские услуги\nООО \"ЛЕЖЕР БОТЭ\"\nИНН: 9714072550"))); ?>
            </p>
         </div>

         <div class="footer-column">
            <p class="med-info">
               <?php echo nl2br(esc_html(legerebeaute_get_option('aesthetic_services_info', "Эстетические косметологические услуги\nИП Левина Кристина Андреевна\nИНН: 382306334420"))); ?>
            </p>
         </div>

         <div class="footer-column">
            <?php
            if (has_nav_menu('footer_menu_3')) {
               wp_nav_menu(array(
                  'theme_location' => 'footer_menu_3',
                  'menu_class' => 'menu footer-menu',
                  'container' => false,
                  'depth' => 1,
               ));
            } ?>
         </div>
      </div>
   </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>