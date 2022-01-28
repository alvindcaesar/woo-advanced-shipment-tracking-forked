<?php
/**
 * html code for tools tab
 */
$free_plugins = array(
	0 => array(
		'title' => 'Advanced Local Pickup',
		'description' => 'Mark orders as “Ready for Pickup” and add pickup instructions to the order email.',
		'image' => 'alp-icon.png',
		'file' => 'advanced-local-pickup-for-woocommerce/woo-advanced-local-pickup.php'
	),
	1 => array(
		'title' => 'Country Based Restriction',
		'description' => 'Restrict your products to be purchasable only to specific countries!',
		'image' => 'cbr-icon.png',
		'file' => 'woo-product-country-base-restrictions/woocommerce-product-country-base-restrictions.php'
	),
	2 => array(
		'title' => 'Sales Report Email',
		'description' => 'Send daily, weekly, or monthly sales report via email from your Store.',
		'image' => 'sre-icon.png',
		'file' => 'woo-advanced-sales-report-email/woocommerce-product-country-base-restrictions.php'
	),
	3 => array(
		'title' => 'Shop Manager Admin for WooCommerce',
		'description' => 'Adds admin tools and admin menu to save time managing WooCommerce stores.',
		'image' => 'sma-icon.png',
		'file' => 'woo-shop-manager-admin-bar/woo-shop-manager-admin.php'
	),
	4 => array(
		'title' => 'Customer verification for WooCommerce',
		'description' => 'Require users to verify their email address and reduce registration spam.',
		'image' => 'cev-icon.png',
		'file' => 'customer-email-verification-for-woocommerce/customer-email-verification-for-woocommerce.php'
	),
	5 => array(
		'title' => 'Sales Report By Country for WooCommerce',
		'description' => 'Adds sales report by country to WooCommerce Reports.',
		'image' => 'src-icon.png',
		'file' => 'woo-sales-by-country-reports/woocommerce-sales-by-country-report.php'
	),
	6 => array(
		'title' => 'Ajax Login/Register for WooCommerce',
		'description' => 'Improve your store UI/UX with AJAX-powered login & registration process.',
		'image' => 'ajax-login-register-icon.png',
		'file' => 'woo-ajax-loginregister/woocommerce-ajax-login-register.php'
	),	
); 

//$status = install_plugin_install_status( $plugin );
$pro_plugins = array(
	0 => array(
		'title' => 'Tracking Per Item Add-on',
		'description' => 'The Tracking per item is add-on for the Advanced Shipment Tracking for WooCommerce plugin that lets you attach tracking numbers to line items and to line item quantities.',
		'url' => 'https://www.zorem.com/products/tracking-per-item-ast-add-on/',
		'image' => 'tpi-icon.png',
	),
	1 => array(
		'title' => 'SMS for WooCommerce',
		'description' => 'Keep your customers informed by sending them automated SMS text messages with order & delivery updates. You can send SMS notifications to customers when the order status is updated or when the shipment is out for delivery and more…',
		'url' => 'https://www.zorem.com/products/sms-for-woocommerce/',
		'image' => 'sms-woo-icon.png',
	),
	2 => array(
		'title' => 'Advanced Order Status Manager',
		'description' => 'The Advanced Order Status Manager allows store owners to manage the WooCommerce orders statuses, create, edit, and delete custom Custom Order Statuses and integrate them into the WooCommerce orders flow.',
		'url' => 'https://www.zorem.com/products/advanced-order-status-manager/',
		'image' => 'AOSM-banner.png',
	),
	3 => array(
		'title' => 'Country Based Restriction Pro',
		'description' => 'The country-based restrictions plugin by zorem works by the WooCommerce Geolocation or the shipping country added by the customer and allows you to restrict products on your store to sell or not to sell to specific countries.',
		'url' => 'https://www.zorem.com/products/country-based-restriction-pro/',
		'image' => 'cbr-banner.png',
	),
	4 => array(
		'title' => 'Sales Report Email Pro',
		'description' => 'The Sales Report Email Pro will help know how well your store is performing and how your products are selling by sending you a daily, weekly, or monthly sales report by email, directly from your WooCommerce store.',
		'url' => 'https://www.zorem.com/products/sales-report-email-for-woocommerce/',
		'image' => 'sre-banner.png',
	),		
); 
?>
<section id="content6" class="tab_section">
	<div class="d_table addons_page_dtable" style="">		
		<?php if ( class_exists( 'ast_woo_advanced_shipment_tracking_by_products' ) ) { ?>	
		<input id="tab_addons" type="radio" name="inner_tabs" class="inner_tab_input" data-tab="addons" checked="">
		<label for="tab_addons" class="inner_tab_label"><?php _e( 'Add-ons', 'woo-advanced-shipment-tracking' ); ?></label>
		
		<input id="tab_license" type="radio" name="inner_tabs" class="inner_tab_input" data-tab="license">
		<label for="tab_license" class="inner_tab_label"><?php _e( 'License', 'woo-advanced-shipment-tracking' ); ?></label>
		<?php } ?>
		
		<section id="content_tab_addons" class="<?php if ( class_exists( 'ast_woo_advanced_shipment_tracking_by_products' ) ) { ?>inner_tab_section<?php } ?>">				
			
			<img class="zorem_logo" src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url()?>assets/images/zorem-logo.png">
			<p class="zorem_description">zorem creates Innovative Plugins, Apps, SaaS products and integrations that help WooCommerce Store owners to better manage their stores and to automate their workflows.</p>
			
			<hr>
			
			<h2 class="addons_page_title">Premium WooCommerce Plugins</h2>					
				
			<div class="plugins_section pro_plugin_section">
				<?php foreach($pro_plugins as $plugin){ ?>
					<div class="single_plugin">
						<div class="plugin_image">
							<a href="<?php echo $plugin['url']; ?>" target="blank"><img src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url()?>assets/images/<?php echo $plugin['image']; ?>"></a>
						</div>						
					</div>	
				<?php } ?>						
			</div>
			
			<h2 class="addons_page_title">Free WooCommerce Plugins</h2>					
			
			<div class="plugins_section free_plugin_section">
				<?php foreach($free_plugins as $plugin){ ?>
					<div class="single_plugin">
						<div class="free_plugin_inner">
							<div class="plugin_image">
								<img src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url()?>assets/images/<?php echo $plugin['image']; ?>">
							</div>
							<div class="plugin_description">
								<h3 class="plugin_title"><?php echo $plugin['title']; ?></h3>
								<p><?php echo $plugin['description']; ?></p>
								<?php 
								if ( is_plugin_active( $plugin['file'] ) ) { ?>
									<button type="button" class="button button-disabled" disabled="disabled">Active</button>
								<?php } else{ ?>
									<a href="<?php echo admin_url('plugin-install.php?s='.$plugin['title'].'&tab=search&type=term'); ?>" class="install-now button">INSTALL NOW</a>
								<?php } ?>								
							</div>
						</div>	
					</div>	
				<?php } ?>						
			</div>					
		</section>
		
		<section id="content_tab_license" class="inner_tab_section">				
			<form method="post" id="wc_ast_addons_form" class="addons_inner_container" action="" enctype="multipart/form-data"> 	
				<div class="ast_addons_section">									
					<div class="single_plugin">
						<div class="plugin_image">
							<img src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url()?>assets/images/tpi-icon_license.png">
						</div>
						<div class="plugin_description">
							<?php do_action('tracking_per_item_addon_license_form'); ?>
						</div>
					</div>	
				</div>						
			</form>				
		</section>						
	</div>
</section>