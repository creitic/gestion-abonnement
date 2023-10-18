<?php $title_for_layout="Page de profil"; ?>

<div id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel panel-heading">
						<h3 class="panel-title">Profil de <?=e($user->nom_e)?></h3>
							
					</div>
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5">
						<img src="<?=$user->photo? 
				 Router::webroot('img/profiles/'.$user->id.'/'.$user->photo
				 ) : get_avatar_url($user->email);?>" alt="<?=$user->nom_e?>"
				  class="avatar-xs">
        
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<strong><?=e($user->nom_e)?></strong></br>
							<a href="mailto:<?=e($user->email)?>"><?=e($user->email)?></a></br>
							<?=
							$user->ville && $user->pays 
							?'<i class="fa fa-location-arrow"></i>&nbsp;'.e($user->ville).' - '.e($user->pays).'</br>': '';
							?>
							<a href="https://www.google.com/maps?q=<?=e($user->ville).' '.e($user->pays)?>" target="_blank">Voir sur Google Maps</a>

						</div>
						<div class="col-sm-6">
							
							<?=
							$user->sexe=='masculin'?'<i class="fa fa-male"></i>': '<i class="fa fa-female"></i>';
							?>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12 well">
							<h5>Activite de l'entreprise <?=e($user->nom_e)?></h5>
							<p>
								<?=
								$user->activite?nl2br(e($user->activite)):"";
								?>
							</p>
							
						</div>
						
					</div>
					</div>
			
				</div>
			</div>

			<div class="col-md-6">
    				
			<?= strtoupper(e($user->nom_e))?>

			</div>
			
		</div>
		
	</div>
</div>

						<!--SCRIPT-->

