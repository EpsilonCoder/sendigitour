<?php
/**
 * PA WooCommerce Products - Sale Flash.
 *
 * @package PA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

global $post, $product;

$product_type = $product->get_type();

$sale_string = __( 'Sale!', 'premium-addons-for-elementor' );

if ( 'custom' === $this->get_option_value( 'sale_type' ) ) {

	$original_price = 'variable' === $product_type ? $product->get_variation_regular_price() : $product->get_regular_price();

	$sale_price = 'variable' === $product_type ? $product->get_variation_sale_price() : $product->get_sale_price();

	if ( $sale_price ) {
		$sale_string  = $this->get_option_value( 'sale_string' );
		$percent_sale = round( ( ( ( $original_price - $sale_price ) / $original_price ) * 100 ), 0 );
		$sale_string  = $sale_string ? $sale_string : '-[value]%';
		$sale_string  = str_replace( '[value]', $percent_sale, $sale_string );
	}
};


?>
<?php if ( $product->is_on_sale() ) : ?>
	<div class="premium-woo-product-sale-wrap">
		<span class="premium-woo-product-onsale"><?php echo esc_html( $sale_string ); ?> </span>
	</div>
	<?php
endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
