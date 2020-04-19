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

  function ex_wrap($pos, $class = '', $id = '', $target = null) {
    if($target == null) {
      $target = $post->ID;
    }
    if($pos == 'start') {
      $styles = ex_bg(get_field($class . '_settings', $target));
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

  function ex_modal($id, $content) {
    $output = '<div id="modal-' . $id . '" class="modal-content-inline">';
      $output .= $content;
    $output .= '</div>';
    return $output;
  }

  function ex_shop_header($repeaterArray) {
    if($repeaterArray) {
    	ex_wrap('start', 'woocommerce_heading_slider');
    		echo '<div id="shop-gallery">';
    			foreach($repeaterArray as $s)  {
    				$lOne = $s['line_1'];
    				$lTwo = $s['line_2'] ? '<span>' . $s['line_2'] . '</span>' : '';
    				$img = wp_get_attachment_image_url($s['background']['id'], 'jumbo');
    				$heading = $lOne || $lTwo ? '<h1>' . $lOne . $lTwo . '</h1>' : '';
    				$button = $s['button'] ? '<a href="' . $s['button']['url'] . '" class="button shop-gallery-cta" target="' . $s['button']['target'] . '">' . $s['button']['title'] . '</a>' : '';
    				echo '<div><div class="shop-gallery-slide" style="background-image: url(' . $img .');">' . $heading . $button . '</div></div>';
    			}
    		echo '</div>';
    	ex_wrap('end');
    }
  }
