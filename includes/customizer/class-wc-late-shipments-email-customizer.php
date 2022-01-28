<?php
/**
 * Customizer Setup and Custom Controls
 *
 */

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class wcast_late_shipments_customizer_email {
	// Get our default values	
	public function __construct() {
		// Get our Customizer defaults
		$this->defaults = $this->wcast_generate_defaults();
		
		$wc_ast_api_key = get_option('wc_ast_api_key');

		if(!$wc_ast_api_key){
			return;
		}
		
		// Register our sample default controls
		add_action( 'customize_register', array( $this, 'wcast_register_sample_default_controls' ) );
		
		// Only proceed if this is own request.
		if ( ! wcast_late_shipments_customizer_email::is_own_customizer_request() && ! wcast_late_shipments_customizer_email::is_own_preview_request() ) {
			return;
		}					
		add_action( 'customize_register', array( wcast_customizer(), 'wcast_add_customizer_panels' ) );
		// Register our sections
		add_action( 'customize_register', array( wcast_customizer(), 'wcast_add_customizer_sections' ) );	
		
		// Remove unrelated components.
		add_filter( 'customize_loaded_components', array( wcast_customizer(), 'remove_unrelated_components' ), 99, 2 );

		// Remove unrelated sections.
		add_filter( 'customize_section_active', array( wcast_customizer(), 'remove_unrelated_sections' ), 10, 2 );	
		
		// Unhook divi front end.
		add_action( 'woomail_footer', array( wcast_customizer(), 'unhook_divi' ), 10 );

		// Unhook Flatsome js
		add_action( 'customize_preview_init', array( wcast_customizer(), 'unhook_flatsome' ), 50  );
		
		add_filter( 'customize_controls_enqueue_scripts', array( wcast_customizer(), 'enqueue_customizer_scripts' ) );				
		
		add_action( 'parse_request', array( $this, 'set_up_preview' ) );	
		
		add_action( 'customize_preview_init', array( $this, 'enqueue_preview_scripts' ) );	

	}
	
	/**
	 * add css and js for preview
	*/
	public function enqueue_preview_scripts() {		 
		wp_enqueue_script('wcast-email-preview-scripts', wc_advanced_shipment_tracking()->plugin_dir_url() . 'assets/js/preview-scripts.js', array('jquery', 'customize-preview'), wc_advanced_shipment_tracking()->version, true);
		wp_enqueue_style('wcast-preview-styles', wc_advanced_shipment_tracking()->plugin_dir_url() . 'assets/css/preview-styles.css', array(), wc_advanced_shipment_tracking()->version  );
		 		// Send variables to Javascript
		$preview_id     = get_theme_mod('wcast_email_preview_order_id');
		wp_localize_script('wcast-email-preview-scripts', 'wcast_preview', array(
			'site_title'   => $this->get_blogname(),
			'order_number' => $preview_id,			
		));
	}
	
	/**
	 * Get blog name formatted for emails.
	 *
	 * @return string
	 */
	public function get_blogname() {
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}	
	
	/**
	 * Checks to see if we are opening our custom customizer preview
	 *
	 * @access public
	 * @return bool
	 */
	public static function is_own_preview_request() {
		return isset( $_REQUEST['wcast-late-shipments-email-customizer-preview'] ) && '1' === $_REQUEST['wcast-late-shipments-email-customizer-preview'];
	}
	
	/**
	 * Checks to see if we are opening our custom customizer controls
	 *
	 * @access public
	 * @return bool
	 */
	public static function is_own_customizer_request() {
		return isset( $_REQUEST['email'] ) && $_REQUEST['email'] === 'admin_late_shipments_email';
	}	
	
	/**
	 * Get Customizer URL
	 *
	 */
	public static function get_customizer_url($email,$return_tab) {		
			$customizer_url = add_query_arg( array(
				'wcast-customizer' => '1',
				'email' => $email,
				'url'                  => urlencode( add_query_arg( array( 'wcast-late-shipments-email-customizer-preview' => '1' ), home_url( '/' ) ) ),
				'return'               => urlencode( wcast_late_shipments_customizer_email::get_email_settings_page_url($return_tab) ),
			), admin_url( 'customize.php' ) );		

		return $customizer_url;
	}	
	
	/**
	 * Get WooCommerce email settings page URL
	 *
	 * @access public
	 * @return string
	 */
	public static function get_email_settings_page_url($return_tab) {
		return admin_url( 'admin.php?page=trackship-for-woocommerce&tab='.$return_tab );
	}
	
	/**
	 * code for initialize default value for customizer
	*/
	public function wcast_generate_defaults() {		
		$customizer_defaults = array(			
			'wcast_late_shipments_email_subject' => __( 'Late shipment for order #{order_number}', 'woo-advanced-shipment-tracking' ),
			'wcast_late_shipments_email_heading' => __( 'Late shipment', 'woo-advanced-shipment-tracking' ),
			'wcast_late_shipments_email_content' => __( 'This order was shipped {shipment_length} days ago, the shipment status is {shipment_status} and its est. delivery date is {est_delivery_date}.', 'woo-advanced-shipment-tracking' ),				
			'wcast_enable_late_shipments_admin_email'  => '',
			'wcast_late_shipments_days' => '7',
			'wcast_late_shipments_email_to'  => '{admin_email}',
			'wcast_late_shipments_show_tracking_details' => '',
			'wcast_late_shipments_show_order_details' => '',
			'wcast_late_shipments_show_billing_address' => '',
			'wcast_late_shipments_show_shipping_address' => '',
			'wcast_late_shipments_email_code_block' => '',
		);

		return apply_filters( 'skyrocket_customizer_defaults', $customizer_defaults );
	}	
	
	/**
	 * Register our sample default controls
	 */
	public function wcast_register_sample_default_controls( $wp_customize ) {		
		/**
		* Load all our Customizer Custom Controls
		*/
		require_once trailingslashit( dirname(__FILE__) ) . 'custom-controls.php';
				
		$wp_customize->add_setting( 'late_shipments_email_settings[late_shipments_admin_email_heading]',
			array(
				'default' => '',
				'transport' => 'postMessage',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( new WP_Customize_Heading_Control( $wp_customize, 'late_shipments_email_settings[late_shipments_admin_email_heading]',
			array(
				'label' => __( 'Late Shipments admin email', 'woo-advanced-shipment-tracking' ),
				'description' => '',
				'section' => 'admin_late_shipments_email'
			)
		) );
		
		// Display Shipment Provider image/thumbnail
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_enable_late_shipments_admin_email]',
			array(
				'default' => $this->defaults['wcast_enable_late_shipments_admin_email'],
				'transport' => 'postMessage',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( 'late_shipments_email_settings[wcast_enable_late_shipments_admin_email]',
			array(
				'label' => __( 'Enable Late Shipments admin email', 'woo-advanced-shipment-tracking' ),
				'description' => esc_html__( '', 'woo-advanced-shipment-tracking' ),
				'section' => 'admin_late_shipments_email',
				'type' => 'checkbox'
			)
		);		
		
		$wp_customize->add_setting( 'wcast_late_shipments_email_preview_order_id',
			array(
				'default' => 'mockup',
				'transport' => 'refresh',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( new Skyrocket_Dropdown_Select_Custom_Control( $wp_customize, 'wcast_late_shipments_email_preview_order_id',
			array(
				'label' => __( 'Preview order', 'woo-advanced-shipment-tracking' ),
				'description' => '',
				'section' => 'admin_late_shipments_email',
				'input_attrs' => array(
					'placeholder' => __( 'Please select a order...', 'skyrocket' ),
					'class' => 'preview_order_select',
				),
				'choices' => wcast_customizer()->get_order_ids(),
			)
		) );						
			
		// Header Text		
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_late_shipments_days]',
			array(
				'default' => $this->defaults['wcast_late_shipments_days'],
				'transport' => 'refresh',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( 'late_shipments_email_settings[wcast_late_shipments_days]',
			array(
				'label' => __( 'Late Shipment Days', 'woocommerce' ),
				'description' => esc_html__( '', 'woocommerce' ),
				'section' => 'admin_late_shipments_email',
				'type' => 'number',				
			)
		);	
		
		// Header Text		
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_late_shipments_email_to]',
			array(
				'default' => $this->defaults['wcast_late_shipments_email_to'],
				'transport' => 'postMessage',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( 'late_shipments_email_settings[wcast_late_shipments_email_to]',
			array(
				'label' => __( 'Recipient(s)', 'woocommerce' ),
				'description' => esc_html__( 'Enter emails here or use variables such as {admin_email}. Multiple emails can be separated by commas.', 'woocommerce' ),
				'section' => 'admin_late_shipments_email',
				'type' => 'text',
				'input_attrs' => array(
					'class' => '',
					'style' => '',
					'placeholder' => __( 'E.g. {admin_email}, admin@example.org', 'woo-advanced-shipment-tracking' ),
				),
			)
		);		
		// Header Text		
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_late_shipments_email_subject]',
			array(
				'default' => $this->defaults['wcast_late_shipments_email_subject'],
				'transport' => 'postMessage',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( 'late_shipments_email_settings[wcast_late_shipments_email_subject]',
			array(
				'label' => __( 'Subject', 'woocommerce' ),
				'description' => esc_html__( 'Available variables:', 'woo-advanced-shipment-tracking' ).' {site_title}, {order_number}',
				'section' => 'admin_late_shipments_email',
				'type' => 'text',
				'input_attrs' => array(
					'class' => '',
					'style' => '',
					'placeholder' => __( $this->defaults['wcast_late_shipments_email_subject'], 'woo-advanced-shipment-tracking' ),
				),
			)
		);
		
		// Header Text		
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_late_shipments_email_heading]',
			array(
				'default' => $this->defaults['wcast_late_shipments_email_heading'],
				'transport' => 'refresh',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( 'late_shipments_email_settings[wcast_late_shipments_email_heading]',
			array(
				'label' => __( 'Email heading', 'woocommerce' ),
				'description' => esc_html__( 'Available variables:', 'woo-advanced-shipment-tracking' ).' {site_title}, {order_number}',
				'section' => 'admin_late_shipments_email',
				'type' => 'text',
				'input_attrs' => array(
					'class' => '',
					'style' => '',
					'placeholder' => __( $this->defaults['wcast_late_shipments_email_heading'], 'woo-advanced-shipment-tracking' ),
				),
			)
		);		
		
		// Test of TinyMCE control
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_late_shipments_email_content]',
			array(
				'default' => $this->defaults['wcast_late_shipments_email_content'],
				'transport' => 'refresh',
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post'
			)
		);
		$wp_customize->add_control( new Skyrocket_TinyMCE_Custom_control( $wp_customize, 'late_shipments_email_settings[wcast_late_shipments_email_content]',
			array(
				'label' => __( 'Email content', 'woo-advanced-shipment-tracking' ),
				'description' => __( '', 'woo-advanced-shipment-tracking' ),
				'section' => 'admin_late_shipments_email',
				'input_attrs' => array(
					'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					'mediaButtons' => true,
					'placeholder' => __( $this->defaults['wcast_late_shipments_email_content'], 'woo-advanced-shipment-tracking' ),
				)
			)
		) );
		
		$wp_customize->add_setting( 'late_shipments_email_settings[wcast_late_shipments_email_code_block]',
			array(
				'default' => '',
				'transport' => 'postMessage',
				'type' => 'option',
				'sanitize_callback' => ''
			)
		);
		$wp_customize->add_control( new WP_Customize_codeinfoblock_Control( $wp_customize, 'late_shipments_email_settings[wcast_late_shipments_email_code_block]',
			array(
				'label' => __( 'Available variables:', 'woo-advanced-shipment-tracking' ),
				'description' => '<code>{site_title}<br>{admin_email}<br>{customer_first_name}<br>{customer_last_name}<br>{customer_company_name}<br>{customer_username}<br>{order_number}<br>{shipment_length}<br>{shipment_status}<br>{est_delivery_date}</code>',
				'section' => 'admin_late_shipments_email',				
			)
		) );
	}		
	
	/**
	 * Set up preview
	 *
	 * @access public
	 * @return void
	 */
	public function set_up_preview() {
		
		// Make sure this is own preview request.
		if ( ! wcast_late_shipments_customizer_email::is_own_preview_request() ) {
			return;
		}
		include wc_advanced_shipment_tracking()->get_plugin_path() . '/includes/customizer/preview/late_shipments_preview.php';		
		exit;			
	}
	/**
	 * code for preview of in transit email
	*/
	public function preview_late_shipments_email(){
		// Load WooCommerce emails.
		$wc_emails      = WC_Emails::instance();
		$emails         = $wc_emails->get_emails();		
		$preview_id     = get_theme_mod('wcast_late_shipments_email_preview_order_id');
		$ast = new WC_Advanced_Shipment_Tracking_Actions;	
		
		$order_id = $ast->get_custom_order_number( $preview_id );
		
		$email_heading = $ast->get_option_value_from_array('late_shipments_email_settings','wcast_late_shipments_email_heading',$this->defaults['wcast_late_shipments_email_heading']);	
		$email_heading = str_replace( '{site_title}', $this->get_blogname(), $email_heading );
		$email_heading =  str_replace( '{order_number}', $order_id, $email_heading );
		
		$email_content = $ast->get_option_value_from_array('late_shipments_email_settings','wcast_late_shipments_email_content',$this->defaults['wcast_late_shipments_email_content']);					
				
		$sent_to_admin = false;
		$plain_text = false;
		$email = '';
		
		if($preview_id == '' || $preview_id == 'mockup') {
			$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'Please select order to preview.', 'woo-advanced-shipment-tracking' ) . '</div>';							
			echo $content;
			return;
		}		
		
		$order = wc_get_order( $preview_id );
		
		if(!$order){
			$content = '<div style="padding: 35px 40px; background-color: white;">' . __( 'Please select order to preview.', 'woo-advanced-shipment-tracking' ) . '</div>';							
			echo $content;
			return;
		}
		
		$mailer = WC()->mailer();
				
		// get the preview email subject
		$email_heading = __( $email_heading, 'woo-advanced-shipment-tracking' );
		//ob_start();				
				
		$wast = WC_Advanced_Shipment_Tracking_Actions::get_instance();
		$message = wc_trackship_email_manager()->email_content($email_content,$preview_id,$order);
		$message = $this->email_content($message,$preview_id,$order);
		
		ob_start();
		$local_template	= get_stylesheet_directory().'/woocommerce/emails/tracking-info.php';
		
		if ( file_exists( $local_template ) && is_writable( $local_template )){
			wc_get_template( 'emails/tracking-info.php', array( 'tracking_items' => $wast->get_tracking_items( $preview_id, true ), 'order_id'=> $preview_id ), 'woocommerce-advanced-shipment-tracking/', get_stylesheet_directory() . '/woocommerce/' );
		} else{
			wc_get_template( 'emails/tracking-info.php', array( 
				'tracking_items' => $wast->get_tracking_items( $preview_id, true ),
				'order_id' => $preview_id,				
			), 'woocommerce-advanced-shipment-tracking/', wc_advanced_shipment_tracking()->get_plugin_path() . '/templates/' );
		}
		
		$message .= ob_get_clean();			
						
		// create a new email
		$email = new WC_Email();
		$email->id = 'WC_Delivered_email';		
		// wrap the content with the email template and then add styles
		$message = apply_filters( 'woocommerce_mail_content', $email->style_inline( $mailer->wrap_message( $email_heading, $message ) ) );
		echo $message;			
	}
	/**
	 * code for format email content 
	 */
	public function email_content($message, $order_id, $order){	
		
		$ast = new WC_Advanced_Shipment_Tracking_Actions;	
		$shipment_length = $ast->get_option_value_from_array('late_shipments_email_settings','wcast_late_shipments_days',$this->defaults['wcast_late_shipments_days']);	
		$message = str_replace( '{shipment_length}', $shipment_length, $message );		
		return $message;
	}
	
}
/**
 * Initialise our Customizer settings
 */

$wcast_late_shipments_settings = new wcast_late_shipments_customizer_email();