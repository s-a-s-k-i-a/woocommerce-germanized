<?php
/**
 * WooCommerce Payment Gateways class
 *
 * Loads hooks for payment gateways
 *
 * @class 		WC_GZD_Payment_Gateways
 * @category	Class
 * @author 		vendidero
 */
class WC_GZD_Payment_Gateways {

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_fields' ) );
		add_action( 'woocommerce_calculate_totals', array( $this, 'checkout' ) );
		add_action( 'woocommerce_cart_calculate_fees', array( $this, 'init_fee' ), 0 );
	}

	/**
	 * Set default order button text instead of the button text defined by each payment gateway.
	 * Can be overriden by setting force_order_button_text within payment gateway class
	 * Manipulate payment gateway description if has a fee and init gateway title filter
	 */
	public function checkout() {
		$gateways = WC()->payment_gateways->get_available_payment_gateways();
		foreach( $gateways as $gateway ) {
			if ( ! isset( $gateway->force_order_button_text ) || ! $gateway->force_order_button_text )
				$gateway->order_button_text = __( get_option( 'woocommerce_gzd_order_submit_btn_text' ), 'woocommerce-germanized' );
			if ( $gateway->get_option( 'fee' ) ) {
				add_filter( 'woocommerce_gateway_title', array( $this, 'set_title' ), 0, 2 );
				$gateway->description .= ' ' . sprintf( __( 'Plus %s payment charge.', 'woocommerce-germanized' ), wc_price( $gateway->get_option( 'fee' ) ) );
			}
		}
	}

	/**
	 * Manipualte payment gateway title
	 *  
	 * @param string $title 
	 * @param string $id    gateway id
	 */
	public function set_title( $title, $id ) {
		$gateways = WC()->payment_gateways->get_available_payment_gateways();
		foreach ( $gateways as $gateway ) {
			if ( $gateway->id != $id )
				continue;
			$title = $gateway->title;
			if ( $gateway->get_option( 'fee' ) && ( is_checkout() || ( defined( 'DOING_AJAX' ) && isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'woocommerce_update_order_review' ) ) )
				$title = $title . ' <span class="small">(' . sprintf( __( 'plus %s payment charge', 'woocommerce-germanized' ), wc_price( $gateway->get_option( 'fee' ) ) ) . ')</span>';
			return $title;
		}
	}

	/**
	 * Dynamically set filter to show additional fields
	 */
	public function init_fields() {
		$gateways = WC()->payment_gateways->payment_gateways;
		if ( ! empty( $gateways ) ) {
			foreach ( $gateways as $key => $gateway ) {
				add_filter( 'woocommerce_settings_api_form_fields_' . $gateway->id, array( $this, "set_fields" ) );
			}
		}
	}

	/**
	 * Set additional payment gateway admin fields
	 *  
	 * @param array $fields 
	 */
	public function set_fields( $fields ) {
		$fields[ 'fee' ] = array(
			'title'       => __( 'Fee', 'woocommerce-germanized' ),
			'type'        => 'decimal',
			'description' => __( 'This fee is being added if customer selects payment method within checkout.', 'woocommerce-germanized' ),
			'default'     => 0,
			'desc_tip'    => true,
		);
		$fields[ 'fee_is_taxable' ] = array(
			'title'       => __( 'Fee is taxable?', 'woocommerce-germanized' ),
			'type'        => 'checkbox',
			'label' 	  => __( 'Check if fee is taxable.', 'woocommerce-germanized' ),
			'default'     => 'no',
		);
		return $fields;
	}

	/**
	 * Update fee for cart if feeable gateway has been selected as payment method
	 */
	public function init_fee() {
		$gateways = WC()->payment_gateways()->get_available_payment_gateways();
		if ( ! ( $key = WC()->session->get('chosen_payment_method') ) || ! isset( $gateways[ $key ] ) )
			return;
		$gateway = $gateways[ $key ];
		if ( $gateway->get_option( 'fee' ) )
			$this->set_fee( $gateway );
	}

	/**
	 * Sets fee for a specific gateway
	 *  
	 * @param object $gateway 
	 */
	public function set_fee( $gateway ) {
		$is_taxable = ( $gateway->get_option( 'fee_is_taxable', 'no' ) == 'no' ? false : true );
		$fee = $gateway->get_option( 'fee' );
		if ( $is_taxable ) {
			$tax_rates = WC_Tax::get_rates();
			$fee_taxes = WC_Tax::calc_tax( $fee, $tax_rates, true );
			$fee = $fee - array_sum( $fee_taxes );
		}
		WC()->cart->add_fee( __( 'Payment charge', 'woocommerce-germanized' ), $fee, $is_taxable );
	}

}

return WC_GZD_Payment_Gateways::instance();
