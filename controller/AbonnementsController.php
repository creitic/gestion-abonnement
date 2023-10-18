<?php
class AbonnementsController extends Controller{
  public $data;
  public $d;
  
    function confirm(){
        require ROOT.DS.'controller'.DS.'PostsController.php';
        $this->loadModel('Compte');
        $posts_con=new PostsController();
        if(!empty($this->request->data->status_id)){
            $posts_con->billposting($this->request->data->fournisseur_id,
            $this->request->data->service_id,
            $this->request->data->status_id);
        }
        $d=$posts_con->service_status;
        $this->d=array();
        $d['posts_con']=$posts_con;
        $this->d=$d;
		$this->set($d);
        if(!empty($this->request->data)){
			
			$datas=new stdClass();
		
			$datas->users=new stdClass();
			$datas->users->comptes=new stdClass();
			$datas->status=new stdClass();

			$datas->status_id=$this->request->data->status_id;
			//Verification de compte
            extract($d);//---
            $datas->users->comptes->utilisateurs_id=$this->Session->user('id');
			$datas->users->comptes->code=$this->request->data->code;
			$datas->users->comptes->type=$this->request->data->type;
			$datas->users->comptes->numero_tel=$this->request->data->numero_tel;
			$datas->status=$status;
			$err=[];
			$err=$this->Compte->transanction_errors($datas);
			if(count($err)==0){
			$this->loadModel('Abonnement');
			$user_comptes=$this->Compte->isCompte($datas->users->comptes);
            $fournisseur_comptes=$this->Compte->isCompte('Compte.utilisateurs_id='.$datas->status->utilisateurs_id);
            $this->data=new stdClass();
            $this->data->datas=new stdClass();
            $this->data->datas=$datas;
            $this->data->user_comptes=new stdClass();
            $this->data->fournisseur_comptes=new stdClass();
            $this->data->fournisseur_comptes=$fournisseur_comptes;
            $this->data->user_comptes=$user_comptes;
            $d['user_comptes']=new stdClass();
            $d['fournisseur_comptes']=new stdClass();
            $d['user_comptes']=$this->data->user_comptes;
            $d['fournisseur_comptes']=$this->data->fournisseur_comptes;
           
            $this->set($d);
			}else{
                $status_id=$this->request->data->status_id;
                $service_id=$this->request->data->service_id;
                $fournisseur_id=$this->request->data->fournisseur_id;
                setFlash($err,'danger');
                $this->redirect("posts/billposting/$fournisseur_id/$service_id/$status_id");			
	 }
    }else{
        setFlash("Abonnement a été annulé, reessayer Si vous voulez bien abonnée!","info");
		$this->redirect("posts/serv/");
	}
}
   
function add(){
    $this->confirm();
    $d=$this->d;
    $d['posts_con']=$this;
    $this->set($d);
    $this->d=$d;
    $this->loadModel('Abonnement');
    $status_id=$this->request->data->status_id;
    $service_id=$this->request->data->service_id;
    $fournisseur_id=$this->request->data->fournisseur_id;

if(isset($this->request->data->isConfirm)){
    //on dimunie users_comptes->solde
     
    $this->data->user_comptes->solde=$this->data->user_comptes->solde - $this->data->datas->status->prix;
    
            //on augmente fournisseur_comptes->solde
  
    $this->data->fournisseur_comptes->solde=$this->data->fournisseur_comptes->solde + $this->data->datas->status->prix;
    
        $this->Abonnement->val->utilisateurs_id= $this->data->user_comptes->utilisateurs_id;
        if(!empty($service_id)){
            $this->Abonnement->val->service_id=$service_id;
        }
        $this->Abonnement->val->status_id=$status_id;
        $nbr_mois=$this->data->datas->status->nbr_mois;
        $this->Abonnement->val->expiration=
        $this->Abonnement->sql_func("DATE_ADD(NOW(),INTERVAL $nbr_mois MONTH)")->resultat;
        $this->Abonnement->save($this->Abonnement->val);
        $this->Compte->primaryKey='code';
          if(!empty($this->Abonnement->id)){
              $u_comptes=new stdClass();
              $f_comptes=new stdClass();
              $index=['utilisateurs_id','code','numero_tel','solde'];
              
              $u_comptes=$this->get_elementKey($this->data->user_comptes,$index);
              $f_comptes=$this->get_elementKey($this->data->fournisseur_comptes,$index);
              
            $this->Compte->save($u_comptes);
            $this->Compte->save( $f_comptes);
            setFlash("Votre abonnement a bien été effectué avec succées!!");
            $this->redirect("abonnements/view/");
          }else{
            setFlash("Il y a un 
            erreur lors de la transaction, reessayer Si vous voulez bien abonnée!","info");
            $this->redirect("posts/billposting/$fournisseur_id/$service_id/$status_id");
          }	
    }else{
        setFlash("Abonnement a été annulé, reessayer Si vous voulez bien abonnée!","info");
		$this->redirect("posts/serv/");
	}
            
}
  
   
    function view($id=null){
        $d[]=null;
        if(!empty($id)){
            $this->canceled_abonned($id);
        }
        $id=null;
        $this->loadModel('Abonnement');

		$cond0=array(
            'utilisateurs_id'=>$this->Session->user('id'),
            'annuler'=>0
            );
   
        $cond1=array(
                'expiration'=>$this->Abonnement->sql_func("NOW()")->resultat
            );

        $cond=[];
        $cond0=$this->Abonnement->Compared_by($cond0); 
        $cond1=$this->Abonnement->Compared_by($cond1,">=");

        $cond[]=$this->Abonnement->separed_by($cond0);
        $cond[]=$cond1[0];//

		$d['abonnements']=$this->Abonnement->find(array(
        'conditions'=>$this->Abonnement->separed_by($cond),//
        'order by'=>"debut DESC"
		));

        $this->set($d);
        if(empty($d['abonnements'])){
            setFlash('Vous n\'ètes pas encore Abonnée à aucun service!','info');
        }
    }
    
       
    //Tous les clients abonne à mes services
    function index(){
       
        
        $this->loadModel('Abonnement');
        $fournisseur_id=$this->Session->user('id');
        $join[]="INNER JOIN utilisateurs ON Abonnement.utilisateurs_id=utilisateurs.id";
        $join[]="INNER JOIN entreprises ON Abonnement.utilisateurs_id=entreprises.utilisateurs_id";
        $join[]="INNER JOIN publications ON publications.id=Abonnement.status_id";

        $req['fields']='Abonnement.*,publications.utilisateurs_id as fournisseur_id,utilisateurs.pseudo,utilisateurs.email,utilisateurs.photo,entreprises.*';
        $req['conditions']='Abonnement.utilisateurs_id!='.$fournisseur_id.
        ' AND publications.utilisateurs_id='.$fournisseur_id.' AND publications.type=\'status\'';
       
        $req['join']=$join;
        $req['order by']="debut DESC";

		$d['abonnements']=$this->Abonnement->find($req);
        $this->set($d);
        if(empty($d['abonnements'])){
            setFlash('Vous n\'avez pas de client Abonnée!','info');
        }

    }
    
}