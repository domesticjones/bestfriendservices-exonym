<?php
  // Declare WC Support
  function ex_add_woocommerce_support() {
    add_theme_support('woocommerce', array(
      'thumbnail_image_width' => 800,
    ));
  }
  add_action('after_setup_theme', 'ex_add_woocommerce_support');


  // Remove All WC Styling
  add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

  // Redirect login requests to Account page
  function possibly_redirect(){
    global $pagenow;
    if( 'wp-login.php' == $pagenow ) {
      if ( isset( $_POST['wp-submit'] ) ||   // in case of LOGIN
        ( isset($_GET['action']) && $_GET['action']=='logout') ||   // in case of LOGOUT
        ( isset($_GET['checkemail']) && $_GET['checkemail']=='confirm') ||   // in case of LOST PASSWORD
        ( isset($_GET['checkemail']) && $_GET['checkemail']=='registered') ) return;    // in case of REGISTER
      else {
        wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')), 301);
        exit();
      }
    }
  }
  add_action('init','possibly_redirect');

  // Kill Breadcrumbs
  remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

  // Send Admins to WP Dashboard instead of customer account
  function ex_redirect_wc_admins() {
    if(current_user_can('manage_options') && is_account_page()) {
      wp_redirect(admin_url(), 301);
      exit();
    }
  }
  add_action('template_redirect', 'ex_redirect_wc_admins');

  // Move Payments into after the order review in Checkout
  remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
  add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 20 );

  // Move Create Account in Checkout
  remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
  add_action( 'woocommerce_checkout_before_customer_details', 'woocommerce_checkout_login_form' );

  // Remove Select2 from front end
  function ex_dequeue_select2() {
    if(class_exists('woocommerce') && !is_admin()) {
      wp_dequeue_style('select2');
      wp_deregister_style('select2');
      wp_dequeue_script('selectWoo');
      wp_deregister_script('selectWoo');
    }
  }
  add_action('wp_enqueue_scripts', 'ex_dequeue_select2', 100);

  // Create the checkout navigation buttons
  function ex_checkoutNav($prev = null, $next = null) {
    echo '<nav class="checkout-section-nav">';
    if($prev) {
      echo '<a href="' . $prev[1] . '" class="checkout-section-nav-button cta-button cta-color-grey cta-arrow-left">' . $prev[0] . '</a>';
    }
    if($next) {
      echo '<a href="' . $next[1] . '" class="checkout-section-nav-button cta-button cta-color-green">' . $next[0] . '</a>';
    }
    echo '</nav>';
  }

  // Limit searches to only products
  function searchfilter($query) {
    if ($query->is_search && !is_admin() ) {
      $query->set('post_type', 'product');
    }
    return $query;
  }
  add_filter('pre_get_posts','searchfilter');
