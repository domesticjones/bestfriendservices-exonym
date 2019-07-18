<?php

function ex_wrap($pos, $class = '', $field = '') {
  if($pos == 'start') {
    $output = '<section id="' . $field . '" class="module module-' . $class . '">';
  } elseif($pos == 'end') {
    $output = '</section>';
  }
  echo $output;
}
