<?php $title_for_layout='Actualités'?>
<div class="page-header">
	<h1>Les Services bientot disponibles</h1>
</div>
<div id="main-content">
	<div class="container">
<?php foreach ($posts as $k => $v):?>
<div class="row col-md-9">
<article class="media status-media" > 
	<div class="pull-left"> 
	<a href="<?php echo Router::url('users/index/'.$v->utilisateurs_id);?>">
        <img src="<?=$v->photo? 
				 Router::webroot('img/profiles/'.$v->utilisateurs_id.'/'.$v->photo
				 ) : get_avatar_url($v->email);?>" alt="<?=getExrait($v->nom_e,4);?>"
				  class="media-object avatar-xs"><?= getExrait($v->nom_e,4); ?></a></div>
				  
				  <div class="media-body">
	<h4 class="media-heading text-info"><?= e($v->nom); ?></h4> 
	<p><i class="fa fa-clock-o"></i> 
<span class="timeago title" title="<?=$v->modification;?>"><?php echo $v->modification; ?></span>
	
	
	

	<?php $d['images']=$this->medias->admin_index($v->id);extract($d);?>
		<?php if($d['images']):?>
			<?php $id=$v->id;$utilisateurs_id=$v->utilisateurs_id;?>
		<div id="mnCarousel<?=$id?>" class="carousel slide well col-md-3" style="max-width:150px;max-height:150px;" data-ride="carousel">
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
							<img class="avatar-md product-image" src="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$utilisateurs_id.DS.$fichier) ; ?>">
								<div class="carousel-caption">
									<h3><?=$nom_f?></h3>
								</div>
							</div>
							<?php $class_active=true;?>
							<?php else:?>
							<div class="item">
							<img class="avatar-md product-image" src="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$utilisateurs_id.DS.$fichier) ; ?>">
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
		<p class="well col-md-offset-3"><?= nl2br(getExrait($v->contenu,400)); ?><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:{$v->slug}"); ?>">Lire la suite &rarr;</a> </p>
<hr>

</div>

</div>
</article>
<?php endforeach ;?>
<div id="pagination" class="col-md-9 center" style="padding-bottom:100px;"><?= $pagination?></div>
</div>
</div>
