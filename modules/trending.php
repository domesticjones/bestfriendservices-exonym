<?php
  $heading = get_field('trending_heading');
  $trendingField = get_field('trending_items');
  if(have_rows('trending_items')) {
    echo '<h1 class="trending-heading">' . $heading . '</h1>';
    echo '<div id="trending-slider">';
    while(have_rows('trending_items')) {
      the_row();
      $content = get_sub_field('content');
      $image = get_sub_field('image');
      echo '<div class="trending-item">';
        echo '<div class="trending-content">';
          echo '<header class="trending-data">';
            echo '<h2>' . $content['heading'] . '</h2>';
            echo '<h3>' . $content['sub_heading'] . '</h3>';
            echo '<p>' . $content['content'] . '</p>';
            echo '<footer><span class="trending-price">' . $content['price'] . '</span>' . ex_cta($content['call_to_action'], false) . '</footer>';
          echo '</header>';
          echo '<div class="trending-photo">' . wp_get_attachment_image($image['id'], 'thumbnail-large') . '</div>';
        echo '</div>';
      echo '</div>';
    }
    echo '</div>';
    ?>
    <div id="trending-thumbs" data-slick='{"slidesToShow": <?php echo count($trendingField); ?>}'>
    <?php
      while(have_rows('trending_items')) {
        the_row();
        $image = get_sub_field('image');
        echo '<div class="trending-thumb">' . wp_get_attachment_image($image['id'], 'thumbnail-medium') . '</div>';
      }
    echo '</div>';
  }
?>
