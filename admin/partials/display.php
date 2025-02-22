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

<h1>Business Info</h1>
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

		/**
		 * The line `db = new DB()` is attempting to create a new instance of the `DB` class. This suggests
		 * that there is a class named `DB` being used in the code. The `DB` class likely contains methods
		 * for interacting with a database, such as fetching data from a table.
		 */
		$db    = new DB();
		$items = $db->table_results();

		// implementin loop to fetch data.
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
