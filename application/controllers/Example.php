<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends MY_Controller {

	function __construct() {

		parent::__construct();
	}

	public function index($method = null)
	{
		$data['content'] = '';
		echo $this->render('formbuilder/index', $data);
	}

	private function render($view = '', $data = [] ){

		$data['js_and_css'] = js_and_css_render(
			$this->config->item('template_files')
		);

		$data['content'] = $this->parser->parse($view, $data, TRUE);

		return $this->parser->parse('sceleton', [], TRUE);
	}

}
