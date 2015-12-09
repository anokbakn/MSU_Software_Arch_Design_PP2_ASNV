<?php
/*	KITE 			- A NANO PHP MVC FRAMEWORK
 *	package 		- lib/installer
 *	file 				- installer.php
 * 	Developer 	- Krishna Teja G S
 *	Website		- http://www.packetcode.com/projects/kite
 *	license			- GNU General Public License version 2 or later
*/

//class used in installing the database and setting the configuration
class installer{

	public function main()
	{
		if(isset($_POST['host']))
		{
			$db_name = $_POST['db_name'];
			$host = $_POST['host'];
			$user =$_POST['username'];
			$pass = $_POST['password'];
			
			$this->create_db($db_name,$host,$user,$pass);
			$this->create_tables($db_name,$host,$user,$pass);
			$this->delete('lib/installer/check.php');
			$this->update_config($db_name,$host,$user,$pass);
			require_once('lib/installer/html/header.php');
			require_once('lib/installer/html/success.php');
			require_once('lib/installer/html/footer.php');
		}	
		else{
			require_once('lib/installer/html/header.php');
			require_once('lib/installer/html/db.php');
			require_once('lib/installer/html/footer.php');
		}
	}
	

	public function create_db($db_name,$host,$user,$pass)
	{
			try {
				$db = new PDO("mysql:host=$host", $user, $pass);
				$db->exec("CREATE DATABASE `$db_name`;") 
				or die(print_r($db->errorInfo(), true));
			} catch (PDOException $e) {
				die("DB ERROR: ". $e->getMessage());
			}	
	}
	
	function create_tables($db_name,$host,$user,$pass)
	{
		$db = new PDO("mysql:host=localhost;dbname=$db_name", $user, $pass);
		
		$apps = array_diff(scandir('apps'), array('.', '..'));
		foreach ($apps as $app)
		{
			$file = 'apps'.DS.$app.DS.'settings.json';
			if(file_exists($file))
			{
				$setting = json_decode(file_get_contents($file));
				foreach($setting as $key =>$value)
				if($key=='DB')
					foreach($value as $table =>$stmt)
						$db->exec($stmt);
			}			
		}
		
	}
	
	function Delete($path)
	{
		if (is_dir($path) === true)
		{
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $file)
			{
				Delete(realpath($path) . '/' . $file);
			}
			return rmdir($path);
		}
		else if (is_file($path) === true)
		{
			return unlink($path);
		}
		return false;
	}
	
	function update_config($db_name,$host,$user,$pass)
	{
		$root= 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		
		$config = json_decode(file_get_contents('config.json'));
		$config->SITE->ROOT = $root;
		$config->SITE->HASH = substr(md5(rand()), 0, 7);
		$config->DB->DB_NAME = $db_name;
		$config->DB->HOST = $host;
		$config->DB->USERNAME = $user;
		$config->DB->PASSWORD = $pass;
		
		file_put_contents('config.json', json_encode($config));
	}
}
?>