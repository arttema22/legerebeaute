<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
   <?php wp_body_open(); ?>

   <header class="site-header" role="banner">
      <div class="container">
         <div class="header-content">
            <?php the_custom_logo(); ?>

            <!-- Бургер-кнопка -->
            <button class="mobile-menu-toggle" aria-expanded="false" aria-controls="main-menu-mobile"
               data-modal-type="mobile-menu">
               <svg xmlns="http://www.w3.org/2000/svg" width="31" height="15" viewBox="0 0 31 15" fill="none">
                  <rect x="0.520996" y="0.497253" width="30.4788" height="1.34856" fill="#0F253D"></rect>
                  <rect x="0.520996" y="13.1945" width="30.4788" height="1.34856" fill="#0F253D"></rect>
                  <rect x="6.73657" y="6.84589" width="24.2635" height="1.34856" fill="#0F253D"></rect>
               </svg>
            </button>

            <!-- Основное меню (десктоп) + контакты + соцсети -->
            <div class="header-right">
               <nav class="main-navigation" role="navigation"
                  aria-label="<?php esc_attr_e('Основное меню', 'legerebeaute'); ?>">
                  <ul class="main-menu js-main-menu">
                     <?php
                     wp_nav_menu([
                        'theme_location' => 'main-menu',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'fallback_cb' => false,
                     ]);
                     ?>
                     <button class="menu-more-btn js-menu-toggle" aria-expanded="false"
                        aria-controls="menu-extra-items">
                        Ещё
                     </button>
                  </ul>

                  <ul class="main-menu--extra js-menu-extra" id="menu-extra-items" hidden>
                     <!-- Сюда JS переместит лишние пункты -->
                  </ul>
               </nav>

               <div class="header-contacts">
                  <?php if ($phone1 = legerebeaute_get_option('phone1')): ?>
                     <span class="header-contacts__item">
                        <a href="tel:<?php echo preg_replace('/[^+\d]/', '', $phone1); ?>" class="header-contacts__link"
                           aria-label="Позвонить по телефону: <?php echo esc_attr($phone1); ?>">
                           <?php echo esc_html($phone1); ?>
                        </a>
                     </span>
                  <?php endif; ?>

                  <?php if ($phone2 = legerebeaute_get_option('phone2')): ?>
                     <span class="header-contacts__item">
                        <a href="tel:<?php echo preg_replace('/[^+\d]/', '', $phone2); ?>" class="header-contacts__link"
                           aria-label="Позвонить по второму телефону: <?php echo esc_attr($phone2); ?>">
                           <?php echo esc_html($phone2); ?>
                        </a>
                     </span>
                  <?php endif; ?>
               </div>

               <div class="social-icons">
                  <?php if ($whatsapp = legerebeaute_get_option('whatsapp_link')): ?>
                     <a href="<?= esc_url($whatsapp); ?>" class="social-icons__item" target="_blank" rel="noopener"
                        aria-label="Написать в WhatsApp">
                        <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                           </path>
                        </svg>
                     </a>
                  <?php endif; ?>

                  <?php if ($vk = legerebeaute_get_option('vk_link')): ?>
                     <a href="<?= esc_url($vk); ?>" class="social-icons__item" target="_blank" rel="noopener"
                        aria-label="Перейти в сообщество ВКонтакте">
                        <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z">
                           </path>
                        </svg>
                     </a>
                  <?php endif; ?>

                  <?php if ($telegram = legerebeaute_get_option('telegram_link')): ?>
                     <a href="<?= esc_url($telegram); ?>" class="social-icons__item" target="_blank" rel="noopener"
                        aria-label="Написать в Telegram">
                        <svg viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M21.974 0.447411C22.2664 0.322145 22.5864 0.278941 22.9008 0.322297C23.2151 0.365652 23.5123 0.493983 23.7614 0.69393C24.0105 0.893877 24.2024 1.15813 24.3172 1.45919C24.4319 1.76025 24.4652 2.0871 24.4137 2.40573L21.7302 18.9744C21.4699 20.5726 19.7472 21.4891 18.3072 20.693C17.1027 20.027 15.3137 19.0009 13.7045 17.9302C12.8999 17.3942 10.4353 15.678 10.7382 14.4567C10.9985 13.4126 15.1398 9.48868 17.5062 7.1558C18.435 6.23927 18.0114 5.71055 16.9146 6.55361C14.1908 8.64682 9.81769 11.83 8.37181 12.7261C7.09632 13.5161 6.43135 13.651 5.63624 13.5161C4.18563 13.2704 2.84032 12.8899 1.7423 12.4262C0.25856 11.7999 0.330735 9.72354 1.74112 9.11894L21.974 0.447411Z"
                              fill="white"></path>
                        </svg>
                     </a>
                  <?php endif; ?>
               </div>

            </div>
         </div>
      </div>
   </header>

   <!-- Мобильное меню -->
   <div id="main-menu-mobile" class="modal">
      <div class="modal__overlay"></div>
      <div class="modal__container">
         <button type="button" class="modal__close">
            <span class="screen-reader-text"><?php esc_html_e('Закрыть', 'legerebeaute'); ?></span>
            ×
         </button>

         <div class="modal__content">
            <div class="mobile-menu-inner">
               <h3 class="modal__title">
                  MENU
               </h3>
               <?php
               wp_nav_menu([
                  'theme_location' => 'main-menu',
                  'menu_class' => 'mobile-menu-list',
                  'container' => false,
                  'fallback_cb' => false,
               ]);
               ?>
            </div>
            <div class="mobile-menu-footer">
               <div class="header-contacts">
                  <?php if ($phone1 = legerebeaute_get_option('phone1')): ?>
                     <span class="header-contacts__item">
                        <a href="tel:<?php echo preg_replace('/[^+\d]/', '', $phone1); ?>" class="header-contacts__link"
                           aria-label="Позвонить по телефону: <?php echo esc_attr($phone1); ?>">
                           <?php echo esc_html($phone1); ?>
                        </a>
                     </span>
                  <?php endif; ?>

                  <?php if ($phone2 = legerebeaute_get_option('phone2')): ?>
                     <span class="header-contacts__item">
                        <a href="tel:<?php echo preg_replace('/[^+\d]/', '', $phone2); ?>" class="header-contacts__link"
                           aria-label="Позвонить по второму телефону: <?php echo esc_attr($phone2); ?>">
                           <?php echo esc_html($phone2); ?>
                        </a>
                     </span>
                  <?php endif; ?>
               </div>
               <div class="social-icons">
                  <?php if ($whatsapp = legerebeaute_get_option('whatsapp_link')): ?>
                     <a href="<?= esc_url($whatsapp); ?>" class="social-icons__item" target="_blank" rel="noopener"
                        aria-label="Написать в WhatsApp">
                        <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                           </path>
                        </svg>
                     </a>
                  <?php endif; ?>

                  <?php if ($vk = legerebeaute_get_option('vk_link')): ?>
                     <a href="<?= esc_url($vk); ?>" class="social-icons__item" target="_blank" rel="noopener"
                        aria-label="Перейти в сообщество ВКонтакте">
                        <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z">
                           </path>
                        </svg>
                     </a>
                  <?php endif; ?>

                  <?php if ($telegram = legerebeaute_get_option('telegram_link')): ?>
                     <a href="<?= esc_url($telegram); ?>" class="social-icons__item" target="_blank" rel="noopener"
                        aria-label="Написать в Telegram">
                        <svg viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M21.974 0.447411C22.2664 0.322145 22.5864 0.278941 22.9008 0.322297C23.2151 0.365652 23.5123 0.493983 23.7614 0.69393C24.0105 0.893877 24.2024 1.15813 24.3172 1.45919C24.4319 1.76025 24.4652 2.0871 24.4137 2.40573L21.7302 18.9744C21.4699 20.5726 19.7472 21.4891 18.3072 20.693C17.1027 20.027 15.3137 19.0009 13.7045 17.9302C12.8999 17.3942 10.4353 15.678 10.7382 14.4567C10.9985 13.4126 15.1398 9.48868 17.5062 7.1558C18.435 6.23927 18.0114 5.71055 16.9146 6.55361C14.1908 8.64682 9.81769 11.83 8.37181 12.7261C7.09632 13.5161 6.43135 13.651 5.63624 13.5161C4.18563 13.2704 2.84032 12.8899 1.7423 12.4262C0.25856 11.7999 0.330735 9.72354 1.74112 9.11894L21.974 0.447411Z"
                              fill="white"></path>
                        </svg>
                     </a>
                  <?php endif; ?>
               </div>
               <?php the_custom_logo(); ?>
            </div>
         </div>
      </div>
   </div>