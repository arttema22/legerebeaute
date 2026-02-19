// wp-content/themes/legerebeaute/assets/js/services-archive-filter.js

document.addEventListener('DOMContentLoaded', function () {
   const filterButtons = document.querySelectorAll('.filter-btn');
   const servicesGrid = document.getElementById('cards-grid');

   if (typeof legerebeaute_archive_vars === 'undefined' || typeof legerebeaute_archive_vars.ajax_url === 'undefined') {
      return;
   }

   const ajaxUrl = legerebeaute_archive_vars.ajax_url;
   filterButtons.forEach(button => {
      button.addEventListener('click', function (e) {
         e.preventDefault();
         filterButtons.forEach(btn => btn.classList.remove('active'));
         this.classList.add('active');
         const categorySlug = this.getAttribute('data-category');
         fetchServices(categorySlug);
      });
   });

   function fetchServices(categorySlug) {
      servicesGrid.innerHTML = '<p>Загрузка...</p>';
      const data = new FormData();
      data.append('action', 'legerebeaute_filter_services');
      data.append('category', categorySlug);
      fetch(ajaxUrl, {
         method: 'POST',
         body: data
      })
         .then(response => response.json())
         .then(data => {
            if (data.success) {
               servicesGrid.innerHTML = data.data;
            } else {
               servicesGrid.innerHTML = '<p>Услуги не найдены.</p>';
            }
         })
         .catch(error => {
            console.error('Ошибка при загрузке услуг:', error);
            servicesGrid.innerHTML = '<p>Произошла ошибка при загрузке услуг.</p>';
         });
   }
});