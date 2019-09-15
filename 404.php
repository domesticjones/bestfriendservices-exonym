<?php
  get_header();

  ex_wrap('start', 'general', '404');
    echo '<h1 class="general-page-heading">' . get_field('404_page_heading', 'options') . '</h1>';
    echo '<p style="text-align: center;">The URL <strong>' . $_SERVER[REQUEST_URI] . '</strong> could not be loaded.</p>';
    if(have_rows('404_page_links', 'options')) {
      echo '<ul class="error-404-links">';
      while(have_rows('404_page_links', 'options')) {
        the_row();
        echo '<li>';
          ex_cta(get_sub_field('call_to_action'));
        echo '</li>';
      }
      echo '<ul>';
    }
  ex_wrap('end');
  get_footer();
?>
