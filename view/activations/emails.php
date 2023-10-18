<!DOCTYPE html>
<html lang="fr">
<head >
	<meta charset="utf-8">
</head> 
<body>
	<h1>Activation de compte!</h1>
	<h2>Nom d'utilisateur :<?=$data->pseudo;?></h2>
	<h2>Mot de passse : <?=$data->mot_de_passe;?></h2>
	Pour activer votre compte, veuillez cliquer sur ce lien :
	<a href="<?=Router::url(BASE_URL.'/activations/emails/?p='.$data->pseudo.'&amp;token='.$token); ?>">Lien d'activation</a>
</body>
</html>