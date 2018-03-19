<?php

class WMT_Builder_Module_WM_MenuBar extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'WordMedia MenuBar', 'wordmedia' );
		$this->slug       = 'et_pb_wm_menubar';
		$this->fb_support = true;
		$this->whitelisted_fields = array(
			'id',
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->main_css_element = '%%order_class%%.et_pb_wm_menubar';
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

		$menubars = array();

		$query = new WP_Query(array(
		    'post_type' => 'menubar',
		    'post_status' => 'publish',
		    'posts_per_page' => -1,
		    'orderby' => 'DESC',
		));
		while ($query->have_posts()) {
		    $query->the_post();
		    $post_id = get_the_ID();
		    $menubars[$post_id] = get_the_title($post_id);
		}
		wp_reset_query();

		$fields = array(
			'id' => array(
				'label'           => esc_html__( 'WordMedia MenuBar', 'wordmedia' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => $menubars,
				'description'     => esc_html__( 'Pick the menubar', 'wordmedia' ),
				'is_fb_content'   => true,
			),
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
		$id                   = $this->shortcode_atts['id'];
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$module_id = '' !== $module_id ? sprintf( ' id="%s"', esc_attr( $module_id ) ) : '';
		$module_class = '' !== $module_class ? sprintf( ' %s', esc_attr( $module_class ) ) : '';

		ob_start();
		echo do_shortcode('[wordmedia_menubar id="' . $id . '"]');
		$content = ob_get_contents();
		ob_end_clean();

		$output = sprintf(
			'<div%1$s class="et_pb_module et_pb_wm_menubar%2$s">
				%3$s
			</div>',
			$module_id,
			$module_class,
			$content
		);
		return $output;
	}
}
new WMT_Builder_Module_WM_MenuBar;