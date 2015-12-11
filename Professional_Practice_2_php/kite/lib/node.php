<?php
/*	KITE 			- A NANO PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 				- node.php
 * 	Developer 	- Krishna Teja G S
 *	Website		- http://www.packetcode.com/projects/kite
 *	license			- GNU General Public License version 2 or later
*/

// A class which deals with url and its fragments(nodes)
// the nodes are named as n1,n2,n3... respectively
// the first few nodes are used for understand the application
// and the rest will be sent to the application as options 
// options are names ad o1,o2,o3....and so on

class node extends kite{
		
		//defining object variable options
		var $option = 0;
		
		// routing function
		public function router()
		{
			//get the nodes to node object
			$this->nodes();
			
			//setting defaults
			$kite = KITE::getInstance('kite');
			$application = $kite->SITE->APP;
			$controller = $kite->SITE->CONTROLLER;
			$method = $kite->SITE->METHOD;
			
			if(isset($this->n1))
			{
				$application = $this->get('n1');
				//checking if n1 is application
				$path = 'apps'.DS.$application;
				if (is_dir($path) === true)
				{
					// check n2 and n3 can fit as controller and method
					$controller = $this->get('n2');
					$method = $this->get('n3');
					// store the node usage as 3 so that 
					//rest nodes can be stored as options
					$this->option = 3;
					if(!$this->controllerCheck($application,$controller,$method))
					{
						//if the controller doesnt exist then changes the values
						// controller to root and n2 as method and check again
						$controller = "root";
						$method = $this->get('n2');
						$this->option = 2;
						$this->controllerCheck($application,$controller,$method);
					}
				}else
				{
					//if the first node is not app then check if its a controller in
					// the default app 
					$kite = KITE::getInstance('kite');
					$application = $kite->SITE->APP;
					
					$path = 'apps'.DS.$application;
					if(is_dir($path))
					{
						$controller = $this->get('n1');
						$method = $this->get('n2');
						$this->option = 2;
						if(!$this->controllerCheck($application,$controller,$method))
						{
							$controller = "root";
							$method = $this->get('n1');
							$this->option = 1;
							$this->controllerCheck($application,$controller,$method);
						}
					}
					else
						Error::errorMsg("No app found");
				}
			}else
			{
				$file = "apps".DS.$application.DS."controllers".DS.$controller.".php";
				if(file_exists($file))
				{
					require_once $file;
					$this->option = 0;
					$this->controllerCall($application,$controller,$method);
				}	
			}
		}
		
		// if the controller exists then call the controller
		//also store the values in Kite object
		public function controllerCall($application,$controller,$method)
		{
			$this->setOptions();
			$kite = KITE::getInstance('kite');
			$kite->set('APP',$application);
			$kite->set('CONTROLLER',$controller);
			$kite->set('METHOD',$method);
			$app = new $controller();
			$app->$method();
		}
		
		//function to check if the controller exists 
		// load the controller and check 
		// for the method existence
		public function controllerCheck($application,$controller,$method)
		{
			$file = "apps".DS.$application.DS."controllers".DS.$controller.".php";
			if(file_exists($file))
			{
				require_once $file;
				if(!method_exists($controller,$method))
				{
						$method = 'main';
						$this->option = $this->option -1;
				}		
				$this->controllerCall($application,$controller,$method);	
			}
			else
				return false;
		}
		
		//function to set the options so as to send to 
		//the application for processing
		public function setOptions()
		{
			$n = $this->option+1;
			$j=1;
			
			// after the usage of first few nodes the rest are set 
			// as o1,o2,o3,...
			while(1)
			{
				$node = 'n'.$n;
				if(isset($this->$node))
					$this->set('o'.$j,$this->$node);
				else
					break;
				$n++;$j++;
			}
		}
		
		public function nodes()
		{
			// check if the url parameter is set
			if(isset($_GET['url']))
			{
				// load the url into url variable
				$url = $_GET['url'];
				
				//trim the url to remove slashes on right
				$url = rtrim($url,'/');
				//break the url to fragments
				$url = explode('/',$url);
				//load the url to the object variable 
				// as n1,n2,n3....
				foreach($url as $key => $value)
				{
					$key++;
					$this->set('n'.$key,$value);	
				}
				// store the terminal position of the node
				$terminal_position = 'n'.sizeof($url);
				$this->set('terminal_position',$terminal_position);			
				$this->node_terminal();
			}	
		}
		//function which analyses the last node 
		//and picks up the extension and stores in node object
		public function node_terminal()
		{
			$terminal_position = $this->get('terminal_position');
			$terminal = $this->$terminal_position;
			$terminal_items = explode('.',$terminal);	
			
			if(isset($terminal_items[0]))
				$this->set('terminal_item',$terminal_items[0]);
			if(	isset($terminal_items[1]))
				$this->set('terminal_ext',$terminal_items[1]);
			
			//update the ternimal node
			$this->set($terminal_position,$terminal_items[0]);
		}

}
?>