$(document).ready(function(){
$('.img_formular').submit(function(event){
event.preventDefault();
var nom_f=$('#inputnom_f').val();
var fichier=$('#inputfichier').val();
alert($_FILES);

return false;
});
});