
<form action="<?php echo Router::url('abonnements/add/');?>" method="post" class=" well col-md-8 col-md-offset-2" enctype="multipart/form-data">
<div class="page-header">
<h2><?= !empty($status->status_id)? strtoupper($status->nom_e).' vous offres son service':'';?></h2>
	<h1><?= !empty($service_id)?'Abonnement au service '.strtoupper($services->nom):"Abonnement sur le ".WEBSITE_NAME;?></h1>
    <h2>Vous allez vous souscrire au status <?=strtoupper($status->status_nom)?></h2>
    <h3>prix :<?=$status->prix;?> Ar</h3>
    <h4>Pour une duree :<?=$status->nbr_mois;?>Mois</h4>
    <?php echo $this->Form->input('fournisseur_id','hidden'); ?>
    <?php echo $this->Form->input('service_id','hidden'); ?>
    <?php echo $this->Form->input('status_id','hidden'); ?>
</div> 
<?php ;?>

                <div class="action">
				    <input type="submit" class="btn btn-success" name="isConfirme" value="Comfirmer" >
                    <input type="submit" class="btn btn-warning" name="isCancel" value="Annuler" >
				</div>
    
    </form>	
