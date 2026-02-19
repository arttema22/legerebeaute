// wp-content/themes/legerebeaute/assets/js/admin-media-uploader.js

// Используем IIFE для изоляции переменной mediaFrame
(function () {
   let mediaFrame; // Локальная переменная

   jQuery(document).ready(function ($) {

      $('#legerebeaute-add-gallery-images').on('click', function (e) {
         e.preventDefault();

         var $container = $('#legerebeaute-gallery-container');

         // Если фрейм уже существует, просто открываем его
         if (mediaFrame) {
            mediaFrame.open();
            return;
         }

         // Создаем новый фрейм
         mediaFrame = wp.media({
            title: 'Выберите изображения для галереи',
            button: {
               text: 'Добавить выбранные изображения'
            },
            multiple: true // Позволяет выбирать несколько изображений
         });

         // Обработчик события выбора изображений
         mediaFrame.on('select', function () {
            var selection = mediaFrame.state().get('selection');

            selection.map(function (attachment) {
               attachment = attachment.toJSON();

               // Проверяем, что это изображение
               if (attachment.type === 'image') {
                  var imageId = attachment.id;
                  var thumbnailUrl = attachment.sizes.thumbnail.url || attachment.url; // Используем миниатюру, если доступна

                  // Проверяем, не добавлено ли уже такое изображение
                  if ($container.find('.gallery-image-preview[data-id="' + imageId + '"]').length === 0) {
                     var previewHtml = '<div class="gallery-image-preview" data-id="' + imageId + '">' +
                        '<img src="' + thumbnailUrl + '" width="150" />' +
                        '<button type="button" class="button remove-image">X</button>' +
                        '<input type="hidden" name="legerebeaute_gallery[]" value="' + imageId + '" />' +
                        '</div>';
                     $container.append(previewHtml);
                  }
               }
            });
         });

         // Открываем фрейм
         mediaFrame.open();
      });

      // Делегированный обработчик клика для кнопки удаления
      $(document).on('click', '.remove-image', function () {
         $(this).closest('.gallery-image-preview').remove();
      });

   });

})();