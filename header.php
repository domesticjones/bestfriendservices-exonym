<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php wp_title(); ?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
		<div id="container">
			<header id="tagline">
				<?php echo get_bloginfo('description'); ex_social(); ?>
			</header>
      <header id="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
        <a href="<?php echo get_home_url(); ?>" id="logo">
					<img src="<?php ex_logo(); ?>" alt="Logo for <?php ex_brand(); ?>" class="logo-dark" />
					<img src="<?php ex_logo('primary', 'light'); ?>" alt="Light-colored Logo for <?php ex_brand(); ?>" class="logo-light" />
				</a>
        <nav class="nav-header" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
          <?php
						wp_nav_menu(array(
	            'container' => false,
	            'theme_location' => 'menu-header',
	            'depth' => 1,
	          ));
					?>
        </nav>
	      <nav class="nav-account" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php
						if(is_user_logged_in()) {
							echo '<button>Account</button>';
							wp_nav_menu(array(
		            'container' => false,
		            'theme_location' => 'menu-account',
		            'depth' => 1,
		          ));
						} else {
							echo '<button>Log In</button>';
							wp_login_form();
						}
					?>
					<?php
					?>
        </nav>
				<a href="#" id="responsive-nav-toggle">
          <span class="line"></span>
          <span class="line"></span>
          <span class="line"></span>
				</a>
      </header>
