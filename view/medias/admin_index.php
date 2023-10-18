
<div class="page-header">
	<h1 class='text-center'>Ajouter une image</h1>
</div> 
<form action="<?php echo Router::url('admin/medias/index/'.$publications_id);?>" method="post" class=" well col-md-8 col-md-offset-2" enctype="multipart/form-data">
	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>Titre</th>
				<th>Actions</th>
			</tr>
		</thead>
	<tbody >
		<?php foreach ($images as $k => $v): ?>
		
		<tr>
		
			<td><img src="<?=Router::webroot('img'.DS.$type_pub.'s'.DS.$user_pub.DS.$v->fichier) ; ?>" class="avatar-md"></td>
			<td><?php echo $v->nom_f; ?></td>
			<td>
				<a onclick="return confirm('voulez vous vraiment supprimer cette image');" href="<?php echo Router::url('admin/medias/delete/'.$v->id);?>" class="btn btn-danger">Supprimer</a>
			</td>
		</tr> 
	<?php endforeach; ?>
	</tbody>
	</table>

	

			<div class="panel panel-default">
					<div class="panel-heading">
								<h1 class="lead text-center">Ajouter une image </h1>
					</div>
                    <div class="panel-body">
						<?php echo $this->Form->input('nom_f','Titre de l\'image',array('class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>
	
						<?php echo $this->Form->input('fichier','Image',array('type'=>'file'));?>		
					</div>
			</div>

				<div class="action">
				<input type="submit" class="btn btn-info" value="Ajouter" >
				</div>
	</form>	
