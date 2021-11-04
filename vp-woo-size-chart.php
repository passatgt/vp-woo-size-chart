<?php
/*
Plugin Name: WooCommerce Mérettáblázat termékoldalon
Plugin URI: http://visztpeter.me
Author: Viszt Péter
Version: 1.0
*/

//Add product metabox
add_action( 'add_meta_boxes', function(){
	add_meta_box('vp_woo_size_guide', 'Mérettáblázat', 'vp_woo_size_guide_options', 'product', 'normal', 'low');
});

//Setup admin fields
function vp_woo_size_guide_options() {
	global $post;
	$product = wc_get_product($post->ID);
	if($product) {
		$size_guide_table = $product->get_meta('_size_guide_table');
		$size_guide_text = $product->get_meta('_size_guide_text');
		?>
		<div class="vp-woo-size-guide-field">
			<label><strong>Táblázat adatok</strong></label><br>
			<textarea name="size_guide_table" rows="5" cols="40"><?php echo esc_textarea($size_guide_table); ?></textarea>
			<div class="howto">
				Az alábbi formátumban add meg a méreteket: méret,szélesség,hossz. Például:<br>
				XL,80,60<br>
				XXL,100,80
			</div>
		</div>
		<hr>
		<div class="vp-woo-size-guide-field">
			<label><strong>Extra leírás</strong></label><br>
			<?php wp_editor( $size_guide_text, 'size_guide_text', array('media_buttons' => false, 'teeny' => true, 'quicktags' => false, 'textarea_rows' => 10)); ?>
		</div>
		<?php
	}
}

//Display size chart table on product page
add_action( 'woocommerce_after_single_product_summary', function(){
	global $product;
	$product_id = $product->get_id();
	if(get_post_meta($product_id, '_size_guide_table', true)) {
		$size_chart = get_post_meta($product_id, '_size_guide_table', true);
		$size_text = get_post_meta($product_id, '_size_guide_text', true);
		$template_base  = plugin_dir_path( __FILE__ ) . 'templates/';
		echo wc_get_template( 'single-product/size-chart.php', array('size_chart' => $size_chart, 'size_text' => $size_text), '', $template_base );
	}
}, 10);

//Save any custom field displayed in the metaboxes
add_action( 'woocommerce_admin_process_product_object', function($product){
	$size_guide_table = ! empty( $_REQUEST['size_guide_table'] ) ? wp_kses_post( $_REQUEST['size_guide_table'] ) : '';
	$size_guide_text = ! empty( $_REQUEST['size_guide_text'] ) ? wp_kses_post( $_REQUEST['size_guide_text'] ) : '';
	$product->update_meta_data( '_size_guide_table', $size_guide_table );
	$product->update_meta_data( '_size_guide_text', $size_guide_text );
	$product->save_meta_data();
});
