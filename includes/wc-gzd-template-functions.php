<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Template functions
 *
 * @author 		Vendidero
 * @version     1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'woocommerce_gzd_template_single_legal_info' ) ) {

	/**
	 * Single Product price per unit.
	 */
	function woocommerce_gzd_template_single_legal_info() {
		global $product;
		wc_get_template( 'single-product/legal-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_single_price_unit' ) ) {

	/**
	 * Single Product price per unit.
	 */
	function woocommerce_gzd_template_single_price_unit() {
		global $product;
		if ( in_array( $product->product_type, array( 'simple', 'external' ) ) )
			wc_get_template( 'single-product/price-unit.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_single_shipping_costs_info' ) ) {

	/**
	 * Single Product Shipping costs info
	 */
	function woocommerce_gzd_template_single_shipping_costs_info() {
		wc_get_template( 'single-product/shipping-costs-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_single_delivery_time_info' ) ) {

	/**
	 * Single Product delivery time info
	 */
	function woocommerce_gzd_template_single_delivery_time_info() {
		wc_get_template( 'single-product/delivery-time-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_single_small_business_info' ) ) {

	/**
	 * Single Product small business info
	 */
	function woocommerce_gzd_template_single_small_business_info() {
		wc_get_template( 'single-product/small-business-info.php' );
	}
} 

if ( ! function_exists( 'woocommerce_gzd_template_small_business_info' ) ) {

	/**
	 * small business info
	 */
	function woocommerce_gzd_template_small_business_info() {
		wc_get_template( 'global/small-business-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_checkout_small_business_info' ) ) {

	/**
	 * small business info within checkout
	 */
	function woocommerce_gzd_template_checkout_small_business_info() {
		echo '<tr class="order-total"><td colspan="2">';
		wc_get_template( 'global/small-business-info.php' );
		echo '</td></tr>';
	}
} 

if ( ! function_exists( 'woocommerce_gzd_template_footer_vat_info' ) ) {

	/**
	 * footer vat info
	 */
	function woocommerce_gzd_template_footer_vat_info() {
		wc_get_template( 'footer/vat-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_footer_sale_info' ) ) {

	/**
	 * footer sale info
	 */
	function woocommerce_gzd_template_footer_sale_info() {
		wc_get_template( 'footer/sale-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_cart_product_delivery_time' ) ) {

	/**
	 * Delivery time within cart
	 */
	function woocommerce_gzd_template_cart_product_delivery_time( $title, $cart_item, $cart_item_key ) {
		if ( isset($cart_item["data"]) ) {
			$product = $cart_item["data"];
			if ( $product->get_delivery_time_term() )
				$title .= '<p class="price-shipping-costs-info">' . $product->get_delivery_time_html() . '</p>';
		}
		return $title;
	}
}

if ( ! function_exists( 'woocommerce_gzd_template_checkout_back_to_cart' ) ) {

	/**
	 * Display back to cart button within checkout cart
	 */
	function woocommerce_gzd_template_checkout_back_to_cart() {
		echo '<tr><td colspan="5" class="actions"><a class="button" href="' . WC()->cart->get_cart_url() . '">' . __( 'Edit Order', 'woocommerce-germanized' ) . '</a></td></tr>';
	}

}

if ( ! function_exists( 'woocommerce_gzd_template_checkout_payment_title' ) ) {

	/**
	 * Checkout payment gateway title
	 */
	function woocommerce_gzd_template_checkout_payment_title() {
		echo '<h3 id="order_payment_heading">' . __( 'Choose a Payment Gateway', 'woocommerce-germanized' ) . '</h3>';
	}

}

if ( ! function_exists( 'woocommerce_gzd_template_checkout_legal' ) ) {

	/**
	 * text legal info within checkout (may contain checkbox)
	 */
	function woocommerce_gzd_template_checkout_legal() {
		echo '<p class="form-row legal terms">' . ( get_option( 'woocommerce_gzd_display_checkout_legal_no_checkbox' ) == 'no' ? '<input type="checkbox" class="input-checkbox" name="legal" id="legal" />' : '' ) . ' <label class="checkbox" for="terms">' . wc_gzd_get_legal_text() . '</label></p>';
	}

}

if ( ! function_exists( 'woocommerce_gzd_checkout_validation' ) ) {

	/**
	 * Validate checkbox data
	 */
	function woocommerce_gzd_checkout_validation( $posted ) {
		if ( ! isset( $_POST['woocommerce_checkout_update_totals'] ) && ! isset( $_POST['legal'] ) && get_option( 'woocommerce_gzd_display_checkout_legal_no_checkbox' ) == 'no' )
			wc_add_notice( wc_gzd_get_legal_text_error(), 'error' );
	}

}

if ( ! function_exists( 'woocommerce_gzd_remove_term_checkbox' ) ) {

	/**
	 * Removes default term checkbox
	 */
	function woocommerce_gzd_remove_term_checkbox() {
		return false;
	}

}

if ( ! function_exists( 'woocommerce_gzd_template_checkout_set_terms_manually' ) ) {

	/**
	 * Set terms checkbox manually
	 */
	function woocommerce_gzd_template_checkout_set_terms_manually() {
		echo '<input type="hidden" name="terms" value="1" />';
	}

}

if ( ! function_exists( 'woocommerce_gzd_template_order_button_text' ) ) {

	/**
	 * Manipulate the order submit button text
	 */
	function woocommerce_gzd_template_order_button_text( $text ) {
		return __( get_option( 'woocommerce_gzd_order_submit_btn_text' ), 'woocommerce-germanized' );
	}

}

if ( ! function_exists( 'woocommerce_gzd_template_checkout_thankyou_trusted_shops' ) ) {

	/**
	 * Add Trusted Shops template to order success
	 */
	function woocommerce_gzd_template_checkout_thankyou_trusted_shops( $order_id ) {
		wc_get_template( 'trusted-shops/thankyou.php', array( 'order_id' => $order_id ) );
	}

}

/**
 * Overwrite variable add to cart function
 */
function woocommerce_variable_add_to_cart() {
	global $product;
	
	$assets_path          = str_replace( array( 'http:', 'https:' ), '', WC_germanized()->plugin_url() ) . '/assets/';
	$frontend_script_path = $assets_path . 'js/';

	// Enqueue variation scripts
	wp_enqueue_script( 'wc-add-to-cart-variation' );
	wp_enqueue_script( 'wc-gzd-add-to-cart-variation', $frontend_script_path . 'add-to-cart-variation.js', array( 'jquery', 'woocommerce' ), WC_GERMANIZED_VERSION, true );

	// Load the template
	wc_get_template( 'single-product/add-to-cart/variable.php', array(
		'available_variations'  => $product->get_available_variations(),
		'attributes'   			=> $product->get_variation_attributes(),
		'selected_attributes' 	=> $product->get_variation_default_attributes()
	) );
}

if ( ! function_exists( 'woocommerce_gzd_add_variation_options' ) ) {

	/**
	 * Add delivery time and unit price to variations
	 */
	function woocommerce_gzd_add_variation_options( $options, $product, $variation ) {
		$options[ 'delivery_time' ] = $variation->get_delivery_time_html();
		$options[ 'unit_price' ] = $variation->get_unit_html();
		return $options;
	}

}

if ( ! function_exists( 'woocommerce_gzd_template_order_success_text' ) ) {

	function woocommerce_gzd_template_order_success_text( $text ) {
		return ( get_option( 'woocommerce_gzd_order_success_text' ) ? get_option( 'woocommerce_gzd_order_success_text' ) : $text );
	}

}

?>