<?php 
if(empty($this->request->data)){
    $this->request->data=new stdClass();
}
$this->request->data->fournisseur_id=$fournisseur_id;
$this->request->data->service_id=$service_id;
$this->request->data->status_id=$status_id;
?>
<form action="<?php echo Router::url('abonnements/confirm/');?>" autocomplete="off" method="post" class=" well col-md-8 col-md-offset-2">

<div class="page-header">
<h2><?= !empty($status_id)? strtoupper($status->nom_e).' vous offres son service':'';?></h2>
	<h1><?= !empty($service_id)?'Abonnement au service '.strtoupper($services->nom):"Abonnement sur le ".WEBSITE_NAME;?></h1>
    <h2>Vous allez vous souscrire au status <?=strtoupper($status->status_nom)?></h2>
    <h3>prix :<?=$status->prix;?> Ar</h3>
    <h4>Pour une duree :<?=$status->nbr_mois;?>Mois</h4>
</div>  

<?php echo $this->Form->input('fournisseur_id','hidden'); ?>
    <?php echo $this->Form->input('service_id','hidden'); ?>
    <?php echo $this->Form->input('status_id','hidden'); ?>

		<div class="panel panel-default ">
			
                <div class="panel-body">
    <?= $this->Form->input('code','Code',
                        array(
                                'class'=>'form-control',
                                'data-parsley-trigger'=>'change',
                                'required'=>'required'
                            )); ?>

<?= $this->Form->select('type','Comptes ',
    array('values'=>$this->Session->locales(['comptes'])->comptes,'class'=>'form-control')); ?>
	
	<?= $this->Form->input('numero_tel','Numero telephone ',
    array('class'=>'form-control','required'=>'required')); ?>							
					</div>
			</div>

				<div class="action">
				<input type="submit" class="btn btn-info" name="validation" value="valider" >
				</div>
  
    
    </form>	
