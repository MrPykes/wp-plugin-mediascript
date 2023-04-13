<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * Class Transcribe_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		TRANSCRIBE
 * @subpackage	Classes/Transcribe_Run
 * @author		ed
 * @since		1.0.0
 */
class Transcribe_Run
{

	/**
	 * Our Transcribe_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks()
	{
		add_action('admin_enqueue_scripts', array($this, 'enqueue_backend_scripts_and_styles'), 20);
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_and_styles'));
		add_action('admin_init', array($this, 'register_page'));

		add_shortcode('files_page', array($this, 'files_page'));
		add_shortcode('add_page', array($this, 'add_page'));
		add_shortcode('edit_page', array($this, 'edit_page'));

		add_action('admin_post_nopriv_UploadForm', array($this, 'UploadForm_form_submit'));
		add_action('admin_post_UploadForm', array($this, 'UploadForm_form_submit'));
	}

	function register_page()
	{
		$page_files = get_page_by_path('files', OBJECT, 'page');
		if (!$page_files) {
			$args = array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title'	=> 'Files',
				'post_name' => 'files',
				'post_content' => '[files_page]'
			);
			$page_files_id = wp_insert_post($args);
		}
		$page_add = get_page_by_path('files/new', OBJECT, 'page');
		if (!$page_add) {
			$args = array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title'	=> 'Add New',
				'post_name' => 'new',
				'post_content' => '[add_page]',
				'post_parent'  => $page_files_id,
			);
			wp_insert_post($args);
		}
		$page_edit = get_page_by_path('files/edit', OBJECT, 'page');
		if (!$page_edit) {
			$args = array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title'	=> 'Edit',
				'post_name' => 'edit',
				'post_content' => '[edit_page]',
				'post_parent'  => $page_files_id,
			);
			wp_insert_post($args);
		}
	}

	function files_page()
	{
		ob_start();
		include_once TRANSCRIBE_PLUGIN_DIR . 'template-parts/files/content-files.php';
		return ob_get_clean();
	}
	function add_page()
	{
		ob_start();
		include_once TRANSCRIBE_PLUGIN_DIR . 'template-parts/files/content-create.php';
		return ob_get_clean();
	}
	function edit_page()
	{
		ob_start();
		include_once TRANSCRIBE_PLUGIN_DIR . 'template-parts/files/content-update.php';
		return ob_get_clean();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles()
	{
		wp_enqueue_style('transcribe-backend-styles', TRANSCRIBE_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), TRANSCRIBE_VERSION, 'all');
	}
	public function enqueue_scripts_and_styles()
	{
		$ver = strtotime(date('Y-m-d H:i:s'));
		wp_enqueue_style('upload-form-styles', TRANSCRIBE_PLUGIN_URL . 'core/includes/assets/css/upload-form.css', array(), $ver, 'all');
		wp_enqueue_script('upload-form-js', TRANSCRIBE_PLUGIN_URL . 'core/includes/assets/js/upload-form.js', array('jquery'), $ver, false);
		wp_localize_script('upload-form-js', 'ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
	}

	function UploadForm_form_submit()
	{
		$temp_name = $_FILES['FileInput']['tmp_name'];
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		die();
		// $temp_name = $_FILES['FileInput']['tmp_name'];
		$file_name = $_POST['file_name'];
		$file_size = $_POST['file_size'];
		$file_type = $_POST['file_type'];
		$Duration_hr = $_POST['Duration_hr'];
		$Duration_min = $_POST['Duration_min'];
		$Duration_sec = $_POST['Duration_sec'];
		$project = $_POST['project'];
		$story = $_POST['story'];
		$client = $_POST['client'];
		$TranscriptEmail = $_POST['TranscriptEmail'];
		$UploadFileOptions = $_POST['UploadFileOptions'];
		$target_dir = wp_upload_dir();
		$uploads_dir = trailingslashit(wp_upload_dir()['basedir']) . 'transcribe';
		wp_mkdir_p($uploads_dir);
		for ($i = 0; $i < count($temp_name); $i++) {
			// if (file_exists($uploads_dir . '/' . $file_name[$i])) {
			// }
			$args = array(
				'post_title' => $file_name[$i],
				'post_type' => 'transcribe',
				'post_status' => 'publish',
				'meta_input'        => array(
					'file_size'     => $file_size[$i],
					'file_type'		=> $file_type[$i],
					'duration'     => array(
						'hour' => $Duration_hr,
						'minute' => $Duration_min,
						'second' => $Duration_sec,
					),
					'project'     => $project,
					'story'     => $story,
					'client'     => $client,
					'option'     => $UploadFileOptions,
				),
			);
			$post_id = wp_insert_post($args);
			if (is_wp_error($post_id)) {
				echo $post_id->get_error_message();
			} else {
				move_uploaded_file($temp_name[$i], $uploads_dir . '/' . $file_name[$i]);
			}
		}
		wp_redirect(site_url('/files/'));
		die();
	}
}
