<?php 
require_once '../core/config.php';
require_once DIR_CORE.'Model.php';
require_once DIR_CORE.'View.php';
require_once DIR_CORE.'CoreController.php';
require_once DIR_CORE.'Xhr.php';

require_once DIR_CORE.'Session.php';

require_once DIR_CORE.'functions.php';
require_once DIR_CORE.'tools.php';
require_once DIR_LANG.LANG.'.php';

// start session
S::init();

header('Content-type: application/json');

if(isset($_GET['a']) && isset($_GET['m']))
{
	$app = $_GET['a'];
	$method = $_GET['m'];
	
	if(is_dir(DIR_APP.$app))
	{
		require_once DIR_APP.$app.'/'.$app.'.model.php';
		require_once DIR_APP.$app.'/'.$app.'.view.php';
		require_once DIR_APP.$app.'/'.$app.'.xhr.php';
		require_once DIR_LANG.$app.'.lang.'.LANG.'.php';
		
		$app = $app.'Xhr';
		
		$app = new $app();
		
		if(method_exists($app, $method))
		{
			if($return = $app->$method())
			{
				if(is_array($return))
				{
					$return = array_merge(array(
						'status' => 1,
						'data' => false
					),$return);
				}
				else
				{
					$return = array(
						'status' => 1,
						'data' => $return
					);
				}
				
				echo json_encode($return);
				exit();
			}
		}
	}
}

echo '{"status":0}';