<?php
  /* TEMPLATE NAME: Home */
  get_header();
  if(have_posts()): while(have_posts()): the_post();
  // Hero Image
    ex_wrap('start', 'hero', 'hero');
      get_template_part('modules/hero');
    ex_wrap('end');
    // Product Categories
    ex_wrap('start', 'cats', get_field('categories_module_id'));
      $catsExclude = get_field('categories_exclude');
      echo '<h2 class="cats-heading">' . get_field('categories_header') . '</h2>';
      $productCatArgs = array(
        'taxonomy'    => 'product_cat',
        'exclude'     => $catsExclude,
        'hide_empty'  => false
      );
      $productCategories = get_categories($productCatArgs);
      echo '<nav class="cats-list">';
        foreach($productCategories as $cat) {
          $thumbId = get_term_meta( $cat->term_id, 'thumbnail_id', true);
          echo '<a href="' . get_term_link($cat->term_id, 'product_cat') . '">' . wp_get_attachment_image($thumbId, 'thumbnail') . '<span>' . $cat->name . '</span></a>';
        }
      echo '</nav>';
    ex_wrap('end');
    ex_wrap('start', 'funnel', get_field('funnel_module_id'));
      get_template_part('modules/funnel');
    ex_wrap('end');
    ex_wrap('start', 'testimonials', get_field('testimonials_settings')['module_id']);
      get_template_part('modules/testimonials');
    ex_wrap('end');
    ex_wrap('start', 'topsellers', 'top-sellers');
      echo 'top sellers';
    ex_wrap('end');
    ex_wrap('start', 'about', get_field('about_settings')['module_id']);
      get_template_part('modules/about');
    ex_wrap('end');
    ex_wrap('start', 'trending', 'trending');
      echo 'trending';
    ex_wrap('end');
    ex_wrap('start', 'quote', get_field('quote_settings')['module_id']);
      echo 'quote';
    ex_wrap('end');
  endwhile; endif;
  get_footer();
?>
