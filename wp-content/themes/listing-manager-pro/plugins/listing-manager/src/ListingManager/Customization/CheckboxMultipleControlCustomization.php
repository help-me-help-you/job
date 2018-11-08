<?php

class CheckboxMultipleControlCustomization extends WP_Customize_Control {
	public $type = 'checkbox-multiple';

	public static function sanitize( $values ) {
		$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
		return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : [];
	}

	public function enqueue() {
		wp_enqueue_script( 'listing-manager-customize-controls', plugins_url( '/listing-manager/assets/js/customize-controls.js' ), [ 'jquery' ] );
	}

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		wc_get_template( 'listing-manager/controls/checkbox-multiple.php', [
			'instance' => $this,
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}