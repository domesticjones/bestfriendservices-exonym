<?php
  /* TEMPLATE NAME: General */
  get_header();
  if(have_posts()): while(have_posts()): the_post();
    ex_wrap('start', 'hero', 'hero');
      get_template_part('modules/hero');
    ex_wrap('end');
    if(have_rows('content_blocks')) {
      ex_wrap('start', 'general');
        while(have_rows('content_blocks')) {
          the_row();
          the_sub_field('content');
        }
      ex_wrap('end');
    }
  endwhile; endif;
  get_footer();
?>
