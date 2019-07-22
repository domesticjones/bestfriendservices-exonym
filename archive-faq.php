<?php
  get_header();
  if(have_posts()):
    ex_wrap('start', 'general');
      echo '<h1 class="general-page-heading">Frequently Asked Questions</h1>';
      echo '<input id="faq-search" type="text" placeholder="Type here to search the FAQ by keyword">';
      echo '<ul id="faq-list">';
        while(have_posts()): the_post();
          echo '<li class="question is-active">';
            echo '<h2 class="faq-title">' . get_the_title() . '</h2>';
            echo '<div class="faq-content">' . get_the_content() . '</div>';
          echo '</li>';
        endwhile;
      echo '</ul>';
    ex_wrap('end');
  endif;
  get_footer();
?>
