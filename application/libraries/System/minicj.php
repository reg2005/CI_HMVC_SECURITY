<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CI Smarty
 *
 * Smarty templating for Codeigniter
 *
 * @package   CI Smarty
 * @author    Dwayne Charrington
 * @copyright 2015 Dwayne Charrington and Github contributors
 * @link      http://ilikekillnerds.com
 * @license   MIT
 * @version   3.0
 */


class Minicj extends Minify{

    /**
     * Enable Caching
     *
     * Allows you to enable caching on a page by page basis
     * @example $this->smarty->enable_caching(); then do your parse call
     */
    public function index()
    {

       	$sourcePath = '/home/user/development/leonardo/application/modules/templates/views/tnt/theme/css/animate.css';
		$minifier = new Minify\CSS($sourcePath);

		// we can even add another file, they'll then be
		// joined in 1 output file
		//$sourcePath2 = '/path/to/second/source/css/file.css';
		//$minifier->add($sourcePath2);

		// or we can just add plain CSS
		$css = 'body { color: #000000; }';
		$minifier->add($css);

		// save minified file to disk
		$minifiedPath = '/path/to/minified/css/file.css';
		$minifier->minify($minifiedPath);

		// or just output the content
		return $minifier->minify();

    }

    /**
     * Disable Caching
     *
     * Allows you to disable caching on a page by page basis
     * @example $this->smarty->disable_caching(); then do your parse call
     */
    public function disable_caching()
    {
        $this->caching = 0;
    }

}
