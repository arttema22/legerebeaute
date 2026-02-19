<?php
/**
 * LégÈre Beauté — functions.php
 */

// Запрет прямого доступа
defined('ABSPATH') || exit;


// Подключаем модули
require_once get_template_directory() . '/inc/core/setup.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/core/enqueue.php';

// Админка
require_once get_template_directory() . '/inc/admin/menu.php';
require_once get_template_directory() . '/inc/admin/settings-general.php';
require_once get_template_directory() . '/inc/admin/settings-hero.php';
require_once get_template_directory() . '/inc/admin/settings-detox-test.php';
require_once get_template_directory() . '/inc/admin/settings-about.php';

// Утилиты
require_once get_template_directory() . '/inc/utils/svg-upload.php';
require_once get_template_directory() . '/inc/utils/cleanup.php';
require_once get_template_directory() . '/inc/utils/cf7-to-cpt.php';

// Пользовательские типы записей
require_once get_template_directory() . '/inc/custom-post-types/services.php';
require_once get_template_directory() . '/inc/custom-post-types/programs.php';
require_once get_template_directory() . '/inc/custom-post-types/specialists.php';
require_once get_template_directory() . '/inc/custom-post-types/offers.php';
require_once get_template_directory() . '/inc/custom-post-types/requests.php';

// Модальное окно онлайн-записи
require get_template_directory() . '/inc/forms/booking-modal.php';

require_once get_template_directory() . '/inc/pages/page-about.php';

// Хелперы
require_once get_template_directory() . '/inc/helpers/helpers.php';
