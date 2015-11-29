<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	function __construct() {

		parent::__construct();
		$this->data = [];
		$this->load->model('core_model', 'core', 'my_ion_auth_model');

		$this->data = array_merge( $this->core->set_headers(), $this->core->init_url() );

		$this->_auth_data();

		$profile = (ENVIRONMENT == 'development') ? TRUE : FALSE;

		//$this->output->enable_profiler($profile);

	}

	function _render($result = [] ){
		/*
			Статусы msg:
			0 все ок
			1 - ошибка валидации
			-1 - ошибка серевера
		*/

		$print['data'] = ( isset($result[0]) ) ? $result[0] : NULL;
		$print['msg'] = ( isset($result[1]) ) ? $result[1] : '';
		$print['status'] = ( isset($result[2]) ) ? $result[2] : 0;
		$print['debug'] = ( isset($result[3]) ) ? $result[3] : '';

		if( !is_array($result) )
			if( !$this->input->get('debug') ){
				$print['debug'] .= $result;
			}else{
				echo $result;
			}


        $this->output
        ->set_output(
        	json($print)
        );
	}

	function _auth_data(){
		$this->data['logged_in'] = $this->ion_auth->logged_in();

		/*
		$this->data['groups']['names'] = [ 'guest' ];

		$this->data['groups']['permissions']['guest'] =
			['allow' =>
				[
					'user' =>
					[
						'profile' =>
						[
							'reg',
							'login'
						]
					],
				],
				'disallow' =>
				[
					'user/profile/logout'
				]
			];
		*/

		if($this->data['logged_in']){
			$this->data['user'] = clear_user_info( $this->ion_auth->user()->row_array() );
			set_cookie('user_id', $this->data['user']['id']);
			$this->data['groups']['names'] = $this->ion_auth->get_users_groups()->result_array();
		}else{
			set_cookie('user_id', 0, 86400);
		}

	}

}