
<div class="page-header">
	<h1><?= $total;?>  <?=ucfirst($type_pub);?><?=$type_pub!=='status'&&$total>1?'s':''?></h1>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>En ligne ?</th>
			<th>Titre</th>
			<th>Date de creation</th>
			<th>Date de modification</th>
			<th>Actions</th>
			
		</tr>
	</thead>
	<tbody >
		<?php foreach ($posts as $k => $v): ?>
		<tr>
		
			<td><?php echo $v->id; ?></td>
			<td><span style="color: <?php ($v->en_ligne==1)?'green;':'red;';?>">
			<?= ($v->en_ligne==1)?'En ligne':'Hors ligne' ;?></span></td>
			<td><?php echo $v->nom; ?></td>
			<td><?php echo $v->creation; ?></td>
			<td><span class="timeago" title="<?=$v->modification;?>"><?php echo $v->modification; ?></span></td>
			<td>
				<a href="<?php echo Router::url('admin/posts/edit/'.$v->id.'/'.$type_pub);?>">Editer</a>
				<a onclick="return confirm('voulez vous vraiment supprimer ce contenu');" href="<?php echo Router::url('admin/posts/delete/'.$v->id.'/'.$type_pub);?>">Supprimer</a>
				<?php if($type_pub=='article'):?>
				<a href="<?php echo Router::url('admin/medias/index/'.$v->id);?>">Gestion d'image</a>
				<?php endif;?>
			</td>
		</tr> 
	<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo Router::url('admin/posts/edit//'.$type_pub);?>" class="btn btn-info">Ajouter un <?=ucfirst($type_pub);?></a>

