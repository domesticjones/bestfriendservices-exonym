<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$type = $product->get_type();
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="product-single-top">
		<?php
			// Image Column
			$productImage = get_the_post_thumbnail($product->get_id(), 'large');
			$productImageUrl = get_the_post_thumbnail_url($product->get_id(), 'large');
			$productImageThumb = get_the_post_thumbnail($product->get_id(), 'thumbnail');
			$productGallery = $product->get_gallery_image_ids();
			echo '<div class="product-single-top-left">';
				echo '<div id="product-single-image" style="background-image: url(' . $productImageUrl . ')">' . $productImage . '</div>';
				if(!empty($productGallery)) {
					echo '<ul id="product-single-thumbs">';
						echo '<li class="is-active" data-image="' . $productImageUrl . '">' . $productImageThumb . '</li>';
						foreach($productGallery as $g) {
							$gThumb = wp_get_attachment_image($g, 'thumbnail');
							$gThumbUrl = wp_get_attachment_image_url($g, 'large');
							echo '<li data-image="' . $gThumbUrl . '">' . $gThumb . '</li>';
						}
					echo '</ul>';
				}
			echo '</div>';

			// Product Summary Column
			$productName = $product->get_name();
			$productPrice = $product->get_price();
			echo '<div class="product-single-top-right">';
				echo '<h1>' . $productName . '</h1>';
				the_excerpt();
				if($type == 'composite') {
					echo '<button id="product-customize" type="button">Customize for Your Pet</button>';
				} else {
					echo woocommerce_template_single_add_to_cart();
				}
			echo '</div>';
		?>
</div>

<?php
	// Composite Product Content
	if($type == 'composite') {
		echo '<div id="product-single-composite">';
			echo woocommerce_template_single_add_to_cart();
		echo '</div>';
	}

	// More Information
	$productInfoImages = get_field('details_images', $product->get_id());
	echo '<div class="product-single-more">';
		echo '<h1>More Information</h1>';
		if(!empty($productInfoImages['heading'])) { echo wp_get_attachment_image($productInfoImages['heading'], 'large', false, array('class' => 'product-single-more-image-heading')); }
		if(!empty($productInfoImages['side'])) {
			echo '<div class="product-single-more-content">';
				the_content();
			echo '</div>';
			echo wp_get_attachment_image($productInfoImages['side'], 'medium', false, array('class' => 'product-single-more-image-side'));
		} else {
			the_content();
		}
	echo '</div>';

	// Related Products
	echo '<div class="product-single-related">';
		echo woocommerce_output_related_products();
	echo '</div>';
?>

<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20

	do_action( 'woocommerce_before_single_product_summary' );

		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60

		do_action( 'woocommerce_single_product_summary' );

	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20

	do_action( 'woocommerce_after_single_product_summary' );
	*/
	?>
