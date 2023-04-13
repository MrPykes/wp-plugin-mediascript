<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * Class Transcribe_Helpers
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		TRANSCRIBE
 * @subpackage	Classes/Transcribe_Helpers
 * @author		ed
 * @since		1.0.0
 */
class Transcribe_Helpers
{

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */
}
function sizeFilter($bytes)
{
	$label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++);
	return (round($bytes, 2) . " " . $label[$i]);
}
