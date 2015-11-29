<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model', 'profile');
    }

	// redirect if needed, otherwise display the user list
	function reg()
	{
		if($data['logged_in'])
			return $this->is_login($data, NULL);

		return $this->profile->register();
	}

	// log the user in

	function is_login($data, $show_data = TRUE)
	{
		$logged_in = $this->ion_auth->logged_in();
		if($logged_in){

			 $result = [
				1 => 'Вы авторизоаны',
				2 => 0];
			if($show_data)
				$result[0] = $data['user'];

			return $result;
		}else{
			return [
				NULL,
				'Вы неавторизованны',
				2 => 1
			];
			}
	}

	function delete_user($data){ //для debug
		if(ENVIRONMENT == 'production')
			return NULL;

		if($data['logged_in'])
			$this->logout($data);

		$email = $this->input->post('email', NULL);

		if(!$email)
			return [ 1 => 'Не указан email', 2 => 1];

		$identity = $this->ion_auth->where('email', $email )->users()->row_array();
		if(!$identity)
			return [ 1 => 'Нет такого пользователя', 2 => 1];

		if($this->ion_auth->delete_user($identity['id']) ){
			return [ 1 => 'Пользователь удален'];
		}else{
			return [ 1 => 'Не удалось удалить', 2 => 1];
		}
	}

	function autologin($data){
		if(ENVIRONMENT == 'production')
			return NULL;
		//return $this->ion_auth->autologin($data['segment'][4]);
		if($this->ion_auth->autologin($data['segment'][4]) )
			return $this->is_login($data);
	}

	function login($data)
	{
		if($data['logged_in'])
			return $this->is_login($data, NULL);

		return $this->profile->login();
	}

	// log the user out
	function logout($data)
	{
		if($data['logged_in']){
			$this->ion_auth->logout();
			return [ 1 => 'Вы успешно разлогинились'];
		}

		return $this->is_login($data, NULL);
	}


	// forgot password
	function forgot($data)
	{
		if(!$data['segment'][4])
			return [1 => 'Отсутсвует 4-ый параметр в строке запроса', 2 => -1];

		switch ($data['segment'][4])
			{
				case 'first_step':
					return $this->profile->forgot_first_request();
					break;
				case 'save_new_password':
					return $this->profile->forgot_save_new_password();
					break;
			}

	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{

	}

	// Activate new user from email link
	function activate($data)
	{
		$id = $data['segment'][4];
		$code = $data['segment'][5];

		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}

		if ($activation)
		{

			redirect("/app/windows/profile/welcome", 'refresh');
		}
		else
		{
			//print_r($data);
			//redirect("app/windows/restore_pass", 'refresh');
		}
		return [$data['segment'][5]];
	}

	// deactivate the user
	function deactivate($id = NULL)
	{

	}

	// create a new user
	function create_user()
    {

    }

	// edit a user
	function edit_user($id)
	{

	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
