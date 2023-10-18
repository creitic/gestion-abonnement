
<?php  $this->request->data=$user;?>
<?php $title_for_layout="Edition de profil"; ?>

<div id="main-content">
	<div class="container">
    <div class="row">
 <!-- <form method="post" class=" well col-md-6 col-md-offset-3">    -->
 <form data-parsley-validate class="col-md-6 col-md-offset-3" action="<?=Router::url('users/edit');?>" 
                                                method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h1 class="panel-title">Completer mon profile </h1>
            </div>
            <div class="panel-body">
            <?php echo $this->Form->input('id','hidden'); ?>
            <?= $this->Form->input('nom_e','Entreprise ou organisation:',array('class'=>'form-control','required'=>'required')); ?>
            <?= $this->Form->input('nom','Nom du responsable :',array('class'=>'form-control','required'=>'required')); ?>
    <?= $this->Form->input('prenom','Prénom du responsable :',
array('class'=>'form-control','data-parsley-minlength'=>'3','required'=>'required')); ?>

    <?= $this->Form->select('pays','Pays :',
    array('values'=>$this->Session->locales()->country,'class'=>'form-control')); ?>

    <?= $this->Form->input('ville','Ville :',
    array('class'=>'form-control','required'=>'required')); ?>	
<img src="<?=$this->userProperty($this->Session->user('id'))->photo? 
Router::webroot('img/profiles/'.$this->Session->user('id').'/'.$this->userProperty($this->Session->user('id'))->photo
) : get_avatar_url($this->userProperty($this->Session->user('id'))->email);?>" alt="<?=$this->userProperty($this->Session->user('id'))->nom_e?>"
 class="avatar-xs">
    <?= $this->Form->input('photo','Photo de profile:',
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
    <?php  $this->request->data='';?>
<div class="action text-right">
    <input type="submit" name='register' class="btn btn-primary" value="Mis à jour"/>
    </div>
         
            </div> 
            
        </div>
        
        
		
            </form>
	</div>
    </div>
</div>
						
