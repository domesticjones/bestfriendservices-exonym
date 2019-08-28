<?php
  /* TEMPLATE NAME: Company */
  get_header();
  if(have_posts()): while(have_posts()): the_post();
    ex_wrap('start', 'hero', 'hero');
      get_template_part('modules/hero');
    ex_wrap('end');
  endwhile; endif;
  get_footer();
?>
