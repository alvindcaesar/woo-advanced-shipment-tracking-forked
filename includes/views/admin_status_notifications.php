<section id="content_status_notifications" class="inner_tab_section">
	<div class="tab_inner_container">
		<h3 class="border0_heading"><?php _e('Shipment Status Email Notifications', 'woo-advanced-shipment-tracking'); ?></h3>
		<div class="outer_form_table">			
			<?php 
				$ast = new WC_Advanced_Shipment_Tracking_Actions;	
				
				$wcast_enable_delivered_email = get_option('woocommerce_customer_delivered_order_settings'); 				
				
				$wcast_enable_intransit_email = $ast->get_option_value_from_array('wcast_intransit_email_settings','wcast_enable_intransit_email','');
				
				$wcast_enable_onhold_email = $ast->get_option_value_from_array('wcast_onhold_email_settings','wcast_enable_onhold_email','');
								
				$wcast_enable_outfordelivery_email = $ast->get_option_value_from_array('wcast_outfordelivery_email_settings','wcast_enable_outfordelivery_email','');
				
				$wcast_enable_failure_email = $ast->get_option_value_from_array('wcast_failure_email_settings','wcast_enable_failure_email','');
				
				$wcast_enable_delivered_status_email = $ast->get_option_value_from_array('wcast_delivered_email_settings','wcast_enable_delivered_status_email','');
				
				$wcast_enable_returntosender_email = $ast->get_option_value_from_array('wcast_returntosender_email_settings','wcast_enable_returntosender_email','');
								
				$wcast_enable_availableforpickup_email = $ast->get_option_value_from_array('wcast_availableforpickup_email_settings','wcast_enable_availableforpickup_email','');
				
				$wcast_enable_late_shipments_admin_email = $ast->get_option_value_from_array('late_shipments_email_settings','wcast_enable_late_shipments_admin_email','');
			?>		
			<table class="form-table shipment-status-email-table">
				<tbody>
					<tr class="<?php if($wcast_enable_intransit_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_intransit_email">
										<input type="checkbox" data-settings="wcast_intransit_email_settings" name="wcast_enable_intransit_email" id="wcast_enable_intransit_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_intransit_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>			
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_intransit_customizer_email::get_customizer_url('customer_intransit_email','notifications') ?>" class="shipment-status-label in-transit woocommerce-help-tip tipTip" title="<?php _e('The shipment was accepted by the shipping provider and its on the way.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('In Transit', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_intransit_customizer_email::get_customizer_url('customer_intransit_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
					<tr class="<?php if($wcast_enable_onhold_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_onhold_email">
										<input type="checkbox" data-settings="wcast_onhold_email_settings" name="wcast_enable_onhold_email" id="wcast_enable_onhold_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_onhold_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>			
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_onhold_customizer_email::get_customizer_url('customer_onhold_email','notifications') ?>" class="shipment-status-label on-hold woocommerce-help-tip tipTip" title="<?php _e('The shipment is On Hold.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('On Hold', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_onhold_customizer_email::get_customizer_url('customer_onhold_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
					<tr class="<?php if($wcast_enable_returntosender_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_returntosender_email">
										<input type="checkbox" data-settings="wcast_returntosender_email_settings" name="wcast_enable_returntosender_email" id="wcast_enable_returntosender_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_returntosender_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_returntosender_customizer_email::get_customizer_url('customer_returntosender_email','notifications') ?>" class="shipment-status-label return-to-sender woocommerce-help-tip tipTip" title="<?php _e('Shipment is returned to sender.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('Return To Sender', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_returntosender_customizer_email::get_customizer_url('customer_returntosender_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
					<tr class="<?php if($wcast_enable_availableforpickup_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_availableforpickup_email">
										<input type="checkbox" data-settings="wcast_availableforpickup_email_settings" name="wcast_enable_availableforpickup_email" id="wcast_enable_availableforpickup_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_availableforpickup_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_availableforpickup_customizer_email::get_customizer_url('customer_availableforpickup_email','notifications') ?>" class="shipment-status-label available-for-pickup woocommerce-help-tip tipTip" title="<?php _e('The shipment is ready to by picked up.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('Available For Pickup', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_availableforpickup_customizer_email::get_customizer_url('customer_availableforpickup_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
					<tr class="<?php if($wcast_enable_outfordelivery_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_outfordelivery_email">
										<input type="checkbox" data-settings="wcast_outfordelivery_email_settings" name="wcast_enable_outfordelivery_email" id="wcast_enable_outfordelivery_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_outfordelivery_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>				
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_outfordelivery_customizer_email::get_customizer_url('customer_outfordelivery_email','notifications') ?>" class="shipment-status-label out-for-delivery woocommerce-help-tip tipTip" title="<?php _e('Carrier is about to deliver the shipment.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('Out For delivery', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_outfordelivery_customizer_email::get_customizer_url('customer_outfordelivery_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
					<tr class="<?php if($wcast_enable_delivered_status_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_delivered_status_email">
										<input type="checkbox" data-settings="wcast_delivered_email_settings" name="wcast_enable_delivered_status_email" id="wcast_enable_delivered_status_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_delivered_status_email == 1 && $wcast_enable_delivered_email['enabled'] != 'yes') { echo 'checked'; } ?> <?php if($wcast_enable_delivered_email['enabled'] === 'yes' && get_option('wc_ast_status_delivered') == 1){ echo 'disabled'; }?> />
									</label>
								</span>				
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_delivered_customizer_email::get_customizer_url('customer_delivered_status_email','notifications') ?>" class="shipment-status-label delivered-status woocommerce-help-tip tipTip" title="<?php _e('The shipment was delivered successfully.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('Delivered', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_delivered_customizer_email::get_customizer_url('customer_delivered_status_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
					<tr class="<?php if($wcast_enable_failure_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action shipment_status_toggle">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_failure_email">
										<input type="checkbox" data-settings="wcast_failure_email_settings" name="wcast_enable_failure_email" id="wcast_enable_failure_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_failure_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>				
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_failure_customizer_email::get_customizer_url('customer_failure_email','notifications') ?>" class="shipment-status-label failed-attempt woocommerce-help-tip tipTip" title="<?php _e('Carrier attempted to deliver the package but failed.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('Failed Attempt', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_failure_customizer_email::get_customizer_url('customer_failure_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>					
				</tbody>
			</table>				
		</div>
		
		<?php do_action( 'after_shipment_status_email_notifications' ); ?>
		<h3 class="border0_heading"><?php _e('Admin Notifications', 'woo-advanced-shipment-tracking'); ?></h3>
		<div class="outer_form_table">
			<table class="form-table shipment-status-email-table">
				<tbody>
					<tr class="<?php if($wcast_enable_late_shipments_admin_email == 1){ echo 'enable'; } else{ echo 'disable'; }?>">
						<td class="forminp">
							<span class="email_status_span">
								<span class="mdl-list__item-secondary-action">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="wcast_enable_late_shipments_admin_email">
										<input type="checkbox" data-settings="late_shipments_email_settings" name="wcast_enable_late_shipments_admin_email" id="wcast_enable_late_shipments_admin_email" class="mdl-switch__input" value="yes" <?php if($wcast_enable_late_shipments_admin_email == 1) { echo 'checked'; } ?> />
									</label>
								</span>			
							</span>
						</td>
						<td class="forminp status-label-column">
							<a href="<?php echo wcast_late_shipments_customizer_email::get_customizer_url('admin_late_shipments_email','notifications') ?>" class="shipment-status-label late-shipments woocommerce-help-tip tipTip" title="<?php _e('If a shipment reached the number of days that you define, and the shipment is not "delivered" or "Returned to Sender" than email will trigger.', 'woo-advanced-shipment-tracking'); ?>"><?php _e('Late Shipments', 'woo-advanced-shipment-tracking'); ?></a>
						</td>
						<td class="forminp">
							<a class="edit_customizer_a" href="<?php echo wcast_late_shipments_customizer_email::get_customizer_url('admin_late_shipments_email','notifications') ?>"><?php _e('edit email', 'woocommerce'); ?></a>
						</td>
					</tr>
				</tbody>
			</table>				
		</div>	
	</div>		
	<?php include 'trackship_sidebar.php'; ?>	
</section>