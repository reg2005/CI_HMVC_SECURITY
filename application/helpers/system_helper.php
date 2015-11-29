<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

function json($data) {
	$CI = & get_instance();
	
	if( $CI->input->is_ajax_request() )
		return json_encode($data);
		
	$data = str_replace('<br />', '', $data);
	return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', function($val) {
			return mb_decode_numericentity('&#' . intval($val[1], 16) . ';', array(0, 0xffff, 0, 0xffff), 'utf-8');
		}, json_encode($data)
	);
}

function send_mail($subj, $msg, $to) {
	$CI = & get_instance();
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'ssl://smtp.yandex.ru';
	$config['smtp_user'] = 'cmp08@yandex.ru';
	$config['smtp_pass'] = 'sirgyspgxhhkpogt';
	$config['smtp_port'] = '465';
	$config['smtp_timeout'] = '5';
	$config['charset'] = "utf-8";
	$config['mailtype'] = "html";
	$config['newline'] = "\r\n";

	$CI = & get_instance();
	$CI->load->library('email');
	$CI->email->initialize($config);
	$CI->email->from('cmp08@yandex.ru');
	$CI->email->to($to);
	$CI->email->subject($subj);
	$CI->email->message($msg);
	if (!$CI->email->send()) {
		log_message('error', $CI->email->print_debugger());
		return NULL;
	} else {
		return TRUE;
	}
}

function clear_user_info($i){
	unset(
		$i['password'],
		$i['ip_address'],
		$i['salt'],
		$i['activation_code'],
		$i['forgotten_password_code'],
		$i['forgotten_password_time'],
		$i['remember_code'],
		$i['active'],
		$i['user_id']
		);
	return $i;
}