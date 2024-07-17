<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Simple_Rest_Form
 * @subpackage Simple_Rest_Form/admin/partials
 */

namespace SimpleRestForm;

?>
<style>
#business-search-form {
  display: flex;
}
button {
  padding-top: 12px;
  padding-bottom: 12px;
}
</style>
<h1>Business Info</h1>

<form id="business-search-form" method="post" action="">  
	<p>
	<input class="widefat" id="srf_search_key" name="search" type="text" placeholder="Search..."/>
	</p>
	<button type="button" id="srf-search">Search</button>
</form>

<table class="widefat">
	<thead>
	<tr>
		<th>
			<?php esc_html_e( 'Id', 'simple-rest-form' ); ?>
		</th>
		<th>
			<?php esc_html_e( 'Name', 'simple-rest-form' ); ?>
		</th>
		<th>
			<?php esc_html_e( 'Address', 'simple-rest-form' ); ?>
		</th>
		<th>
			<?php esc_html_e( 'Website', 'simple-rest-form' ); ?>
		</th>
		<th>
			<?php esc_html_e( 'Register Date', 'simple-rest-form' ); ?>
		</th>
	</tr>
</thead>
<tbody id="the-list">
	<?php
		/**
		 * Fetching the data from database without restapi.
		 */
		$db    = new DB();
		$items = $db->table_results( $attributes['search'] );

		// implementing loop to fetch data.
	foreach ( $items as $item ) {
		?>
	<tr>
		<td>
		<?php echo absint( $item->id ); ?>
		</td>
		<td>
		<?php echo esc_html( $item->business_name ); ?>
		</td>
		<td>
		<?php echo esc_html( $item->business_address ); ?>
		</td>
		<td>
		<?php echo esc_url( $item->website_url ); ?>
		</td>
		<td>
		<?php echo esc_html( $item->time ); ?>
		</td>
	</tr>
	<?php } ?>
</tbody>
</table>
