<?php

namespace  Framework;

use Twig_Environment;
use Twig_Loader_Filesystem;

class View
 {
	/**
     * @var Twig_Environment
     */
    private static $twig;
    /**
     * @var Twig_Loader_Filesystem
     */
    private static $loader;
    /**
     * @var string
     */
    private static $template;
    /**
     * @var array
     */
    private static $params;

 	public static function render($file, $args = [])
 	{
 		extract($args, EXTR_SKIP);

		 $view = dirname(__DIR__) . "/app/View/$file.php";
		 
         if (is_readable($view)) {
 			require $view;
 		}
	 }
	 
	 public static function template($template, $args = []) {
		self::$loader = new Twig_Loader_Filesystem('../app/View');
        self::$twig = new Twig_Environment(self::$loader);
        self::$template = $template;
		
		extract($args, EXTR_SKIP);
		self::$params = $args;
		
		try {
            return self::$twig->render(self::$template, self::$params);
        } catch (Twig_Error_Loader $e) {
            $error = new Error();
            $error->index404();
        }
	 }
 }