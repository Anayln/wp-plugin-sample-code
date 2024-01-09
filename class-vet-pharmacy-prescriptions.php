<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://digitalpie.co.nz
 * @since      1.0.0
 *
 * @package    Vet_Pharmacy_Prescriptions
 * @subpackage Vet_Pharmacy_Prescriptions/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Vet_Pharmacy_Prescriptions
 * @subpackage Vet_Pharmacy_Prescriptions/includes
 * @author     Digital Pie <support@digitalpie.co.nz>
 */
class Vet_Pharmacy_Prescriptions {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Vet_Pharmacy_Prescriptions_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	// Pets DB Interface.
	protected $db_interface_pets;

	// Pets DB Interface.
	protected $db_interface_prescriptions;

	protected $db_interface_veterinarians;

	protected $db_interface_vet_practices;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'VET_PHARMACY_PRESCRIPTIONS_VERSION' ) ) {
			$this->version = VET_PHARMACY_PRESCRIPTIONS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'vet-pharmacy-prescriptions';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Vet_Pharmacy_Prescriptions_Loader. Orchestrates the hooks of the plugin.
	 * - Vet_Pharmacy_Prescriptions_i18n. Defines internationalization functionality.
	 * - Vet_Pharmacy_Prescriptions_Admin. Defines all hooks for the admin area.
	 * - Vet_Pharmacy_Prescriptions_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-vet-pharmacy-prescriptions-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-vet-pharmacy-prescriptions-i18n.php';

		require_once plugin_dir_path( __DIR__ ) . 'tcpdf/examples/tcpdf_include.php' ;

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		// require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-vet-pharmacy-prescriptions-admin.php';

		$this->loader = new Vet_Pharmacy_Prescriptions_Loader();

		// Pets DB interface
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-vppp-db-pets.php';
		$this->db_interface_pets = new DB_Interface_Pets();

		// Pets Frontend
		require_once plugin_dir_path( __DIR__ ) . 'public/class-vppp-pets-frontend.php';

		// Pets Backend
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-pets-backend.php';

		// Pets list
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-pets-list.php';		
		
		//Pets add
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-pets-add.php';

		// Prescription Frontend
		require_once plugin_dir_path( __DIR__ ) . 'public/class-vppp-prescriptions-frontend.php';

		// Prescription Backend
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-prescriptions-backend.php';

		//Prescriptions list
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-prescriptions-list.php';		

		//Prescriptions add
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-prescriptions-add.php';

		// Prescriptions DB interface
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-vppp-db-prescriptions.php';
		$this->db_interface_prescriptions = new DB_Interface_Prescriptions();

		// Veterinarians DB interface
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-vppp-db-veterinarians.php';
		$this->db_interface_veterinarians = new DB_Interface_Veterinarians();

		// Veterinarians Backend
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-veterinarians-backend.php';

		// Veterinarians list
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-veterinarians-list.php';		
		
		//Veterinarians add
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-veterinarians-add.php';

		// Practices DB interface
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-vppp-db-vet-practices.php';
		$this->db_interface_vet_practices = new DB_Interface_Vet_Practices();

		// Practices Backend
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-vet-practices-backend.php';

		// Practices list
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-vet-practices-list.php';		
		
		//Practices add
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-vppp-vet-practices-add.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Vet_Pharmacy_Prescriptions_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Vet_Pharmacy_Prescriptions_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		/*
		$plugin_admin = new Vet_Pharmacy_Prescriptions_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		*/

		$prescriptions_backend = new Prescriptions_Backend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_prescriptions );			
		$this->loader->add_action( 'admin_menu', $prescriptions_backend, 'add_prescriptions_menu_entry');		
		$this->loader->add_action( 'rest_api_init',$prescriptions_backend,'register_rest_route_garoute' );			

		if ( is_admin() ) {
			$pets_backend = new Pets_Backend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_pets );
			$this->loader->add_action( 'admin_enqueue_scripts', $pets_backend, 'enqueue_styles' );
			// $this->loader->add_action( 'wp_enqueue_scripts', $pets_backend, 'enqueue_scripts' );
			$this->loader->add_action( 'admin_menu', $pets_backend, 'add_pets_menu_entry' );
			$this->loader->add_action( 'wp_loaded', $pets_backend, 'pets_action_handler' );
			$this->loader->add_filter( 'set-screen-option', $pets_backend, 'pets_set_screen_option', 5, 3 );
			$this->loader->add_action( 'prescriptions_page_customer-pets-list', $pets_backend, 'load_prescriptions_page_customer_pets_list');
			$this->loader->add_action( 'init', $pets_backend, 'save_pet_custom_metabox_data');
			
			// $prescriptions_backend = new Prescriptions_Backend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_prescriptions );
			
			$this->loader->add_action( 'admin_menu', $prescriptions_backend, 'generate_prescriptions_settings_page',12);
			$this->loader->add_action( 'admin_enqueue_scripts', $prescriptions_backend, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $prescriptions_backend, 'enqueue_scripts' );
			$this->loader->add_filter( 'set-screen-option', $prescriptions_backend, 'prescriptions_set_screen_option', 5, 3 );
			$this->loader->add_action( 'load-toplevel_page_prescriptions-list', $prescriptions_backend, 'load_prescriptions_page_prescriptions_list');
			$this->loader->add_action( 'init', $prescriptions_backend, 'save_prescriptions_custom_metabox_data');
			$this->loader->add_action( 'wp_ajax_fetch_practice_data', $prescriptions_backend, 'fetch_practice_data');
			$this->loader->add_action( 'wp_ajax_fetch_veterinarian_data', $prescriptions_backend, 'fetch_veterinarian_data');
			$this->loader->add_action( 'wp_ajax_fetch_pet_data', $prescriptions_backend, 'fetch_pet_data');
			$this->loader->add_action( 'wp_ajax_fetch_all_pet_data', $prescriptions_backend, 'fetch_all_pet_data');
			$this->loader->add_action( 'wp_ajax_fetch_all_practice_data', $prescriptions_backend, 'fetch_all_practice_data');
			$this->loader->add_action( 'wp_ajax_fetch_product_data', $prescriptions_backend, 'fetch_product_data');			
			$this->loader->add_action( 'wp_ajax_get_assign_order', $prescriptions_backend, 'get_assign_order');			
			$this->loader->add_action( 'wp_ajax_set_assign_order', $prescriptions_backend, 'set_assign_order');			
			$this->loader->add_action( 'rest_api_init',$prescriptions_backend,'register_rest_route_garoute' );
			$this->loader->add_action( 'woocommerce_admin_order_data_after_order_details',$prescriptions_backend, 'prescription_order_notes' );
			$this->loader->add_action( 'woocommerce_process_shop_order_meta',$prescriptions_backend, 'insert_order_to_prescription' );
			$this->loader->add_action( 'admin_init', $prescriptions_backend, 'register_prescription_settings');
			$this->loader->add_action( 'admin_init', $prescriptions_backend, 'generate_prescription_pdf');			
			$this->loader->add_action( 'init', $prescriptions_backend, 'update_prescriptions_status_based_on_expiry_date');
			$this->loader->add_action('woocommerce_order_status_changed',$prescriptions_backend,'woocommerce_process_shop_order', 10, 3);	
			
			$veterinarians_backend = new Veterinarians_Backend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_veterinarians );
			$this->loader->add_action( 'admin_enqueue_scripts', $veterinarians_backend, 'enqueue_styles' );
			$this->loader->add_action( 'admin_menu', $veterinarians_backend, 'add_veterinarians_menu_entry' );
			$this->loader->add_filter( 'set-screen-option', $veterinarians_backend, 'veterinarians_set_screen_option', 5, 3 );
			$this->loader->add_action( 'load-prescriptions_page_veterinarians-list', $veterinarians_backend, 'load_prescriptions_page_veterinarians_list');
			$this->loader->add_action( 'init', $veterinarians_backend, 'save_veterinarian_custom_metabox_data');
			$this->loader->add_action( 'wp_ajax_fetch_all_vet_data', $prescriptions_backend, 'fetch_all_vet_data');
			

			$vet_practices_backend = new Vet_Practices_Backend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_vet_practices );
			$this->loader->add_action( 'admin_enqueue_scripts', $vet_practices_backend, 'enqueue_styles' );
			$this->loader->add_action( 'admin_menu', $vet_practices_backend, 'add_vet_practices_menu_entry' );
			$this->loader->add_filter( 'set-screen-option', $vet_practices_backend, 'vet_practices_set_screen_option', 5, 3 );
			$this->loader->add_action( 'load-prescriptions_page_vet-practices-list', $vet_practices_backend, 'load_prescriptions_page_vet_practices_list');
			$this->loader->add_action( 'init', $vet_practices_backend, 'save_vet_practice_custom_metabox_data');
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		
		
		$prescription_frontend = new Prescription_Frontend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_prescriptions,$this->db_interface_vet_practices,$this->db_interface_veterinarians,$this->db_interface_pets );

		if ( ! is_admin() ) {
			$pets_frontend = new Pets_Frontend( $this->get_plugin_name(), $this->get_version(), $this->db_interface_pets );
			$this->loader->add_action( 'wp_enqueue_scripts', $pets_frontend, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $pets_frontend, 'enqueue_scripts' );
			$this->loader->add_filter( 'woocommerce_account_menu_items', $pets_frontend, 'add_pets_my_account_tab', 40 );
			$this->loader->add_action( 'init', $pets_frontend, 'add_pets_my_account_endpoint' );
			$this->loader->add_action( 'woocommerce_account_my-pets_endpoint', $pets_frontend, 'my_pets_endpoint_content' );
			$this->loader->add_action( 'wp_loaded', $pets_frontend, 'my_pets_action_handler' );

			$this->loader->add_action( 'wp_enqueue_scripts', $prescription_frontend, 'enqueue_styles' );
			$this->loader->add_action( 'init', $prescription_frontend, 'add_prescriptions_my_account_endpoint' );
			$this->loader->add_filter( 'woocommerce_account_menu_items', $prescription_frontend, 'add_prescriptions_my_account_tab', 40 );
			$this->loader->add_action( 'woocommerce_account_prescriptions_endpoint', $prescription_frontend, 'prescriptions_endpoint_content' );
		}

		$this->loader->add_action( 'wp_ajax_show_prescription_record', $prescription_frontend, 'show_prescription_record' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Vet_Pharmacy_Prescriptions_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
