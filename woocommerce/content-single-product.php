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


// LOGIC: Check Product Object Type
// if($product instanceof WC_Product_Composite) { echo 'it is composite'; }



?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<?php
    $productGalleryLifestyleImages = get_field('lifestyle_images');
    $productGalleryLifestyle = [];
    if($productGalleryLifestyleImages) {
      foreach($productGalleryLifestyleImages as $img) {
        array_push($productGalleryLifestyle, $img['ID']);
      }
    }
    $productGalleryThumb = [(int) get_post_thumbnail_id()];
    $productGallery = $product->get_gallery_image_ids();
    $images = array_merge($productGalleryLifestyle, $productGalleryThumb, $productGallery);
    if(!empty($images)) {
      echo '<div class="product-single-images">';
        echo '<div id="product-single-gallery-frame" style="background-image: url(' . wp_get_attachment_image_url($images[0], 'large') . ')"></div>';
        echo '<div id="product-single-gallery">';
          foreach($images as $img) {
            $largeUrl = wp_get_attachment_image_url($img, 'large');
            $largeImg = wp_get_attachment_image($img, 'large');
            echo '<div><div class="product-image-gallery-single" style="background-image: url(' . $largeUrl . ');">' . $largeImg . '</div></div>';
          }
        echo '</div>';
      echo '</div>';
    }
	?>
  <div class="product-single-data">
    <?php the_excerpt(); ?>
    <nav class="product-single-nav">
      <?php
				$terms = get_the_terms($product->get_id(), 'product_type');
				$product_type = sanitize_title(current($terms)->name);
				woocommerce_template_single_price();
        if($product_type == 'composite') {
          ob_start();
            woocommerce_template_single_add_to_cart();
            $productAddToCart = ob_get_contents();
          ob_end_clean();
          echo ex_modal('customize', $productAddToCart);
          echo '<a href="#customize" id="product-button-customize" class="cta-button cta-color-green cta-arrow-right">Select Options</a>';
        } elseif($product_type == 'simple') {
					woocommerce_template_single_add_to_cart();
				} elseif($product_type == 'variable') {
					ob_start();
						echo '<div class="variation-modal-wrap">';
							echo '<h2>Choose Options</h2>';
							echo '<div class="variation-modal-img">';
								echo '<img src="' . get_the_post_thumbnail_url($post->ID) . '" id="variation_custom_preview" />';
							echo '</div>';
							echo '<div class="variation-modal-data">';
								woocommerce_template_single_add_to_cart();
							echo '</div>';
						echo '</div>';
						$productAddToCart = ob_get_contents();
					ob_end_clean();
          echo ex_modal('options', $productAddToCart);
          echo '<a href="#options" id="product-button-options" class="cta-button cta-color-green cta-arrow-right">Select Options</a>';
				}
      ?>
    </nav>
    <nav class="product-tab-nav">
      <ul>
        <?php
          $contentMore = apply_filters('the_content', get_the_content());
          if(!empty($contentMore)) {
            $contentMoreOutput = '<h2>More Info About ' . get_the_title($product->ID) . '</h2>' . apply_filters('the_content', get_the_content());
            echo '<li><a href="#info">More Information</a>' . ex_modal('info', $contentMoreOutput) . '</li>';
          }
          $contentSpecs = 'size_guide';
          if(have_rows($contentSpecs)) {
            $contentSpecsOutput = '<h2>Size Guide for ' . get_the_title($product->ID) . '</h2>';
            $contentSpecsOutput .= '<table>';
            $contentSpecsOutput .= '<tr><th>Size</th><th>Width</th><th>Depth</th><th>Height</th><th>Pet Weight</th></tr>';
            while(have_rows($contentSpecs)) {
              the_row();
              $contentSpecsOutput .= '<tr>';
              $contentSpecsOutput .= '<td>' . get_sub_field('name') . '</td>';
              $contentSpecsOutput .= '<td>' . get_sub_field('width') . ' <sup>in</sup></td>';
              $contentSpecsOutput .= '<td>' . get_sub_field('depth') . ' <sup>in</sup></td>';
              $contentSpecsOutput .= '<td>' . get_sub_field('height') . ' <sup>in</sup></td>';
              $contentSpecsOutput .= '<td>' . get_sub_field('min_pet_weight') . ' - ' . get_sub_field('max_pet_weight') . ' <sup>lbs</sup></td>';
              $contentSpecsOutput .= '</tr>';
            }
            $contentSpecsOutput .= '</table>';
            echo '<li><a href="#size">Size Guide</a>' . ex_modal('size', $contentSpecsOutput) . '</li>';
          }
        ?>
      </ul>
    </nav>
  </div>



	<?php
	/*

  <div id="product-single-modal">
		<?php
		/**
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

		//do_action( 'woocommerce_single_product_summary' );
	</div>


	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	//do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
