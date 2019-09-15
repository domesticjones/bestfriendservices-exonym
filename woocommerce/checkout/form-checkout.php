<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$checkoutPage = wc_get_page_id('checkout'); ex_wrap('start', 'woocommerce_heading', '', $checkoutPage); ?>
<?php if(apply_filters( 'woocommerce_show_page_title', true)): ?>
	<h1 class="woocommerce-page-title"><?php the_field('woocommerce_heading', $checkoutPage); ?></h1>
<?php endif; ex_wrap('end'); ?>


<?php

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

ex_wrap('start', 'checkout');
?>
<aside class="checkout-sidebar">
	<?php
		do_action('woocommerce_before_checkout_form', $checkout);
    $cart = WC()->cart->get_cart();
		echo '<ul class="checkout-lineitems">';
		foreach($cart as $item => $values) {
			$prod =  $values['product_id'];
			$isCompositeChild = $values['composite_parent'];
			$childStatus = '';
			if($isCompositeChild) {
				$childStatus = ' composite_child';
			}
			$customForms = $values['wcpa_data'];
			$customFormsInfo = [];
			$customFormsPrint = '';
			if($customForms) {
				foreach($customForms as $form) {
					array_push($customFormsInfo, array('name' => $form['label'], 'value' => $form['value']));
				}
				foreach($customFormsInfo as $info) {
					$customFormsPrint .= '<i>' . $info['name'] . ':</i><span class="engraving-info">' . $info['value'] . '</span>';
				}
			}
			$product = wc_get_product($prod);
			$price = get_post_meta($prod, '_price', true);
			$variations = (!empty($values['variation_id'])) ? $values['variation_id'] : '';
			$variationsPrint = '';
			if(!empty($variations)) {
			   $variationsPrint = ex_wcVariationRetrieval($variations);
			}
			echo '<li class="checkout-product' . $childStatus . '">';
				echo '<div class="checkout-cart-photo">' . get_the_post_thumbnail($prod, 'thumbnail') . '</div>';
				echo '<div class="checkout-cart-data"><h3>' . get_the_title($prod) . '</h3><p>' . $customFormsPrint . $variationsPrint . '</p><p class="price">' . get_woocommerce_currency_symbol() . $price . '</p></div>';
			echo '</li>';
		}
		echo '<li class="checkout-editcart"><a href="' . get_permalink(wc_get_page_id('cart')) . '">Edit Cart Contents</a></li>';
		echo '<li id="checkout-cart-subtotal" class="checkout-total"><h3>Subtotal:</h3><i></i></li>';
		echo '<li id="checkout-cart-total" class="checkout-total"><h3>Total:</h3><i></i></li>';
		echo '</ul>';
	?>
</aside>
<header class="checkout-steps">
	<a href="#checkout-login" class="checkout-step<?php if(!is_user_logged_in()) { echo ' is-active'; } ?>">Account</a>
	<a href="#checkout-info" class="checkout-step<?php if(is_user_logged_in()) { echo ' is-active'; } ?>">Your Info</a>
	<a href="#checkout-shipping" class="checkout-step">Shipping</a>
	<a href="#checkout-payment" class="checkout-step">Payment</a>
</header>
<section id="checkout-login" class="checkout-section<?php if(!is_user_logged_in()) { echo ' is-active'; } ?>">
	<?php
		do_action('woocommerce_checkout_before_customer_details');
		if(is_user_logged_in()) {
			$user = wp_get_current_user();
			echo '<p><strong>Currently Logged In As:</strong><br />' . $user->billing_first_name . ' ' . $user->billing_last_name . '</p>';
			echo '<a href="' . wc_logout_url() . '">' . Logout . '</a>';
		} else {
			echo '
				<nav>
					<a id="checkout-continue-guest" href="#checkout-info" class="checkout-section-nav-button">Continue as Guest</a>
					<a id="checkout-continue-guest" href="' . wc_lostpassword_url() . '">Reset Password</a>
					<a id="checkout-continue-create" href="#checkout-info" class="checkout-section-nav-button">Create Account</a>
				</nav>
			';
		}
	?>

</section>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

	<?php if($checkout->get_checkout_fields()): ?>
			<section id="checkout-info" class="checkout-section<?php if(is_user_logged_in()) { echo ' is-active'; } ?>">
				<?php
					do_action('woocommerce_checkout_billing');
					do_action('woocommerce_checkout_after_customer_details');
					ex_checkoutNav(array('Change Accounts', '#checkout-login'), array('Shipping Options', '#checkout-shipping'));
				?>
			</section>
		<section id="checkout-shipping" class="checkout-section">
			<?php
				do_action('woocommerce_checkout_before_order_review_heading');
				do_action('woocommerce_checkout_before_order_review');
				do_action('woocommerce_checkout_shipping');
			?>
			<h3 class="checkout-shipping-heading">Choose a Shipping Method</h3>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			<?php ex_checkoutNav(array('Your Info', '#checkout-info'), array('Payment Info', '#checkout-payment')); ?>
		</section>
		<section id="checkout-payment" class="checkout-section">
			<?php
				do_action('woocommerce_checkout_after_order_review');
				echo '<nav class="checkout-section-nav">';
					echo '<a href="#checkout-shipping" class="checkout-section-nav-button cta-button cta-color-grey cta-arrow-left">Back to Shipping Info</a>';
					echo '<button type="submit" class="cta-button cta-color-green">Place Order</button>';
				echo '</nav>';
			?>
		</section>
	<?php endif; ?>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ex_wrap('end') ?>
