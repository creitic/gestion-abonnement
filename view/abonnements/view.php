
<div class="page-header">
	<h1> Mes abonnements en cours d'utilisation</h1>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Entreprises</th>
			<th>Service</th>
			<th>status</th>
			<th>Debut </th>
            <th>fin </th>
			<th>Actions</th>
			
		</tr>
	</thead>
	<tbody >
	<?php
		$status=new stdClass();
		$services=new stdClass();
		$entreprises=new stdClass();
		?>
	
		<?php foreach ($abonnements as $k => $v): ?>
		
		<?php $status=$this->getStatus($v->status_id)?>
		<?php $services=$this->getService($v->service_id);
		?>
		<?php $entreprises=$this->userProperty($status->utilisateurs_id)?>
		<tr>
		
			
			<td><a href="<?php echo Router::url('users/index/'.$entreprises->utilisateurs_id);?>">
        <img src="<?=$entreprises->photo? 
				 Router::webroot('img/profiles/'.$entreprises->id.'/'.$entreprises->photo
				 ) : get_avatar_url($entreprises->email);?>" alt="<?=$entreprises->nom_e?>"
				  class="avatar-xs"><?= $entreprises->nom_e; ?></a></td>
			<td><?=$v->service_id?$services->nom:WEBSITE_NAME; ?></td>
			<td><?=$status->nom; ?></td>
			<td><span class="timeago" title="<?=$v->debut;?>"><?php echo $v->debut; ?></span></td>
			<td><?=$v->expiration; ?></td>
			<td>
				<a onclick="return confirm('Etes-vous sure d\'anuler l\'abonnement?');" href="<?php echo Router::url('abonnements/view/'.$v->id);?>" class="btn btn-danger">Annuler</a>
				
			</td>
		</tr> 
	<?php endforeach; ?>
	</tbody>
</table>


