<?php
/*	KITE 			- A NANO PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 				- kite.php
 * 	Developer 	- Krishna Teja G S
 *	Website		- http://www.packetcode.com/projects/kite
 *	license			- GNU General Public License version 2 or later
*/

// Kite is the core class of application
// which handles the core switching mechanism

class kite extends Error
{
	// varaible to store object references	
	private static $instance = array();
		
		// the main function of the class
		public function kite_main()
		{
			//set the configuration
			self::config();
			
			//load the node file and initiate the process of routing
			require_once "lib".DS."node.php";
			$node = KITE::getInstance('node');
			$node->router();
		}
		
		//load the configuration from config.json to KITE object
		private static function config()
		{
			$config = json_decode(file_get_contents('config.json'));
			
			// config is std obj so we recast it to kite object
			self::recast('kite',$config);
			$kite = KITE::getInstance('kite');
			
			//defining ROOT so as to use it in whole application
			define('ROOT',$kite->SITE->ROOT);
		}
		
		//function to store the values to object variables
		function set($key,$value)
		{
			$this->$key = $value;
		}
		
		//function to retrieve the data from object varaibles
		function get($key)
		{
			if(isset($this->$key))
				return $this->$key;
			else
				return null;
		}
		
		
		// function to cast the stdObject to a class object 
		// assigns the varaibles to object class
		public static function recast($className, stdClass &$object)
		{
			if (!class_exists($className))
				throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

			$new = KITE::getInstance($className);
			
			foreach($object as $property => &$value)
			{
				$new->$property = &$value;
				unset($object->$property);
			}
			unset($value);
			$object = (unset) $object;
		}
	
		// function to contruct and store the reference of the object
		public static function getInstance($class)
		{
			if(isset(self::$instance[$class]))
				return self::$instance[$class];
			else
			{
				//if the class doesnot exists call the autoload function
				if(!class_exists($class))
				self::autoload($class);
				
				//if the object required is pdo then 
				// extract the config data from kite object
				// and create a pdo object using it
				if($class == 'pdo')
				{
					$kite = KITE::getInstance('kite');
					$host = $kite->DB->HOST;
					$db_name = $kite->DB->DB_NAME;
					$username = $kite->DB->USERNAME;
					$password = $kite->DB->PASSWORD;
					
					self::$instance[$class] = new PDO("mysql:host=$host;dbname=$db_name", "$username", "$password");
				}else	
				self::$instance[$class] = new $class();
				return self::$instance[$class];
			}	
		}
		
		//function to load the classes automatically
		private static function autoload($class)
		{
			$paths = array('lib','app'.DS.'controllers','app'.DS.'models');
			foreach($paths as $path)
			{
				$file = $path.DS.$class.'.php';
				if(file_exists($file))
					require_once $file;
			}
		}
		
		//function to render the view to template or json/html format
		public static function render($view)
		{
			// get the current app from kite object
			$kite = KITE::getInstance('kite');
			$app = $kite->get('APP');
			
			// get the terminal node extension
			$node = KITE::getInstance('node');
			$ext= $node->get('terminal_ext');
			
			// set the view as kite object variable
			//so as to use in the application call from template
			$kite->set('VIEW',$view);
			//get the details of template and hash from kite object
			$tmpl = $kite->SITE->TMPL;
			$site_hash = $kite->SITE->HASH;
			//check if security to display html/json is true or false
			$secure = $kite->SITE->SECURE;
			
			//get the url parameters for template and hash if they exists
			$request = KITE::getInstance('request');
			if($request->get('tmpl')!=null)
			$tmpl = $request->get('tmpl');
			if($request->get('hash')!=null)
			$hash =$request->get('hash');
			
			//if secure is not true then give access to display json/html format
			if($secure ==0)
				$hash = $site_hash;
				
			$basket = KITE::getInstance('basket');
			
			//if terminal extension is json then display json format
			if($ext==='json' && $site_hash===$hash)
				echo json_encode($basket);
			//if the terminal extension is html then render only html without template	
			else if(	$ext==='html' && $site_hash===$hash)
				require_once "apps".DS.$app.DS."views".DS.$view.DS."default.php";
			//else display template +view		
			else
				require_once "templates".DS.$tmpl.DS."index.php";	
		}
		
		//function called from the template
		//to load the application
		public static function app()
		{
			//get the values of app and the view to 
			//be rendered from the kite object
			$kite = KITE::getInstance('kite');
			$app = $kite->get('APP');
			$view = $kite->get('VIEW');
			require_once "apps".DS.$app.DS."views".DS.$view.DS."default.php";	
		}
		
		//function to call te model of the application
		public static function getModel($model)
		{
			$kite = KITE::getInstance('kite');
			$app = $kite->get('APP');
			
			$file = "apps".DS.$app.DS."models".DS.$model.".php";
			//check if the model exists then load the model file
			if(file_exists($file))
			{
				require_once $file;
				$model_obj = new $model();
				return $model_obj;
			}
			else
				echo "model doesnt exists";
		}
		
		public function view($view, $data = [])
    		{
        		require_once '../views/'. $view .'.php';
    		}
}

?>