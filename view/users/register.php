<?php $title_for_layout="Inscription"; ?>
<div id="main-content">
	<div class="container">
    <div class="row">
 <!-- <form method="post" class=" well col-md-6 col-md-offset-3">    -->
 <form data-parsley-validate action="<?=Router::url('users/register');?>" 
                                                method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="panel panel-default">
        <h1 class="lead text-center">Devenez dès à present membre </h1>
            <div class="panel-body">
                <div class="row">
                <!--informations sur les utilisateurs-->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <?= $this->Form->input('pseudo',"Nom d'utilisateurs :",
    array('class'=>'form-control','data-parsley-minlength'=>'3','required'=>'required')); ?>
    
    <?= $this->Form->input('email','Adresse email :',
    array('class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>	
    
    <?= $this->Form->input('mot_de_passe','Mot de passe :',
    array('type'=>'password','class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>
    
    <?= $this->Form->input('password_confirm','Confirmer votre mot de passe :',
    array('type'=>'password','class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required',
    'data-parsley-equalto'=>'#inputmot_de_passe')); ?>
    

<?= $this->Form->select('pays','Pays :',
    array('values'=>$this->Session->locales()->country,'class'=>'form-control')); ?>

<?= $this->Form->input('ville','Ville :',
    array('class'=>'form-control','required'=>'required')); ?>	
    
        <a href="<?=Router::url('users/login');?>">Vous avez dejà un compte?</a>
  
<div class="action text-right">
    <input type="submit" name='register' class="btn btn-info" value="Inscription"/>
    </div>

    

                                <!--informations sur les utilisateurs-->
                             </div>    
                            
                        </div>
                    </div>

                    <!--informations sur l'organisation-->
                    <div class="col-md-6">
                        <div class="panel panel-default">

                            <div class="panel-body">
                            
                                <!--informations sur les utilisateurs-->
                                <?= $this->Form->input('nom_e','Entreprise ou organisation:',array('class'=>'form-control','required'=>'required')); ?>

   
    <?= $this->Form->input('nom','Nom du responsable :',array('class'=>'form-control','required'=>'required')); ?>

    <?= $this->Form->input('prenom','Prénom du responsable :',
array('class'=>'form-control','data-parsley-minlength'=>'3','required'=>'required')); ?>

<?= $this->Form->input('cin','CIN du responsable :',
array('class'=>'form-control','data-parsley-minlength'=>'10','required'=>'required')); ?>
<?= $this->Form->input('photo','Photo de profile :',
array('type'=>'file')); ?>
<?= $this->Form->input('sexe','Sexe :',
    array('type'=>'radio','values'=>array('masculin'=>'masculin','feminin'=>'féminin'))); ?>
     <?php echo $this->Form->input('activite','Activité ou description de l\'entreprise',
							array(
								'placeholder'=>'Ecriver quelque chose',
								'class'=>'form-control',
								'cols'=>"30",
								'rows'=>"10",
								'type'=>'textarea')); ?>
                             </div>    
                            
                        </div>
                    </div>
        
                </div>


            </div>
            
        </div>
        
        
		
            </form>
	</div>
    </div>
</div>