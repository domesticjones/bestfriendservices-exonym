<?php
  get_header();
    if(have_posts()): while(have_posts()): the_post();
      ex_wrap('start', 'general');
        echo '<h1 class="general-page-heading">' . get_the_title() . '<a href="' . get_post_type_archive_link('resource') . '" class="heading-sub">Back to Resources</a></h1>';
        the_content();
        if(have_rows('links')) {
          echo '<h2 class="resource-subhead">References &amp; Links</h2>';
          echo '<nav class="resource-reference">';
            while(have_rows('links')) {
              the_row();
              if(get_row_layout() == 'link') {
                $link = get_sub_field('link');
                $domain = parse_url($link['url']);
                echo '<a href="' . $link['url'] . '" target="' . $link['target'] . '" class="cta-button cta-color-violet"><span class="name">' . $link['title'] . '</span><span class="details">' . $domain['host'] . '</span></a>';
              } elseif(get_row_layout() == 'file') {
                $file = get_sub_field('file');
                echo '<a href="' . $file['url'] . '" target="_blank" class="cta-button cta-color-violet"><span class="name">' . $file['title'] . '</span><span class="details">' . $file['mime_type'] . '</span></a>';
              }
            }
          echo '</nav>';
        }
        $subTopics = get_children('post_parent=' . $post->ID . '&post_type=resource');
        if(!empty($subTopics)) {
          echo '<h2 class="resource-subhead">Sub Topics</h2>';
          echo '<nav class="resource-subtopics">';
            foreach($subTopics as $topic) {
              echo '<a href="' . get_the_permalink($topic->ID) . '" class="cta-button cta-color-green">' . get_the_title($topic->ID) . '</a>';
            }
          echo '</nav>';
        }
      ex_wrap('end');
    endwhile; endif;
  get_footer();
?>
