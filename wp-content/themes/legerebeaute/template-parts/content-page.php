<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package legerebeaute
 */

$page_id = get_the_ID();

$page_title = get_the_title($page_id);
$page_content = get_the_content($page_id);

$has_content = !empty(trim($page_content));

?>

<article id="post-<?php echo esc_attr($page_id); ?>" <?php post_class(); ?>>

   <?php if ($page_title): ?>
      <header class="entry-header">
         <h1 class="entry-title"><?php echo esc_html($page_title); ?></h1>
      </header>
   <?php endif; ?>

   <?php if ($has_content): ?>
      <div class="entry-content">
         <?php
         echo apply_filters('the_content', $page_content);
         // Используем apply_filters для корректной обработки shortcodes и т.п.
      
         // Выводим навигацию по страницам, если контент был разбит на несколько (например, wp_link_pages)
         wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Страницы:', 'legerebeaute') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
         ));
         ?>
      </div>
   <?php endif; ?>

</article>