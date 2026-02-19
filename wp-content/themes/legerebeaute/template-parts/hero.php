<?php
/**
 * Hero-секция главной страницы
 */

$hero = get_option('legerebeaute_hero_settings', []);

$title = $hero['title'] ?? 'Студия детокса';
$subtitle = $hero['subtitle'] ?? 'LégÈre beauté';
$description = $hero['description'] ?? 'Мы создали премиальное пространство...';
$booking_label = $hero['booking_label'] ?? 'Онлайн-запись';

$desktop_id = $hero['bg_desktop'] ?? 0;
$mobile_id = $hero['bg_mobile'] ?? 0;

$desktop_url = $desktop_id ? wp_get_attachment_image_url($desktop_id, 'full') : '';
$mobile_url = $mobile_id ? wp_get_attachment_image_url($mobile_id, 'full') : '';
$fallback_url = $desktop_url ?: $mobile_url;
?>

<section class="hero" aria-label="Главный баннер">
   <div class="container">
      <?php if ($desktop_url || $mobile_url): ?>
         <picture class="hero__bg">
            <source media="(max-width: 768px)" srcset="<?= esc_url($mobile_url); ?>">
            <img src="<?= esc_url($fallback_url); ?>" alt="Интерьер студии LégÈre Beauté" loading="lazy">

            <div class="hero__booking">
               <a href="#" data-hystmodal="#formModal" class="hero__btn-booking-modal"
                  aria-label="Записаться на приём онлайн">
                  <span class="hero__booking-icon-wrapper">
                     <svg class="hero__booking-icon" aria-hidden="true" viewBox="0 0 47 46">
                        <path
                           d="M23.6028 44.7952H9.59204C5.17376 44.7952 1.59204 41.2135 1.59204 36.7952V12.9766C1.59204 8.55829 5.17376 4.97656 9.59204 4.97656H37.6135C42.0318 4.97656 45.6135 8.55828 45.6135 12.9766V27.16"
                           stroke="#FEFEFE" stroke-width="1.3" stroke-linecap="round"></path>
                        <circle cx="35.6978" cy="36.0179" r="8.12736" stroke="#FEFEFE" stroke-width="1.3"></circle>
                        <path d="M35.3281 31.9409V35.9054C35.3281 36.4577 35.7758 36.9054 36.3281 36.9054H38.6826"
                           stroke="#FEFEFE" stroke-width="1.3" stroke-linecap="round"></path>
                        <circle cx="11.9537" cy="19.2702" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="19.7189" cy="19.2702" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="27.484" cy="19.2702" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="35.2492" cy="19.2702" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="19.7189" cy="26.9762" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="11.9537" cy="26.9762" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="11.9537" cy="34.6823" r="1.75257" fill="#FEFEFE"></circle>
                        <circle cx="19.7189" cy="34.6823" r="1.75257" fill="#FEFEFE"></circle>
                        <rect x="12.8015" y="0.339478" width="1.3" height="10.737" rx="0.65" fill="#FEFEFE"></rect>
                        <rect x="22.9529" y="0.339478" width="1.3" height="10.737" rx="0.65" fill="#FEFEFE"></rect>
                        <rect x="33.1042" y="0.339478" width="1.3" height="10.737" rx="0.65" fill="#FEFEFE"></rect>
                     </svg>
                  </span>
                  <span class="hero__booking-text"><?= esc_html($booking_label); ?></span>
               </a>
            </div>

         </picture>
      <?php endif; ?>

      <div class="hero__heading">
         <h1 class="hero__title"><?= esc_html($title); ?></h1>
         <h2 class="hero__subtitle"><?= esc_html($subtitle); ?></h2>
      </div>

      <div class="hero__description">
         <?= esc_html($description); ?>
      </div>



   </div>
</section>