<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller
{

	function __construct()
    {
        parent::__construct();

    }

	function add()
	{
		return [1 => 'Вы неавторизованны'];
	}
}