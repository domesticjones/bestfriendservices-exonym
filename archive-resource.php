<?php
  get_header();
  ex_wrap('start', 'general');
    echo '<h1 class="general-page-heading">Resources</h1>';
    echo '<p class="resource-disclaimer">Please click on a resource below for more information.</p>';
    $resourceQueryArgs = array(
      'post_type' => 'resource',
      'posts_per_page' => -1,
      'post_parent' => 0,
    );
    $resourceQuery = new WP_Query($resourceQueryArgs);
    if($resourceQuery->have_posts()) {
      echo '<nav class="resources-list">';
      while ($resourceQuery->have_posts()) {
        $resourceQuery->the_post();
        echo '<li class="resource">';
          echo '<a href="' . get_the_permalink() . '">';
            echo '<h2>' . get_the_title() . '</h2>';
          echo '</a>';
          $subTopics = get_children('post_parent=' . $post->ID . '&post_type=resource');
          if(!empty($subTopics)) {
            foreach($subTopics as $topic) {
              echo '<a href="' . get_the_permalink($topic->ID) . '" class="resource-child">' . get_the_title($topic->ID) . '</a>';
            }
          }
        echo '</li>';
      }
      echo '</nav>';
      wp_reset_query();
    }
  ex_wrap('end');
  get_footer();
?>
