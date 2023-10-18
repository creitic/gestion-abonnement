<?php $title_for_layout='Services disponibles'?>
<div class="page-header">
	<h1> SERVICES DISPONIBLES</h1>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Entreprises</th>
			<th>Service</th>
            <th>Date de publications</th>
			<th>Actions</th>
			
		</tr>
	</thead>
	<tbody >
	
		<?php foreach ($posts as $k => $v): ?>
		<tr>
		<?php 
		?>
			<td><a href="<?php echo Router::url('users/index/'.$v->fournisseur_id);?>">
        <img src="<?=$v->photo? 
				 Router::webroot('img/profiles/'.$v->fournisseur_id.'/'.$v->photo
				 ) : get_avatar_url($v->email);?>" alt="<?=$v->nom_e?>"
				  class="avatar-xs"><?= $v->nom_e; ?></a></td>
				  <td> <?php echo $v->service; ?></td>
            <td ><span class="timeago" title="<?=$v->modification;?>"><?php echo $v->modification; ?></span></td>
			<td>
			
			<?php $user_abonned=$this->user_abonned($v->service_id);?>
			<?php if($user_abonned):?>
			<a class="btn btn-danger" onclick="return confirm('voulez vous desabonner à cette service?');" href="<?php echo Router::url('posts/serv//'.$user_abonned->id);?>">Désabonner</a>
		
					<?php else:?>
			<a class="btn btn-info" href="<?php echo Router::url('posts/stat/'.$v->fournisseur_id.'/'.$v->service_id);?>">abonné ici</a>
		
			<?php endif;?>	
			</td>
		</tr> 
	<?php endforeach; ?>
	</tbody>
</table>

