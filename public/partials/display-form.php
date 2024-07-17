<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/public/partials
 */

?>
<style>
label{
	display:block;
}
input{
	width: 100%;
}
button{
	margin-top: 15px;
}
</style>

<?php

/**
 * Assigning title value from shortcode attribute.
 */
	$title = ! empty( $attributes['title'] ) ? esc_html( $attributes['title'] ) : __( 'Business Name', 'simple-rest-form' );
	printf( '<h2>%s</h2>', esc_html( $title ) );
?>

<form id="business-form" method="post" action="">  
	<p>
	<label for="business_name"><?php esc_html_e( 'Business Name', 'simple-rest-form' ); ?></label> 
	<input class="widefat" id="business-name" name="business_name" type="text" required/>
	</p>
	<p>
	<label for="business_address"><?php esc_html_e( 'Business Address', 'simple-rest-form' ); ?></label> 
	<input class="widefat" id="business-address" name="business_address" type="text" required/>
	</p>
	<p>
	<label for="business_url"><?php esc_html_e( 'Business Website', 'simple-rest-form' ); ?></label> 
	<input class="widefat" id="business-url" name="business_url" type="text"/>
	</p>  
	<button type="submit">Submit</button>
</form>