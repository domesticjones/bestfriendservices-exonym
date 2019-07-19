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
      <header id="header" class="is-top" role="banner" itemscope itemtype="http://schema.org/WPHeader">
        <a href="<?php echo get_home_url(); ?>" id="logo">
					<img src="<?php ex_logo(); ?>" alt="Logo for <?php ex_brand(); ?>" class="logo-dark" />
					<img src="<?php ex_logo('primary', 'light'); ?>" alt="Light-colored Logo for <?php ex_brand(); ?>" class="logo-light" />
					<img src="<?php ex_logo('alternate', 'light'); ?>" alt="Emblem for <?php ex_brand(); ?>" class="logo-emblem" />
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
							echo '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '"><button type="button">Account</button></a>';
							wp_nav_menu(array(
		            'container' => false,
		            'theme_location' => 'menu-account',
		            'depth' => 1,
		          ));
						} else {
							echo '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '"><button type="button">Log In</button></a>';
							echo
								'<section class="header-login">' .
									wp_login_form(array(
										'echo' 						=> false,
										'label_username' 	=> 'Email Address',
										'label_remember' 	=> 'Stay Logged in',
										'value_remember'	=> true,
									)) .
									'<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '#register">Create an Account</a>
								</section>';
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
			<main id="content">
