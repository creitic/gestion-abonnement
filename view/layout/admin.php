<?php $users_connected=new stdClass();
				$users_connected=$this->userProperty($this->Session->user('id'));
		?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<meta name="description" content="Site d'abonnement client">
	<meta name="author" content=" ">

	<title><?php echo isset($title_for_layout)?$title_for_layout:'Administration';  ?></title>
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/main.css');?>">
	<script type="text/javascript" src="<?=Router::webroot('js/html5shiv.min.js');?>"></script>
	<script type="text/javascript" src="<?=Router::webroot('js/respond.min.js');?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/bootstrap-theme.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?=Router::webroot('css/monStyle.css');?>">
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
			<div class="row">
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-left">
				<li><a  href="<?php echo Router::url('posts/serv');?>" class="<?=strpos(BASE_URL.'/'.$this->request->url,Router::url('posts/serv'))===0?'btn btn-info':''?>">Offres pro</a></li>
				
				<li><a href="<?php echo Router::url('/');?>" class="<?=strpos(BASE_URL.'/'.$this->request->url,Router::url('/'))===0?'btn btn-info':''?>">Voir le site</a></li>
				</ul> 
				<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
				 aria-expanded="false">
				 <img src="<?=$this->Session->user('photo')? 
				 Router::webroot('img/profiles/'.$this->Session->user('id').'/'.$this->Session->user('photo')
				 ) : get_avatar_url($users_connected->email);?>" alt="<?=$this->Session->user('pseudo')?>"
				  class="avatar-xs"><span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
				
				<li><a  href="<?php echo Router::url('users/');?>" class="<?=BASE_URL.'/'.$this->request->url==Router::url('users/')?'btn btn-info':''?>">Mon profile</a></li>
				<li><a  href="<?php echo Router::url('users/edit');?>" class="<?=BASE_URL.'/'.$this->request->url==Router::url('users/edit')?'btn btn-info':''?>">Editer mon profile</a></li>
				<li><a  href="<?php echo Router::url('abonnements/view');?>" class="<?=BASE_URL.'/'.$this->request->url==Router::url('abonnements/view')?'btn btn-info':''?>">Mes abonnements</a></li>

				
				<li data-toggle="tooltip"  title="Vos differents articles"><a   href="<?=$user_act?Router::url('admin/posts/index/article'):"#";?>" class=" <?=BASE_URL.'/'.$this->request->url==Router::url('admin/posts/index/article')?'btn btn-info':''?>">Mes articles</a></li>
				<li data-toggle="tooltip"  title="Vos differents services"><a  href="<?=$user_act?Router::url('admin/posts/index/service'):"#";?>" class=" <?=BASE_URL.'/'.$this->request->url==Router::url('admin/posts/index/service')?'btn btn-info':''?>" >Mes Services</a></li>
				<li data-toggle="tooltip"  title="Vos differents status"><a  href="<?=$user_act?Router::url('admin/posts/index/status'):"#";?>" class="<?=BASE_URL.'/'.$this->request->url==Router::url('admin/posts/index/status')?'btn btn-info':''?>">Mes Status</a></li>
				
				<li><a  href="<?php echo Router::url('abonnements/');?>" class="<?=BASE_URL.'/'.$this->request->url==Router::url('abonnements/')?'btn btn-info':''?>">Mes clients</a></li>
				<li class="divider"></li>
				<li><a class="btn connect-btn" href="<?php echo Router::url('users/logout');?>">Se deconnecter</a></li>
					
				</li>
				
				
				
				</ul>
			</div><!--/.nav-collapse -->
			</div>
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