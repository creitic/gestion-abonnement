<div id="main-content">
	<div class="container">
    	<div class="row">
		<form data-parsley-validate action="<?=Router::url('admin/posts/edit/'.$id.'/'.$type_pub);?>" 
		class=" well col-md-6" method="post" enctype="multipart/form-data">
			
        		<h1 class="lead text-center"><?=$id?'Editer':'Ajouter';?> un <?=$type_pub;?> </h1>
            		
				<div class="row">
						<?php echo $this->Form->input('nom','Titre',array('class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>
						<?php echo $this->Form->input('slug','Url',array('class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>
						<?php echo $this->Form->input('id','hidden'); ?>
						<?php switch($type_pub):?><?php case "article":?>
						<?php if(empty($id)):?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h1 class="lead text-center">Image </h1>
							</div>
                            <div class="panel-body">
							<?php echo $this->Form->input('nom_f','Titre de l\'image',array('class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>
	
							<?php echo $this->Form->input('fichier','Image',array('type'=>'file'));?>

							</div>
						</div>
						<?php endif;?>
								<?php echo $this->Form->input('contenu','Contenu',
							array(
								'placeholder'=>'Ecriver quelque chose',
								'class'=>'form-control',
								'cols'=>"30",
								'rows'=>"10",
								'type'=>'textarea')); ?>
						
						<?php break;?>
						<?php case 'status':?>
						
							<?php echo $this->Form->input('nbr_mois','Nombre de mois',
							array('type'=>'number',
							'class'=>'form-control'));?>
							<?php echo $this->Form->input('prix','Prix abonnement',
							array('class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>
						
						<?php break;?>
						<?php endswitch;?>


						<?php echo $this->Form->input('en_ligne','En ligne',array('type'=>'checkbox','class'=>'form-control')); ?>
						<div class="action">
							<input type="submit" class="btn btn-info" value="Envoyer" >
						</div>

				</div>
			</form>
		</div>
	</div>
</div>


