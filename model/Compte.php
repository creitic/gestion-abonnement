<?php

class Compte extends Model
{
    
 function isCompte($data){
     $req=array();
     $join=[];
     $req['inner join']='utilisateurs ';
     $req['on']='utilisateurs.id=Compte.utilisateurs_id';
     $req['fields']='Compte.*,utilisateurs.*';
     $req['conditions']=$data;
     if(isset($data->code)){
        $req['conditions']=array(
            'Compte.code'=>$data->code,
            'Compte.type'=>$data->type,
            'Compte.numero_tel'=>$data->numero_tel,
            'Compte.utilisateurs_id'=>$data->utilisateurs_id
        );
      
     }
    return $this->findFirst($req);
 }
 function transanction_errors($data){

    $errors=[];
    $cond=["Compte.utilisateurs_id"=>$data->status->fournisseur_id];
    if(!$this->isCompte($cond)){
        $errors[]="La transaction ne peut pas effectuer
        car votre fournisseur n\'as pas de Compte!";
    }
    elseif(!$this->isCompte($data->users->comptes)){
        $errors[]="Information invalide!";
    }
    elseif($this->isCompte($data->users->comptes)->solde < $data->status->prix){
        $errors[]="Votre solde est insuffisant pour effectuer cette opération!!','Veuillez recharger votre comptes!!";
    }
    return $errors;
 }
 
}