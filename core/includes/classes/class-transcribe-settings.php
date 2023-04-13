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
	}

	function register_custom_post_type()
	{
		$transcibe = array(
			'public' => true,
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
