<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
    }

	function register(){

		$rules = [
			[
				'field' => 'login',
	            'label' => 'Email',
	            'rules' => 'required|valid_email|is_unique[users.email]',
            ],
            [
	            'field' => 'pwd',
	            'label' => 'Пароль',
	            'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[pwd2]'
            ],
            [
	            'field' => 'pwd2',
	            'label' => 'Пароль повторно',
	            'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[pwd2]'
            ],
		];
		
		if( !count($this->input->post()) )
			return [ 1 => 'POST пуст', 2 => 1];

		if ($this->form_validation->set_data( $this->input->post() )->set_rules($rules)->run() == true)
        {
            $s['email']    = strtolower($this->input->post('login'));
            $s['password'] = $this->input->post('pwd');
            
			$username = explode('@', $s['email']);
            $s['additional_data'] = [
	            'username' => $username[0]
            ];
            
            if($s['debug'] .= $this->ion_auth->register($s['email'], $s['password'], $s['email'], $s['additional_data'])){
            	return [ 1 => $this->ion_auth->messages(), 3 => $s['debug']];
            }else{
            	return [ 1 => $this->ion_auth->errors(), 2 => -1, 3 => $s];
            }
            
        }else{
	        return [ 0 => $this->form_validation->error_array(), 2 => 1];
        }
        
        
        /* /user/auth/register?debug=yes&email=efwefw@tr.ru&password=ddsfsdf&password_confirm=ddsfsdf */
	}
	
	function login(){
		
		$rules = [
			[
				'field' => 'login',
	            'label' => 'Email',
	            'rules' => 'required',
            ],
            
            [
				'field' => 'pwd',
	            'label' => 'Пароль',
	            'rules' => 'required',
            ],
        ];
        
		if( !count($this->input->post()) )
			return [ 1 => 'POST пуст', 2 => 1];

		if ($valid = $this->form_validation->set_data( $this->input->post() )->set_rules($rules)->run() == true)
        {
            //$remember = (bool) $this->input->post('remember');
            
            $remember = TRUE;

			if ($this->ion_auth->login($this->input->post('login'), $this->input->post('pwd'), $remember))
			{
				return [1 => 'Авторизация удалась'];
			}
			else
			{
				return [1 => 'Авторизация не удалась, проверьте логин и пароль', 2 => 1];
			}
            
        }else{
	        return [ 0 => $this->form_validation->error_array(), 2 => 1 ];
        }
	}
	
	function forgot_first_request(){
		$rules = [
			[
				'field' => 'login',
	            'label' => 'Email',
	            'rules' => 'required|valid_email',
            ],
        ];
        if( !count($this->input->post()) )
			return [ 1 => 'POST пуст', 2 => 1];
		
		if ($valid = $this->form_validation->set_data( $this->input->post() )->set_rules($rules)->run() == true)
        {
	        $identity = $this->ion_auth->where('email', $this->input->post('login'))->users()->row_array();
			$s =  $this->ion_auth->forgotten_password($identity['email']);
			if ( $s )
			{
				$domain = explode('@', $identity['email']);
				return [1 => 'Ссылка на востановление пароля успешно выслана. <a href="http://'.$domain[1].'">Перейти на почту</a>'];
			}
			else
			{
				return [1 => $this->ion_auth->errors(), 2 => 1, 3 => $s]; //нет такого email
			}
			
	    
	    }else{
		    return [ 0 => $this->form_validation->error_array(), 2 => 1 ];
	    }
			
			
	}

	function forgot_save_new_password(){
		$rules = [
			[
				'field' => 'request_code',
	            'label' => 'Код востановления',
	            'rules' => 'required',
            ],
            [
	            'field' => 'pwd',
	            'label' => 'Пароль',
	            'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[pwd2]'
            ],
            [
	            'field' => 'pwd2',
	            'label' => 'Пароль повторно',
	            'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[pwd2]'
            ],
		];
		
		if( !count($this->input->post()) )
			return [ 1 => 'POST пуст', 2 => 1];
		
		
		if ($valid = $this->form_validation->set_data( $this->input->post() )->set_rules($rules)->run() == true)
        {
	        $user = $this->ion_auth->forgotten_password_check($this->input->post('request_code'));
	       
	       // finally change the password
				$identity = $user->{'email'};

				$change = $this->ion_auth->reset_password($identity, $this->input->post('pwd'));

				if ($change)
				{
					return [1 => 'Пароль успешно сохранен'];
				}
				else
				{
					return [1 => $this->ion_auth->errors(), 2 => 1, 3 => $s];
				}
	    }else{
		    return [ 0 => $this->form_validation->error_array(), 2 => 1 ];
	    }

		
	}
}