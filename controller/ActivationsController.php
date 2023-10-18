<?php

class ActivationsController extends Controller{

 function emails($pseudo,$token){
    if(!empty($p) && !empty($t)){
        $this->loadModel('Utilisateur');
        $req['conditions']='pseudo='.$pseudo;
        $user=$this->Utilisateur->findFirst($req); 
    
    if(!empty($user)){
                
        $token_verif=sha1($pseudo.$user->email.$user->mot_de_passe);
        
        if($token==$token_verif){
           $user->active=1;
           $this->Utilisateur->save($user);
            setflash('votre compte a été bel et bien activé');
            $this->redirect('users/login');
    
        }else{
            setflash('Jeton de sécurité invalide','danger');
            $this->redirect('/');
        }
    
    }else{
        $this->redirect('/');
    }
 }
}
}