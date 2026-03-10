// wp-content/themes/legerebeaute/assets/js/admin-price-options.js

// Используем IIFE для изоляции
(function () {
   // Код из таблицы price-options-meta-box уже встроен в HTML как <script>
   // Здесь можно добавить общую логику, если нужно, но для простого repeater-а достаточно встроенного скрипта.
   // Убедимся, что функции доступны глобально, если они используются из PHP
   window.addPriceOptionRow = addPriceOptionRow;
   window.removePriceOptionRow = removePriceOptionRow;

   // Эти функции уже определены в <script> внутри legerebeaute_service_price_options_meta_box_callback
   // function addPriceOptionRow() { ... }
   // function removePriceOptionRow(button) { ... }
   // Но если хочется вынести, то можно определить здесь и удалить из PHP-кода.
   // Пример:
   /*
   function addPriceOptionRow() {
       const tableBody = document.querySelector('#price-options-table tbody');
       const newRow = document.createElement('tr');
       // ... логика добавления ...
       tableBody.appendChild(newRow);
   }

   function removePriceOptionRow(button) {
       const row = button.closest('tr');
       row.remove();
   }
   */
   // В данном случае, оставим как есть, так как код работает.

})();