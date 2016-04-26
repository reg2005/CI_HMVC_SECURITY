<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Класс расширяющий правила Form_Validation, добавляя в них работу с кириллицей
 *
 * @package		CodeIgniter
 * @author		ZUMA
 * @copyright	Copyright (c) 2012, Максим Сергеевич Зубенко. (Россия) 
 * @license		freeware
 * @link		http://jawsik.com/myprogsandscripts/codeigniter-form_validation.php
 * @since		Version 1.0
 * @filesource	
 */

// ------------------------------------------------------------------------
class MY_Form_validation extends CI_Form_validation {
	
	// --------------------------------------------------------------------

	/**
	 * Буквы (английские и русские), цифры, а так же минус и нижнее подчёркивание
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function cyr_alpha_dash($str)
	{
		return ( ! preg_match("/^([-а-яёa-z0-9_-\s])+$/ui", $str)) ? FALSE : TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Буквы (английские и русские) и цифры
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function cyr_alpha_numeric($str)
	{
		return ( ! preg_match("/^([а-яёa-z0-9\s])+$/ui", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Буквы (английские и русские)
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function cyr_alpha($str)
	{
		return ( ! preg_match("/^([а-яёa-z\s])+$/ui", $str)) ? FALSE : TRUE;
	}
	// --------------------------------------------------------------------

	/**
	 * Буквы (только русские), цифры, а так же минус и нижнее подчёркивание
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function cyr_dash($str)
	{
		return ( ! preg_match("/^([-а-яё0-9_-\s])+$/ui", $str)) ? FALSE : TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Буквы (только русские) и цифры
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function cyr_numeric($str)
	{
		return ( ! preg_match("/^([а-яё0-9\s])+$/ui", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Буквы (только русские)
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function cyr($str)
	{
		return ( ! preg_match("/^([а-яё\s])+$/ui", $str)) ? FALSE : TRUE;
	}	
			
}

/**/