<nav id="responsive-nav">
  <img src="<?php ex_logo(); ?>" alt="Logo for <?php ex_brand(); ?>" class="responsive-logo" />
  <?php
    wp_nav_menu(array(
      'container' => false,
      'theme_location' => 'menu-responsive',
      'depth' => 2,
    ));
  ?>
  <?php get_template_part('modules/copyright'); ?>
</nav>
