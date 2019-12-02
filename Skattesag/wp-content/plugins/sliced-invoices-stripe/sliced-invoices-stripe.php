<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Sliced Invoices Stripe
 * Plugin URI:        https://slicedinvoices.com/extensions/stripe-payment-gateway/
 * Description:       Accept invoice payments using Stripe payment gateway. Requirements: The Sliced Invoices Plugin
 * Version:           1.7.5
 * Author:            Sliced Invoices
 * Author URI:        https://slicedinvoices.com/
 * Text Domain:       sliced-invoices-stripe
 * Domain Path:       /languages
 *
 * -------------------------------------------------------------------------------
 * Copyright 2015-2019 Sliced Apps, Inc.  All rights reserved.
 * -------------------------------------------------------------------------------
 */

// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}

/**
 * Initialize
 */
define( 'SI_STRIPE_VERSION', '1.7.5' );
define( 'SI_STRIPE_DB_VERSION', '2' );
define( 'SI_STRIPE_FILE', __FILE__ );

include( plugin_dir_path( __FILE__ ) . '/updater/plugin-updater.php' );

register_activation_hook( __FILE__, array( 'Sliced_Stripe', 'sliced_stripe_activate' ) );
register_deactivation_hook( __FILE__, array( 'Sliced_Stripe', 'sliced_stripe_deactivate' ) );

