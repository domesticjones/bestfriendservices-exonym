<?php

  function ex_bg($val) {
    if($val['background_settings']['color']) {
      $color = $val['background_settings']['color'];
    } else {
      $color = 'white';
    }
    $opacity = $val['background_settings']['opacity'] / 100;
    $img = $val['background_image'];
    if($img) {
      $output = [$color, '<div class="module-bg" style="opacity: ' . $opacity . '; background-image: url(' . $img['sizes']['jumbo'] . ')">' . wp_get_attachment_image($img['id'], 'jumbo') . '</div>'];
    } else {
      $output = [$color, null];
    }
    return $output;
  }

  function ex_wrap($pos, $class = '', $id = '') {
    if($pos == 'start') {
      $styles = ex_bg(get_field($class . '_settings'));
      $output = '<section id="' . $id . '" class="module module-bg-' . $styles[0] . ' animate-parallax animate-z-normal module-' . $class . '">' . $styles[1];
    } elseif($pos == 'end') {
      $output = '</section>';
    }
    echo $output;
  }

  function ex_cta($field, $print = true) {
    $cta = $field;
    if(empty($cta['link']['title'])) {
      return false;
    } else {
      $output = '<a href="' . $cta['link']['url'] . '" target="' . $cta['link']['target'] . '" class="cta-button cta-color-' . $cta['color'] . ' cta-arrow-' . $cta['arrow_direction'] . '"><span>' . $cta['link']['title'] . '</span></a>';
      if($print == true) {
        echo $output;
      } else {
        return $output;
      }
    }
  }
