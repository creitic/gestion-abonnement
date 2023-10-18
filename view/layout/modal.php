<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<meta name="description" content="Site d'abonnement client">
	<meta name="author" content="Claudio ramahavita">
	<link rel="shortcut icon" href="<?=Router::webroot('img/logo/logo.jpg');?>">

	<title><?php echo isset($title_for_layout)?$title_for_layout:'Administration';  ?></title>
	<script type="text/javascript" src="<?=Router::webroot('js/html5shiv.min.js');?>"></script>
	<script type="text/javascript" src="<?=Router::webroot('js/respond.min.js');?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/bootstrap-theme.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/main.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/style.css');?>">

</head>
<body class='home'>
<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				
			<a class="navbar-brand" href="<?php echo Router::url('admin/posts/index');?>">

Admin<span class="text-info">istration</span>

</a>
			</div>
			
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
				<li><a class="btn btn-warning" href="<?php echo Router::url('admin/posts/index');?>" >Services</a></li>
				<li><a class="btn btn-info" href="<?php echo Router::url('admin/posts/index');?>" >Articles</a></li>
				<li><a href="<?php echo Router::url('/');?>">Voir le site</a></li>
				<li><a class="btn connect-btn" href="<?php echo Router::url('users/logout');?>">Se deconnecter</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
		
	<div class="container" style="padding-top: 100px;">
		<?php echo $this->Session->flash();?>
		<?php echo $content_for_layout;?>
	</div>
	

</body>
<script type="text/javascript" src="<?=Router::webroot('js/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?=Router::webroot('js/bootstrap.min.js');?>"></script>

<script type="text/javascript" src="<?=Router::webroot('js/headroom.min.js');?>"></script>
<script type="text/javascript" src="<?=Router::webroot('js/jQuery.headroom.min.js');?>"></script>
<script type="text/javascript" src="<?=Router::webroot('js/template.js');?>"></script>
<script type="text/javascript" src="<?=Router::webroot('libraries/parsley/parsley.min.js');?>"></script>
<script type="text/javascript" src="<?=Router::webroot('libraries/parsley/i18n/fr.js');?>"></script>
<script type="text/javascript">
		window.ParsleyValidator.setLocale('fr');
	</script>
</html>