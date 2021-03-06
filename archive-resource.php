<?php
  /* TEMPLATE NAME: Help Center */
  $resourcesArchive = get_page_by_path('help-center'); // Page ID of the "Help Center" page
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
      $formId = get_field('footer_form', $resourcesArchive);
      echo do_shortcode('[contact-form-7 id="' . $formId . '"]');
    echo '</footer>';
  ex_wrap('end');
  get_footer();
?>
