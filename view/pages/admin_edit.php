
<div class="page-heder">
	<h1>Editer une page</h1>
</div>
<form action="<?php echo Router::url('admin/pages/edit/'.$id);?>" method="post">
	<?php echo $this->Form->input('name','Titre'); ?>
	<?php echo $this->Form->input('slug','Url'); ?>
	<?php echo $this->Form->input('id','hidden'); ?>
	<?php echo $this->Form->input('content','Contenu',array('type'=>'textarea','class'=>'xxlarge','rows'=>5)); ?>
	<?php echo $this->Form->input('online','En ligne',array('type'=>'checkbox')); ?>
	<div class="action">
		<input type="submit" class="btn primary" value="Envoyer" >
	</div>
</form>

