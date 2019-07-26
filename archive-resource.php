<?php
  $resourcesArchive = 39537; // Page ID of the "Help Center" page
  get_header();
  ex_wrap('start', 'resources_heading', '', $resourcesArchive);
    echo '<h1>' . get_field(resources_heading, $resourcesArchive) . '</h1>';
  ex_wrap('end');
  ex_wrap('start', 'resources');
    echo '<nav class="resources-list"><ul>';
    if(have_rows('resource_links', $resourcesArchive)) {
      while(have_rows('resource_links', $resourcesArchive)) {
        the_row();
        $link = get_sub_field('link');
        $photo = get_sub_field('image');
        echo '<li class="resource" style="background-image: url(' . $photo['sizes']['medium'] . ')"><a href="' . $link['url'] . '"><h2>' . $link['title'] . '</h2>' . wp_get_attachment_image($photo['id'], 'medium') . '</a></li>';
      }
    }
    $resourceQueryArgs = array(
      'post_type' => 'resource',
      'posts_per_page' => -1,
      'post_parent' => 0,
    );
    $resourceQuery = new WP_Query($resourceQueryArgs);
    if($resourceQuery->have_posts()) {
      while ($resourceQuery->have_posts()) {
        $resourceQuery->the_post();
        echo '<li class="resource" style="background-image: url(' . get_the_post_thumbnail_url($post->ID, 'medium') . ')">';
          echo '<a href="' . get_the_permalink() . '">';
            echo '<h2>' . get_the_title() . '</h2>';
            the_post_thumbnail('medium');
          echo '</a>';
        echo '</li>';
      }
      wp_reset_query();
    }
    echo '</ul></nav>';
  ex_wrap('end');
  ex_wrap('start', 'general');
    the_field('resources_footer', $resourcesArchive);
    echo '<a href="#contact" class="cta-button cta-color-green cta-arrow-down" id="resources-contact">Contact</a>';
    echo '<footer id="resources-contact-info">';
      ex_contact('phone');
      ex_contact('email');
      ex_contact('address');
      ex_social();
    echo '</footer>';
  ex_wrap('end');
  get_footer();
?>
