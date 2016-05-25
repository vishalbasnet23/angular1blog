<?php

function vb_23_theme_setup() {
	add_theme_support( 'post-thumbnails' );
}
add_action('after_setup_theme', 'vb_23_theme_setup' );
function vb_23_prepare_rest_post( $data, $post, $request ) {
	$_data = $data->data;
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumbnail_full = wp_get_attachment_image_src( $thumbnail_id, 'full' );
	$thumbnail_thumb = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
	$thumbnail_medium = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
	$thumbnail_large = wp_get_attachment_image_src( $thumbnail_id, 'large' );
	$previous_post = get_previous_post();
	$next_post = get_next_post();
  $post_author = get_the_author();
  $avatar_url = get_avatar_url(get_the_author_meta('id'));
	if( ! empty($thumbnail_id) ) {
		$_data['featured_image_thumbnail_url'] = array('full'=>$thumbnail_full[0], 'thumbnail' => $thumbnail_thumb[0], 'medium' => $thumbnail_medium[0], 'large' => $thumbnail_large[0]  );
	} else {
		$_data['featured_image_thumbnail_url'] = null;
	}

	$post_metas = get_post_meta($post->ID);

	if( !empty($post_metas) ) {
		$_data['post_metas'] = $post_metas;
	} else {
		$_data['post_metas'] = null;
	}
  if( ! empty( $post_author ) ) {
    $_data['author_name'] = $post_author;
  }
  if( ! empty( $avatar_url ) ) {
    $_data['avatar_url'] = $avatar_url;
  }
  // unset($_data['categories']);
  $category_detail=get_the_category();
  $_data['categories_details'] = $category_detail;
	$_data['previous_post'] = $previous_post;
	$_data['next_post'] = $next_post;
	$data->data = $_data;
	return $data;
}
add_filter( 'rest_prepare_post', 'vb_23_prepare_rest_post', 10, 3 );

/*function vb_23_allow_meta_query( $valid_vars ) {

    $valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value' ) );
    return $valid_vars;
}
add_filter( 'rest_query_vars', 'vb_23_allow_meta_query' );*/

add_action( 'rest_api_init', 'vb_23_rest_api_customizer_fields');

function vb_23_rest_api_customizer_fields() {
	register_rest_route( 'customizer/v1', '/customizer-fields/', array(
		'methods' => 'GET',
		'callback' => 'get_beyond_the_bell_customizer_fields',
	) );
}

function get_beyond_the_bell_customizer_fields() {
	$current_active_theme = wp_get_theme();
	$current_active_theme_name = $current_active_theme->get('Name');
	$theme_mod = get_option( 'theme_mods_'.$current_active_theme_name.'theme' );
	return $theme_mod;
}


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vb_23_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'header_section', array(
				'title'       => __( 'Header Section', 'vb_23' ),
				'priority'    => 20,
				'description' => 'Modify Header Section'
		) );
	/*Upload Shirley Site Logo image*/
	$wp_customize->add_setting( 'site_logo', array(
			'default' => '',
			'transport'=>'postMessage',
			'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
			'label'    => __( 'Upload Site Logo', 'vb_23' ),
			'section'  => 'header_section',
			'settings' => 'site_logo' ,
	) ) );
	$wp_customize->add_setting('header_email_address', array(
		'default' => 'vishalbasnet23@gmail.com',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control('header_email_address', array(
		'label' => __( 'Email Address', 'vb_23' ),
		'section' => 'header_section',
		'settings' => 'header_email_address'
	));
	$wp_customize->add_setting('header_instagram_link', array(
		'default' => '@vishalbasnet23',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control('header_instagram_link', array(
		'label' => __( 'Instagram Link', 'vb_23' ),
		'section' => 'header_section',
		'settings' => 'header_instagram_link'
	));
	$wp_customize->add_setting('header_twitter_link', array(
		'default' => '@vishalbasnet23',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control('header_twitter_link', array(
		'label' => __( 'Twitter Link', 'vb_23' ),
		'section' => 'header_section',
		'settings' => 'header_twitter_link'
	));
	$wp_customize->add_setting('header_facebook_link', array(
		'default' => 'https://facebook.com/vishalbasnet23',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control('header_facebook_link', array(
		'label' => __( 'Facebook Link', 'vb_23' ),
		'section' => 'header_section',
		'settings' => 'header_facebook_link'
	));

	$wp_customize->add_section( 'footer_section', array(
				'title'       => __( 'Footer Section', 'vb_23' ),
				'priority'    => 60,
				'description' => 'Modify Footer Section'
	) );

	$wp_customize->add_setting('footer_copy_right', array(
		'default' => '<p>© Vishal Basnet. All Rights Reserved.</p>',
		'transport' => 'postMessage',
	) );
	$wp_customize->add_control('footer_copy_right', array(
		'label' => __( 'Footer Copy Right Text', 'vb_23' ),
		'section' => 'footer_section',
		'settings' => 'footer_copy_right'
	));
}
add_action( 'customize_register', 'vb_23_customize_register' );
