<?php
/**
 * CPT "Специальные предложения"
 */

if (!defined('ABSPATH')) {
   exit;
}

function legerebeaute_register_offers_cpt()
{
   $labels = [
      'name' => _x('Специальные предложения', 'Post type general name', 'legerebeaute'),
      'singular_name' => _x('Специальное предложение', 'Post type singular name', 'legerebeaute'),
      'menu_name' => _x('Спецпредложения', 'Admin Menu text', 'legerebeaute'),
      'name_admin_bar' => _x('Спецпредложение', 'Add New on Toolbar', 'legerebeaute'),
      'add_new' => __('Добавить новое', 'legerebeaute'),
      'add_new_item' => __('Добавить новое спецпредложение', 'legerebeaute'),
      'new_item' => __('Новое спецпредложение', 'legerebeaute'),
      'edit_item' => __('Редактировать спецпредложение', 'legerebeaute'),
      'view_item' => __('Просмотр спецпредложения', 'legerebeaute'),
      'all_items' => __('Все спецпредложения', 'legerebeaute'),
      'search_items' => __('Искать спецпредложения', 'legerebeaute'),
      'not_found' => __('Спецпредложений не найдено.', 'legerebeaute'),
      'not_found_in_trash' => __('В корзине спецпредложений нет.', 'legerebeaute'),
   ];

   $args = [
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => ['slug' => 'offers'],
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-tickets-alt',
      'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
   ];

   register_post_type('offers', $args);
}
add_action('init', 'legerebeaute_register_offers_cpt');