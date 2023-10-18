
<?php  $title_for_layout=$post->nom;?>

<div class="page-header">
<h1><?php echo $post->nom;?></h1>
</div>
<div id="main-content">
	<div class="container">

<div class="row col-md-9">
<article class="media status-media" > 
	<div class="pull-left"> 
	<a href="<?php echo Router::url('users/index/'.$post->utilisateurs_id);?>">
        <img src="<?=$post->photo? 
				 Router::webroot('img/profiles/'.$post->utilisateurs_id.'/'.$post->photo
				 ) : get_avatar_url($post->email);?>" alt="<?=$post->nom_e?>"
				  class="media-object avatar-xs"><?= $post->nom_e; ?></a></div>
				  
				  <div class="media-body">
	<h4 class="media-heading text-info"><?= e($post->nom); ?></h4> 
	<p><i class="fa fa-clock-o"></i> 
<span class="timeago title" title="<?=$post->modification;?>"><?php echo $post->modification; ?></span>
	
	
	

	<?php $d['images']=$this->medias->admin_index($post->id);extract($d);?>
		<?php if($d['images']):?>
			<?php $id=$post->id;$utilisateurs_id=$post->utilisateurs_id;?>
		<div id="mnCarousel<?=$id?>" class="carousel slide col-md-3" style="width:35%;height:35%;" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php $class_active=false;?>
					<?php foreach ($images as $kley => $val):?>
						<?php $fichier=$val->fichier;
							$nom_f=$val->nom_f;
						?>
						<?php if(!$class_active):?>
							<li data-target="#mnCarousel<?=$id?>" 
							data-slide-to="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$utilisateurs_id.DS.$fichier) ; ?>" 
							class="active"></li>
							<?php $class_active=true;?>
							<?php else:?>
							<li data-target="#mnCarousel<?=$id?>" 
							data-slide-to="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$utilisateurs_id.DS.$fichier) ; ?>"></li>
							<?php endif;?>
					<?php endforeach;?>
				</ol>
				<div class="carousel-inner" role="listbox">
					<?php $class_active=false;?>
					<?php foreach ($images as $kley => $val):?>
						<?php $fichier=$val->fichier;
							$nom_f=$val->nom_f;
						?>
						<?php if(!$class_active):?>
							<div class="item active">
							<img class="center" src="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$utilisateurs_id.DS.$fichier) ; ?>">
								<div class="carousel-caption">
									<h3><?=$nom_f?></h3>
								</div>
							</div>
							<?php $class_active=true;?>
							<?php else:?>
							<div class="item">
							<img class="center" src="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$utilisateurs_id.DS.$fichier) ; ?>">
								<div class="carousel-caption">
									<h3><?=$nom_f?></h3>
									</div>
							</div>
							<?php endif;?>
					<?php endforeach;?>
				</div>
				<a href="#mnCarousel<?=$id?>" class="left carousel-control" role="button" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left"></span>
	</a>

	<a href="#mnCarousel<?=$id?>" class="right carousel-control" role="button" data-slide="next">
	<span class="glyphicon glyphicon-chevron-right"></span>
	</a>

		</div>
		
		<?php endif;?>
		<p class="well col-md-offset-4"><?= nl2br(e($post->contenu)); ?></p>
<hr>

</div>

</div>
</article>

</div>
</div>
