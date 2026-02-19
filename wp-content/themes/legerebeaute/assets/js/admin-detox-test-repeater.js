// wp-content/themes/legerebeaute/assets/js/admin-detox-test-repeater.js

jQuery(document).ready(function ($) {
   let cardIndex = $('tbody tr:not(.card-template)').length;
   let mediaUploader = null;

   function initializeTinyMCE(targetId) {
      if (typeof tinyMCE !== 'undefined' && tinyMCE.editors && Object.keys(tinyMCE.editors).length > 0) {
         const configTemplate = $(`.tinymce-config-template[data-target-id="${targetId}"]`);
         if (configTemplate.length) {
            try {
               const configCodeString = configTemplate.html();
               const script = document.createElement('script');
               script.textContent = `
                        (function() {
                            ${configCodeString} // Выполняем код, который создаёт переменную config
                            if (window.tinyMCE) {
                                const existingEditor = window.tinyMCE.get('${targetId}');
                                if (existingEditor) {
                                    existingEditor.remove();
                                }
                                window.tinyMCE.init(config);
                            }
                        })();
                    `;
               document.head.appendChild(script);
               document.head.removeChild(script);

            } catch (e) {
               console.error('Ошибка инициализации TinyMCE для #' + targetId + ':', e, configCodeString);
            }
         } else {
         }
      } else {
         console.warn('TinyMCE еще не готов для инициализации в поле:', targetId);
         setTimeout(() => initializeTinyMCE(targetId), 100);
      }
   }

   function initializeImageHandlersForRow(row) {
      const selectBtn = row.find('.select-card-image-btn');
      const removeBtn = row.find('.remove-card-image-btn');
      const previewContainer = row.find('.card-image-preview-container');
      const hiddenField = row.find('.card-image-id-field');

      selectBtn.off('click').on('click', function (e) {
         e.preventDefault();
         const button = $(this);

         if (mediaUploader) {
            mediaUploader.open();
            return;
         }

         mediaUploader = wp.media({
            title: 'Выберите изображение для карточки',
            button: { text: 'Выбрать' },
            multiple: false
         });

         mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            hiddenField.val(attachment.id);

            const imgHtml = `<img src="${attachment.url}" class="card-image-preview" alt="Предпросмотр">`;
            previewContainer.html(imgHtml);

            removeBtn.show();
         });

         mediaUploader.open();
      });

      removeBtn.off('click').on('click', function (e) {
         e.preventDefault();
         const button = $(this);
         const previewContainer = button.siblings('.card-image-preview-container');
         const hiddenField = button.siblings('.card-image-id-field');

         hiddenField.val('');
         previewContainer.html('');
         button.hide();
      });
   }

   setTimeout(function () {
      console.log('Попытка инициализировать существующие TinyMCE...');
      $('tbody tr:not(.card-template)').each(function () {
         const row = $(this);
         const textarea = row.find('textarea');
         if (textarea.length && textarea.attr('id')) {
            if (textarea.attr('id') !== 'detox_test_hidden_editor_for_loading') {
               initializeTinyMCE(textarea.attr('id'));
            }
         }
         initializeImageHandlersForRow(row);
      });
   }, 100);

   $('#add-detox-test-card-row').on('click', function (e) {
      e.preventDefault();
      const newRow = $('.card-template').clone().removeClass('card-template').removeAttr('style');

      const newIndex = cardIndex++;
      newRow.find('.card-image-id-field').attr('name', DetoxTestRepeater.fieldNamePrefix + '[' + newIndex + ']' + DetoxTestRepeater.imageFieldName);
      const newTextareaId = 'detox_test_card_text_' + Date.now() + '_' + newIndex;
      newRow.find('textarea').attr('id', newTextareaId).attr('name', DetoxTestRepeater.fieldNamePrefix + '[' + newIndex + ']' + DetoxTestRepeater.textFieldName).val('');

      $('tbody').append(newRow);

      const newConfigTemplate = newRow.find('.tinymce-config-template');
      if (newConfigTemplate.length) {
         let configCode = newConfigTemplate.html();
         configCode = configCode.replace(/#REPLACE_WITH_NEW_ID/g, '#' + newTextareaId);
         newConfigTemplate.html(configCode);
         newConfigTemplate.attr('data-target-id', newTextareaId);
      }

      setTimeout(() => initializeTinyMCE(newTextareaId), 100);

      initializeImageHandlersForRow(newRow);
   });

   $(document).on('click', '.remove-card-row', function (e) {
      e.preventDefault();
      const row = $(this).closest('tr');
      const textareaId = row.find('textarea').attr('id');

      if (textareaId && typeof tinyMCE !== 'undefined') {
         const editor = tinyMCE.get(textareaId);
         if (editor) {
            editor.remove();
         }
      }

      row.remove();
   });
});