
<div id="main-content">
	<div class="container">
	
	<h1 class="lead">Zone réservée </h1>

		<!-- <form method="post" class=" well col-md-6 col-md-offset-3">    -->
        <form data-parsley-validate action="<?=Router::url('users/login');?>" 
                                                    method="post" autocomplete="off" class=" well col-md-6">


        <?= $this->Form->input('identifiant',"Nom d'utilisateurs ou Adresse electronique :",
        array('class'=>'form-control')); ?>

        <?= $this->Form->input('mot_de_passe','Mot de passe :',
        array('type'=>'password','class'=>'form-control','data-parsley-trigger'=>'change','required'=>'required')); ?>

<?= $this->Form->input('remember_me','Garder ma session active :',array('type'=>'checkbox')); ?>
<div class="clearfix">

		
            <div class="action">
			<input type="submit" name='connection' class="btn btn-info" value="Connexion"/>

            </div>
		<li><a href="<?=Router::url('users/forgot_password');?>">Mot de passe oublié?</a></li>
		</form>
	</div>
</div>
