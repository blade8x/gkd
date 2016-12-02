<?php
/*
 * Plugin Name: Woo Product Excel Importer
 * Plugin URI: http://webdeveloping.gr/en/projects/woo-product-excel-importer
 * Description: Import/Update Simple products for Woocommerce
 * Version: 1.0
 * Author: tazbambu
 * Author URI: http://webdeveloping.gr
 * License: GPL2
 * Created On: 10-05-2016
 * Updated On: 12-05-2016
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function woopei_js(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
			
    wp_enqueue_script( 'custom_js', plugins_url( '/js/myjs.js', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-droppable') , null, true);	
	wp_enqueue_script( 'custom_js');
    $woopeiUrl = array( 'plugin_url' => plugins_url( '', __FILE__ ) );
    wp_localize_script( 'custom_js', 'url', $woopeiUrl );
}
add_action('admin_enqueue_scripts', 'woopei_js');

include( plugin_dir_path(__FILE__) .'/options.php');

//ADD MENU LINK AND PAGE FOR WOO PRODUCT IMPORTER
add_action('admin_menu', 'woopei_menu');

function woopei_menu() {
	add_menu_page('Woo Product Importer Settings', 'Stock Importer', 'administrator', 'woo-product-importer', 'woopei_form', 'dashicons-upload','100');
}


//ADD ACTION LINKS
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_woopei_links' );

function add_woopei_links ( $links ) {
 $links[] =  '<a href="' . admin_url( 'admin.php?page=woo-product-importer' ) . '">Settings</a>';
 $links[] = '<a href="http://webdeveloping.gr" target="_blank">More plugins by Bambu</a>';
   return $links;
}

//MAIN FORM FOR EXCEL UPLOAD
function woopei_form() {
	?>
	<div class="wrap">
	
	<h2><img src='<?php echo plugins_url( 'images/excel-icon.jpg', __FILE__ ); ?>'style='width:100px;height:100px;'  /><?php _e('STOCK IMPORTER', 'woo_product_importer'); ?></h2>
	
	<form method="post" id='woo_importer' enctype="multipart/form-data" action= "<?php echo admin_url( 'admin.php?page=woo-product-importer' ); ?>">
		
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e( 'EXCEL FILE', 'woo_product_importer' ) ?></th>
			<td><?php wp_nonce_field('excel_upload'); ?></td>
			<td><input type="file"  required name="file" id='file'  /></td>
			</tr>
		</table>
		
		<?php submit_button('Upload','primary','upload'); ?>

	</form>
	
	<hr>
	
	
	
	</div>
	<?php  
	woopei_processData();
}
?>