<?php

namespace  Framework;

use Twig_Environment;
use Twig_Loader_Filesystem;

class View
 {
 	public static function render($file, $args = [])
 	{
 		extract($args, EXTR_SKIP);

		 $view = dirname(__DIR__) . "/app/View/$file.php";
		 
         if (is_readable($view)) {
 			require $view;
 		}
	 }
	 
	 public static function template($template, $args = []) {
		$loader = new Twig_Loader_Filesystem('../app/View');
        $twig = new Twig_Environment($loader);
        $template = $template;
		
		extract($args, EXTR_SKIP);
		
		try {
            return $twig->render($template, $args);
        } catch (Twig_Error_Loader $e) {
            $error = new Error();
            $error->index404();
        }
	 }
 }