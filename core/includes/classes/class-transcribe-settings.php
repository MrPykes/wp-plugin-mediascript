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
		add_action('init', array($this, 'user_role_restricted'));
		add_action('after_setup_theme', array($this, 'remove_admin_bar'));
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
	function remove_admin_bar()
	{
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}
	function user_role_restricted()
	{
		if (is_admin() && !defined('DOING_AJAX') && (current_user_can('staff') || current_user_can('uploader'))) {
			wp_redirect(home_url());
			exit;
		}
	}

	function register_custom_post_type()
	{
		$transcibe = array(
			'public' => true,
			'label'	 => __('Transcibe', 'transcribe'),
			'supports' => array('title', 'editor', 'thumbnail', 'comments', 'author'),
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
		// add_submenu_page(
		// 	'transcribe',
		// 	__('Add New', 'transcribe'),
		// 	__('Add New', 'transcribe'),
		// 	'manage_options',
		// 	'add-new-file',
		// 	array($this, 'add_new_transcribe_page'),
		// );
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
		$transcribe_list_table = new Transcribe_List_Table();
		$transcribe_list_table->prepare_items();
?>
		<div class="wrap">
			<h1><?php _e('Transcribes', 'transcribe'); ?></h1>
			<form method="post">
				<?php $transcribe_list_table->display(); ?>
			</form>
		</div>
<?php
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
