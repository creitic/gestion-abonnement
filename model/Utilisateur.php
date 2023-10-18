<?php



class Utilisateur extends Model
{
	var $validate = array(
		'name'=> array(
			'rule' => 'notEmpty',
			'message'=>'Vous devez préciser un titre'
		),
		'slug'=> array(
			'rule' => '([a-z0-9\-]+)',
			'message'=>"L'url n'est pas valide"
		),
	);
function regist_validates($data){
	$errors=[];
	if ($this->not_empty(['nom','pseudo','email','mot_de_passe','password_confirm','nom_e'])){
            if (mb_strlen($data->pseudo)<3) {
                $errors[]="Nom d'utilisateur trop court !(Minimum 3 caractères)";
            }
            if (!filter_var($data->email,FILTER_VALIDATE_EMAIL)) {
                $errors[]="Adresse email invalide!"; 
            }
            if (mb_strlen($data->mot_de_passe)<6) {
                $errors[]="Mot de passe trop court !(Minimum 6 caractères)";   
            }
            else{
                if ($data->mot_de_passe!=$data->password_confirm) {    
                    $errors[]="Les deux mots de passe ne concordent pas!";
                }
            }
            $errors[]=$this->errors_img_import('photo');
            
        	$user=$this->findFirst(array(
            'conditions'=>array('email'=>$data->email)
            ));
            if (!empty($user)) {
                $errors[]="Adresse email déjà utilisé!";
            }
            $user=$this->findFirst(array(
                'conditions'=>array('pseudo'=>$data->pseudo)
            ));
            if (!empty($user)) {
                $errors[]="Pseudo déjà utilisé!";
            }
        }else{
            $errors[]="Veuillez S'il vous plait remplir tous les champs!";
		}
			return $errors;	
}
	public function bcrypt_hash_password($value,$options=array()){
		$cost=isset($options['rounds'])? $options['rounds'] : 10;
		$hash=password_hash($value, PASSWORD_BCRYPT,array('cost'=>$cost));
		if ($hash==false) {
			throw new Exception("bcrypt hashing n'est pas supporté.");
			
		}
		return $hash;
	}
	public function bcrypt_verify_password($value,$hashedValue){
		return password_verify($value, $hashedValue);
	}
}