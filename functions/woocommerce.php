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
  function ex_redirect_wc_public(){
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
  add_action('init','ex_redirect_wc_public');

  // Kill Breadcrumbs
  remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

  // Kill Related Products
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

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

  // Change "Sorting" Names
  function ex_wcSortingRename($sorting_options){
    $sorting_options = array(
      'menu_order' => __( 'Sort Items...', 'woocommerce' ),
      'popularity' => __( 'Top Sellers', 'woocommerce' ),
      'rating'     => __( 'Highest Rated', 'woocommerce' ),
      'date'       => __( 'Newest Items', 'woocommerce' ),
      'price'      => __( 'Price: $ &rarr; $$$', 'woocommerce' ),
      'price-desc' => __( 'Price: $$$ &rarr; $', 'woocommerce' ),
    );
    return $sorting_options;
  }
  add_filter('woocommerce_catalog_orderby', 'ex_wcSortingRename');

  // Change Products Per Pages
  function ex_wcPostsPerPage($cols) {
    $cols = 12;
    return $cols;
  }
  add_filter('loop_shop_per_page', 'ex_wcPostsPerPage', 20);

  // Get the variations on the checkout list
  function ex_wcVariationRetrieval($item_id) {
    $_product = new WC_Product_Variation($item_id);
    $variation_data = $_product->get_variation_attributes();
    //$variation_detail = woocommerce_get_formatted_variation( $variation_data, true );  // this will give all variation detail in one line
    $variation_detail = woocommerce_get_formatted_variation($variation_data, false);  // this will give all variation detail one by one
    return $variation_detail; // $variation_detail will return string containing variation detail which can be used to print on website
    // return $variation_data; // $variation_data will return only the data which can be used to store variation data
  }

  // Redirect to product on registration if browser token available
  function custom_registration_redirect_after_registration() {
    $backtoproduct = $_GET['goto'];
    if($backtoproduct) {
      return home_url('?p=' . $backtoproduct);
    } else {
      return get_permalink(wc_get_page_id('myaccount'));
    }
  }
  add_action('woocommerce_registration_redirect', 'custom_registration_redirect_after_registration', 2);

  // Allow Customer Role to upload files
  global $wp_roles; // global class wp-includes/capabilities.php
  $wp_roles->add_cap('customer', 'upload_files');

  // Make Terms & Conditions checked by Default
  add_filter('woocommerce_terms_is_checked_default', '__return_true');
