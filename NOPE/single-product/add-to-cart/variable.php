<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options( array(
									'options'   => $options,
									'attribute' => $attribute_name,
									'product'   => $product,
								) );
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php
			ob_start();
				do_action( 'woocommerce_single_variation' );
				$addonForms = ob_get_contents();
			ob_end_clean();
			if(strpos($addonForms, 'photo-engrave-upload') !== false) {
				if(is_user_logged_in()) {
					?>

					<div id="photo-engrave" class="not-active">
						<span>Click here to upload your photo</span>
						<input type="file" name="file" accept="image/jpg, image/jpeg, image/png" id="photo-upload" onchange="upload();return false;">
					</div>

					<script type="text/javascript">
						var uploadFacade = document.getElementById("photo-engrave");
						var fileInputElement = document.getElementById("photo-upload");
						function upload(){
							uploadFacade.classList.remove("not-active", "is-active");
						  var formData = new FormData();
						  formData.append("action", "upload-attachment");
						  formData.append("async-upload", fileInputElement.files[0]);
						  formData.append("name", fileInputElement.files[0].name);
						  <?php $my_nonce = wp_create_nonce('media-form'); ?>
						  formData.append("_wpnonce", "<?php echo $my_nonce; ?>");
						  var xhr = new XMLHttpRequest();
						  xhr.onreadystatechange=function(){
						    if (xhr.readyState==4 && xhr.status==200) {
									var fileInfo = JSON.parse(xhr.responseText).data;
									var img = document.createElement('img');
									img.src = fileInfo.url;
									uploadFacade.appendChild(img);
									uploadFacade.classList.add("is-active");
									document.getElementById("photo-engrave-upload").value = fileInfo.url;
						    }
						  }
						  xhr.open("POST","/wp-admin/async-upload.php",true);
						  xhr.send(formData);
						}
					</script>
					<?
				} else {
					echo 'Please <a href="' . get_permalink(wc_get_page_id('myaccount')) . '?goto=' . get_the_id() . '">Log In or Register</a> to upload a photo of your pet.';
				}
			}
		?>
		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
