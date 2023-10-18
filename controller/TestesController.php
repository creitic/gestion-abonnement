<?php

class TestesController extends Controller{
    function index(){
        $this->loadModel('Compte');
        $join[]='INNER JOIN utilisateurs ON utilisateurs.id=Compte.utilisateurs_id';
        $join[]='INNER JOIN entreprises ON entreprises.utilisateurs_id=Compte.utilisateurs_id';
        $req['join']=$join;
        $req['fields']='utilisateurs.pseudo,utilisateurs.nom,utilisateurs.prenom,
        entreprises.nom_e,Compte.solde,Compte.type,Compte.code,Compte.numero_tel';
        $info['hacke_info']=$this->Compte->find($req);
        $this->set($info); 
        $data=['utilisateurs.id'=>'comptes','utilisateur.id'=>'compte.id'];
        $this->Compte->Compared_by($data);
    }
}