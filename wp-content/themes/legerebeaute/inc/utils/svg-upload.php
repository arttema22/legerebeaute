<?php
/**
 * Поддержка загрузки SVG-файлов в медиабиблиотеку
 *
 * Включает MIME-тип image/svg+xml и обходит проверку безопасности
 * только для пользователей с правами manage_options (администраторы).
 */

if (!defined('ABSPATH')) {
   exit; // Запрет прямого доступа
}

/**
 * Разрешить SVG в списке допустимых MIME-типов при загрузке
 */
function legerebeaute_allow_svg_upload($mimes)
{
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}
add_filter('upload_mimes', 'legerebeaute_allow_svg_upload');

/**
 * Обход дополнительной проверки типа файла для SVG
 * (только для администраторов — для безопасности)
 */
function legerebeaute_fix_svg_mime_type($data, $file, $filename, $mimes)
{
   // Пропускаем проверку только если расширение — .svg
   if (pathinfo($filename, PATHINFO_EXTENSION) !== 'svg') {
      return $data;
   }

   // Разрешаем только пользователям с правами администратора
   if (current_user_can('manage_options')) {
      $data['ext'] = 'svg';
      $data['type'] = 'image/svg+xml';
   }

   return $data;
}
add_filter('wp_check_filetype_and_ext', 'legerebeaute_fix_svg_mime_type', 10, 4);