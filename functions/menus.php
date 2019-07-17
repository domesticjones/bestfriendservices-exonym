<?php
/*
==============================
  [[[ Define all the Menus ]]]
==============================
*/

// Enable menus in WP
add_theme_support('menus');

// Define the nav bars
register_nav_menus(
  array(
    'menu-header' => __('Header', 'exonym'),
    'menu-responsive' => __('Responsinve', 'exonym'),
    'menu-account' => __('Account', 'exonym'),
    'menu-services' => __('Services', 'exonym'),
    'menu-info' => __('Information', 'exonym'),
  )
);
