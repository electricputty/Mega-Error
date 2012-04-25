<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Mega Error
 *
 * @package	ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author	Malcolm Elsworth / Rob Sanchez (@_rsan)
 * @link	http://labs.electricputty.co.uk
 * @copyright 	Copyright (c) 2011 Electric Putty
 * @license   	http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 */

// ------------------------------------------------------------------------
 

class Ep_mega_error_ext {

	public $settings 		= array();
	public $description		= 'Makes it hard to miss errors in the publish view - even if they are on a different tab';
	public $docs_url		= 'http://labs.electricputty.co.uk/post/mega_error/';
	public $name			= 'Mega Error';
	public $settings_exist	= 'n';
	public $version			= '1.1';
	
	private $EE;
	function __construct()
	{
		$this->EE =& get_instance();
		
		// variables
		$this->_theme_base_url = version_compare(APP_VER, '2.4.0', '<')
			? $this->EE->config->item('theme_folder_url').'third_party/ep_mega_error/'
			: URL_THIRD_THEMES.'ep_mega_error/';
	}


	/**
	 * publish_form_channel_preferences
	 *
	 * @param $row channel preferences array
	 * @return array
	 */
	public function publish_form_channel_preferences($row)
	{
		$row = $this->EE->extensions->last_call !== FALSE ? $this->EE->extensions->last_call : $row;
		
		// add jQuery to control panel head
		$this->EE->cp->add_to_head('<link type="text/css" href="'.$this->_theme_base_url.'css/ep_mega_error.css" rel="stylesheet" />');
		$this->EE->cp->add_to_head('<script src="'.$this->_theme_base_url.'js/ep_mega_error.js"></script>');
		
		return $row;
	}

	// ----------------------------------------------------------------------
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'publish_form_channel_preferences',
			'hook'		=> 'publish_form_channel_preferences',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);			
		
	}	

	// ----------------------------------------------------------------------
	
	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.ep_mega_error.php */
/* Location: /system/expressionengine/third_party/ep_mega_error/ext.ep_mega_error.php */