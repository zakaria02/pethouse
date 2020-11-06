<?php
/**
 * @cmsmasters_package 	Whiskers
 * @cmsmasters_version 	1.0.0
 */


/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="cmsmasters_tabs tabs_mode_tab cmsmasters_woo_tabs">
		<ul class="cmsmasters_tabs_list">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab cmsmasters_tabs_list_item">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<span><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="cmsmasters_tabs_wrap">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="entry-content cmsmasters_tab" id="tab-<?php echo esc_attr( $key ); ?>">
					<div class="cmsmasters_tab_inner">
						<?php call_user_func( $tab['callback'], $key, $tab ) ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>