function sliced_stripe_load_textdomain() {
    load_plugin_textdomain( 'sliced-invoices-stripe', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'sliced_stripe_load_textdomain' );


/**
 * 2018-04-12: update from DB 1 to DB 2, for Sliced Invoices Stripe versions < 1.7.1
 */
function sliced_invoices_db_update_stripe() {
	$general = get_option('sliced_general');
	if ( isset( $general['stripe_db_version'] ) && $general['stripe_db_version'] >= SI_STRIPE_DB_VERSION ) {
		// okay
	} else {
		// update needed
		$payments = get_option( 'sliced_payments' );
		$payments['stripe_enabled'] = 'on';
		update_option( 'sliced_payments', $payments );
		
		// Done
		$general['stripe_db_version'] = '2';
		update_option( 'sliced_general', $general );
	}
}
add_action( 'init', 'sliced_invoices_db_update_stripe' );


/**
 * Global functions
 */
function sliced_get_gateway_stripe_label() {
	$translate = get_option( 'sliced_translate' );
	$label = isset( $translate['gateway-stripe-label'] ) ? $translate['gateway-stripe-label'] : __( 'Pay with Stripe', 'sliced-invoices');
	return apply_filters( 'sliced_get_gateway_stripe_label', $label );
}


/**
 * Calls the class.
 */
function sliced_call_stripe_class() {
    new Sliced_Stripe();
}
add_action( 'init', 'sliced_call_stripe_class' );


/** 
 * The Class.
 */
class Sliced_Stripe {

	/**
     * @var  object  Instance of this class
     */
    protected static $instance;
	
	/**
     * @var  string  unique prefix for this gateway
     */
	protected $prefix = 'sliced-stripe';
	
	/**
     * @var  string  unique slug for this gateway
     */
	protected $slug   = 'sliced_stripe';
	

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
	
		global $pagenow;
		
		if ( ! $this->validate_settings() ) {
			return;
		}

        add_filter( 'sliced_payment_option_fields', array( $this, 'add_options_fields') );
        add_filter( 'sliced_get_accepted_payment_methods', array( $this, 'add_payment_method') );
		add_filter( 'sliced_get_invoice_payment_methods', array( $this, 'check_payment_method' ) );
		add_filter( 'sliced_translate_option_fields', array( $this, 'add_translate_options' ) );
		add_action( 'script_loader_tag', array( $this, 'add_defer_attribute' ) );
        add_action( 'sliced_payment_head', array( $this, 'enqueue_payment_scripts') );
        add_action( 'sliced_do_payment', array( $this, 'payment_form') );
        add_action( 'sliced_do_payment', array( $this, 'payment_return'), 10 );
		add_action( 'admin_init', array( $this, 'admin_notices' ) );
		
		if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] === 'sliced_invoices_settings' ) {
			add_action( 'admin_head', array( $this, 'admin_inline_css' ) );
		}
 
    }
	
	
	public static function get_instance() {
        if ( ! ( self::$instance instanceof self ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	
	/**
	 * Internal helpers
	 */
	public function _settings_group_before() {
		?>
		<table class="widefat" id="<?php echo $this->prefix; ?>-settings-wrapper">
			<tr id="<?php echo $this->prefix; ?>-settings-header">
				<th class="row-title"><h4><?php _e( 'Stripe Gateway', 'sliced-invoices-stripe' ); ?></h4></th>
				<th class="row-toggle"><span class="dashicons dashicons-arrow-down" id="<?php echo $this->prefix; ?>-settings-toggle"></span></th>
			</tr>
			<tr id="<?php echo $this->prefix; ?>-settings" style="display:none;">
				<td colspan="2">
		<?php
	}
	public function _settings_group_after() {
		?>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			jQuery('#<?php echo $this->prefix; ?>-settings-header').click(function(){
				var settingsElem = jQuery('#<?php echo $this->prefix; ?>-settings');
				var toggleElem = jQuery('#<?php echo $this->prefix; ?>-settings-toggle');
				if ( jQuery(settingsElem).is(':visible') ) {
					jQuery(settingsElem).slideUp();
					jQuery(toggleElem).removeClass('dashicons-arrow-up').addClass('dashicons-arrow-down');
				} else {
					jQuery(settingsElem).slideDown();
					jQuery(toggleElem).removeClass('dashicons-arrow-down').addClass('dashicons-arrow-up');
				}
			});
		</script>
		<?php
	}
	
	
	/**
	 * Fix for cloudflare caching scripts, etc.
	 *
	 * @since   1.3.0
	 */
	public function add_defer_attribute( $tag ) {

		$payments = get_option( 'sliced_payments' );
        if ( is_page( (int)$payments['payment_page'] ) ) {
		
			// array of scripts not to defer
			$scripts_to_defer = array( 'stripe', 'jquery' );
			$attributes_to_remove = array( "async='async'", 'async="async"', "defer='defer'", 'defer="defer"' );

			foreach ( $scripts_to_defer as $defer_script ) {
				if ( true == strpos( $tag, $defer_script ) ) {
					if ( strpos( $tag, 'data-cfasync="false"' ) === false ) {
						$tag = str_replace( ' src', ' data-cfasync="false" src', $tag );
					}
					$tag = str_replace( $attributes_to_remove, '', $tag );
					return $tag;
				}
			}
			
		}

		return $tag;
	}


    /**
     * Add the options for this gateway to the admin payment settings
     */
    public function add_options_fields( $options ) {

		$options['fields'][] = array(
			'name'          => __( 'Enable', 'sliced-invoices-stripe' ),
			'desc'          => '',
			'type'          => 'checkbox',
			'id'            => 'stripe_enabled',
			'before_row'    => array( $this, '_settings_group_before' ),
        );
        $options['fields'][] = array(
                    'name'      => __( 'Stripe Currency', 'sliced-invoices-stripe' ),
                    'desc'      => __( '3 letter code - <a href="https://support.stripe.com/questions/which-currencies-does-stripe-support" target="_blank">Full list of accepted currencies here</a>', 'sliced-invoices-stripe' ),
                    'default'   => 'USD',
                    'type'      => 'text',
                    'id'        => 'stripe_currency',
        );
		$options['fields'][] = array(
                    'name'      => __( 'Country Code', 'sliced-invoices-stripe' ),
                    'desc'      => __( 'Your 2-digit country code', 'sliced-invoices-stripe' ),
					'default'   => 'US',
                    'type'      => 'text',
                    'id'        => 'stripe_apple_pay_country',
		);
        $options['fields'][] = array(
                    'name'      => __( 'Stripe Publishable Key', 'sliced-invoices-stripe' ),
                    'desc'      => __( 'You will find your Secret Key under "Your Account" and then "API Keys".', 'sliced-invoices-stripe' ),
                    'type'      => 'text',
                    'id'        => 'stripe_publishable',
        );
        $options['fields'][] = array(
                    'name'      => __( 'Stripe Secret Key', 'sliced-invoices-stripe' ),
                    'desc'      => __( 'You will find your Secret Key under "Your Account" and then "API Keys".', 'sliced-invoices-stripe' ),
                    'type'      => 'text',
                    'id'        => 'stripe_secret',
        );
		$options['fields'][] = array(
					'name'      => __( 'Optional Settings', 'sliced-invoices' ),
					'desc'      => __( '', 'sliced-invoices' ),
					'default'   => '',
					'id'        => 'stripe_title_optional_settings',
					'type'      => 'title',
		);
        $options['fields'][] = array(
                    'name'      => __( 'Show and require "Name on Card" field', 'sliced-invoices-stripe' ),
                    'type'      => 'checkbox',
                    'id'        => 'stripe_require_name',
        );
        $options['fields'][] = array(
                    'name'      => __( 'Show and require "Zip/Postal Code" field', 'sliced-invoices-stripe' ),
                    'type'      => 'checkbox',
                    'id'        => 'stripe_require_zip',
        );
		$options['fields'][] = array(
					'name'      => __( 'Additional Payment Providers', 'sliced-invoices' ),
					'desc'      => __( '', 'sliced-invoices' ),
					'default'   => '',
					'id'        => 'stripe_title_payment_providers',
					'type'      => 'title',
		);
		$options['fields'][] = array(
                    'name'      => __( 'Enable Apple Pay via Stripe', 'sliced-invoices-stripe' ),
                    'after_field' => '<p class="cmb2-metabox-description" style="clear:both;">' . __( 'Apple Pay must be enabled in your Stripe account, and your domain verified.', 'sliced-invoices-stripe' ) . '</p>',
                    'type'      => 'checkbox',
                    'id'        => 'stripe_apple_pay',
		);
		$options['fields'][] = array(
                    'name'      => __( 'Enable Alipay via Stripe', 'sliced-invoices-stripe' ),
                    'after_field' => '<p class="cmb2-metabox-description" style="clear:both;">' . __( 'Alipay must be enabled in your Stripe account. Only supports payments in AUD, CAD, EUR, GBP, HKD, JPY, NZD, SGD, or USD. Users in Denmark, Norway, Sweden, or Switzerland must use EUR.', 'sliced-invoices-stripe' ) . '</p>',
                    'type'      => 'checkbox',
                    'id'        => 'stripe_alipay',
		);
		$options['fields'][] = array(
                    'name'      => __( 'Enable Bancontact via Stripe', 'sliced-invoices-stripe' ),
                    'after_field' => '<p class="cmb2-metabox-description" style="clear:both;">' . __( 'Bancontact must be enabled in your Stripe account. Only supports payments in EUR.', 'sliced-invoices-stripe' ) . '</p>',
                    'type'      => 'checkbox',
                    'id'        => 'stripe_bancontact',
		);
		$options['fields'][] = array(
                    'name'      => __( 'Enable Giropay via Stripe', 'sliced-invoices-stripe' ),
                    'after_field' => '<p class="cmb2-metabox-description" style="clear:both;">' . __( 'Giropay must be enabled in your Stripe account. Only supports payments in EUR.', 'sliced-invoices-stripe' ) . '</p>',
                    'type'      => 'checkbox',
                    'id'        => 'stripe_giropay',
		);
		$options['fields'][] = array(
                    'name'      => __( 'Enable iDEAL via Stripe', 'sliced-invoices-stripe' ),
                    'after_field' => '<p class="cmb2-metabox-description" style="clear:both;">' . __( 'iDEAL must be enabled in your Stripe account. Only supports payments in EUR.', 'sliced-invoices-stripe' ) . '</p>',
                    'type'      => 'checkbox',
                    'id'        => 'stripe_ideal',
					'after_row' => array( $this, '_settings_group_after' ),
		);
		/* P24 pending official Stripe support (still in "preview" status as of 2017-11-12)
		$options['fields'][] = array(
                    'name'      => __( 'Enable P24 via Stripe', 'sliced-invoices-stripe' ),
                    'after_field' => '<p class="cmb2-metabox-description" style="clear:both;">' . __( 'Przelewy24 must be enabled in your Stripe account. Only supports payments in EUR or PLN.', 'sliced-invoices-stripe' ) . '</p>',
                    'type'      => 'checkbox',
                    'id'        => 'stripe_p24',
					'after_row' => array( $this, '_settings_group_after' ),
		);
		*/

        return $options;

    }


    /**
     * Add this gateway to the list of registered payment methods
     */
    public function add_payment_method( $pay_array ) {

        $payments = get_option( 'sliced_payments' );
        if ( ! empty( $payments['stripe_enabled'] ) ) {
            $pay_array['stripe'] = 'Stripe';
        }
        return $pay_array;

    }
	
	
	/**
	 * Add the options for this gateway to the translate settings.
	 *
	 * @since   1.1.3
	 */
	public function add_translate_options( $options ) {
	
		if ( class_exists( 'Sliced_Translate' ) ) {

			// add fields to end of options array
			$options['fields'][] = array(
				'name'      => __( 'Stripe Gateway', 'sliced-invoices-translate' ),
				'desc'      => '',
				'id'        => 'translate_stripe_title',
				'type'      => 'title',
			);
			$options['fields'][] = array(
				'name'      => __( 'Pay with Stripe', 'sliced-invoices-translate' ),
				'desc'      => __( '', 'sliced-invoices-stripe' ),
				'default'   => '',
				'type'      => 'text',
				'id'        => 'gateway-stripe-label',
				'attributes' => array(
					'class'      => 'i18n-multilingual regular-text',
				),
			);
		
		}

		return $options;

	}
	
	
	/**
     * Add inline css to admin area.
     *
     * @since 1.5.0
     */
    public function admin_inline_css() {
        ?>
		<style type="text/css">
			#<?php echo $this->prefix; ?>-settings-wrapper {
			}
			#<?php echo $this->prefix; ?>-settings-header {
				background: #f8f8f8 none repeat scroll 0 0;
				border: 1px solid #e5e5e5;
				border-radius: 3px;
				margin: 10px 20px;
				padding: 15px 25px 15px 12px;
			}
			#<?php echo $this->prefix; ?>-settings-header th {
				cursor: pointer;
				padding-bottom: 10px;
			}
			#<?php echo $this->prefix; ?>-settings-header .row-toggle {
				text-align: right;
			}
			#<?php echo $this->prefix; ?>-settings-header .row-title {
				padding: 0 20px 0 20px;
			}
			#<?php echo $this->prefix; ?>-settings > td {
				padding-left: 40px;
			}
		</style>
		<?php
    }
	
	
	/**
     * Admin notices for various things...
     *
     * @since   1.4.0
     */
	public function admin_notices() {
		
		// check just in case we're on < Sliced Invoices v3.5.0
		if ( class_exists( 'Sliced_Admin_Notices' ) ) {
		
			// placeholder for future notices
			
		}
		
	}
	
	public function admin_notices_clear( $exclude = '' ) {
	
		// check just in case we're on < Sliced Invoices v3.5.0
		if ( class_exists( 'Sliced_Admin_Notices' ) ) {
		
			$notices = array(
				'sliced_stripe_old_vendor_library',
			);
		
			foreach ( $notices as $notice ) {
				if ( Sliced_Admin_Notices::has_notice( $notice ) && $notice !== $exclude ) {
					Sliced_Admin_Notices::remove_notice( $notice );
				}
			}
			
		}
		
	}
	
	
	/**
	 * Cancel subscription invoice payments
	 *
	 * @since   1.3.0
	 */
	public function cancel_subscription( $id, $gateway_subscr_id ) {
		
		$this->load_vendor_library();
		
		try {
			$sub = \Stripe\Subscription::retrieve( $gateway_subscr_id );
			$sub->cancel();
			return array(
				'status'  => 'success',
				'message' => sprintf( __( 'Subscription %s cancelled', 'sliced-invoices-stripe' ), $gateway_subscr_id ),
			);
		} catch (Exception $e) {
            // Something happened, return error message
            $message = $e->getMessage();
			return array(
				'status'  => 'error',
				'message' => sprintf( __( 'Gateway says: %s', 'sliced-invoices-stripe' ), $message ),
			);
        }
		
	}
	
	
	/**
     * Make sure this invoice can be paid by this gateway
     *
     * @since   1.7.1
     */
    public function check_payment_method( $pay_array ) {

		$remove = false;
		
        $payments = get_option( 'sliced_payments' );
        if ( 
			empty( $payments['stripe_enabled'] ) ||
			empty( $payments['stripe_secret'] ) ||
			empty( $payments['stripe_publishable'] ) ||
			empty( $payments['stripe_currency'] )
		) {
			$remove = true;
        }
		
		if ( $remove ) {
			if( ! empty( $pay_array[0] ) ) {
				$index = false;
				foreach( $pay_array[0] as $key => $value ) {
					if ( $value === 'stripe' ) { $index = $key; }
				}
				if ( $index ) {
					unset( $pay_array[0][$index] );
				}
			}
		}
		
        return $pay_array;

    }
	
	
	/**
     * Create stripe customer record
	 *
	 * @since   1.3.0
     */
	public function create_customer( $id, $token ) {
	
		$this->load_vendor_library();

		$client_id      = get_post_meta( $id, '_sliced_client', true );
		$client_email   = sliced_get_client_email( $id );

		$customer = \Stripe\Customer::create(
			apply_filters( 'sliced_stripe_customer_create_args',
				array(
					'description' => __( sprintf( 'Customer for %s', $client_email ), 'sliced-invoices-stripe' ),
					'email'       => $client_email,
					'metadata'    => array(
						'sliced_invoice_id' => $id,
					),
					'source'      => $token,
				)
			)
		);
		
		update_user_meta( $client_id, '_sliced_stripe_id', $customer['id'] );

		return $customer['id'];
	}


    /**
     * Register the Stripe script.
     *
     * @since    1.0.0
     */
    public function enqueue_payment_scripts() {
        wp_register_script( 'stripe', 'https://js.stripe.com/v2/', array( 'jquery' ) );
        wp_print_scripts( 'stripe' );

        wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
        wp_print_styles( 'fontawesome' );

        $inline = '<style>';
        $inline .= ".stripe .btn {
				display: inline-block;
				width: 100%;
				text-align: center;
				border: none;
				padding: 15px;
				margin: 15px 0;
				font-size: 20px;
				background: rgb(66,173,230); /* Old browsers */
				background: -moz-linear-gradient(top,  rgba(66,173,230,1) 0%, rgba(47,125,194,1) 100%); /* FF3.6-15 */
				background: -webkit-linear-gradient(top,  rgba(66,173,230,1) 0%,rgba(47,125,194,1) 100%); /* Chrome10-25,Safari5.1-6 */
				background: linear-gradient(to bottom,  rgba(66,173,230,1) 0%,rgba(47,125,194,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#42ade6', endColorstr='#2f7dc2',GradientType=0 ); /* IE6-9 */
			}
			#sliced-stripe-apple-pay-button {
				display: none;
				background-color: black;
				background-image: -webkit-named-image(apple-pay-logo-white);
				background-size: 100% 100%;
				background-origin: content-box;
				background-repeat: no-repeat;
				width: 100%;
				height: 44px;
				padding: 10px 0;
				border: none;
				border-radius: 10px;
			}
			.sliced-stripe-methods {
				list-style: none;
				margin: 0 0 1.5em;
				padding: 0;
			}
			.sliced-stripe-method-header {
				background-color: #f0f0f0;
				border-bottom: 1px solid #e8e8e8;
				padding: 16px;
				width: 100%;
			}
			.sliced-stripe-method-header img {
				float: right;
				max-height: 36px;
				width: auto;
			}
			.sliced-stripe-method-header label {
				cursor: pointer;
				margin-top: 5px;
			}
			.sliced-stripe-method-inner {
				clear: both;
				border: 1px solid #f0f0f0;
			}
			.sliced-stripe-method-inner .form-group {
				padding-left: 15px;
				padding-right: 15px;
			}
			.sliced-stripe-method-inner .form-group:first-child {
				padding-top: 15px;
			}
			.sliced-stripe-method-inner .form-group:last-child {
				padding-bottom: 15px;
			}
        ";
        $inline .= '</style>';
        echo $inline;
    }


    public function gateway() {
        $payments = get_option( 'sliced_payments' );
        $gateway = array(
            'currency'          => $payments['stripe_currency'],
			'country'           => $payments['stripe_apple_pay_country'],
            'secret'            => $payments['stripe_secret'],
            'publishable'       => $payments['stripe_publishable'],
            'payment_page'      => esc_url( get_permalink( (int)$payments['payment_page'] ) ),
            'cancel_page'       => esc_url( get_permalink( (int)$payments['payment_page'] ) ),
			'require_name'      => isset( $payments['stripe_require_name'] ) ? $payments['stripe_require_name'] : false,
			'require_zip'       => isset( $payments['stripe_require_zip'] ) ? $payments['stripe_require_zip'] : false,
			'apple_pay'         => isset( $payments['stripe_apple_pay'] ) ? $payments['stripe_apple_pay'] : false,
			'alipay'            => isset( $payments['stripe_alipay'] ) ? $payments['stripe_alipay'] : false,
			'bancontact'        => isset( $payments['stripe_bancontact'] ) ? $payments['stripe_bancontact'] : false,
			'giropay'           => isset( $payments['stripe_giropay'] ) ? $payments['stripe_giropay'] : false,
			'ideal'             => isset( $payments['stripe_ideal'] ) ? $payments['stripe_ideal'] : false,
			'p24'               => isset( $payments['stripe_p24'] ) ? $payments['stripe_p24'] : false,
        );
        return $gateway;
    }

	
	/**
	 * Helper to convert billing period value into the specific value needed by this gateway
	 *
	 * @since   1.3.0
	 */
	public function get_billing_period( $input ) {
		switch ( $input ) {
			case 'days':
				$output = 'day';
				break;
			case 'months':
				$output = 'month';
				break;
			case 'years':
				$output = 'year';
				break;
			default:
				$output = 'month';
		}
		return $output;
	}
	
	
	/**
	 * Helper to convert trial period value into the specific value needed by this gateway
	 *
	 * @since   1.3.0
	 */
	public function get_trial_days( $id ) {
		if ( get_post_meta( $id, '_sliced_subscription_trial', true ) != '1' ) {
			return 0;
		}
		$trial_billing_period = get_post_meta( $id, '_sliced_subscription_trial_interval_type', true );
		$trial_billing_frequency = (int) get_post_meta( $id, '_sliced_subscription_trial_interval_number', true );
		$trial_total_billing_cycles = (int) get_post_meta( $id, '_sliced_subscription_trial_cycles_count', true );
		$days = 0;
		switch ( $trial_billing_period ) {
			case 'days':
				$days = $trial_billing_frequency;
				break;
			case 'months':
				$days = $trial_billing_frequency * 30;
				break;
			case 'years':
				$days = $trial_billing_frequency * 365;
				break;
		}
		if ( $trial_total_billing_cycles > 1 ) {
			$days = $days * $trial_total_billing_cycles;
		}
		return $days;
	}
	
	
	/**
	 * Load vendor library when called, or throw error if in incompatible version is already loaded
	 *
	 * @since   1.7.1
	 */
	public function load_vendor_library() {
		
		if ( class_exists( '\Stripe\Stripe' ) ) {
			
			if ( version_compare( \Stripe\Stripe::VERSION, '4.4.2', '<' ) ) {
				
				if ( class_exists( 'Sliced_Admin_Notices' ) ) {
						
					if ( ! Sliced_Admin_Notices::has_notice( 'sliced_stripe_old_vendor_library' ) ) {
						$notice_args = array(
							'class' => 'notice-error',
							'content' => '<p>' . __( 'Sliced Invoices Stripe Gateway recently detected an outdated version of the Stripe library being loaded on your site, possibly from one of your other plugins. This blocked Sliced Invoices from loading a more recent version.  As a result, Stripe payments may not work properly.  Please check your plugins to make sure they are updated, and/or deactivate any older Stripe gateways you are no longer using.', 'sliced-invoices-stripe' ) . '</p>',
							'dismissable' => true,
							'dismiss_permanent' => '1',
						);
						Sliced_Admin_Notices::add_custom_notice( 'sliced_stripe_old_vendor_library', $notice_args );
					}
					
				}
				
			}
			
		} else {
		
			require_once plugin_dir_path( __FILE__ ) . 'includes/stripe-php-master/init.php' ;

			Sliced_Admin_Notices::remove_notice( 'sliced_stripe_old_vendor_library' );
			
		}
		
		$gateway = $this->gateway();
		
        \Stripe\Stripe::setApiKey( $gateway['secret'] );
		\Stripe\Stripe::setApiVersion("2017-02-14");
		\Stripe\Stripe::setAppInfo("Sliced Invoices", SLICED_VERSION, "https://slicedinvoices.com");
		
	}


    /**
     * Show the Stripe form
     */
    public function payment_form() {

        if ( empty( $_POST ) )
            return;

        // if we have POSTED from the invoice payment popup
        if ( ! isset( $_POST['start-payment'] ) )
            return;

        if ( $_POST['sliced_gateway'] != 'stripe' ) {
            // return and look for another payment gateway
            return;
        }
		
		$id = (int) $_POST['sliced_payment_invoice_id'];

        // check the nonce
        if( ! isset( $_POST['sliced_payment_nonce'] ) || ! wp_verify_nonce( $_POST['sliced_payment_nonce'], 'sliced_invoices_payment' ) ) {
            sliced_print_message( $id, __( 'There was an error with the form submission, please try again.', 'sliced-invoices-stripe' ), 'error' );
            return;
        }

        $gateway             = $this->gateway();
		$currency            = sliced_get_invoice_currency( $id );
		$currency_code       = $currency && $currency !== 'default' ? $currency : $gateway['currency'];
		$currency_exp        = Sliced_Shared::currency_exponent( $currency_code );
		$payments            = get_option( 'sliced_payments' );
		$payments_url        = esc_url( get_permalink( (int)$payments['payment_page'] ) );
		$subscription_status = get_post_meta( $id, '_sliced_subscription_status', true );
		$totals              = Sliced_Shared::get_totals( $id );
		
		$stripe_sources = array( 'card' => __( 'Credit Card', 'sliced-invoices-stripe' ) );
		if ( $gateway['alipay'] && in_array( $currency_code, array( 'AUD', 'CAD', 'EUR', 'GBP', 'HKD', 'JPY', 'NZD', 'SGD', 'USD' ) ) && $subscription_status !== 'pending' ) {
			$stripe_sources['alipay'] = __( 'Alipay', 'sliced-invoices-stripe' );
		}
		if ( $gateway['bancontact'] && $currency_code === 'EUR' && $subscription_status !== 'pending' ) {
			$stripe_sources['bancontact'] = __( 'Bancontact', 'sliced-invoices-stripe' );
		}
		if ( $gateway['giropay'] && $currency_code === 'EUR' && $subscription_status !== 'pending' ) {
			$stripe_sources['giropay'] = __( 'Giropay', 'sliced-invoices-stripe' );
		}
		if ( $gateway['ideal'] && $currency_code === 'EUR' && $subscription_status !== 'pending' ) {
			$stripe_sources['ideal'] = __( 'iDEAL payment', 'sliced-invoices-stripe' );
		}
		if ( $gateway['p24'] && ( $currency_code === 'EUR' || $currency_code === 'PLN' ) && $subscription_status !== 'pending' ) {
			$stripe_sources['p24'] = __( 'Przelewy24', 'sliced-invoices-stripe' );
		}

        ?>

        <div class="sliced_payment_form stripe">
		
		<div class="sliced-message message">
			<span><?php printf( __( '%s nummer', 'sliced-invoices-stripe' ), sliced_get_invoice_label() ); ?>:</span> <?php esc_html_e( sliced_get_invoice_prefix() ); ?><?php esc_html_e( sliced_get_invoice_number() ); ?><br />
			<span><?php printf( __( '%s beløb', 'sliced-invoices-stripe' ), sliced_get_invoice_label() ); ?>:</span> <?php echo Sliced_Shared::get_formatted_currency( $totals['total'], $id ); ?>
			<?php do_action( 'sliced_payment_message' ); ?>
		</div>

        <form action="" method="POST" id="payment-form" autocomplete="on">
            
            <span class="sliced-message error" style="display:none;"></span>
			
			<?php do_action( 'sliced_payment_inline_before_form_fields' ); ?>
			
			<div class="form-group">
				<button id="sliced-stripe-apple-pay-button" type="button"></button>
			</div>
			
			<ul class="sliced-stripe-methods">
			
				<?php foreach ( $stripe_sources as $type => $label ): ?>
				
					<li class="sliced-stripe-method" data-type="<?php echo $type; ?>">
					
						<?php if ( count( $stripe_sources ) > 1 ): ?>
						<div class="sliced-stripe-method-header">
							<input type="radio" name="payment_type" id="payment-<?php echo $type; ?>" value="<?php echo $type; ?>" <?php echo ( $type === 'card' ? 'checked' : '' ); ?>> <label for="payment-<?php echo $type; ?>"><?php echo $label; ?></label>
							<?php if ( $type === 'card' ): ?>
							<img src="<?php echo plugins_url( '/accept-cards.png', __FILE__ ); ?>" alt="Credit Card">
							<?php endif; ?>
							<?php if ( $type === 'alipay' ): ?>
							<img src="<?php echo plugins_url( '/accept-alipay.png', __FILE__ ); ?>" alt="Alipay">
							<?php endif; ?>
							<?php if ( $type === 'bancontact' ): ?>
							<img src="<?php echo plugins_url( '/accept-bancontact.png', __FILE__ ); ?>" alt="Bancontact">
							<?php endif; ?>
							<?php if ( $type === 'giropay' ): ?>
							<img src="<?php echo plugins_url( '/accept-giropay.png', __FILE__ ); ?>" alt="Giropay">
							<?php endif; ?>
							<?php if ( $type === 'ideal' ): ?>
							<img src="<?php echo plugins_url( '/accept-ideal.png', __FILE__ ); ?>" alt="iDEAL payment">
							<?php endif; ?>
							<?php if ( $type === 'p24' ): ?>
							<img src="<?php echo plugins_url( '/accept-p24.png', __FILE__ ); ?>" alt="Przelewy24">
							<?php endif; ?>
						</div>
						
						<div class="sliced-stripe-method-inner" <?php echo ( $type !== 'card' ? 'style="display:none;"' : '' ); ?>>
						<?php endif; ?>

							<?php if ( $type === 'card' ): ?>
							<div class="form-group">
								<label><?php _e( 'Kortnummer', 'sliced-invoices-stripe' ); ?></label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i></div>
									<input id="cardnumber" type="text" size="20" data-stripe="number" class="form-control" placeholder="Card Number" autocomplete="cc-number" required />
								</div>
							</div>

							<div class="form-group">
								<label><?php _e( 'CVC', 'sliced-invoices-stripe' ); ?></label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-lock fa-fw"></i></div>
									<input id="cc-csc" type="text" size="4" data-stripe="cvc" class="form-control" placeholder="CVC" autocomplete="off" required />
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 pad-right">
										<label><?php _e( 'Udløbs måned', 'sliced-invoices-stripe' ); ?></label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i></div>
											<input id="exp-month" type="text" size="2" data-stripe="exp-month" class="form-control" placeholder="mm" autocomplete="cc-exp-month" required />
										</div>
									</div>
									<div class="col-xs-6">
										<label><?php _e( 'Udløbs år', 'sliced-invoices-stripe' ); ?></label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i></div>
											<input id="exp-year" type="text" size="4" data-stripe="exp-year" class="form-control" placeholder="yyyy" autocomplete="cc-exp-year" required />
										</div>
									</div>
								</div>
							</div>
							
								<?php if ( $gateway['require_name'] ): ?>
								<div class="form-group">
									<label><?php _e( 'Name on Card', 'sliced-invoices-stripe' ); ?></label>
									<div class="input-group">
										<div class="input-group-addon"><i class="fa fa-lock fa-fw"></i></div>
										<input id="name" type="text" size="4" data-stripe="name" class="form-control" placeholder="Name on Card" autocomplete="off" required />
									</div>
								</div>
								<?php endif; ?>
							
								<?php if ( $gateway['require_zip'] ): ?>
								<div class="form-group">
									<label><?php _e( 'Billing Zip/Postal Code', 'sliced-invoices-stripe' ); ?></label>
									<div class="input-group">
										<div class="input-group-addon"><i class="fa fa-lock fa-fw"></i></div>
										<input id="address_zip" type="text" size="4" data-stripe="address_zip" class="form-control" placeholder="Zip/Postal Code" autocomplete="off" required />
									</div>
								</div>
								<?php endif; ?>
								
							<?php endif; ?>
							
							<?php if ( $type === 'ideal' ): ?>
							<div class="form-group">
								&nbsp;<br />
								<label>Bank</label>
								<select id="iDEAL_BANK" name="iDEAL_BANK" class="form-control">
									<option></option>
									<option value="abn_amro">ABN Amro</option>
									<option value="asn_bank">ASN Bank</option>
									<option value="bunq">Bunq</option>
									<option value="ing">ING</option>
									<option value="knab">Knab</option>
									<option value="rabobank">Rabobank</option>
									<option value="regiobank">Regiobank</option>
									<option value="sns_bank">SNS Bank</option>
									<option value="triodos_bank">Triodos Bank</option>
									<option value="van_lanschot">Van Lanschot</option>
								</select>
							</div>
							<?php endif; ?>
							
						<?php if ( count( $stripe_sources ) > 1 ): ?>
						</div>
						<?php endif; ?>
					</li>
				
				<?php endforeach; ?>
				
			</ul>

            <div class="form-group">
				<input type="hidden" name="sliced_payment_invoice_id" value="<?php echo $id; ?>" />
                <button type="submit" class="btn btn-success btn-lg"><?php
					if ( $subscription_status === 'pending' ) {
						_e( 'Confirm subscription', 'sliced-invoices-stripe' );
					} else {
						printf( __( 'Godkend %s', 'sliced-invoices-stripe' ), sliced_get_invoice_total_due( $id ) );
					}
				?></button>
            </div>
			
			<?php do_action( 'sliced_payment_inline_after_form_fields' ); ?>

        </form>
		
		<div class="gateway-image" id="sliced_gateway_image">
			<?php echo apply_filters( 'sliced_stripe_gateway_image', '' ); ?>
		</div>

        </div>

        <script type="text/javascript">

            // This identifies your website in the createToken call below
            Stripe.setPublishableKey( '<?php echo $gateway['publishable'] ?>' );
			
			<?php if ( $gateway['apple_pay'] ): ?>
			/*
			 * begin apple pay
			 */
			Stripe.applePay.checkAvailability(function(available) {
			  if (available) {
				document.getElementById('sliced-stripe-apple-pay-button').style.display = 'block';
			  }
			});
			document.getElementById('sliced-stripe-apple-pay-button').addEventListener('click', beginApplePay);
			
			function beginApplePay() {
			  var paymentRequest = {
				countryCode: '<?php echo ( $gateway['country'] );?>',
				currencyCode: '<?php echo $currency_code; ?>',
				total: {
				  label: '<?php echo __( 'Invoice', 'sliced-invoices' ) . ' ' . esc_html( sliced_get_invoice_prefix() ) . esc_html( sliced_get_invoice_number() ); ?>',
				  amount: '<?php echo sliced_get_invoice_total_due_raw( $id ); ?>'
				}
			  };
			  var session = Stripe.applePay.buildSession(paymentRequest,
				function(result, completion) {
				/*
				completion(ApplePaySession.STATUS_SUCCESS);
				var $form = $('#payment-form');
				$form.append($('<input type="hidden" name="stripeToken" />').val(result.token.id));
                $form.get(0).submit();
				*/
				jQuery.post('<?php echo $payments_url; ?>', {
						sliced_payment_invoice_id: "<?php echo $id; ?>",
						stripeToken: result.token.id,
						sliced_stripe_applepay: "auth"
					}).done(function() {
				  completion(ApplePaySession.STATUS_SUCCESS);
				  // You can now redirect the user to a receipt page, etc.
				  window.location.href = '<?php echo add_query_arg( array( 
					'sliced_stripe_applepay' => 'success',
					'sliced_payment_invoice_id' => $id,
				  ), $payments_url ); ?>';
				}).fail(function() {
				  completion(ApplePaySession.STATUS_FAILURE);
				});

			  }, function(error) {
				console.log(error.message);
			  });

			  session.oncancel = function() {
				console.log("User hit the cancel button in the payment window");
			  };

			  session.begin();
			}
			// end apple pay
			<?php endif; ?>
			
			<?php if ( isset( $stripe_sources['alipay'] ) ): ?>
			/*
			 * begin Alipay
			 */
			function slicedBeginAlipay() {
				var args = {
					type: 'alipay',
					amount: <?php echo sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ); ?>,
					currency: '<?php echo strtolower( $currency_code ); ?>',
					redirect: {
						return_url: '<?php echo add_query_arg( array( 
							'sliced_stripe_alipay' => '1',
							'sliced_payment_invoice_id' => $id,
						  ), $payments_url ); ?>',
					}
				}
				Stripe.source.create(args, stripeResponseHandler);
			}
			// end Alipay
			<?php endif; ?>
			
			<?php if ( isset( $stripe_sources['bancontact'] ) ): ?>
			/*
			 * begin Bancontact
			 */
			function slicedBeginBancontact() {
				var args = {
					type: 'bancontact',
					amount: <?php echo sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ); ?>,
					currency: 'eur',
					owner: {
						name: '<?php echo sliced_get_client_business($id); ?>'
					},
					redirect: {
						return_url: '<?php echo add_query_arg( array( 
							'sliced_stripe_bancontact' => '1',
							'sliced_payment_invoice_id' => $id,
						  ), $payments_url ); ?>',
					},
					statement_descriptor: '<?php echo 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) . sliced_get_invoice_suffix($id); ?>'
				}
				Stripe.source.create(args, stripeResponseHandler);
			}
			// end Bancontact
			<?php endif; ?>
			
			<?php if ( isset( $stripe_sources['giropay'] ) ): ?>
			/*
			 * begin Giropay
			 */
			function slicedBeginGiropay() {
				var args = {
					type: 'giropay',
					amount: <?php echo sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ); ?>,
					currency: 'eur',
					owner: {
						name: '<?php echo sliced_get_client_business($id); ?>'
					},
					redirect: {
						return_url: '<?php echo add_query_arg( array( 
							'sliced_stripe_giropay' => '1',
							'sliced_payment_invoice_id' => $id,
						  ), $payments_url ); ?>',
					},
					statement_descriptor: '<?php echo 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) . sliced_get_invoice_suffix($id); ?>'
				}
				Stripe.source.create(args, stripeResponseHandler);
			}
			// end Giropay
			<?php endif; ?>
			
			<?php if ( isset( $stripe_sources['ideal'] ) ): ?>
			/*
			 * begin iDEAL
			 */
			function slicedBeginIdeal() {
				var args = {
					type: 'ideal',
					amount: <?php echo sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ); ?>,
					currency: 'eur',
					redirect: {
						return_url: '<?php echo add_query_arg( array( 
							'sliced_stripe_ideal' => '1',
							'sliced_payment_invoice_id' => $id,
						  ), $payments_url ); ?>',
					},
					statement_descriptor: '<?php echo 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) . sliced_get_invoice_suffix($id); ?>'
				}
				var bank = jQuery('#iDEAL_BANK').val();
				if ( bank > '' ) {
					args.ideal = { 'bank': bank };
				}
				Stripe.source.create(args, stripeResponseHandler);
			}
			// end iDEAL
			<?php endif; ?>
			
			<?php if ( isset( $stripe_sources['p24'] ) ): ?>
			/*
			 * begin P24
			 */
			function slicedBeginP24() {
				var args = {
					type: 'p24',
					amount: <?php echo sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ); ?>,
					currency: '<?php echo strtolower( $currency_code ); ?>',
					owner: {
						name: '<?php echo sliced_get_client_business($id); ?>',
						email: '<?php echo sliced_get_client_email($id); ?>'
					},
					redirect: {
						return_url: '<?php echo add_query_arg( array( 
							'sliced_stripe_p24' => '1',
							'sliced_payment_invoice_id' => $id,
						  ), $payments_url ); ?>',
					},
					statement_descriptor: '<?php echo 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) . sliced_get_invoice_suffix($id); ?>'
				}
				Stripe.source.create(args, stripeResponseHandler);
			}
			// end P24
			<?php endif; ?>
          
            jQuery(function($) {
				
				$('input[name=payment_type]').change(function(){
					var paymentType = $(this).val();
					var $cardFields = $('#cardnumber, #cc-csc, #exp-month, #exp-year, #name, #address_zip')
					$('.sliced-stripe-method').each(function(){
						if ( $(this).data('type') === paymentType ) {
							$(this).children('.sliced-stripe-method-inner').slideDown();
						} else {
							$(this).children('.sliced-stripe-method-inner').slideUp();
						}
					});
					if ( paymentType === 'card' ) {
						$($cardFields).attr('required', true);
					} else {
						$($cardFields).attr('required', false);
					}
				});
				
                $('#payment-form').submit(function(event) {
					event.preventDefault();
					
                    var $form = $(this);
					var paymentType = $('input[name=payment_type]:checked').val();
					
                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

					if ( paymentType === 'alipay' ) {
						slicedBeginAlipay();
					} else if ( paymentType === 'bancontact' ) {
						slicedBeginBancontact();
					} else if ( paymentType === 'giropay' ) {
						slicedBeginGiropay();
					} else if ( paymentType === 'ideal' ) {
						slicedBeginIdeal();
					} else if ( paymentType === 'p24' ) {
						slicedBeginP24();
					} else {
						Stripe.card.createToken($form, stripeResponseHandler);
					}

                    // Prevent the form from submitting with the default action
                    return false;
                });

                window.stripeResponseHandler = function(status, response) {
                    var $form = $('#payment-form');

                    if (response.error) {
                        // Show the errors on the form
                        $('.error').show();
                        $form.find('.sliced-message').text(response.error.message);
                        $form.find('button').prop('disabled', false);
                    } else {
                        // response contains id and card, which contains additional card details
                        var token = response.id;
                        // Insert the token into the form so it gets submitted to the server
                        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
						// do we need to redirect?
						if ( typeof ( response.redirect ) !== "undefined" ) {
							window.location.href = response.redirect.url;
						} else {
							// otherwise, submit
							$form.get(0).submit();
						}
                    }
                };

            });
        </script>

    <?php
    }


    /**
     * complete the purchase
     */
    public function payment_return() {
	
		// is this a Stripe webhook?
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && substr( $_SERVER['HTTP_USER_AGENT'], 0, 6 ) === 'Stripe' ) {
			$this->process_webhook();
			return;
		}
		
		// apple pay confirmation message
		if ( isset( $_GET['sliced_stripe_applepay'] ) && $_GET['sliced_stripe_applepay'] === 'success' ) {
			$id = (int) $_GET['sliced_payment_invoice_id'];
			$status  = 'success';
            $message = '<h2>' . __( 'Success', 'sliced-invoices-stripe' ) .'</h2>';
            $message .= '<p>';
			$message .= __( 'Payment has been received!', 'sliced-invoices-stripe' ) . '<br>';
			//$message .= sprintf( __( 'Payment of %s has been received!', 'sliced-invoices-stripe' ), sliced_get_invoice_total($id) ) . '<br>';
			//$message .= __( 'The Stripe charge ID is ', 'sliced-invoices-stripe' ) . $charge['id'];
            $message .= '</p>';
            $message .= '<p>';
            $message .= sprintf( __( '<a href="%1s">Click here to return to %s</a>', 'sliced-invoices-stripe' ), apply_filters( 'sliced_get_the_link', get_permalink($id), $id ), sliced_get_invoice_label() );
            $message .= '</p>';
			sliced_print_message( $id, $message, $status );
			return;
		}
		
		$token = false;
		
		if (
			( isset( $_GET['sliced_stripe_alipay'] ) && isset( $_GET['source'] ) ) ||
			( isset( $_GET['sliced_stripe_bancontact'] ) && isset( $_GET['source'] ) ) ||
			( isset( $_GET['sliced_stripe_giropay'] ) && isset( $_GET['source'] ) ) ||
			( isset( $_GET['sliced_stripe_ideal'] ) && isset( $_GET['source'] ) ) ||
			( isset( $_GET['sliced_stripe_p24'] ) && isset( $_GET['source'] ) )
		) {
			// alipay, bancontact, giropay, ideal, or p24 payment
			$token = esc_html( $_GET['source'] );
			$id    = (int) $_GET['sliced_payment_invoice_id'];
		} elseif ( isset( $_POST['stripeToken'] ) ) {
			// card payment
			$token = esc_html( $_POST['stripeToken'] );
			$id    = (int) $_POST['sliced_payment_invoice_id'];
		}
        
        //check for token back from stripe
        if ( ! $token ) {
            return;
		}

        // get some data
        $gateway        = $this->gateway();
		$currency       = sliced_get_invoice_currency( $id );
		$currency_code  = $currency && $currency !== 'default' ? $currency : $gateway['currency'];
		$currency_exp   = Sliced_Shared::currency_exponent( $currency_code );

        // include Stripe
		$this->load_vendor_library();

        // set the start of the error message as a default. Overwritten if success
        $status = 'failed';
        $message = '<strong>Error!</strong> ';

        // start the charge 
        try {
			
			if ( isset( $_POST['sliced_stripe_applepay'] ) && $_POST['sliced_stripe_applepay'] === "auth" ) {
				
				// apple pay charge
				$charge = \Stripe\Charge::create(
					apply_filters( 'sliced_stripe_charge_create_args',
						array(
							'amount'      => sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ),
							'currency'    => $currency_code,
							'metadata'    => array(
								'sliced_invoice_id' => $id,
							),
							'source'      => $token,
							'description' => 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) . sliced_get_invoice_suffix($id),
						)
					)
				);
				
			} elseif ( 
				( isset( $_GET['sliced_stripe_alipay'] ) && $_GET['sliced_stripe_alipay'] === "1" ) ||
				( isset( $_GET['sliced_stripe_bancontact'] ) && $_GET['sliced_stripe_bancontact'] === "1" ) ||
				( isset( $_GET['sliced_stripe_giropay'] ) && $_GET['sliced_stripe_giropay'] === "1" ) ||
				( isset( $_GET['sliced_stripe_ideal'] ) && $_GET['sliced_stripe_ideal'] === "1" ) ||
				( isset( $_GET['sliced_stripe_p24'] ) && $_GET['sliced_stripe_p24'] === "1" )
			) {
				
				// Alipay, Bancontact, Giropay, iDEAL, or P24 charge
				$charge = \Stripe\Charge::create(
					apply_filters( 'sliced_stripe_charge_create_args',
						array(
							'amount'      => sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ),
							'currency'    => strtolower( $currency_code ),
							'metadata'    => array(
								'sliced_invoice_id' => $id,
							),
							'source'      => $token,
							'description' => 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) . sliced_get_invoice_suffix($id),
						)
					)
				);
				
			} else {
			
				// get customer ID if they already exist in stripe
				$customer_id = $this->retrieve_customer( $id );
				
				if ( $customer_id === false ) {
					// customer doesn't exist... create it
					$customer_id = $this->create_customer( $id, $token );
					$customer = \Stripe\Customer::retrieve( $customer_id );
					$source = $customer->default_source;
				} else {
					// add the source to existing customer
					$source = \Stripe\Source::create(
						apply_filters( 'sliced_stripe_source_create_args',
							array(
								'type'  => 'card',
								'token' => $token,
							)
						)
					);
					$source = $source['id'];
				}
			
				// is it a subscription?
				$subscription_status = get_post_meta( $id, '_sliced_subscription_status', true );
				
				if ( $subscription_status === 'pending' ) {
				
					// subscription
					// 1) create plan
					$plan = \Stripe\Plan::create(
						apply_filters( 'sliced_stripe_plan_create_args',
							array(
								'id'                => 'sliced_invoice_'.$id.'-'.uniqid(),
								'amount'            => sliced_get_invoice_total_raw($id) * ( pow( 10, $currency_exp ) ),
								'currency'          => $currency_code,
								'interval'          => $this->get_billing_period( get_post_meta( $id, '_sliced_subscription_interval_type', true ) ),
								'interval_count'    => get_post_meta( $id, '_sliced_subscription_interval_number', true ),
								'metadata'          => array(
									'sliced_invoice_id' => $id,
								),
								'name'              => __( 'Invoice', 'sliced-invoices' ) . ' ' . esc_html( sliced_get_invoice_prefix() ) . esc_html( sliced_get_invoice_number() ),
								'trial_period_days' => $this->get_trial_days( $id ),
							)
						)
					);
					$plan_id = $plan['id'];
					update_post_meta( $id, '_sliced_subscription_stripe_plan', $plan_id );
					
					//to-do: handle differing trial amounts via a discount?
					
					// 2) subscripe customer to plan
					$charge = \Stripe\Subscription::create(
						apply_filters( 'sliced_stripe_subscription_create_args',
							array(
								'customer' => $customer_id,
								'metadata'    => array(
									'sliced_invoice_id' => $id,
								),
								'plan'     => $plan_id,
								'source'   => $source,
							)
						)
					);
					
					// 3) activate subscription
					if ( class_exists( 'Sliced_Subscriptions' ) ) {
						Sliced_Subscriptions::activate_subscription_invoice( 
							$id, 
							'Stripe', // must match class name
							$charge['id'],
							print_r( $charge, true )
						);
					}
					
				} else {
				
					// regular charge
					$charge = \Stripe\Charge::create(
						apply_filters( 'sliced_stripe_charge_create_args',
							array(
								'amount'      => sliced_get_invoice_total_due_raw($id) * ( pow( 10, $currency_exp ) ),
								'customer'    => $customer_id,
								'currency'    => $currency_code,
								'metadata'    => array(
									'sliced_invoice_id' => $id,
								),
								'source'      => $source,
								'description' => 'Payment for ' . sliced_get_invoice_prefix($id) . sliced_get_invoice_number($id) ,
							)
						)
					);
					
				}
			}
			
            $status  = 'success';
            $message = '<h2>' . __( 'Gennemført', 'sliced-invoices-stripe' ) .'</h2>';
            $message .= '<p>';
			if ( $subscription_status === 'pending' ) {
				$message .= __( 'Subscription has been activated!', 'sliced-invoices-stripe' );
				$message .= '<br />';
				$message .= __( 'The Stripe subscription ID is: ', 'sliced-invoices-stripe' ) . $charge['id'] .'</p>';
			} else {
				$message .= sprintf( __( 'Din betaling på %s er modtaget!', 'sliced-invoices-stripe' ), Sliced_Shared::get_formatted_currency( $charge['amount'] / ( pow( 10, $currency_exp ) ) ) ) . '<br>';
				$message .= __( 'Dit betalings ID er ', 'sliced-invoices-stripe' ) . $charge['id'];
			}
            $message .= '</p>';
            $message .= '<p>';
            $message .= sprintf( __( '<a href="%1s">Klik her for at se din %s</a>', 'sliced-invoices-stripe' ), apply_filters( 'sliced_get_the_link', get_permalink($id), $id ), sliced_get_invoice_label() );
            $message .= '</p>';

        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $message .= $e->getMessage();
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $message .= $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $message .= $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $message .= $e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $message .= $e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $message .= $e->getMessage();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $message .= $e->getMessage();
        }
        
		$amount = ( $charge['amount'] ? $charge['amount'] : $charge['plan']['amount'] );
		
		$payments = get_post_meta( $id, '_sliced_payment', true );
		if ( ! is_array( $payments ) ) {
			$payments = array();
		}
		$payments[] = array(
			'gateway'    => 'stripe',
			'date'       => date("Y-m-d H:i:s"),
			'amount'     => Sliced_Shared::get_formatted_number( $amount / ( pow( 10, $currency_exp ) ) ),
			'currency'   => $currency_code,
			'payment_id' => $charge['id'],
			'status'     => $status,
			'extra_data' => array( 
				'response'  => base64_encode( serialize( $charge ) ),
				'clientip'  => Sliced_Shared::get_ip(),
			),
		);
		update_post_meta( $id, '_sliced_payment', $payments );

        do_action( 'sliced_payment_made', $id, 'Stripe', $status );
        sliced_print_message( $id, $message, $status );


    }
	
	
	/**
	 * Process Webhooks (for subscription invoice payments)
	 *
	 * @since   1.3.0
	 */
	public function process_webhook() {
		
		$this->load_vendor_library();

		// Retrieve the request's body and parse it as JSON
		$input = @file_get_contents("php://input");
		$event_json = json_decode($input);

		try {
			
			// Verify the event by fetching it from Stripe
			$event = \Stripe\Event::retrieve($event_json->id);
			
			// Do something with $event
			switch( $event->type ) {
			
				case 'customer.subscription.deleted':
					
					$args = array(
						'post_type'     =>  'sliced_invoice',
						'meta_key'      =>  '_sliced_subscription_gateway_subscr_id',
						'meta_value'    =>  $event->data->object->id,
					);
					$query      = get_posts( $args );
					$id         = $query[0]->ID;
					
					if ( class_exists( 'Sliced_Subscriptions' ) ) {
						Sliced_Subscriptions::cancel_subscription_invoice( $id, $event );
					}
			
					break;
					
				case 'invoice.payment_succeeded':
				
					// 2017-02-14 api version
					$gateway_subscr_id = $event->data->object->id;
					// catch for 2017-06-05 api version + newer
					if ( substr( $gateway_subscr_id, 0, 4 ) !== 'sub_' ) {
						$gateway_subscr_id = $event->data->object->subscription;
					}
					
					$args = array(
						'post_type'     =>  'sliced_invoice',
						'meta_key'      =>  '_sliced_subscription_gateway_subscr_id',
						'meta_value'    =>  $gateway_subscr_id,
					);
					$query      = get_posts( $args );
					$id         = $query[0]->ID;
					
					if ( class_exists( 'Sliced_Subscriptions' ) ) {
						Sliced_Subscriptions::create_receipt_invoice( $id, $event );
					}
			
					break;
					
				// to-do: add in case 'invoice.payment_succeeded', some solution for this:
				// http://stackoverflow.com/questions/25130263/set-end-date-when-setting-up-stripe-subscription
			}
			
		} catch (Exception $e) {
            // Something happened, return error message
            $message = $e->getMessage();
			echo $message;
        }
		
	}
	

    /**
     * Try to find an existing stripe customer
     */
	public function retrieve_customer( $id ) {

		$client_id      = get_post_meta( $id, '_sliced_client', true );
		//$client_email   = sliced_get_client_email( $id );

		// check if customers stripe id exists in the database
		$stripe_id = get_user_meta( $client_id, '_sliced_stripe_id', true );

		// check if stripe id is valid
		$customer_id = false;
		if( $stripe_id && $stripe_id != '' ) {
		
			try {
				$stripe_customer = \Stripe\Customer::retrieve($stripe_id);
				if ( $stripe_customer && ! property_exists($stripe_customer, 'deleted') ) {
					$customer_id = $stripe_id;
				}
			} catch (Exception $e) {
				// Something happened, return $customer_id (false)
				return $customer_id;
			}
		} 
		/* else {
			// get all customers and create array of emails and ID's
			$stripe_customers = \Stripe\Customer::all( array( "limit" => 100 ) ); // 100 is max
			if( $stripe_customers['data'] ) {
				foreach ($stripe_customers['data'] as $key => $value) {
					if( $value['email'] != '' ) { // ignore empty emails
						$cust_emails[$value['email']] = $value['id'];
					}
				}
			}
			// Try to match the client email with a stripe customer email and then get their stripe id
			if( array_key_exists( $client_email, $cust_emails ) ) {
				$customer_id = $cust_emails[$client_email];
			}
			
		}
		*/

		return $customer_id;
	}
	
	
	/**
     * Add default options to database.
     *
     * @since 1.1.3
     */
    public static function sliced_stripe_activate() {

        $translate = get_option( 'sliced_translate' );
		$translate['gateway-stripe-label'] = isset( $translate['gateway-stripe-label'] ) ? $translate['gateway-stripe-label'] : 'Pay with Stripe';
		update_option('sliced_translate', $translate);

    }
	
	
	public static function sliced_stripe_deactivate() {
	
		wp_clear_scheduled_hook( 'sliced_invoices_stripe_gateway_updater' );
		$main = Sliced_Stripe::get_instance();
		$main->admin_notices_clear();
		$updater = Sliced_Stripe_Gateway_Updater::get_instance();
		$updater->updater_notices_clear();
		
	}
	
	
	/**
     * Output requirements not met notice.
     *
     * @since   1.7.5
     */
	public function requirements_not_met_notice() {
		echo '<div id="message" class="error">';
		echo '<p>' . sprintf( __( 'Sliced Invoices Stripe Gateway cannot find the required <a href="%s">Sliced Invoices plugin</a>. Please make sure the core Sliced Invoices plugin is <a href="%s">installed and activated</a>.', 'sliced-invoices-stripe' ), 'https://wordpress.org/plugins/sliced-invoices/', admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}
	
	
	/**
     * Validate settings, make sure all requirements met, etc.
     *
     * @since   1.7.5
     */
	public function validate_settings() {
	
		if ( ! class_exists( 'Sliced_Invoices' ) ) {
			
			// Add a dashboard notice.
			add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

			return false;
		}
		
		return true;
	}

	
}
