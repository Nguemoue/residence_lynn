<?php
/**
 * VW Construction Estate Theme Customizer
 *
 * @package VW Construction Estate
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_construction_estate_custom_controls() {

    load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_construction_estate_custom_controls' );

function vw_construction_estate_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial( 'blogname', array( 
        'selector' => '.logo .site-title a', 
        'render_callback' => 'vw_construction_estate_customize_partial_blogname', 
    )); 

    $wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
        'selector' => 'p.site-description', 
        'render_callback' => 'vw_construction_estate_customize_partial_blogdescription', 
    ));

    //add home page setting pannel
	$VWConstructionEstateParentPanel = new VW_Construction_Estate_WP_Customize_Panel( $wp_customize, 'vw_construction_estate_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'VW Settings', 'vw-construction-estate' ),
		'priority' => 10,
	));

	$wp_customize->add_panel( $VWConstructionEstateParentPanel );

	$HomePageParentPanel = new VW_Construction_Estate_WP_Customize_Panel( $wp_customize, 'vw_construction_estate_homepage_panel', array(
		'title' => __( 'Homepage Settings', 'vw-construction-estate' ),
		'panel' => 'vw_construction_estate_panel_id',
	));

	$wp_customize->add_panel( $HomePageParentPanel );

	//Top Bar
	$wp_customize->add_section('vw_construction_estate_contact',array(
		'title'	=> __('Contact Us','vw-construction-estate'),
		'description'	=> __('Add contact us here','vw-construction-estate'),
		'priority'	=> 10,
		'panel' => 'vw_construction_estate_homepage_panel',
	));

   	// Header Background color
	$wp_customize->add_setting('vw_construction_estate_header_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_header_background_color', array(
		'label'    => __('Header Background Color', 'vw-construction-estate'),
		'section'  => 'header_image',
	)));

	$wp_customize->add_setting('vw_construction_estate_header_img_position',array(
	  'default' => 'center top',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_header_img_position',array(
		'type' => 'select',
		'label' => __('Header Image Position','vw-construction-estate'),
		'section' => 'header_image',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'vw-construction-estate' ),
			'center top'   => esc_html__( 'Top', 'vw-construction-estate' ),
			'right top'   => esc_html__( 'Top Right', 'vw-construction-estate' ),
			'left center'   => esc_html__( 'Left', 'vw-construction-estate' ),
			'center center'   => esc_html__( 'Center', 'vw-construction-estate' ),
			'right center'   => esc_html__( 'Right', 'vw-construction-estate' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'vw-construction-estate' ),
			'center bottom'   => esc_html__( 'Bottom', 'vw-construction-estate' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'vw-construction-estate' ),
		),
	));

	$wp_customize->add_setting( 'vw_construction_estate_topbar_hide_show',
       array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_topbar_hide_show',
       array(
      'label' => esc_html__( 'Show / Hide Topbar','vw-construction-estate' ),
      'section' => 'vw_construction_estate_contact'
    )));

    $wp_customize->add_setting('vw_construction_estate_topbar_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_topbar_padding_top_bottom',array(
		'label'	=> __('Topbar Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_contact',
		'type'=> 'text'
	));

    //Sticky Header
	$wp_customize->add_setting( 'vw_construction_estate_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_sticky_header',array(
        'label' => esc_html__( 'Sticky Header','vw-construction-estate' ),
        'section' => 'vw_construction_estate_contact'
    )));

    $wp_customize->add_setting('vw_construction_estate_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_contact',
		'type'=> 'text'
	));

    $wp_customize->add_setting( 'vw_construction_estate_search_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_search_hide_show',array(
		'label' => esc_html__( 'Show / Hide Search','vw-construction-estate' ),
		'section' => 'vw_construction_estate_contact'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_location', array(
    	'selector' => 'p.diff-lay', 
		'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_location', 
    ));

    $wp_customize->add_setting('vw_construction_estate_location_icon',array(
		'default'	=> 'fas fa-map-marker-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_location_icon',array(
		'label'	=> __('Add Location Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_contact',
		'setting'	=> 'vw_construction_estate_location_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_location',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_location',array(
		'label'	=> __('Location','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_location1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_location1',array(
		'label'	=> __('Other Location','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_phone_icon',array(
		'default'	=> 'fas fa-tty',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_phone_icon',array(
		'label'	=> __('Add Phone Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_contact',
		'setting'	=> 'vw_construction_estate_phone_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_call',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_call',array(
		'label'	=> __('Phone Text','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_call1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_phone_number'
	));
	
	$wp_customize->add_control('vw_construction_estate_call1',array(
		'label'	=> __('Phone Number','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_email_icon',array(
		'default'	=> 'far fa-envelope-open',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_email_icon',array(
		'label'	=> __('Add Email Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_contact',
		'setting'	=> 'vw_construction_estate_email_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_mail',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_mail',array(
		'label'	=> __('Email Text','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_mail1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	
	$wp_customize->add_control('vw_construction_estate_mail1',array(
		'label'	=> __('Mail Address','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_contact_icon',array(
		'default'	=> 'far fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_contact_icon',array(
		'label'	=> __('Add Contact Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_contact',
		'setting'	=> 'vw_construction_estate_contact_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_time',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_time',array(
		'label'	=> __('Contact Text','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_time1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_time1',array(
		'label'	=> __('Working Time','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_contact',
		'type'		=> 'text'
	));

	//Menus Settings
	$wp_customize->add_section( 'vw_construction_estate_menu_section' , array(
    	'title' => __( 'Menus Settings', 'vw-construction-estate' ),
		'panel' => 'vw_construction_estate_homepage_panel',
		'priority'	=> 10,
	) );

	$wp_customize->add_setting('vw_construction_estate_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_menu_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_navigation_menu_font_weight',array(
        'default' => 700,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','vw-construction-estate'),
        'section' => 'vw_construction_estate_menu_section',
        'choices' => array(
        	'100' => __('100','vw-construction-estate'),
            '200' => __('200','vw-construction-estate'),
            '300' => __('300','vw-construction-estate'),
            '400' => __('400','vw-construction-estate'),
            '500' => __('500','vw-construction-estate'),
            '600' => __('600','vw-construction-estate'),
            '700' => __('700','vw-construction-estate'),
            '800' => __('800','vw-construction-estate'),
            '900' => __('900','vw-construction-estate'),
        ),
	) );

	// text trasform
	$wp_customize->add_setting('vw_construction_estate_menu_text_transform',array(
		'default'=> 'Uppercase',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_menu_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Menus Text Transform','vw-construction-estate'),
		'choices' => array(
            'Uppercase' => __('Uppercase','vw-construction-estate'),
            'Capitalize' => __('Capitalize','vw-construction-estate'),
            'Lowercase' => __('Lowercase','vw-construction-estate'),
        ),
		'section'=> 'vw_construction_estate_menu_section',
	));

	$wp_customize->add_setting('vw_construction_estate_menus_item_style',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_menus_item_style',array(
        'type' => 'select',
        'section' => 'vw_construction_estate_menu_section',
		'label' => __('Menus Item Hover Style','vw-construction-estate'),
		'choices' => array(
            'None' => __('None','vw-construction-estate'),
            'Zoom In' => __('Zoom In','vw-construction-estate'),
        ),
	) );

	$wp_customize->add_setting('vw_construction_estate_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_header_menus_color', array(
		'label'    => __('Menus Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_menu_section',
	)));

	$wp_customize->add_setting('vw_construction_estate_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_menu_section',
	)));

	$wp_customize->add_setting('vw_construction_estate_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_menu_section',
	)));

	$wp_customize->add_setting('vw_construction_estate_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_menu_section',
	)));

	//Social links
	$wp_customize->add_section(
		'vw_construction_estate_social_links', array(
		'title'		=>	__('Social Links', 'vw-construction-estate'),
		'priority'	=> 10,
		'panel'		=>	'vw_construction_estate_homepage_panel'
		)
	);

	$wp_customize->add_setting('vw_construction_estate_social_icons',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_social_icons',array(
		'label' =>  __('Steps to setup social icons','vw-construction-estate'),
		'description' => __('<p>1. Go to Dashboard >> Appearance >> Widgets</p>
			<p>2. Add Vw Social Icon Widget in Social Icon Widget area.</p>
			<p>3. Add social icons url and save.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_social_links',
		'type'=> 'hidden'
	));
	$wp_customize->add_setting('vw_construction_estate_social_icon_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_social_icon_btn',array(
		'description' => "<a target='_blank' href='". admin_url('widgets.php') ." '>Setup Social Icons</a>",
		'section'=> 'vw_construction_estate_social_links',
		'type'=>'hidden'
	));

	//home page slider
    $wp_customize->add_section( 'vw_construction_estate_slidersettings' , array(
      	'title'      => __( 'Slider Settings', 'vw-construction-estate' ),
    	'description' => "Free theme has 3 slides options, For unlimited slides and more options </br> <a class='go-pro-btn' target='_blank' href='". esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO) ." '>GET PRO</a>",
      	'priority'   => null,
      	'panel' => 'vw_construction_estate_homepage_panel'
    ) );

    $wp_customize->add_setting( 'vw_construction_estate_slider_hide_show',
       array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_slider_hide_show',
       array(
      'label' => esc_html__( 'Show / Hide Slider','vw-construction-estate' ),
      'section' => 'vw_construction_estate_slidersettings'
    )));

    $wp_customize->add_setting('vw_construction_estate_slider_type',array(
        'default' => 'Default slider',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	) );
	$wp_customize->add_control('vw_construction_estate_slider_type', array(
        'type' => 'select',
        'label' => __('Slider Type','vw-construction-estate'),
        'section' => 'vw_construction_estate_slidersettings',
        'choices' => array(
            'Default slider' => __('Default slider','vw-construction-estate'),
            'Advance slider' => __('Advance slider','vw-construction-estate'),
        ),
	));

	$wp_customize->add_setting('vw_construction_estate_advance_slider_shortcode',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_advance_slider_shortcode',array(
		'label'	=> __('Add Slider Shortcode','vw-construction-estate'),
		'section'=> 'vw_construction_estate_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_construction_estate_advance_slider'
	));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_slider_hide_show',array(
        'selector'        => '.slider .inner_carousel h1',
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_slider_hide_show',
    ));

    for ( $count = 1; $count <= 3; $count++ ) {
	    // Add color scheme setting and control.
	    $wp_customize->add_setting( 'vw_construction_estate_slider_page' . $count, array(
	      'default'           => '',
	      'sanitize_callback' => 'vw_construction_estate_sanitize_dropdown_pages'
	    ) );
	    $wp_customize->add_control( 'vw_construction_estate_slider_page' . $count, array(
	      'label'    => __( 'Select Slide Image Page', 'vw-construction-estate' ),
	      'description' => __( 'Slider image size (1500 x 765)', 'vw-construction-estate' ),
	      'section'  => 'vw_construction_estate_slidersettings',
	      'type'     => 'dropdown-pages',
	      'active_callback' => 'vw_construction_estate_default_slider'
	    ) );
    }

	$wp_customize->add_setting('vw_construction_estate_banner_button_label',array(
		'default' => 'DISCOVER MORE',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_banner_button_label',array(
		'label' => __('Button','vw-construction-estate'),
		'section' => 'vw_construction_estate_slidersettings',
		'setting' => 'vw_construction_estate_banner_button_label',
		'type' => 'text',
		'active_callback' => 'vw_construction_estate_default_slider'
	));

	$wp_customize->add_setting('vw_construction_estate_top_button_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('vw_construction_estate_top_button_url',array(
		'label'	=> __('Add Button URL','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_slidersettings',
		'setting'	=> 'vw_construction_estate_top_button_url',
		'type'	=> 'url',
		'active_callback' => 'vw_construction_estate_default_slider'
	));

    //content layout
	$wp_customize->add_setting('vw_construction_estate_slider_content_option',array(
        'default' => 'Right',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Image_Radio_Control($wp_customize, 'vw_construction_estate_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','vw-construction-estate'),
        'section' => 'vw_construction_estate_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/images/slider-content3.png',
    ),'active_callback' => 'vw_construction_estate_default_slider'
    )));

    //Slider content padding
    $wp_customize->add_setting('vw_construction_estate_slider_content_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_slider_content_padding_top_bottom',array(
		'label'	=> __('Slider Content Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in %. Example:20%','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_construction_estate_default_slider'
	));

	$wp_customize->add_setting('vw_construction_estate_slider_content_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_slider_content_padding_left_right',array(
		'label'	=> __('Slider Content Padding Left Right','vw-construction-estate'),
		'description'	=> __('Enter a value in %. Example:20%','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_construction_estate_default_slider'
	));

    //Slider excerpt
	$wp_customize->add_setting( 'vw_construction_estate_slider_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt Length','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_construction_estate_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),'active_callback' => 'vw_construction_estate_default_slider'
	) );

	//Opacity
	$wp_customize->add_setting('vw_construction_estate_slider_opacity_color',array(
      'default'              => 0.7,
      'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));

	$wp_customize->add_control( 'vw_construction_estate_slider_opacity_color', array(
		'label'       => esc_html__( 'Slider Image Opacity','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_slidersettings',
		'type'        => 'select',
		'settings'    => 'vw_construction_estate_slider_opacity_color',
		'choices' => array(
	      '0' =>  esc_attr(__('0','vw-construction-estate')),
	      '0.1' =>  esc_attr(__('0.1','vw-construction-estate')),
	      '0.2' =>  esc_attr(__('0.2','vw-construction-estate')),
	      '0.3' =>  esc_attr(__('0.3','vw-construction-estate')),
	      '0.4' =>  esc_attr(__('0.4','vw-construction-estate')),
	      '0.5' =>  esc_attr(__('0.5','vw-construction-estate')),
	      '0.6' =>  esc_attr(__('0.6','vw-construction-estate')),
	      '0.7' =>  esc_attr(__('0.7','vw-construction-estate')),
	      '0.8' =>  esc_attr(__('0.8','vw-construction-estate')),
	      '0.9' =>  esc_attr(__('0.9','vw-construction-estate'))
		),'active_callback' => 'vw_construction_estate_default_slider'
	));

	//Slider height
	$wp_customize->add_setting('vw_construction_estate_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_slider_height',array(
		'label'	=> __('Slider Height','vw-construction-estate'),
		'description'	=> __('Specify the slider height (px).','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_construction_estate_default_slider'
	));

	$wp_customize->add_setting( 'vw_construction_estate_slider_speed', array(
		'default'  => 4000,
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_float'
	) );
	$wp_customize->add_control( 'vw_construction_estate_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','vw-construction-estate'),
		'section' => 'vw_construction_estate_slidersettings',
		'type'  => 'number',
		'active_callback' => 'vw_construction_estate_default_slider'
	) );

	//Consultant
	$wp_customize->add_section( 'vw_construction_estate_consultant' , array(
      	'title'      => __( 'Consultant Section', 'vw-construction-estate' ),
    	'description' => "For more options for consultant section </br> <a class='go-pro-btn' target='_blank' href='". esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO) ." '>GET PRO</a>",
      	
      	'panel' => 'vw_construction_estate_homepage_panel'
    ) );

	//Selective Refresh
    $wp_customize->selective_refresh->add_partial( 'vw_construction_estate_contact_number', array( 
        'selector' => '.contact-no span', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_contact_number',
    ));

    $wp_customize->add_setting('vw_construction_estate_contact_number_icon',array(
		'default'	=> 'fas fa-phone-square',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_contact_number_icon',array(
		'label'	=> __('Add Contact Number Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_consultant',
		'setting'	=> 'vw_construction_estate_contact_number_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_contact_number',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_contact_number',array(
		'label'	=> __('Contact Number','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_consultant',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_contact_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_contact_title',array(
		'label'	=> __('Contact Title','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_consultant',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_contact_content',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_contact_content',array(
		'label'	=> __('Contact content','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_consultant',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_contact_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('vw_construction_estate_contact_text',array(
		'label'	=> __('Button Text','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_consultant',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_contact_link',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('vw_construction_estate_contact_link',array(
		'label'	=> __('Button Url','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_consultant',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('vw_construction_estate_contact_text_icon',array(
		'default'	=> 'fas fa-arrow-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_contact_text_icon',array(
		'label'	=> __('Add Button Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_consultant',
		'setting'	=> 'vw_construction_estate_contact_text_icon',
		'type'		=> 'icon'
	)));
	
	//About
	$wp_customize->add_section( 'vw_construction_estate_about' , array(
      	'title'      => __( 'About Section', 'vw-construction-estate' ),
    	'description' => "For more options for about section </br> <a class='go-pro-btn' target='_blank' href='". esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO) ." '>GET PRO</a>",
      	
      	'panel' => 'vw_construction_estate_homepage_panel'
    ) );

	//Selective Refresh
    $wp_customize->selective_refresh->add_partial( 'vw_construction_estate_about_setting', array( 
        'selector' => '.about-section h3', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_about_setting',
    ));

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$posts[]='Select';	
	foreach($post_list as $post){
		$posts[$post->post_title] = $post->post_title;
	}
	$wp_customize->add_setting('vw_construction_estate_about_setting',array(
		'sanitize_callback' => 'vw_construction_estate_sanitize_choices',
	));
	$wp_customize->add_control('vw_construction_estate_about_setting',array(
		'type'    => 'select',
		'choices' => $posts,
		'label' => __('Select post','vw-construction-estate'),
		'section' => 'vw_construction_estate_about',
	));

	//About excerpt
	$wp_customize->add_setting( 'vw_construction_estate_about_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_about_excerpt_number', array(
		'label'       => esc_html__( 'About Excerpt length','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_about',
		'type'        => 'range',
		'settings'    => 'vw_construction_estate_about_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_construction_estate_about_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_about_button_text',array(
		'label'	=> __('Add Slider Button Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'DISCOVER MORE', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_about',
		'type'=> 'text'
	));

	//records Section
	$wp_customize->add_section('vw_construction_estate_records', array(
		'title'       => __('Records Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_records_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_records_text',array(
		'description' => __('<p>1. More options for records section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for records section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_records',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_records_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_records_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_records',
		'type'=> 'hidden'
	));

	//services Section
	$wp_customize->add_section('vw_construction_estate_services', array(
		'title'       => __('Services Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_services_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_services_text',array(
		'description' => __('<p>1. More options for services section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for services section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_services',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_services_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_services_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_services',
		'type'=> 'hidden'
	));

	//project Section
	$wp_customize->add_section('vw_construction_estate_project', array(
		'title'       => __('Project Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_project_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_project_text',array(
		'description' => __('<p>1. More options for project section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for project section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_project',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_project_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_project_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_project',
		'type'=> 'hidden'
	));

	//expert Section
	$wp_customize->add_section('vw_construction_estate_expert', array(
		'title'       => __('Expert Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_expert_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_expert_text',array(
		'description' => __('<p>1. More options for expert section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for expert section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_expert',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_expert_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_expert_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_expert',
		'type'=> 'hidden'
	));

	//choose video Section
	$wp_customize->add_section('vw_construction_estate_choosevideo', array(
		'title'       => __('Choose Video Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_choosevideo_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_choosevideo_text',array(
		'description' => __('<p>1. More options for choose video section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for choose video section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_choosevideo',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_choosevideo_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_choosevideo_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_choosevideo',
		'type'=> 'hidden'
	));

	//testimonials Section
	$wp_customize->add_section('vw_construction_estate_testimonials', array(
		'title'       => __('Testimonials Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_testimonials_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_testimonials_text',array(
		'description' => __('<p>1. More options for testimonials section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for testimonials section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_testimonials',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_testimonials_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_testimonials_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_testimonials',
		'type'=> 'hidden'
	));

	//properties Section
	$wp_customize->add_section('vw_construction_estate_properties', array(
		'title'       => __('Properties Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_properties_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_properties_text',array(
		'description' => __('<p>1. More options for properties section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for properties section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_properties',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_properties_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_properties_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_properties',
		'type'=> 'hidden'
	));

    //partners Section
	$wp_customize->add_section('vw_construction_estate_partners', array(
		'title'       => __('Partners Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_partners_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_partners_text',array(
		'description' => __('<p>1. More options for partners section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for partners section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_partners',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_partners_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_partners_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_partners',
		'type'=> 'hidden'
	));

	//newsletter Section
	$wp_customize->add_section('vw_construction_estate_newsletter', array(
		'title'       => __('Newsletter Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_newsletter_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_newsletter_text',array(
		'description' => __('<p>1. More options for newsletter section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for newsletter section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_newsletter',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_newsletter_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_newsletter_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_newsletter',
		'type'=> 'hidden'
	));

	//latest post Section
	$wp_customize->add_section('vw_construction_estate_latest_post', array(
		'title'       => __('Latest Post Section', 'vw-construction-estate'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-construction-estate'),
		'priority'    => null,
		'panel'       => 'vw_construction_estate_homepage_panel',
	));

	$wp_customize->add_setting('vw_construction_estate_latest_post_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_latest_post_text',array(
		'description' => __('<p>1. More options for latest post section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for latest post section.</p>','vw-construction-estate'),
		'section'=> 'vw_construction_estate_latest_post',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_construction_estate_latest_post_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_latest_post_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO).">More Info</a>",
		'section'=> 'vw_construction_estate_latest_post',
		'type'=> 'hidden'
	));

	//footer
	$wp_customize->add_section( 'vw_construction_estate_footer_section' , array(
      	'title'      => __( 'Footer Text', 'vw-construction-estate' ),
    	'description' => "For more options for footer section </br> <a class='go-pro-btn' target='_blank' href='". esc_url(VW_CONSTRUCTION_ESTATE_GO_PRO) ." '>GET PRO</a>",
      	'priority'	=> null,
      	'panel' => 'vw_construction_estate_homepage_panel'
    ) );

	$wp_customize->add_setting( 'vw_construction_estate_footer_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_footer_hide_show',array(
      'label' => esc_html__( 'Show / Hide Footer','vw-construction-estate' ),
      'section' => 'vw_construction_estate_footer_section'
    )));

     // font size
	$wp_customize->add_setting('vw_construction_estate_button_footer_font_size',array(
		'default'=> 25,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_footer_font_size',array(
		'label'	=> __('Footer Heading Font Size','vw-construction-estate'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_construction_estate_footer_section',
	));

	$wp_customize->add_setting('vw_construction_estate_button_footer_heading_letter_spacing',array(
		'default'=> 1,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_footer_heading_letter_spacing',array(
		'label'	=> __('Heading Letter Spacing','vw-construction-estate'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'vw_construction_estate_footer_section',
	));

	// text trasform
	$wp_customize->add_setting('vw_construction_estate_button_footer_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_button_footer_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Heading Text Transform','vw-construction-estate'),
		'choices' => array(
      'Uppercase' => __('Uppercase','vw-construction-estate'),
      'Capitalize' => __('Capitalize','vw-construction-estate'),
      'Lowercase' => __('Lowercase','vw-construction-estate'),
    ),
		'section'=> 'vw_construction_estate_footer_section',
	));

	$wp_customize->add_setting('vw_construction_estate_footer_heading_weight',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_footer_heading_weight',array(
        'type' => 'select',
        'label' => __('Heading Font Weight','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section',
        'choices' => array(
        	'100' => __('100','vw-construction-estate'),
            '200' => __('200','vw-construction-estate'),
            '300' => __('300','vw-construction-estate'),
            '400' => __('400','vw-construction-estate'),
            '500' => __('500','vw-construction-estate'),
            '600' => __('600','vw-construction-estate'),
            '700' => __('700','vw-construction-estate'),
            '800' => __('800','vw-construction-estate'),
            '900' => __('900','vw-construction-estate'),
        ),
	) );

	$wp_customize->add_setting('vw_construction_estate_footer_template',array(
	  'default'	=> esc_html('vw_construction_estate-footer-one'),
	  'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_footer_template',array(
	      'label'	=> esc_html__('Footer style','vw-construction-estate'),
	      'section'	=> 'vw_construction_estate_footer_section',
	      'setting'	=> 'vw_construction_estate_footer_template',
	      'type' => 'select',
	      'choices' => array(
	          'vw_construction_estate-footer-one' => esc_html__('Style 1', 'vw-construction-estate'),
	          'vw_construction_estate-footer-two' => esc_html__('Style 2', 'vw-construction-estate'),
	          'vw_construction_estate-footer-three' => esc_html__('Style 3', 'vw-construction-estate'),
	          'vw_construction_estate-footer-four' => esc_html__('Style 4', 'vw-construction-estate'),
	          'vw_construction_estate-footer-five' => esc_html__('Style 5', 'vw-construction-estate'),
	          )
	));

	$wp_customize->add_setting('vw_construction_estate_footer_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_footer_background_color', array(
		'label'    => __('Footer Background Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_footer_section',
	)));

	$wp_customize->add_setting('vw_construction_estate_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'vw_construction_estate_footer_background_image',array(
        'label' => __('Footer Background Image','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section'
	)));

	$wp_customize->add_setting('vw_construction_estate_footer_img_position',array(
	  'default' => 'center center',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','vw-construction-estate'),
		'section' => 'vw_construction_estate_footer_section',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'vw-construction-estate' ),
			'center top'   => esc_html__( 'Top', 'vw-construction-estate' ),
			'right top'   => esc_html__( 'Top Right', 'vw-construction-estate' ),
			'left center'   => esc_html__( 'Left', 'vw-construction-estate' ),
			'center center'   => esc_html__( 'Center', 'vw-construction-estate' ),
			'right center'   => esc_html__( 'Right', 'vw-construction-estate' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'vw-construction-estate' ),
			'center bottom'   => esc_html__( 'Bottom', 'vw-construction-estate' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'vw-construction-estate' ),
		),
	)); 

	// Footer
	$wp_customize->add_setting('vw_construction_estate_img_footer',array(
		'default'=> 'scroll',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_img_footer',array(
		'type' => 'select',
		'label'	=> __('Footer Background Attatchment','vw-construction-estate'),
		'choices' => array(
            'fixed' => __('fixed','vw-construction-estate'),
            'scroll' => __('scroll','vw-construction-estate'),
        ),
		'section'=> 'vw_construction_estate_footer_section',
	));

	// footer padding
	$wp_customize->add_setting('vw_construction_estate_footer_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_footer_padding',array(
		'label'	=> __('Footer Top Bottom Padding','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'vw-construction-estate' ),
    ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_footer_widgets_heading',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_footer_widgets_heading',array(
        'type' => 'select',
        'label' => __('Footer Widget Heading','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section',
        'choices' => array(
        	'Left' => __('Left','vw-construction-estate'),
            'Center' => __('Center','vw-construction-estate'),
            'Right' => __('Right','vw-construction-estate')
        ),
	) );

	$wp_customize->add_setting('vw_construction_estate_footer_widgets_content',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_footer_widgets_content',array(
        'type' => 'select',
        'label' => __('Footer Widget Content','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section',
        'choices' => array(
        	'Left' => __('Left','vw-construction-estate'),
            'Center' => __('Center','vw-construction-estate'),
            'Right' => __('Right','vw-construction-estate')
        ),
	) );

	// footer social icon
  	$wp_customize->add_setting( 'vw_construction_estate_footer_icon',array(
		'default' => false,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_footer_icon',array(
		'label' => esc_html__( 'Show / Hide Footer Social Icon','vw-construction-estate' ),
		'section' => 'vw_construction_estate_footer_section'
    ))); 
	
	//Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_footer_copy', array( 
        'selector' => '.copyright p', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_footer_copy', 
    ));

	$wp_customize->add_setting( 'vw_construction_estate_copyright_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_copyright_hide_show',array(
      'label' => esc_html__( 'Show / Hide Copyright','vw-construction-estate' ),
      'section' => 'vw_construction_estate_footer_section'
    )));

	$wp_customize->add_setting('vw_construction_estate_copyright_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_footer_section',
	)));
	
	$wp_customize->add_setting('vw_construction_estate_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('vw_construction_estate_footer_copy',array(
		'label'	=> __('Copyright Text','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_footer_section',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_copyright_font_size',array(
		'label'	=> __('Copyright Font Size','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_copyright_alignment',array(
        'default' => 'center',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Image_Radio_Control($wp_customize, 'vw_construction_estate_copyright_alignment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section',
        'settings' => 'vw_construction_estate_copyright_alignment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/images/copyright3.png'
    ))));

	$wp_customize->add_setting( 'vw_construction_estate_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','vw-construction-estate' ),
      	'section' => 'vw_construction_estate_footer_section'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_scroll_top_icon', array( 
        'selector' => '.scrollup i', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_scroll_top_icon', 
    ));

    $wp_customize->add_setting('vw_construction_estate_scroll_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_scroll_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_footer_section',
		'setting'	=> 'vw_construction_estate_scroll_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_scroll_to_top_width',array(
		'label'	=> __('Icon Width','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_scroll_to_top_height',array(
		'label'	=> __('Icon Height','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_footer_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_construction_estate_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_footer_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_construction_estate_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Image_Radio_Control($wp_customize, 'vw_construction_estate_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section',
        'settings' => 'vw_construction_estate_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/images/layout3.png'
    ))));

    $wp_customize->add_setting('vw_construction_estate_align_footer_social_icon',array(
        'default' => 'center',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_align_footer_social_icon',array(
        'type' => 'select',
        'label' => __('Social Icon Alignment ','vw-construction-estate'),
        'section' => 'vw_construction_estate_footer_section',
        'choices' => array(
            'left' => __('Left','vw-construction-estate'),
            'right' => __('Right','vw-construction-estate'),
            'center' => __('Center','vw-construction-estate'),
        ),
	) );

	//Blog Post
	$wp_customize->add_panel( $VWConstructionEstateParentPanel );

	$BlogPostParentPanel = new VW_Construction_Estate_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'vw-construction-estate' ),
		'panel' => 'vw_construction_estate_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'vw_construction_estate_post_settings', array(
		'title' => __( 'Post Settings', 'vw-construction-estate' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Blog layout
    $wp_customize->add_setting('vw_construction_estate_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
    ));
    $wp_customize->add_control(new VW_Construction_Estate_Image_Radio_Control($wp_customize, 'vw_construction_estate_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Post Layouts','vw-construction-estate'),
        'section' => 'vw_construction_estate_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/images/blog-layout3.png',
    ))));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_construction_estate_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'	        
	) );
	$wp_customize->add_control('vw_construction_estate_theme_options', array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','vw-construction-estate'),
        'description' => __('Here you can change the sidebar layout for posts. ','vw-construction-estate'),
        'section' => 'vw_construction_estate_post_settings',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-construction-estate'),
            'Right Sidebar' => __('Right Sidebar','vw-construction-estate'),
            'One Column' => __('One Column','vw-construction-estate'),
            'Three Columns' => __('Three Columns','vw-construction-estate'),
            'Four Columns' => __('Four Columns','vw-construction-estate'),
            'Grid Layout' => __('Grid Layout','vw-construction-estate')
        ),
	));

	//Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_toggle_postdate', array( 
        'selector' => '.postbox h2 a', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_toggle_postdate', 
    ));

  	$wp_customize->add_setting('vw_construction_estate_toggle_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_toggle_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_post_settings',
		'setting'	=> 'vw_construction_estate_toggle_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_construction_estate_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_toggle_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','vw-construction-estate' ),
        'section' => 'vw_construction_estate_post_settings'
    )));

    $wp_customize->add_setting('vw_construction_estate_toggle_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_toggle_author_icon',array(
		'label'	=> __('Add Author Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_post_settings',
		'setting'	=> 'vw_construction_estate_toggle_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','vw-construction-estate' ),
		'section' => 'vw_construction_estate_post_settings'
    )));

    $wp_customize->add_setting('vw_construction_estate_toggle_comments_icon',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_toggle_comments_icon',array(
		'label'	=> __('Add Comments Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_post_settings',
		'setting'	=> 'vw_construction_estate_toggle_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','vw-construction-estate' ),
		'section' => 'vw_construction_estate_post_settings'
    )));

    $wp_customize->add_setting('vw_construction_estate_toggle_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_toggle_time_icon',array(
		'label'	=> __('Add Time Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_post_settings',
		'setting'	=> 'vw_construction_estate_toggle_time_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','vw-construction-estate' ),
		'section' => 'vw_construction_estate_post_settings'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_featured_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','vw-construction-estate' ),
		'section' => 'vw_construction_estate_post_settings'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_construction_estate_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Featured Image
	$wp_customize->add_setting('vw_construction_estate_blog_post_featured_image_dimension',array(
       'default' => 'default',
       'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
  	$wp_customize->add_control('vw_construction_estate_blog_post_featured_image_dimension',array(
		'type' => 'select',
		'label'	=> __('Blog Post Featured Image Dimension','vw-construction-estate'),
		'section'	=> 'vw_construction_estate_post_settings',
		'choices' => array(
		'default' => __('Default','vw-construction-estate'),
		'custom' => __('Custom Image Size','vw-construction-estate'),
      ),
  	));

	$wp_customize->add_setting('vw_construction_estate_blog_post_featured_image_custom_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		));
	$wp_customize->add_control('vw_construction_estate_blog_post_featured_image_custom_width',array(
		'label'	=> __('Featured Image Custom Width','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'vw-construction-estate' ),),
		'section'=> 'vw_construction_estate_post_settings',
		'type'=> 'text',
		'active_callback' => 'vw_construction_estate_blog_post_featured_image_dimension'
		));

	$wp_customize->add_setting('vw_construction_estate_blog_post_featured_image_custom_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_blog_post_featured_image_custom_height',array(
		'label'	=> __('Featured Image Custom Height','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'vw-construction-estate' ),),
		'section'=> 'vw_construction_estate_post_settings',
		'type'=> 'text',
		'active_callback' => 'vw_construction_estate_blog_post_featured_image_dimension'
	));

    $wp_customize->add_setting( 'vw_construction_estate_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_post_settings',
		'type'        => 'range',
		'settings'    => 'vw_construction_estate_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_construction_estate_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-construction-estate'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-construction-estate'),
		'section'=> 'vw_construction_estate_post_settings',
		'type'=> 'text'
	));

    $wp_customize->add_setting('vw_construction_estate_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
    ));
    $wp_customize->add_control('vw_construction_estate_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','vw-construction-estate'),
        'section' => 'vw_construction_estate_post_settings',
        'choices' => array(
            'Content' => __('Content','vw-construction-estate'),
            'Excerpt' => __('Excerpt','vw-construction-estate'),
            'No Content' => __('No Content','vw-construction-estate')
        ),
    ) );

    $wp_customize->add_setting('vw_construction_estate_excerpt_suffix',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('vw_construction_estate_excerpt_suffix',array(
        'label' => __('Add Excerpt Suffix','vw-construction-estate'),
        'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-construction-estate' ),
        ),
        'section'=> 'vw_construction_estate_post_settings',
        'type'=> 'text'
    ));

    $wp_customize->add_setting( 'vw_construction_estate_blog_pagination_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_blog_pagination_hide_show',array(
      'label' => esc_html__( 'Show / Hide Blog Pagination','vw-construction-estate' ),
      'section' => 'vw_construction_estate_post_settings'
    )));

	$wp_customize->add_setting( 'vw_construction_estate_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
    ));
    $wp_customize->add_control( 'vw_construction_estate_blog_pagination_type', array(
        'section' => 'vw_construction_estate_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'vw-construction-estate' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'vw-construction-estate' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'vw-construction-estate' ),
    )));

    $wp_customize->add_setting('vw_construction_estate_blog_page_posts_settings',array(
        'default' => 'Into Blocks',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_blog_page_posts_settings',array(
        'type' => 'select',
        'label' => __('Display Blog Posts','vw-construction-estate'),
        'section' => 'vw_construction_estate_post_settings',
        'choices' => array(
        	'Into Blocks' => __('Into Blocks','vw-construction-estate'),
            'Without Blocks' => __('Without Blocks','vw-construction-estate')
        ),
	) );


    // Button Settings
	$wp_customize->add_section( 'vw_construction_estate_button_settings', array(
		'title' => __( 'Button Settings', 'vw-construction-estate' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_button_text', array( 
        'selector' => '.postbox .read_full a', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_button_text', 
    ));

    $wp_customize->add_setting('vw_construction_estate_button_text',array(
		'default'=> esc_html__( 'Read Full', 'vw-construction-estate' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_text',array(
		'label'	=> __('Add Button Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Read Full', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_button_settings',
		'type'=> 'text'
	));

	// font size button
	$wp_customize->add_setting('vw_construction_estate_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_font_size',array(
		'label'	=> __('Button Font Size','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'vw-construction-estate' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_construction_estate_button_settings',
	));

	$wp_customize->add_setting( 'vw_construction_estate_button_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_construction_estate_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_button_letter_spacing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_button_letter_spacing',array(
		'label'	=> __('Button Letter Spacing','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'vw-construction-estate' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_construction_estate_button_settings',
	));

	// text trasform
	$wp_customize->add_setting('vw_construction_estate_button_text_transform',array(
		'default'=> 'Uppercase',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','vw-construction-estate'),
		'choices' => array(
            'Uppercase' => __('Uppercase','vw-construction-estate'),
            'Capitalize' => __('Capitalize','vw-construction-estate'),
            'Lowercase' => __('Lowercase','vw-construction-estate'),
        ),
		'section'=> 'vw_construction_estate_button_settings',
	));

	// Related Post Settings
	$wp_customize->add_section( 'vw_construction_estate_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'vw-construction-estate' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_construction_estate_related_post_title', array( 
        'selector' => '.related-post h3', 
        'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_related_post_title', 
    ));

    $wp_customize->add_setting( 'vw_construction_estate_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_post',array(
		'label' => esc_html__( 'Show / Hide Related Post','vw-construction-estate' ),
		'section' => 'vw_construction_estate_related_posts_settings'
    )));

    $wp_customize->add_setting('vw_construction_estate_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_related_post_title',array(
		'label'	=> __('Add Related Post Title','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('vw_construction_estate_related_posts_count',array(
		'default'=> '2',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_float'
	));
	$wp_customize->add_control('vw_construction_estate_related_posts_count',array(
		'label'	=> __('Add Related Post Count','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_related_posts_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'vw_construction_estate_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'vw_construction_estate_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_construction_estate_related_toggle_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
  	));
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_toggle_postdate',array(
	    'label' => esc_html__( 'Show / Hide Post Date','vw-construction-estate' ),
	    'section' => 'vw_construction_estate_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_construction_estate_related_postdate_icon',array(
	    'default' => 'fas fa-calendar-alt',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_construction_estate_related_postdate_icon',array(
	    'label' => __('Add Post Date Icon','vw-construction-estate'),
	    'transport' => 'refresh',
	    'section' => 'vw_construction_estate_related_posts_settings',
	    'setting' => 'vw_construction_estate_related_postdate_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'vw_construction_estate_related_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
  	));
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','vw-construction-estate' ),
		'section' => 'vw_construction_estate_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_construction_estate_related_author_icon',array(
	    'default' => 'fas fa-user',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_construction_estate_related_author_icon',array(
	    'label' => __('Add Author Icon','vw-construction-estate'),
	    'transport' => 'refresh',
	    'section' => 'vw_construction_estate_related_posts_settings',
	    'setting' => 'vw_construction_estate_related_author_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'vw_construction_estate_related_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
  	) );
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','vw-construction-estate' ),
		'section' => 'vw_construction_estate_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_construction_estate_related_comments_icon',array(
	    'default' => 'fa fa-comments',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_construction_estate_related_comments_icon',array(
	    'label' => __('Add Comments Icon','vw-construction-estate'),
	    'transport' => 'refresh',
	    'section' => 'vw_construction_estate_related_posts_settings',
	    'setting' => 'vw_construction_estate_related_comments_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'vw_construction_estate_related_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
  	) );
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','vw-construction-estate' ),
		'section' => 'vw_construction_estate_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_construction_estate_related_time_icon',array(
	    'default' => 'fas fa-clock',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_construction_estate_related_time_icon',array(
	    'label' => __('Add Time Icon','vw-construction-estate'),
	    'transport' => 'refresh',
	    'section' => 'vw_construction_estate_related_posts_settings',
	    'setting' => 'vw_construction_estate_related_time_icon',
	    'type'    => 'icon'
  	)));

  	$wp_customize->add_setting('vw_construction_estate_related_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_related_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-construction-estate'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-construction-estate'),
		'section'=> 'vw_construction_estate_related_posts_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_construction_estate_related_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	));
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','vw-construction-estate' ),
		'section' => 'vw_construction_estate_related_posts_settings'
  	)));

  	$wp_customize->add_setting( 'vw_construction_estate_related_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_related_image_box_shadow', array(
		'label'       => esc_html__( 'Related post Image Box Shadow','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_related_posts_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	$wp_customize->add_setting('vw_construction_estate_related_button_text',array(
		'default'=> esc_html__('Read More','vw-construction-estate'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_related_button_text',array(
		'label'	=> esc_html__('Add Button Text','vw-construction-estate'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Read More', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_related_posts_settings',
		'type'=> 'text'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'vw_construction_estate_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'vw-construction-estate' ),
		'panel' => 'blog_post_parent_panel',
	));

  	$wp_customize->add_setting('vw_construction_estate_single_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_single_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_single_blog_settings',
		'setting'	=> 'vw_construction_estate_single_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_construction_estate_single_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_postdate',array(
	    'label' => esc_html__( 'Show / Hide Date','vw-construction-estate' ),
	   'section' => 'vw_construction_estate_single_blog_settings'
	)));

	$wp_customize->add_setting('vw_construction_estate_single_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_single_author_icon',array(
		'label'	=> __('Add Author Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_single_blog_settings',
		'setting'	=> 'vw_construction_estate_single_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_single_author',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_author',array(
	    'label' => esc_html__( 'Show / Hide Author','vw-construction-estate' ),
	    'section' => 'vw_construction_estate_single_blog_settings'
	)));

   	$wp_customize->add_setting('vw_construction_estate_single_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_single_comments_icon',array(
		'label'	=> __('Add Comments Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_single_blog_settings',
		'setting'	=> 'vw_construction_estate_single_comments_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_construction_estate_single_comments',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_comments',array(
	    'label' => esc_html__( 'Show / Hide Comments','vw-construction-estate' ),
	    'section' => 'vw_construction_estate_single_blog_settings'
	)));

  	$wp_customize->add_setting('vw_construction_estate_single_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_single_time_icon',array(
		'label'	=> __('Add Time Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_single_blog_settings',
		'setting'	=> 'vw_construction_estate_single_time_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_construction_estate_single_time',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_time',array(
	    'label' => esc_html__( 'Show / Hide Time','vw-construction-estate' ),
	    'section' => 'vw_construction_estate_single_blog_settings'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','vw-construction-estate' ),
		'section' => 'vw_construction_estate_single_blog_settings'
    )));

    // Single Posts Category
  	$wp_customize->add_setting( 'vw_construction_estate_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_post_category',array(
		'label' => esc_html__( 'Show / Hide Category','vw-construction-estate' ),
		'section' => 'vw_construction_estate_single_blog_settings'
    )));

	 $wp_customize->add_setting( 'vw_construction_estate_toggle_tags',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_toggle_tags', array(
		'label' => esc_html__( 'Tags','vw-construction-estate' ),
		'section' => 'vw_construction_estate_single_blog_settings'
    )));

	$wp_customize->add_setting( 'vw_construction_estate_singlepost_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_singlepost_image_box_shadow', array(
		'label'       => esc_html__( 'Single post Image Box Shadow','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_single_blog_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

   	$wp_customize->add_setting('vw_construction_estate_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-construction-estate'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-construction-estate'),
		'section'=> 'vw_construction_estate_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_construction_estate_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_blog_post_navigation_show_hide', array(
		'label' => esc_html__( 'Show / Hide Post Navigation','vw-construction-estate' ),
		'section' => 'vw_construction_estate_single_blog_settings'
    )));

	//navigation text
	$wp_customize->add_setting('vw_construction_estate_single_blog_prev_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_single_blog_next_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_single_blog_comment_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_construction_estate_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Leave a Reply', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_single_blog_comment_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_construction_estate_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','vw-construction-estate'),
		'description'	=> __('Enter a value in %. Example:50%','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_single_blog_settings',
		'type'=> 'text'
	));

	// Grid layout setting
	$wp_customize->add_section( 'vw_construction_estate_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'vw-construction-estate' ),
		'panel' => 'blog_post_parent_panel',
	));

  	$wp_customize->add_setting('vw_construction_estate_grid_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_grid_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_grid_layout_settings',
		'setting'	=> 'vw_construction_estate_grid_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_construction_estate_grid_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_grid_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','vw-construction-estate' ),
        'section' => 'vw_construction_estate_grid_layout_settings'
    )));

	$wp_customize->add_setting('vw_construction_estate_grid_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_grid_author_icon',array(
		'label'	=> __('Add Author Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_grid_layout_settings',
		'setting'	=> 'vw_construction_estate_grid_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_grid_author',array(
		'label' => esc_html__( 'Show / Hide Author','vw-construction-estate' ),
		'section' => 'vw_construction_estate_grid_layout_settings'
    )));

   	$wp_customize->add_setting('vw_construction_estate_grid_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_grid_comments_icon',array(
		'label'	=> __('Add Comments Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_grid_layout_settings',
		'setting'	=> 'vw_construction_estate_grid_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_construction_estate_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_grid_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','vw-construction-estate' ),
		'section' => 'vw_construction_estate_grid_layout_settings'
    )));

   	$wp_customize->add_setting('vw_construction_estate_grid_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_grid_time_icon',array(
		'label'	=> __('Add Time Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_grid_layout_settings',
		'setting'	=> 'vw_construction_estate_grid_time_icon',
		'type'		=> 'icon'
	)));
 
    $wp_customize->add_setting( 'vw_construction_estate_grid_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_grid_time',array(
		'label' => esc_html__( 'Show / Hide Time','vw-construction-estate' ),
		'section' => 'vw_construction_estate_grid_layout_settings'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_grid_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
	));
  	$wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_grid_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','vw-construction-estate' ),
		'section' => 'vw_construction_estate_grid_layout_settings'
  	)));

 	$wp_customize->add_setting('vw_construction_estate_grid_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_grid_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-construction-estate'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-construction-estate'),
		'section'=> 'vw_construction_estate_grid_layout_settings',
		'type'=> 'text'
	)); 

  	$wp_customize->add_setting('vw_construction_estate_display_grid_posts_settings',array(
	    'default' => 'Into Blocks',
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_display_grid_posts_settings',array(
	    'type' => 'select',
	    'label' => __('Display Grid Posts','vw-construction-estate'),
	    'section' => 'vw_construction_estate_grid_layout_settings',
	    'choices' => array(
	    	'Into Blocks' => __('Into Blocks','vw-construction-estate'),
	      	'Without Blocks' => __('Without Blocks','vw-construction-estate')
	    ),
	) );

	$wp_customize->add_setting('vw_construction_estate_grid_button_text',array(
		'default'=> esc_html__('Read More','vw-construction-estate'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_grid_button_text',array(
		'label'	=> esc_html__('Add Button Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Read More', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_grid_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_grid_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_grid_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_grid_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Grid Post Content','vw-construction-estate'),
        'section' => 'vw_construction_estate_grid_layout_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','vw-construction-estate'),
            'Excerpt' => esc_html__('Excerpt','vw-construction-estate'),
            'No Content' => esc_html__('No Content','vw-construction-estate')
        ),
	) );

	$wp_customize->add_setting( 'vw_construction_estate_grid_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_grid_featured_image_border_radius', array(
		'label'       => esc_html__( 'Grid Featured Image Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_construction_estate_grid_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_grid_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Grid Featured Image Box Shadow','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

   // other settings
	$OtherParentPanel = new VW_Construction_Estate_WP_Customize_Panel( $wp_customize, 'vw_construction_estate_other_panel_id', array(
		'title' => __( 'Others Settings', 'vw-construction-estate' ),
		'panel' => 'vw_construction_estate_panel_id',
	));

	$wp_customize->add_panel( $OtherParentPanel );

	$wp_customize->add_section( 'vw_construction_estate_left_right', array(
    	'title'      => esc_html__( 'General Settings', 'vw-construction-estate' ),
		'priority'   => 10,
		'panel' => 'vw_construction_estate_other_panel_id'
	) );

	$wp_customize->add_setting('vw_construction_estate_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Construction_Estate_Image_Radio_Control($wp_customize, 'vw_construction_estate_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','vw-construction-estate'),
        'description' => __('Here you can change the width layout of Website.','vw-construction-estate'),
        'section' => 'vw_construction_estate_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('vw_construction_estate_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','vw-construction-estate'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-construction-estate'),
        'section' => 'vw_construction_estate_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-construction-estate'),
            'Right Sidebar' => __('Right Sidebar','vw-construction-estate'),
            'One Column' => __('One Column','vw-construction-estate')
        ),
	) );

	$wp_customize->add_setting( 'vw_construction_estate_single_page_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_single_page_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Page Breadcrumb','vw-construction-estate' ),
		'section' => 'vw_construction_estate_left_right'
    )));

	 //Wow Animation
	$wp_customize->add_setting( 'vw_construction_estate_animation',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_animation',array(
        'label' => esc_html__( 'Show / Hide Animation ','vw-construction-estate' ),
        'description' => __('Here you can disable overall site animation effect','vw-construction-estate'),
        'section' => 'vw_construction_estate_left_right'
    )));

	//Pre-Loader
	$wp_customize->add_setting( 'vw_construction_estate_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_loader_enable',array(
        'label' => esc_html__( 'Show / Hide Pre-Loader','vw-construction-estate' ),
        'section' => 'vw_construction_estate_left_right'
    )));

	$wp_customize->add_setting('vw_construction_estate_preloader_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_left_right',
	)));

	$wp_customize->add_setting('vw_construction_estate_preloader_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_left_right',
	)));

	$wp_customize->add_setting('vw_construction_estate_preloader_bg_img',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'vw_construction_estate_preloader_bg_img',array(
        'label' => __('Preloader Background Image','vw-construction-estate'),
        'section' => 'vw_construction_estate_left_right'
	)));

	$wp_customize->add_setting('vw_construction_estate_bradcrumbs_alignment',array(
        'default' => 'Left',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_bradcrumbs_alignment',array(
        'type' => 'select',
        'label' => __('Bradcrumbs Alignment','vw-construction-estate'),
        'section' => 'vw_construction_estate_left_right',
        'choices' => array(
            'Left' => __('Left','vw-construction-estate'),
            'Right' => __('Right','vw-construction-estate'),
            'Center' => __('Center','vw-construction-estate'),
        ),
	) );
	
    //404 Page Setting
	$wp_customize->add_section('vw_construction_estate_404_page',array(
		'title'	=> __('404 Page Settings','vw-construction-estate'),
		'panel' => 'vw_construction_estate_other_panel_id',
	));	

	$wp_customize->add_setting('vw_construction_estate_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_construction_estate_404_page_title',array(
		'label'	=> __('Add Title','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_construction_estate_404_page_content',array(
		'label'	=> __('Add Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_404_page_button_text',array(
		'label'	=> __('Add Button Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Return to Home Page', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('vw_construction_estate_no_results_page',array(
		'title'	=> __('No Results Page Settings','vw-construction-estate'),
		'panel' => 'vw_construction_estate_other_panel_id',
	));	

	$wp_customize->add_setting('vw_construction_estate_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_construction_estate_no_results_page_title',array(
		'label'	=> __('Add Title','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_construction_estate_no_results_page_content',array(
		'label'	=> __('Add Text','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('vw_construction_estate_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','vw-construction-estate'),
		'panel' => 'vw_construction_estate_other_panel_id',
	));	

	$wp_customize->add_setting('vw_construction_estate_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_social_icon_padding',array(
		'label'	=> __('Icon Padding','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_social_icon_width',array(
		'label'	=> __('Icon Width','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_social_icon_height',array(
		'label'	=> __('Icon Height','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_construction_estate_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('vw_construction_estate_responsive_media',array(
		'title'	=> __('Responsive Media','vw-construction-estate'),
		'panel' => 'vw_construction_estate_other_panel_id',
	));

	$wp_customize->add_setting( 'vw_construction_estate_resp_topbar_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_resp_topbar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Topbar','vw-construction-estate' ),
      'section' => 'vw_construction_estate_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_stickyheader_hide_show',array(
      'label' => esc_html__( 'Sticky Header','vw-construction-estate' ),
      'section' => 'vw_construction_estate_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_resp_slider_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-construction-estate' ),
      'section' => 'vw_construction_estate_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','vw-construction-estate' ),
      'section' => 'vw_construction_estate_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_responsive_preloader_hide',array(
        'default' => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_responsive_preloader_hide',array(
        'label' => esc_html__( 'Show / Hide Preloader','vw-construction-estate' ),
        'section' => 'vw_construction_estate_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_construction_estate_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','vw-construction-estate' ),
      'section' => 'vw_construction_estate_responsive_media'
    )));

    $wp_customize->add_setting('vw_construction_estate_resp_menu_toggle_btn_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_construction_estate_resp_menu_toggle_btn_bg_color', array(
		'label'    => __('Toggle Button Bg Color', 'vw-construction-estate'),
		'section'  => 'vw_construction_estate_responsive_media',
	)));

    $wp_customize->add_setting('vw_construction_estate_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_responsive_media',
		'setting'	=> 'vw_construction_estate_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_construction_estate_res_close_menu_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Construction_Estate_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_construction_estate_res_close_menu_icon',array(
		'label'	=> __('Add Close Menu Icon','vw-construction-estate'),
		'transport' => 'refresh',
		'section'	=> 'vw_construction_estate_responsive_media',
		'setting'	=> 'vw_construction_estate_res_close_menu_icon',
		'type'		=> 'icon'
	)));

	
    //Woocommerce settings
	$wp_customize->add_section('vw_construction_estate_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'vw-construction-estate'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Shop Page Featured Image
	$wp_customize->add_setting( 'vw_construction_estate_shop_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_shop_featured_image_border_radius', array(
		'label'       => esc_html__( 'Shop Page Featured Image Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_construction_estate_shop_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_shop_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Shop Page Featured Image Box Shadow','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_construction_estate_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product .sidebar', 
		'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_woocommerce_shop_page_sidebar', ) );

	//Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'vw_construction_estate_woocommerce_shop_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Shop Page Sidebar','vw-construction-estate' ),
		'section' => 'vw_construction_estate_woocommerce_section'
    )));

     $wp_customize->add_setting('vw_construction_estate_shop_page_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_shop_page_layout',array(
        'type' => 'select',
        'label' => __('Shop Page Sidebar Layout','vw-construction-estate'),
        'section' => 'vw_construction_estate_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-construction-estate'),
            'Right Sidebar' => __('Right Sidebar','vw-construction-estate'),
        ),
	) );

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_construction_estate_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product .sidebar', 
		'render_callback' => 'vw_construction_estate_customize_partial_vw_construction_estate_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'vw_construction_estate_woocommerce_single_product_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Single Product Sidebar','vw-construction-estate' ),
		'section' => 'vw_construction_estate_woocommerce_section'
    )));

    $wp_customize->add_setting('vw_construction_estate_single_product_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_single_product_layout',array(
        'type' => 'select',
        'label' => __('Single Product Sidebar Layout','vw-construction-estate'),
        'section' => 'vw_construction_estate_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-construction-estate'),
            'Right Sidebar' => __('Right Sidebar','vw-construction-estate'),
        ),
	) );

    //Products per page
    $wp_customize->add_setting('vw_construction_estate_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_float'
	));
	$wp_customize->add_control('vw_construction_estate_products_per_page',array(
		'label'	=> __('Products Per Page','vw-construction-estate'),
		'description' => __('Display on shop page','vw-construction-estate'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('vw_construction_estate_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_products_per_row',array(
		'label'	=> __('Products Per Row','vw-construction-estate'),
		'description' => __('Display on shop page','vw-construction-estate'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('vw_construction_estate_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'vw_construction_estate_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'vw_construction_estate_products_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_construction_estate_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_construction_estate_products_button_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_products_button_border_radius', array(
		'label'       => esc_html__( 'Products Button Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products Sale Badge
	$wp_customize->add_setting('vw_construction_estate_woocommerce_sale_position',array(
        'default' => 'right',
        'sanitize_callback' => 'vw_construction_estate_sanitize_choices'
	));
	$wp_customize->add_control('vw_construction_estate_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','vw-construction-estate'),
        'section' => 'vw_construction_estate_woocommerce_section',
        'choices' => array(
            'left' => __('Left','vw-construction-estate'),
            'right' => __('Right','vw-construction-estate'),
        ),
	) );

	$wp_customize->add_setting('vw_construction_estate_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_construction_estate_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_construction_estate_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','vw-construction-estate'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-construction-estate'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-construction-estate' ),
        ),
		'section'=> 'vw_construction_estate_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_construction_estate_woocommerce_sale_border_radius', array(
		'default'              => '100',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_construction_estate_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_construction_estate_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','vw-construction-estate' ),
		'section'     => 'vw_construction_estate_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	// Related Product
    $wp_customize->add_setting( 'vw_construction_estate_related_product_show_hide',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_construction_estate_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Construction_Estate_Toggle_Switch_Custom_Control( $wp_customize, 'vw_construction_estate_related_product_show_hide',array(
        'label' => esc_html__( 'Show / Hide Related product','vw-construction-estate' ),
        'section' => 'vw_construction_estate_woocommerce_section'
    )));
	
	 // Has to be at the top
	$wp_customize->register_panel_type( 'VW_Construction_Estate_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'VW_Construction_Estate_WP_Customize_Section' );
}
add_action( 'customize_register', 'vw_construction_estate_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class VW_Construction_Estate_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'vw_construction_estate_panel';
	    public function json() {
			$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
			$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content'] = $this->get_content();
			$array['active'] = $this->active();
			$array['instanceNumber'] = $this->instance_number;
			return $array;
	    }
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class VW_Construction_Estate_WP_Customize_Section extends WP_Customize_Section {  	
	    public $section;
	    public $type = 'vw_construction_estate_section';
	    public function json() {
			$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
			$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content'] = $this->get_content();
			$array['active'] = $this->active();
			$array['instanceNumber'] = $this->instance_number;

			if ( $this->panel ) {
			$array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
			} else {
			$array['customizeAction'] = 'Customizing';
			}
			return $array;
	    }
  	}
}

// Enqueue our scripts and styles
function vw_construction_estate_customize_controls_scripts() {
  wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'vw_construction_estate_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
if ( ! class_exists ( 'VW_Construction_Estate_Customize' ) ) {
final class VW_Construction_Estate_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Construction_Estate_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new VW_Construction_Estate_Customize_Section_Pro($manager,'vw_construction_estate_upgrade_pro_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'VW Construction Pro', 'vw-construction-estate' ),
			'pro_text' => esc_html__( 'Upgarde Pro',         'vw-construction-estate' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/products/premium-construction-wordpress-theme')
		)));

		// Register sections.
		$manager->add_section(new VW_Construction_Estate_Customize_Section_Pro($manager,'vw_construction_estate_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'Documentation', 'vw-construction-estate' ),
			'pro_text' => esc_html__( 'Docs', 'vw-construction-estate' ),
			'pro_url'  => esc_url('https://preview.vwthemesdemo.com/docs/free-vw-construction-estate/')
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'vw-construction-estate-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-construction-estate-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Construction_Estate_Customize::get_instance();
}