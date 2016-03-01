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

function js_and_css_render($array = []){
	if( !count($array))
		return '';

	$result = '';
	$templates['css'] = '<link href="%s" rel="stylesheet">';
	$templates['js'] = '<script src="%s" type="text/javascript"></script>';

	foreach($array as $val)
	{
		$explode = explode('.', $val);

		$type = trim(end($explode));

		$result .= ( isset($templates[$type]) ) ? sprintf($templates[$type], $val) : '';
	}
	return $result;
}