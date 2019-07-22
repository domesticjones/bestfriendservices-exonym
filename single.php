<?php
  get_header();
    if(have_posts()): while(have_posts()): the_post();
      ex_wrap('start', 'general');
        echo get_the_post_thumbnail($post->ID, 'large', array('class' => 'aligncenter'));
        echo '<h1 class="general-page-heading">' . get_the_title() . '<time class="heading-sub" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time></h1>';
        the_content();
      ex_wrap('end');
    endwhile; endif;
  get_footer();
?>
