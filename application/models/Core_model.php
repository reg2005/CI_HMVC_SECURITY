<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Version: 2.5.2
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Last Change: 3.22.13
*
* Changelog:
* * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Core_model extends CI_Model
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	function set_headers(){
		$data['referal'] = ( isset($_SERVER['HTTP_REFERER']) ) ? parse_url($_SERVER['HTTP_REFERER']) : NULL ;
		$data['domain'] = $_SERVER['HTTP_HOST'];
		

		
		if(ENVIRONMENT == 'production'){
			$this->output
				->set_content_type('application/json')
				->set_header('Access-Control-Allow-Origin: *');
		}else{
			
			if( isset($data['domain']) AND isset($data['referal']['host']) AND $data['domain'] != $data['referal']['host'] ){
				$this->output
				->set_header('Access-Control-Allow-Origin: '.$data['referal']['scheme']. "://" .$data['referal']['host']);
			}else{
				$this->output
				->set_header('Access-Control-Allow-Origin: *');
			}
			$this->output
				->set_header('Access-Control-Allow-Headers: X-Requested-With, application/json')
				->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS')
				->set_header('Access-Control-Allow-Credentials: true')
		        ->set_content_type('application/json');
        }
        return $data;
	}
	
	function init_url(){
		
		$i = ( $this->uri->segment(1) == 'dev') ? 2 : 1;
		$c = 1;
		
		for(; $i <= 6; $i++){
			$data['segment'][$c] = 
				$this->security->xss_clean(
					$this->uri->segment($i)
				);
			//Для правильной работы необходимо как минимум 3 сегмента, даже если они пустые!
				
			$c++;
		}

		$data['segment']['total'] = $c;
		
		return $data;		
	}

}
