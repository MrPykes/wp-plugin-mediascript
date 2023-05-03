<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;
if (!class_exists('Transcribe')) :

	/**
	 * Main Transcribe Class.
	 *
	 * @package		TRANSCRIBE
	 * @subpackage	Classes/Transcribe
	 * @since		1.0.0
	 * @author		ed
	 */
	final class Transcribe
	{

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Transcribe
		 */
		private static $instance;

		/**
		 * TRANSCRIBE helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Transcribe_Helpers
		 */
		public $helpers;

		/**
		 * TRANSCRIBE settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Transcribe_Settings
		 */
		public $settings;
		/**
		 * TRANSCRIBE settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Uploaders_File_List_Table_Function
		 */
		public $uploaders_table;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone()
		{
			_doing_it_wrong(__FUNCTION__, __('You are not allowed to clone this class.', 'transcribe'), '1.0.0');
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup()
		{
			_doing_it_wrong(__FUNCTION__, __('You are not allowed to unserialize this class.', 'transcribe'), '1.0.0');
		}

		/**
		 * Main Transcribe Instance.
		 *
		 * Insures that only one instance of Transcribe exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Transcribe	The one true Transcribe
		 */
		public static function instance()
		{
			if (!isset(self::$instance) && !(self::$instance instanceof Transcribe)) {
				self::$instance					= new Transcribe;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Transcribe_Helpers();
				self::$instance->settings		= new Transcribe_Settings();
				self::$instance->uploaders_table		= new Uploaders_File_List_Table_Function();

				//Fire the plugin logic
				new Transcribe_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action('TRANSCRIBE/plugin_loaded');
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes()
		{
			require_once TRANSCRIBE_PLUGIN_DIR . 'core/includes/classes/class-transcribe-helpers.php';
			require_once TRANSCRIBE_PLUGIN_DIR . 'core/includes/classes/class-transcribe-settings.php';

			require_once TRANSCRIBE_PLUGIN_DIR . 'core/includes/classes/class-transcribe-run.php';

			require_once TRANSCRIBE_PLUGIN_DIR . 'core/includes/classes/class-uploader-files-list-table-functions.php';

			require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
			require_once TRANSCRIBE_PLUGIN_DIR . 'core/includes/classes/class-uploaders-all-files-list-table.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks()
		{
			add_action('plugins_loaded', array(self::$instance, 'load_textdomain'));
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain()
		{
			load_plugin_textdomain('transcribe', FALSE, dirname(plugin_basename(TRANSCRIBE_PLUGIN_FILE)) . '/languages/');
		}
	}

endif; // End if class_exists check.