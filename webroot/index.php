<?php
$debug = microtime(true);
 
 define('WEBROOT', dirname(__FILE__));
 define('ROOT', dirname(WEBROOT));
 define('DS', DIRECTORY_SEPARATOR);
 define('CORE',ROOT.DS.'core');
 define('BASE_URL',	dirname(dirname($_SERVER['SCRIPT_NAME'])));
 session_start();
require CORE.DS.'includes.php';

new Dispatcher();

?>
<!--
<div style="position:fixed; bottom:0; background:#900; color:#FFF;
line-height:30px; height:30px; left:0; right:0; padding-left:10px; ">
	<?php 
		//echo 'page générée en '. round(microtime(true) - $debug,5).' secondes';
	?>
</div>
-->