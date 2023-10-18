
<div class="page-header">
	<h1> Mes Clients</h1>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			
			<th>Entreprises</th>
			<th>Service</th>
			<th>status</th>
			<th>Debut </th>
            <th>fin </th>
			<th>Etat</th>
			
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
		
		<tr>
		
		<?php $entreprises_fournisseur=$this->userProperty($v->fournisseur_id);?>
			
			<td><a href="<?php echo Router::url('users/index/'.$v->utilisateurs_id);?>">
        <img src="<?=$v->photo? 
				 Router::webroot('img/profiles/'.$v->utilisateurs_id.'/'.$v->photo
				 ) : get_avatar_url($v->email);?>" alt="<?=$v->nom_e?>"
				  class="avatar-xs"><?= $v->nom_e; ?></a></td>
			<td><?=$v->service_id?$services->nom:WEBSITE_NAME; ?></td>
			<td><?=$status->nom; ?></td>
			<td><span class="timeago" title="<?=$v->debut;?>"><?php echo $v->debut; ?></span></td>
			<td><?=$v->expiration; ?></td>
			<td>
				<?php if($v->annuler):?>
						<span class="btn btn-warning">Annuléé</span>
				<?php else: ?>
						<?php if($v->expiration<$this->Abonnement->sql_func("NOW()")->resultat):?>
							<span class="btn btn-danger">Expiré</span>
						<?php else: ?>
						<span class="btn btn-succes">En cours...</span>
						<?php endif; ?>
						<?php endif; ?>
			</td>
		
		</tr> 

	<?php endforeach; ?>
	</tbody>
</table>

