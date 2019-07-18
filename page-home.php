<?php
  /* TEMPLATE NAME: Home */
  get_header();
  if(have_posts()): while(have_posts()): the_post();
    ex_wrap('start', 'hero', 'hero');
      echo 'hero image';
    ex_wrap('end');
    ex_wrap('start', 'cats', get_field('categories_module_id'));
      echo 'categories';
    ex_wrap('end');
    ex_wrap('start', 'start', 'funnel');
      echo 'funnel area';
    ex_wrap('end');
    ex_wrap('start', 'testimonials', get_field('testimonials_settings')['module_id']);
      echo 'testimonials';
    ex_wrap('end');
    ex_wrap('start', 'topsellers', 'top-sellers');
      echo 'top sellers';
    ex_wrap('end');
    ex_wrap('start', 'about', get_field('about_settings')['module_id']);
      echo 'about';
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
