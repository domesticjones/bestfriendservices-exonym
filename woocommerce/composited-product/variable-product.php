<?php
/**
 * Composited Variable Product template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/composited-product/variable-product.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 4.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><div class="details component_data"><?php

	/**
	 * 'woocommerce_composited_product_details' hook.
	 *
	 * @since 3.2.0
	 *
	 * @hooked wc_cp_composited_product_excerpt - 10
	 */
	do_action( 'woocommerce_composited_product_details', $product, $component_id, $composite_product );
    $contentSpecs = 'size_guide';
    if(have_rows($contentSpecs, $product->get_id())) {
	?>
  <div id="funnel-weight-recommend">
    <div id="funnel-weight-recommend-value"></div>
    <div id="funnel-weight-recommend-text">Based on <strong id="recommend-pet-name"></strong>'s weight (<span id="recommend-pet-weight"></span>lbs), we recommend a size <strong id="recommend-pet-size"></strong>.</div>
    <?php
        $contentSpecsOutput = '<a href="#" id="funnel-weight-recommend-toggle">View the Size Guide</a>';
        $contentSpecsOutput .= '<table id="funnel-weight-recommend-table">';
        $contentSpecsOutput .= '<tr><th>Size</th><th>Width</th><th>Depth</th><th>Height</th><th>Pet Weight</th></tr>';
        while(have_rows($contentSpecs, $product->get_id())) {
          the_row();
          $contentSpecsOutput .= '<tr>';
          $contentSpecsOutput .= '<td>' . get_sub_field('name') . '</td>';
          $contentSpecsOutput .= '<td>' . get_sub_field('width') . ' <sup>in</sup></td>';
          $contentSpecsOutput .= '<td>' . get_sub_field('depth') . ' <sup>in</sup></td>';
          $contentSpecsOutput .= '<td>' . get_sub_field('height') . ' <sup>in</sup></td>';
          $contentSpecsOutput .= '<td><span class="pet-weight-min">' . get_sub_field('min_pet_weight') . '</span> - <span class="pet-weight-max">' . get_sub_field('max_pet_weight') . '</span> <sup>lbs</sup></td>';
          $contentSpecsOutput .= '</tr>';
        }
        $contentSpecsOutput .= '</table>';
        echo $contentSpecsOutput;
        ?>
  </div>
<?php } ?>
  <table class="variations" cellspacing="0">
		<tbody><?php

			foreach ( $attributes as $attribute_name => $options ) {

				?><tr class="attribute_options" data-attribute_label="<?php echo esc_attr( wc_attribute_label( $attribute_name ) ); ?>">
					<td class="label">
						<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?> <abbr class="required" title="<?php _e( 'Required option', 'woocommerce-composite-products' ); ?>">*</abbr></label>
					</td>
					<td class="value"><?php

						echo wc_cp_composited_single_variation_attribute_options( array(
							'options'    => $options,
							'attributes' => $attributes,
							'attribute'  => $attribute_name,
							'product'    => $product,
							'component'  => $composite_product->get_component( $component_id )
						) );

					?></td>
				</tr><?php
			}

		?></tbody>
	</table><?php

	/**
	 * 'woocommerce_composited_product_add_to_cart' hook.
	 *
	 * Useful for outputting content normally hooked to 'woocommerce_before_add_to_cart_button'.
	 */
	do_action( 'woocommerce_composited_product_add_to_cart', $product, $component_id, $composite_product );

	?><div class="single_variation_wrap component_wrap"><?php

		/**
		 * 'woocommerce_composited_single_variation' hook.
		 *
		 * Used to output the cart button and placeholder for variation data.
		 *
		 * @since 3.4.0
		 *
		 * @hooked wc_cp_composited_single_variation          - 10
		 * @hooked wc_cp_composited_single_variation_template - 20
		 */
		do_action( 'woocommerce_composited_single_variation', $product, $component_id, $composite_product );

	?></div>
</div>
