<?php

defined( 'ABSPATH' ) || exit;

global $product;
global $wp;
?>
<div class="vp-woo-size-guide-modal-header">
	<h4>Mérettáblázat</h4>
</div>
<div class="vp-woo-size-guide-modal-content">
	<?php
	$table_data = esc_textarea($size_chart);
	$table_data = explode("\n", $table_data);
	?>
	<?php if($table_data): ?>
		<table>
			<thead>
				<tr>
					<th></th>
					<th>Szélesség</th>
					<th>Hossz</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($table_data as $size): ?>
					<tr>
						<?php $size_data = explode(',', $size); ?>
						<?php foreach ($size_data as $size_data): ?>
							<td><?php echo esc_html($size_data); ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>

	<?php echo apply_filters( 'the_content', wp_kses_post( $size_text ) ); ?>
</div>
