<?php
/**
 * Модальное окно для онлайн-записи
 *
 * @package legerebeaute
 */

if (!defined('ABSPATH')) {
   exit;
}

/**
 * Класс модального окна
 */
class LB_Booking_Modal
{

   /**
    * Инициализация
    */
   public function init()
   {
      add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
      add_action('wp_footer', [$this, 'render_modal']);

      // Регистрация AJAX-экшенов
      add_action('wp_ajax_lb_get_service_data', [$this, 'ajax_get_service_data']);
      add_action('wp_ajax_nopriv_lb_get_service_data', [$this, 'ajax_get_service_data']);
   }

   /**
    * Подключение стилей и скриптов
    */
   public function enqueue_assets()
   {
      // Скрипт модального окна
      wp_enqueue_script(
         'booking-modal',
         get_template_directory_uri() . '/assets/js/booking-modal.js',
         ['jquery'],
         1,
         true
      );

      // Локализация данных для JS
      wp_localize_script(
         'booking-modal',
         'lb_booking_modal',
         [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('lb_booking_nonce'),
         ]
      );
   }

   /**
    * Вывод кнопки заказа
    *
    * @param int $post_id ID услуги.
    */
   public function render_button($post_id = null)
   {
      if (!$post_id) {
         global $post;
         $post_id = $post->ID;
      }

      $service = get_post($post_id);

      if (!$service || 'services' !== $service->post_type) {
         return;
      }


      ?>
      <button type="button" class="btn btn-booking-modal" data-service-id="<?php echo esc_attr($post_id); ?>"
         data-service-title="<?php echo esc_attr(get_the_title($post_id)); ?>">
         Онлайн-запись
         <span class="btn-icon"></span>
      </button>

      <?php
   }

   /**
    * Вывод модального окна в футер
    */
   public function render_modal()
   {
      get_template_part('template-parts/modal/booking-modal.php');
   }

   /**
    * AJAX: Получение данных об услуге
    */
   public function ajax_get_service_data()
   {
      check_ajax_referer('lb_booking_nonce', 'nonce');

      $service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : 0;

      if (!$service_id) {
         wp_send_json_error(__('ID услуги не указан', 'legerebeaute'));
      }

      $service = get_post($service_id);

      if (!$service || 'services' !== $service->post_type) {
         wp_send_json_error(__('Услуга не найдена', 'legerebeaute'));
      }

      // Получаем данные об услуге
      $service_data = [
         'id' => $service->ID,
         'title' => $service->post_title,
      ];

      wp_send_json_success($service_data);
   }
}

// Инициализация
$lb_booking_modal = new LB_Booking_Modal();
$lb_booking_modal->init();

// Хук для вывода кнопки
function lb_booking_button($post_id = null)
{
   global $lb_booking_modal;
   $lb_booking_modal->render_button($post_id);
}