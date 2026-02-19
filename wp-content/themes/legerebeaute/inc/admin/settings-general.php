<?php
/**
 * Общие настройки сайта: контакты и соцсети
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_settings_init()
{
   register_setting('legerebeaute_settings_group', 'legerebeaute_settings');

   // Секция "Контакты"
   add_settings_section(
      'legerebeaute_contacts_section',
      'Контактная информация',
      null,
      'legerebeaute-settings'
   );

   add_settings_field(
      'phone1',
      'Телефон 1',
      'legerebeaute_render_phone_field_1',
      'legerebeaute-settings',
      'legerebeaute_contacts_section'
   );

   add_settings_field(
      'phone2',
      'Телефон 2',
      'legerebeaute_render_phone_field_2',
      'legerebeaute-settings',
      'legerebeaute_contacts_section'
   );

   add_settings_field(
      'email',
      'Email',
      'legerebeaute_render_email_field',
      'legerebeaute-settings',
      'legerebeaute_contacts_section'
   );

   add_settings_field(
      'address',
      'Адрес',
      'legerebeaute_render_address_field',
      'legerebeaute-settings',
      'legerebeaute_contacts_section'
   );

   add_settings_field(
      'work_hours',
      'Время работы',
      'legerebeaute_render_work_hours_field',
      'legerebeaute-settings',
      'legerebeaute_contacts_section'
   );

   add_settings_section(
      'legerebeaute_socials_section',
      'Социальные сети',
      null,
      'legerebeaute-settings'
   );

   add_settings_field(
      'whatsapp_link',
      'WhatsApp',
      'legerebeaute_render_whatsapp_field',
      'legerebeaute-settings',
      'legerebeaute_socials_section'
   );

   add_settings_field(
      'vk_link',
      'VK',
      'legerebeaute_render_vk_field',
      'legerebeaute-settings',
      'legerebeaute_socials_section'
   );

   add_settings_field(
      'telegram_link',
      'Telegram',
      'legerebeaute_render_telegram_field',
      'legerebeaute-settings',
      'legerebeaute_socials_section'
   );

   add_settings_section(
      'legerebeaute_legal_section',
      'Юридическая информация',
      'legerebeaute_render_legal_section_info',
      'legerebeaute-settings'
   );

   add_settings_field(
      'medical_services_info',
      'Медицинские услуги',
      'legerebeaute_render_medical_info_field',
      'legerebeaute-settings',
      'legerebeaute_legal_section'
   );

   add_settings_field(
      'aesthetic_services_info',
      'Эстетические косметологические услуги',
      'legerebeaute_render_aesthetic_info_field',
      'legerebeaute-settings',
      'legerebeaute_legal_section'
   );

   add_settings_section(
      'legerebeaute_map_section',
      'Карта',
      'legerebeaute_render_map_section_info',
      'legerebeaute-settings'
   );

   add_settings_field(
      'map_iframe_code',
      'Код карты Яндекс',
      'legerebeaute_render_map_iframe_field',
      'legerebeaute-settings',
      'legerebeaute_map_section'
   );

   add_settings_section(
      'legerebeaute_cf7_section',
      'Форма заказа',
      null,
      'legerebeaute-settings'
   );

   add_settings_field(
      'сf7_id',
      'ID формы заявки на запись',
      'legerebeaute_render_cf7_id',
      'legerebeaute-settings',
      'legerebeaute_cf7_section'
   );

   add_settings_field(
      'сf7_form_id',
      'ID шорткода формы',
      'legerebeaute_render_cf7_form_id',
      'legerebeaute-settings',
      'legerebeaute_cf7_section'
   );

}
add_action('admin_init', 'legerebeaute_settings_init');

function legerebeaute_render_legal_section_info()
{
   echo '<p>Введите юридическую информацию для отображения в футере.</p>';
}

function legerebeaute_render_medical_info_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<textarea name="legerebeaute_settings[medical_services_info]" rows="3" cols="50" class="large-text">%s</textarea>',
      esc_textarea($options['medical_services_info'] ?? "")
   );
   echo '<p class="description">Поддерживаются переводы строк.</p>';
}

function legerebeaute_render_aesthetic_info_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<textarea name="legerebeaute_settings[aesthetic_services_info]" rows="3" cols="50" class="large-text">%s</textarea>',
      esc_textarea($options['aesthetic_services_info'] ?? "")
   );
   echo '<p class="description">Поддерживаются переводы строк.</p>';
}

function legerebeaute_render_map_section_info()
{
   echo '<p>Вставьте готовый HTML-код iframe карты из Конструктора Яндекс Карт.</p>';
}

function legerebeaute_render_map_iframe_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<textarea name="legerebeaute_settings[map_iframe_code]" rows="5" cols="50" class="large-text code">%s</textarea>',
      esc_textarea($options['map_iframe_code'])
   );
   echo '<p class="description">Скопируйте код из <a href="https://yandex.ru/map-constructor/" target="_blank">Конструктора Яндекс Карт</a>.</p>';
}

function legerebeaute_render_phone_field_1()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="text" name="legerebeaute_settings[phone1]" value="%s" class="regular-text">',
      esc_attr($options['phone1'] ?? '+7 (XXX) XXX-XX-XX')
   );
}

function legerebeaute_render_phone_field_2()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="text" name="legerebeaute_settings[phone2]" value="%s" class="regular-text">',
      esc_attr($options['phone2'] ?? '+7 (XXX) XXX-XX-XX')
   );
}

function legerebeaute_render_email_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="email" name="legerebeaute_settings[email]" value="%s" class="regular-text">',
      esc_attr($options['email'] ?? '')
   );
}

function legerebeaute_render_address_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="text" name="legerebeaute_settings[address]" value="%s" class="large-text">',
      esc_attr($options['address'] ?? 'Москва')
   );
}

function legerebeaute_render_work_hours_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="text" name="legerebeaute_settings[work_hours]" value="%s" class="regular-text">',
      esc_attr($options['work_hours'] ?? '')
   );
}

function legerebeaute_render_whatsapp_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="url" name="legerebeaute_settings[whatsapp_link]" value="%s" class="regular-text" placeholder="https://wa.me/...  ">',
      esc_url($options['whatsapp_link'] ?? '')
   );
}

function legerebeaute_render_vk_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="url" name="legerebeaute_settings[vk_link]" value="%s" class="regular-text" placeholder="https://vk.com/...  ">',
      esc_url($options['vk_link'] ?? '')
   );
}

function legerebeaute_render_telegram_field()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="url" name="legerebeaute_settings[telegram_link]" value="%s" class="regular-text" placeholder="https://t.me/...  ">',
      esc_url($options['telegram_link'] ?? '')
   );
}

function legerebeaute_render_cf7_id()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="number" name="legerebeaute_settings[сf7_id]" value="%s" class="small-text" placeholder="ID">',
      esc_attr($options['сf7_id'] ?? '')
   );
   echo '<p class="description">Укажите ID формы Contact Form 7 (например, 66). Найти можно в URL при редактировании формы. Чтобы узнать ID — откройте форму на редактирование и посмотрите URL: <code>?post=66</code></p>';
}

function legerebeaute_render_cf7_form_id()
{
   $options = get_option('legerebeaute_settings');
   printf(
      '<input type="text" name="legerebeaute_settings[сf7_form_id]" value="%s" class="regular-text" placeholder="ID">',
      esc_attr($options['сf7_form_id'] ?? '')
   );
   echo '<p class="description">Укажите ID формы в шорткоде (например, 5a385a0). Найти можно на странице форм в столбце Шорткод: <code>[contact-form-7 id="5a385a0" title="Форма записи на услугу"]</code></p>';
}

function legerebeaute_settings_page()
{
   ?>
   <div class="wrap">
      <h1>Общие настройки сайта</h1>
      <form action="options.php" method="post">
         <?php
         settings_fields('legerebeaute_settings_group');
         do_settings_sections('legerebeaute-settings');
         submit_button();
         ?>
      </form>
   </div>
   <?php

}

if (!function_exists('legerebeaute_get_option')) {
   function legerebeaute_get_option($key, $default = '')
   {
      $options = get_option('legerebeaute_settings', []);
      return isset($options[$key]) ? $options[$key] : $default;
   }
}
