<?php


class Conf
{
	
static $debug=1;
static $databases=array(
'default' => array(
	'host' => 'localhost',
	'database' => 'site',
	'login'=> 'root',
	'password' =>''
),
);
}

Router::connect('/','posts/index');
Router::prefix('cockpit','admin');

Router::connect('cockpit','cockpit/posts/index');

Router::connect('pub/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');

Router::connect('pub/*','posts/*'); 	



