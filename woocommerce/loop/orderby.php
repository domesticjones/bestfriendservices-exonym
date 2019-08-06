<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form class="woocommerce-ordering" method="get">
  <?php
    $preResults = 'Showing ';
    $results = 0;
    $postResults = ' items';
    if(is_shop()) {
      $preResults = '';
      $results = '';
	    $postResults = '(' . wp_count_posts('product')->publish . ' items)' . ex_page_navi();
    } elseif(is_tax('product_cat')) {
      $term = get_queried_object()->term_id;
      $termData = get_term($term);
      $preResults = 'Showing only ' . $termData->name . ': ';
      $results = $termData->count;
    }
    if($results == 1) {
      $postResults = ' item';
    }
    $resultsPrint = $preResults . '<strong>' . $results . '</strong>' . $postResults;
    if($results = 0) {
      $resultsPrint = 'No items found';
    }
		$typeSelect = ($_GET['pettype']);
		if($typeSelect == 'cat') {
      $resultsPrint = 'Showing all <strong>Cat</strong>-specific items';
		} elseif($typeSelect == 'dog') {
      $resultsPrint = 'Showing all <strong>Dog</strong>-specific items';
		}
    echo '<p>' . $resultsPrint . '</p>';
  ?>
	<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
