<?php
if (!defined('ABSPATH')) die();

//ENQUEUE SCRIPTS AND STYLES
function wmt_enqueue_style() {
	wp_enqueue_style( 'wmt-style', get_template_directory_uri() . '/style.css' );
}
function wmt_enqueue_js() {
	wp_enqueue_script( 'wmt-script', get_stylesheet_directory_uri() . '/scripts.js', array( 'jquery' ) );
}

//REMOVE PROJECT POST TYPE
function wmt_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}

//INJECT INFO IN JS
function wmt_inject_js() {
    global $post;
    $user = wp_get_current_user();

    if ( isset( $post ) && $post != null ) {
    	wp_localize_script('wmt-script', 'wmt_script_vars', array(
	            'postID' => $post->ID,
	            'postType' => $post->post_type,
				'postAuthor' => $post->post_author,
				'postName' => $post->post_name,
				'postTitle' => $post->post_title,
				'postDateGMT' => strtotime( $post->post_date_gmt ),
				'postContent' => $post->post_content,
				'postExcerpt' => $post->post_excerpt,
				'postStatus' => $post->post_status,
				'postCommentStatus' => $post->comment_status,
				'postPingStatus' => $post->ping_status,
				'postPassword' => $post->post_password,
				'postParent' => $post->post_parent,
				'postModifiedGMT' => strtotime( $post->post_modified_gmt ),
				'postCommentCount' => $post->comment_count,
				'postMenuOrder' => $post->menu_order,
				'userID' => $user->ID,
				'userCaps' => $user->caps,
				'userCapKey' => $user->cap_key,
				'userRoles' => $user->roles,
				'userAllCaps' => $user->allcaps,
				'userFirstName' => $user->first_name,
				'userLastName' => $user->last_name
	        )
	    );
    }    
}


//OVERRIDE AND ADD MODULES
function divi_child_theme_setup() {

    if( class_exists( "ET_Builder_Module" ) ) {
		//include( get_stylesheet_directory() . "/custom-modules/Blog.php" );

		include( get_stylesheet_directory() . "/custom-modules/WM_Video.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_Gallery.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_Evidence.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_CallToAction.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_SocialButtons.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_MenuBar.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_Map.php" );

		include( get_stylesheet_directory() . "/custom-modules/WM_FullwidthSlider.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_FullwidthHeadline.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_FullwidthMenuBar.php" );

		include( get_stylesheet_directory() . "/custom-modules/WM_Footer.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_SpecialOne.php" );
		include( get_stylesheet_directory() . "/custom-modules/WM_Offers.php" );
	}

    //$blog = new WMT_Builder_Module_Blog();
    //remove_shortcode( 'et_pb_blog' );
    //add_shortcode( $blog->slug, array($blog, '_shortcode_callback') );

    $wm_video = new WMT_Builder_Module_WM_Video();
    add_shortcode( $wm_video->slug, array($wm_video, '_shortcode_callback') );
    $wm_gallery = new WMT_Builder_Module_WM_Gallery();
    add_shortcode( $wm_gallery->slug, array($wm_gallery, '_shortcode_callback') );
    $wm_evidence = new WMT_Builder_Module_WM_Evidence();
    add_shortcode( $wm_evidence->slug, array($wm_evidence, '_shortcode_callback') );
    $wm_calltoaction = new WMT_Builder_Module_WM_CallToAction();
    add_shortcode( $wm_calltoaction->slug, array($wm_calltoaction, '_shortcode_callback') );
    $wm_socialbuttons = new WMT_Builder_Module_WM_SocialButtons();
    add_shortcode( $wm_socialbuttons->slug, array($wm_socialbuttons, '_shortcode_callback') );
    $wm_menubar = new WMT_Builder_Module_WM_MenuBar();
    add_shortcode( $wm_menubar->slug, array($wm_menubar, '_shortcode_callback') );
    $wm_map = new WMT_Builder_Module_WM_Map();
    add_shortcode( $wm_map->slug, array($wm_map, '_shortcode_callback') );

    $wm_fw_slider = new WMT_Builder_Module_WM_Fullwidth_Slider();
    add_shortcode( $wm_fw_slider->slug, array($wm_fw_slider, '_shortcode_callback') );
    $wm_fw_headline = new WMT_Builder_Module_WM_Fullwidth_Headline();
    add_shortcode( $wm_fw_headline->slug, array($wm_fw_headline, '_shortcode_callback') );
    $wm_fw_menubar = new WMT_Builder_Module_WM_Fullwidth_MenuBar();
    add_shortcode( $wm_fw_menubar->slug, array($wm_fw_menubar, '_shortcode_callback') );

    $wm_footer = new WMT_Builder_Module_WM_Footer();
    add_shortcode( $wm_footer->slug, array($wm_footer, '_shortcode_callback') );
    $wm_specialone = new WMT_Builder_Module_WM_SpecialOne();
    add_shortcode( $wm_specialone->slug, array($wm_specialone, '_shortcode_callback') );
    $wm_offers = new WMT_Builder_Module_WM_Offers();
    add_shortcode( $wm_offers->slug, array($wm_offers, '_shortcode_callback') );
}


// ACTIONS
add_action( 'wp_enqueue_scripts', 'wmt_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'wmt_enqueue_js' );
add_action( 'wp_enqueue_scripts', 'wmt_inject_js' );
add_action( 'et_builder_ready', 'divi_child_theme_setup' );
// FILTERS
add_filter( 'et_project_posttype_args', 'wmt_et_project_posttype_args', 10, 1 );

?>
