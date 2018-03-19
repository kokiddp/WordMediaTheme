<?php

class WMT_Builder_Module_WM_Offers extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'WordMedia Offers', 'wordmedia' );
		$this->slug       = 'et_pb_wm_offers';
		$this->fb_support = true;
		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->main_css_element = '%%order_class%%.et_pb_wm_offers';
		$this->advanced_options = array(
			'fonts' => array(
				'text' => array(
					'label'    => esc_html__( 'Text', 'wordmedia' ),
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
				),
			),
			'background' => array(
				'use_background_color' => false,
			),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
		);
		$this->custom_css_options = array();
	}
	function get_fields() {

		$fields = array(
			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'wordmedia' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'wordmedia' ),
					'tablet'  => esc_html__( 'Tablet', 'wordmedia' ),
					'desktop' => esc_html__( 'Desktop', 'wordmedia' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'wordmedia' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'wordmedia' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'wordmedia' ),
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'wordmedia' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'wordmedia' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);
		return $fields;
	}
	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$module_id = '' !== $module_id ? sprintf( ' id="%s"', esc_attr( $module_id ) ) : '';
		$module_class = '' !== $module_class ? sprintf( ' %s', esc_attr( $module_class ) ) : '';

		ob_start();
		echo do_shortcode('[wordmedia_offer_slider]');
		$content = ob_get_contents();
		ob_end_clean();

		$output = sprintf(
			'<div%1$s class="et_pb_module et_pb_wm_offers%2$s">
				%3$s
			</div>',
			$module_id,
			$module_class,
			$content
		);
		return $output;
	}
}
new WMT_Builder_Module_WM_Offers;