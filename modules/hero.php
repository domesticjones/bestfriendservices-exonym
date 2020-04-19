<?php
  $heightRaw = get_field('hero_image_height');
  $height = $heightRaw['number'] . $heightRaw['unit'];
  $images = get_field('hero_images');
  if(have_rows('hero_images')) {
    echo '<ul id="hero-slider">';
    while(have_rows('hero_images')) {
      the_row();
      $data = get_sub_field('data');
      $bg = get_sub_field('background');
      $graphic = $data['graphic'];
      if($bg['image']) {
        echo '<li><div class="hero-wrap animate-parallax animate-z-extreme" style="min-height: ' . $height . '">';
          echo '<div class="hero-content" style="min-height: ' . $height . '"><img src="' . $graphic['sizes']['large'] . '" alt="' . $graphic['alt'] . '" />' .  ex_cta($data['call_to_action'], false) . '</div>';
          echo '<div class="module-bg not-loaded" style="opacity: ' . ($bg['opacity'] / 100) . '; background-image: url(' . $bg['image']['sizes']['jumbo'] . ');">' . wp_get_attachment_image($bg['image']['id'], 'jumbo') . '</div>';
        echo '</div></li>';
      }
    }
    echo '</ul>';
  }
