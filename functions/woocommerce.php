<?php
  // Declare WC Support
  function ex_add_woocommerce_support() {
    add_theme_support('woocommerce');
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
