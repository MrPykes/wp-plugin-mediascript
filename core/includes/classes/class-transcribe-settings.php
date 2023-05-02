<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * Class Transcribe_Settings
 *
 * This class contains all of the plugin settings.
 * Here you can configure the whole plugin data.
 *
 * @package		TRANSCRIBE
 * @subpackage	Classes/Transcribe_Settings
 * @author		ed
 * @since		1.0.0
 */
class Transcribe_Settings
{

	/**
	 * The plugin name
	 *
	 * @var		string
	 * @since   1.0.0
	 */
	private $plugin_name;

	/**
	 * Our Transcribe_Settings constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{

		$this->plugin_name = TRANSCRIBE_NAME;
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### Register to Admin Menu
	 * ###
	 * ######################
	 */

	private function add_hooks()
	{
		add_action('admin_menu', array($this, 'register_transcribe_page'));
		add_action('init', array($this, 'register_custom_post_type'));
		add_action('init', array($this, 'create_custom_role'));
	}

	function create_custom_role()
	{
		add_role('uploader', 'Uploader', array(
			'read' => true,
			'create_posts' => true,
			'edit_posts' => true,
			'edit_others_posts' => true,
			'publish_posts' => true,
			'manage_categories' => true,
		));
		add_role('staff', 'Staff', array(
			'read' => true,
			'create_posts' => true,
			'edit_posts' => true,
			'edit_others_posts' => true,
			'publish_posts' => true,
			'manage_categories' => true,
		));
	}
	function register_custom_post_type()
	{
		$transcibe = array(
			'public' => false,
			'label'	 => __('Transcibe', 'transcribe'),
		);
		register_post_type('transcribe', $transcibe);
	}
	/**
	 * Register a custom menu page.
	 */
	function register_transcribe_page()
	{
		add_menu_page(
			__('Transcribe', 'transcribe'),
			__('Transcribe', 'transcribe'),
			'manage_options',
			'transcribe',
			array($this, 'transcribe_page'),
			'dashicons-book',
			6
		);
		add_submenu_page(
			'transcribe',
			__('Add New', 'transcribe'),
			__('Add New', 'transcribe'),
			'manage_options',
			'add-new-file',
			array($this, 'add_new_transcribe_page'),
		);
		add_submenu_page(
			'transcribe',
			__('Settings', 'transcribe'),
			__('Settings', 'transcribe'),
			'manage_options',
			'settings',
			array($this, 'settings_page'),
		);
	}

	function settings_page()
	{
		ob_start();
		include_once TRANSCRIBE_PLUGIN_DIR . 'template-parts/files/content-settings.php';
		echo ob_get_clean();
	}
	function transcribe_page()
	{
		echo "test";
	}
	function add_new_transcribe_page()
	{
		echo "add new page";
	}
	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */

	/**
	 * Return the plugin name
	 *
	 * @access	public
	 * @since	1.0.0
	 * @return	string The plugin name
	 */
	public function get_plugin_name()
	{
		return apply_filters('TRANSCRIBE/settings/get_plugin_name', $this->plugin_name);
	}
}
