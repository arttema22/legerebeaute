<?php
/**
 * Вспомогательные функции темы
 *
 * Этот файл содержит пользовательские вспомогательные функции,
 * которые могут использоваться в различных частях темы.
 *
 * @package legerebeaute
 */

if (!defined('ABSPATH')) {
   exit; // Exit if accessed directly.
}

/**
 * Sanitizes a phone number string for use in an href attribute for tel: links.
 *
 * This function ensures the phone number is formatted correctly for the browser
 * to recognize and handle as a telephone link. It removes all non-digit characters
 * except the leading '+' sign, which is required for international format.
 *
 * @param string $phone_raw The raw phone number string potentially containing spaces, hyphens, parentheses, etc.
 * @return string The sanitized phone number suitable for a 'tel:' href (e.g., '+74951234567').
 */
function legerebeaute_sanitize_phone_for_href($phone_raw)
{
   // Удаляем все символы, кроме цифр и начального '+'
   $sanitized = preg_replace('/[^0-9\+]/', '', $phone_raw);

   // Убеждаемся, что '+' стоит только в начале и только один раз
   // Удаляем все '+' кроме первого
   $plus_pos = strpos($sanitized, '+');
   if ($plus_pos !== false && $plus_pos === 0) {
      // '+' на первом месте, удаляем другие
      $sanitized = '+' . str_replace('+', '', substr($sanitized, 1));
   } elseif ($plus_pos !== false && $plus_pos > 0) {
      // '+' не на первом месте, удаляем все
      $sanitized = str_replace('+', '', $sanitized);
   }
   // Если '+' не было, строка остается без него, что тоже допустимо для 'tel:' URI в некоторых случаях,
   // но для международного формата лучше бы его иметь. Функция просто очищает.

   return $sanitized;
}

// Примеры использования (можно удалить):
// echo legerebeaute_sanitize_phone_for_href('+7 (495) 123-45-67'); // Вывод: +74951234567
// echo legerebeaute_sanitize_phone_for_href('8 800 555 35 35');   // Вывод: 88005553535
// echo legerebeaute_sanitize_phone_for_href('123-45-67 ext. 890'); // Вывод: 1234567890



// === Хелпер для получения данных в шаблонах ===
if (!function_exists('legerebeaute_get_meta')) {
   function legerebeaute_get_meta($post_id = null, $key = '')
   {
      if (!$post_id)
         $post_id = get_the_ID();
      $prefix = '_legerebeaute_';
      return get_post_meta($post_id, $prefix . $key, true);
   }
}

?>