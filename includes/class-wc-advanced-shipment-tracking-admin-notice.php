<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Advanced_Shipment_Tracking_Admin_notice {

	/**
	 * Instance of this class.
	 *
	 * @var object Class Instance
	 */
	private static $instance;
	
	/**
	 * Initialize the main plugin function
	*/
    public function __construct() {
		
		global $wpdb;
		$this->table = $wpdb->prefix."woo_shippment_provider";
		if( is_multisite() ){
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			}
			if ( is_plugin_active_for_network( 'woo-advanced-shipment-tracking/woocommerce-advanced-shipment-tracking.php' ) ) {
				$main_blog_prefix = $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE);			
				$this->table = $main_blog_prefix."woo_shippment_provider";	
			} else{
				$this->table = $wpdb->prefix."woo_shippment_provider";
			}			
		} else{
			$this->table = $wpdb->prefix."woo_shippment_provider";	
		}
		
		$this->init();	
    }
	
	/**
	 * Get the class instance
	 *
	 * @return WC_Advanced_Shipment_Tracking_Admin_notice
	*/
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	/*
	* init from parent mail class
	*/
	public function init(){						
		add_action( 'wp_ajax_ast_hide_admin_menu_tooltip', array( $this, 'ast_mark_admin_menu_tooltip_hidden') );		
		$wc_ast_api_key = get_option('wc_ast_api_key');		
		
		require_once( 'vendor/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php' );			
		add_action( 'admin_init', array( 'PAnD', 'init' ) );
				
		//add_action( 'admin_notices', array( $this, 'admin_notice_after_update' ) );		
		//add_action('admin_init', array( $this, 'ast_plugin_notice_ignore' ) );
		add_action( 'admin_notices', array( $this, 'admin_notice_for_sync_providers' ) );				
		
		if(!$wc_ast_api_key){			
			//add_action( 'admin_notices', array( $this, 'admin_notice_for_trackship' ) );
		}		
	}		

	
	
	/*
	* Display admin notice addons
	*/	
	public function admin_notice_for_trackship(){
		if ( ! PAnD::is_admin_notice_active( 'disable-trackship-notice-forever' ) ) {
			return;
		}
		?>		
		<style>		
		.notice.addon-admin-notice {			
			padding: 10px 20px;
			background: #F6FBFF;
			border: 1px solid #eee;
			border-left: 4px solid #3c4858 !important;
		}
		.rtl .notice.addon-admin-notice {
			border-right-color: #3c4858 !important;
		}
		.notice.addon-admin-notice .ast-admin-notice-inner {
			display: table;
			width: 100%;
		}
		.notice.addon-admin-notice .ast-admin-notice-inner .ast-admin-notice-icon,
		.notice.addon-admin-notice .ast-admin-notice-inner .ast-admin-notice-content,
		.notice.addon-admin-notice .ast-admin-notice-inner .trackship-install-now {
			display: table-cell;
			vertical-align: middle;
		}
		.notice.addon-admin-notice .ast-admin-notice-icon {
			color: #83bd31;			
		}
		.notice.addon-admin-notice .ast-admin-notice-icon .notice-logo{
			width: 200px;
		}
		.notice.addon-admin-notice .ast-admin-notice-content {
			padding: 0 20px;
		}
		.notice.addon-admin-notice p {
			padding: 0;
			margin: 0;
		}
		.notice.addon-admin-notice h3 {
			margin: 0 0 5px;
			color: #005B9A;
		}
		.notice.addon-admin-notice .trackship-install-now {
			text-align: center;
		}
		.notice.addon-admin-notice .trackship-install-now .hello-elementor-install-button {
			padding: 5px 30px;
			height: auto;
			line-height: 20px;
			text-transform: capitalize;
		}
		.notice.addon-admin-notice .trackship-install-now .hello-elementor-install-button i {
			padding-right: 5px;
		}
		.rtl .notice.addon-admin-notice .trackship-install-now .hello-elementor-install-button i {
			padding-right: 0;
			padding-left: 5px;
		}
		.notice.addon-admin-notice .trackship-install-now .hello-elementor-install-button:active {
			transform: translateY(1px);
		}
		.addon-admin-notice .notice-dismiss:before{
			color: #3c4858;
			font: normal 20px/20px dashicons;
		}
		.wp-core-ui .btn_large.btn_green {
			background: #59c889;
			text-shadow: none;
			border-color: #59c889;
			color: #fff;
			box-shadow: none;
			font-size: 14px;
			line-height: 30px;
			height: 34px;
			padding: 0 10px;
			margin-top: 5px;
		}
		.wp-core-ui .button-primary.btn_black_outline {
			background: transparent;
			text-shadow: none;
			border-color: #3c4858;
			box-shadow: none;
			font-size: 14px;
			line-height: 30px;
			height: 34px;
			padding: 0 10px;
			margin-top: 5px;
			color: #3c4858;
		}
		.wp-core-ui .btn_green:hover, .wp-core-ui .btn_green:focus {
			background: #59c889;
			border-color: rgba(0,0,0,0.05);
			color: #fff;
			text-shadow: none;
			box-shadow: inset 0 0 0 100px rgba(0,0,0,0.2);
		}
		.wp-core-ui .button-primary.btn_black_outline.notice-dismiss,.wp-core-ui .button-primary.btn_green.notice-dismiss{
			position: relative;
		}
		.wp-core-ui .button-primary.btn_green.notice-dismiss:before,.wp-core-ui .button-primary.btn_black_outline.notice-dismiss:before{
			display:none;
		}
		</style>	
		<div data-dismissible="disable-trackship-notice-forever" class="notice updated is-dismissible addon-admin-notice">
			<div class="ast-admin-notice-inner">
				<div class="ast-admin-notice-icon">
					<a href="https://trackship.info/my-account/?register=1" target="_blank"><img class="notice-logo" src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url().'/assets/images/trackship-logo.png'; ?>" alt="TrackShip" /></a>
				</div>
		
				<div class="ast-admin-notice-content">					
					<p style="font-size: 15px;"><strong>Try TrackShip for Free! 20 free shipment trackers for every new account + 20% Off for the first 3 month.</strong></p>
					<p>Trackship seamlessly connects to your store with the AST plugin and auto-tracks your shipments and proactively updates your orders with shipment & delivery status changes, until the shipments are delivered to your customers. Get <strong>20%</strong> off on your first 3 month plan, use code <strong>TSJU20X3</strong> during checkout. (Valid by July 10th)</p>
					<a class="button btn_large btn_green" href="https://trackship.info/my-account/?register=1" target="_blank">Start your Free Trial today</a>	
					<div data-dismissible="disable-trackship-notice-forever" style="display:inline-block;">						
						<a class="button button-primary btn_black_outline notice-dismiss" href="javascript:void(0);">Dismiss this notice</a>	
					</div>
				</div>						
			</div>
		</div>
	<?php 
	}	
	
	/*
	* Display admin notice on plugin install or update
	*/
	public function admin_notice_after_update(){ 		
		
		if ( get_option('ast_review_notice_ignore') ) return;
		
		$dismissable_url = esc_url(  add_query_arg( 'ast-review-ignore-notice', 'true' ) );
		?>		
		<style>		
		.wp-core-ui .notice.ast-dismissable-notice{
			position: relative;
			padding-right: 38px;
		}
		.wp-core-ui .notice.ast-dismissable-notice a.notice-dismiss{
			padding: 9px;
			text-decoration: none;
		} 
		.wp-core-ui .button-primary.btn_review_notice {
			background: transparent;
			color: #005b9a;
			border-color: #74c2e1;
			text-transform: uppercase;
			padding: 0 11px;
			font-size: 12px;
			height: 30px;
			line-height: 28px;
			margin: 5px 0 15px;
		}
		</style>	
		<div class="notice updated notice-success ast-dismissable-notice">
			<a href="<?php echo $dismissable_url; ?>" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a>
			<p>Hey, I noticed you are using the Advanced Shipment Tracking - that’s awesome!</br>Could you please do me a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?</p>
			<p>Eran Shor</br>Founder of zorem</p>
			<a class="button-primary btn_review_notice" target="blank" href="https://wordpress.org/support/plugin/woo-advanced-shipment-tracking/reviews/#new-post">Ok, you deserve it</a>
			<a class="button-primary btn_review_notice" href="<?php echo $dismissable_url; ?>">Nope, maybe later</a>
			<a class="button-primary btn_review_notice" href="<?php echo $dismissable_url; ?>">I already did</a>
		</div>
	<?php 		
	}	

	public function ast_plugin_notice_ignore(){
		if (isset($_GET['ast-review-ignore-notice'])) {
			update_option( 'ast_review_notice_ignore', 'true' );
		}
	}	

	public function admin_notice_for_sync_providers(){
		if ( ! PAnD::is_admin_notice_active( 'disable-synch-provider-notice-forever' ) ) {
			return;
		}
		?>
		<div data-dismissible="disable-synch-provider-notice-forever" class="notice updated is-dismissible">
			<p>Shipping Providers List Update is required. <span data-dismissible="disable-synch-provider-notice-forever"><a class="synch_providers_link" href="<?php echo admin_url( '/admin.php?page=woocommerce-advanced-shipment-tracking&tab=shipping-providers&open=synch_providers' ); ?>">Sync Now</a></span></p>
		</div> <?php
	}	
	
	/**
	* Store the time when the float bar was hidden so it won't show again for 14 days.
	*/
	function ast_mark_admin_menu_tooltip_hidden() {
		check_ajax_referer( 'ast-admin-tooltip-nonce', 'nonce' );
		update_option( 'ast_admin_menu_tooltip', time() );
		wp_send_json_success();
	}	
}