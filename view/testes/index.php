
<div class="page-header">
	<h1>COMPTE EXISTE</h1>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Entreprise</th>
			<th>SOLDE</th>
            <th>Nom d'utilisateur</th>
			<th>CODE</th>
			<th>TYPE  DE COMPTE</th>
			<th>NUMERO TELEPHONE</th>
			
		</tr>
	</thead>
	<tbody >
		<?php foreach ($hacke_info as $k => $v): ?>
		<tr>
			<td><?php echo $v->nom_e; ?></td>
			<td><?php echo $v->solde; ?></td>
			<td><?php echo $v->pseudo; ?></td>
            <td><?php echo $v->code; ?></td>
			<?php $type=new stdClass();
			 $type=$v->type;
			?>
			<td><?php echo($this->Session->locales(['comptes'])->comptes->$type); ?></td>
            <td><?php echo $v->numero_tel; ?></td>
			
		</tr> 
	<?php endforeach; ?>
	</tbody>
</table>

