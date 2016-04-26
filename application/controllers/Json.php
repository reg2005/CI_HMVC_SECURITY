<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends MY_Controller {

	function __construct() {

		parent::__construct();
	}

	public function door($method = null)
	{

		$this->_render( $this->checker() ) ;
	}

	private function check_group(){

	}

	private function checker(){
		if( $this->data['segment']['total'] >= 3 ){

			$result = NULL;

			$end_point =
					$this->data['segment'][1].'/'.
					$this->data['segment'][2].'/'.
					$this->data['segment'][3];

/*
			return [$this->check_user_permissions('module', $this->data['segment'][1])];

			if( ! $this->check_user_permissions('module', $this->data['segment'][1]) )
				return [1 => 'Вам запрещен доступ к этому методу', -1];

			if( ! $this->check_user_permissions('controller') )
				return [1 => 'Вам запрещен доступ к этому методу', -1];

			if( ! $this->check_user_permissions('method') )
				return [1 => 'Вам запрещен доступ к этому методу', -1];

			$allow = ['login', 'is_login'];

			$intersect = array_intersect($methods_in_class, $allow);

			if( !in_array($this->data['segment'][3], $intersect) )
				return [1 => 'Вам запрещен доступ к этому методу, обратитесь к администратору', 1];

*/

			$methods_in_class = Modules::run(
					$this->data['segment'][1].'/'.
					$this->data['segment'][2].'/'.
					'_get_info'
					);

			if( !is_array($methods_in_class) )
				return [1 => 'Модуль несуществует, либо отсутствует контроллер модуля', -1];

			if( !in_array($this->data['segment'][3], $methods_in_class) )
				return [1 => 'Метод не существует, либо он приватный', -1];

			$result = Modules::run(
					$end_point,
					$this->data
				);

			//if( empty($result) )
				//return [1 => 'Модуль не существует', -1];

			if(!$result)
				return [1 => 'Запрошенная функция не существует, проверьте адрес запроса', -1];

			return $result;

		}else{
			return [ 1 => 'Неверный адрес', -1];
		}
	}

	function check_user_permissions($point = '', $value = ''){
		$res = TRUE;

		if(count($permissions) == 0)
			return FALSE;


		switch ($point) {
		    case 'controller':
		        return  $this->check_user_permissions_in_controller($permissions['allow'], $value);
		        break;
		    case 'method':
		        return  $this->check_user_permissions_in_method($permissions['allow'], $value);
		        break;
		}
	}

	function check_user_permissions_in_method($permissions, $value){
		$res = array_key_exists ( $value, $permissions['allow'] );
	}

	function check_user_permissions_in_controller($permissions, $value){
		$res = array_key_exists ( $value, $permissions['allow'] );
	}

}
