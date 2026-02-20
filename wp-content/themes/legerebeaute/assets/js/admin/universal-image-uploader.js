// wp-content/themes/legerebeaute/assets/js/admin/universal-image-uploader.js

(function ($) {
   let mediaFrame = null;

   $(document).ready(function () {
      // Убедимся, что LegerebeauteImageHelper определён
      if (typeof LegerebeauteImageHelper === 'undefined') {
         console.error('LegerebeauteImageHelper is not defined.');
         return;
      }

      handleImageSelectionClick();
      handleImageRemovalClick();
   });

   // Делегированный обработчик для кнопок "Выбрать изображение"
   function handleImageSelectionClick() {
      $(document).on('click', '.legerebeaute-select-image-btn', function (e) {
         e.preventDefault();

         const $button = $(this);
         const fieldName = $button.data('field-name');
         const $wrapper = $(`.legerebeaute-image-field-wrapper[data-field-name="${fieldName}"]`);
         if ($wrapper.length === 0) {
            console.error(`Wrapper not found for field name: ${fieldName}`);
            return;
         }
         const $previewContainer = $wrapper.find('.legerebeaute-image-preview-container');
         const $idInput = $wrapper.find('.legerebeaute-image-id-field');
         const $urlInput = $wrapper.find('.legerebeaute-image-url-field');
         const isMultiple = $wrapper.data('multiple') === true;
         const currentId = parseInt($idInput.val(), 10) || 0;


         if (mediaFrame) {
            mediaFrame.off('open');
            mediaFrame.open();

            if (currentId) {
               mediaFrame.on('open', function () {
                  const selection = mediaFrame.state().get('selection');
                  selection.reset([]);
                  selection.add(wp.media.attachment(currentId));
                  const attachment = selection.get(currentId);
                  if (attachment) {
                     attachment.set({ selected: true });
                  }
               });
            }
            return;
         }

         mediaFrame = wp.media({
            title: LegerebeauteImageHelper.defaults.title || 'Выберите изображение',
            button: {
               text: LegerebeauteImageHelper.defaults.button_text || 'Выбрать'
            },
            library: {
               type: LegerebeauteImageHelper.defaults.type || 'image'
            },
            multiple: isMultiple
         });

         mediaFrame.on('select', function () {
            const selection = mediaFrame.state().get('selection');
            const attachments = selection.toJSON();

            if (!isMultiple) {
               const attachment = attachments[0];
               if (!attachment) {
                  console.error('Attachment is null or undefined');
                  return;
               }

               $idInput.val(attachment.id);
               if ($urlInput.length) {
                  $urlInput.val(attachment.url);
               }

               const imgSrc = attachment.sizes?.thumbnail?.url || attachment.url;
               const imgHtml = `<img src="${imgSrc}" class="legerebeaute-image-preview" style="max-width: 150px; height: auto;" alt="Предпросмотр">`;
               $previewContainer.html(imgHtml);

               let $removeBtn = $wrapper.find('.legerebeaute-remove-image-btn');
               if ($removeBtn.length === 0) {
                  $removeBtn = $(`<button type="button" class="legerebeaute-remove-image-btn button">${LegerebeauteImageHelper.l10n?.remove_button_text || 'Удалить'}</button>`);
                  $button.after($removeBtn);
               } else {
                  $removeBtn.show();
               }
            } else {
            }
         });
         mediaFrame.open();
      });
   }

   function handleImageRemovalClick() {
      $(document).on('click', '.legerebeaute-remove-image-btn', function (e) {
         e.preventDefault();
         const $button = $(this);
         const fieldName = $button.data('field-name');
         const $wrapper = $(`.legerebeaute-image-field-wrapper[data-field-name="${fieldName}"]`);
         if ($wrapper.length === 0) {
            console.error(`Wrapper not found for field name: ${fieldName}`);
            return;
         }
         const $previewContainer = $wrapper.find('.legerebeaute-image-preview-container');
         const $idInput = $wrapper.find('.legerebeaute-image-id-field');
         const $urlInput = $wrapper.find('.legerebeaute-image-url-field');

         $idInput.val('');
         if ($urlInput.length) {
            $urlInput.val('');
         }
         $previewContainer.html('');

         $button.hide();
      });
   }

})(jQuery);