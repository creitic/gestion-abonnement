<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<meta name="description" content="Site d'abonnement client">
	<meta name="author" content=" ">

	<title><?php echo isset($title_for_layout)?$title_for_layout:WEBSITE_NAME;  ?></title>
	<script type="text/javascript" src="<?=Router::webroot('js/html5shiv.min.js');?>"></script>
	<script type="text/javascript" src="<?=Router::webroot('js/respond.min.js');?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/bootstrap-theme.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/main.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/style.css');?>">

</head>
<body class='home'>
<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				
			<a class="navbar-brand" href="<?=Router::url('/');?>">

PLATEFORME<span class="text-info">-SaaS</span>

</a>
			</div>
			
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="<?=Router::url('/');?>" class="<?=strpos(BASE_URL.'/'.$this->request->url,Router::url('/'))===0?'btn btn-info':''?>">Actualités</a></li>
					<li><a href="<?php echo Router::url('posts/serv');?>" class="<?=strpos(BASE_URL.'/'.$this->request->url,Router::url('posts/serv'))===0?'btn btn-info':''?>">Offre pro</a></li>
					<li><a href="<?=Router::url('users/login');?>" class="<?=strpos(BASE_URL.'/'.$this->request->url,Router::url('users/login'))===0?'btn btn-info':''?>">Se connecter</a></li>
					<li><a  href="<?=Router::url('users/register');?>" class="<?=strpos(BASE_URL.'/'.$this->request->url,Router::url('users/register'))===0?'btn btn-info':''?>">S'inscrire</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
		
	<div class="container" style="padding-top: 100px;">
		<?php echo flash();?>
		<?php echo $content_for_layout;?>
	</div>
	

</body>
<script src="<?=Router::webroot('js/jquery.min.js');?>"></script>
<script src="<?=Router::webroot('js/bootstrap.min.js');?>"></script>

<script src="<?=Router::webroot('libraries/timeago/jquery.timeago.js');?>"></script>
<script src="<?=Router::webroot('libraries/timeago/jquery.timeago.fr.js');?>"></script>
<script src="<?=Router::webroot('libraries/timeago/jquery.livequery.min.js');?>"></script>
<script src="<?=Router::webroot('js/headroom.min.js');?>"></script>
<script src="<?=Router::webroot('js/jQuery.headroom.min.js');?>"></script>
<script src="<?=Router::webroot('js/template.js');?>"></script>
<script src="<?=Router::webroot('libraries/parsley/parsley.min.js');?>"></script>
<script src="<?=Router::webroot('libraries/parsley/i18n/fr.js');?>"></script>
<script type="text/javascript">
		window.ParsleyValidator.setLocale('fr');
		$(document).ready(function(){$(".timeago").timeago();});
		$(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</html>