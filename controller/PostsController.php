<?php

class PostsController extends Controller{
	public $service_status;
	public $datas;
	public $medias;
public $posts_=['status','article','service'];
function view($id,$slug,$tp='article'){
	$d['type_pub']=$tp;
	require ROOT.DS.'controller'.DS.'MediasController.php';
	$perPage=1;
	$this->loadModel('Publication');
	$this->medias=new MediasController();
	$join[]='INNER JOIN utilisateurs ON utilisateurs.id=Publication.utilisateurs_id';
	$join[]='INNER JOIN entreprises ON entreprises.utilisateurs_id=Publication.utilisateurs_id';
	$post['join']=$join;
	$post['fields']='Publication.*,utilisateurs.photo,utilisateurs.email,entreprises.nom_e';
	$post['conditions']="en_ligne=1 AND Publication.type='$tp' AND Publication.id=$id";
	$post['order by']="Publication.modification DESC";

$this->loadModel('Publication');
$d['post']=$this->Publication->findFirst($post);

if(empty($d['post'])){
	$this->e404('Page introuvable');
}
if($slug!= $d['post']->slug){
	$this->redirect("posts/view/id:$id/slug:".$d['post']->slug,301);
}

$this->set($d);

}
	function index($tp='article',$page=null){
		require ROOT.DS.'controller'.DS.'MediasController.php';
		$perPage=1;
		$this->loadModel('Publication');
		$this->medias=new MediasController();
		$join[]='INNER JOIN utilisateurs ON utilisateurs.id=Publication.utilisateurs_id';
		$join[]='INNER JOIN entreprises ON entreprises.utilisateurs_id=Publication.utilisateurs_id';
		$post['join']=$join;
		$post['fields']='Publication.*,utilisateurs.photo,utilisateurs.email,entreprises.nom_e';
		$post['conditions']="en_ligne=1 AND Publication.type='$tp'";
		$post['order by']="Publication.modification DESC";
		$d['type_pub']=$tp;
		$d['pagination']=$this->getPage($post);
		$d['posts']=$this->data_page;
		
		$this->set($d);
	}
	
	//affiche les differents services existes
	function serv($fournisseur_id=null,$canceled_id=null){
		$cond=[];
		if(!empty($canceled_id)){
			$this->canceled_abonned($canceled_id);
		}
		$canceled_id=null;
		$this->loadModel('Utilisateur');
		$join[]="INNER JOIN publications ON Utilisateur.id=publications.utilisateurs_id";
		$join[]="INNER JOIN entreprises ON entreprises.utilisateurs_id=Utilisateur.id";
	$req['join']=$join;
	$req['fields']="publications.id as service_id,publications.utilisateurs_id as fournisseur_id,publications.nom as service,
	publications.modification,Utilisateur.*,entreprises.*";
	if(empty(!$fournisseur_id)){
			$req['conditions']="publications.utilisateurs_id=$fournisseur_id AND publications.type='service'";
	}else{
		if(empty($this->Session->user('id'))){
			$req['conditions']='publications.type=\'service\'';
	
		}else{
			$req['conditions']='publications.utilisateurs_id!='.$this->Session->user('id').' AND publications.type=\'service\'';
		}
		}
		$req['order by']="publications.modification DESC";
		
	$d['posts']=$this->Utilisateur->find($req);

		$this->set($d);
	}
	//affiche les differents status fourniseur
	function stat($fournisseur_id=null,$service_id=null,$status_id=null){
		$this->loadModel('Publication');
		$join[]="INNER JOIN utilisateurs ON Publication.utilisateurs_id=utilisateurs.id";
		$join[]="INNER JOIN entreprises ON Publication.utilisateurs_id=entreprises.utilisateurs_id";
		$join[]="INNER JOIN status ON status.publications_id=Publication.id";
		$req['join']=$join;
		$req['fields']="Publication.id as status_id,Publication.nom as status_nom,Publication.utilisateurs_id as fournisseur_id,status.*,utilisateurs.*,entreprises.*";
		if(empty($status_id)){
			if(!empty($fournisseur_id)){
			$req['conditions']="Publication.utilisateurs_id=$fournisseur_id";
		}else{
			
			$req['conditions']="utilisateurs.role='admin'";
		}
		}else{
			if(empty($this->datas)){
				$this->datas=new stdClass();
			}
			$d['status_id']=$status_id;
			$this->datas->status_id=$status_id;
			$req['conditions']="Publication.id=$status_id";
		}
		if(empty($this->datas)){
			$this->datas=new stdClass();
		}
		$this->datas->service_id=$service_id;
		$this->datas->fournisseur_id=$fournisseur_id;
		
		if(!empty($service_id)){
			$reqt=array();
			$reqt['conditions']="id=$service_id";
			$d['services']=$this->Publication->findFirst($reqt);
		}
		
		$d['service_id']=$service_id;
		$d['status_id']=$status_id;
		$d['fournisseur_id']=$fournisseur_id;

		$d['status']=$this->Publication->find($req);
		if(!empty($status_id)){
			$d['status']=$this->Publication->findFirst($req);
		}
		if(!empty($status_id)){
			extract($d);
			$this->datas->status=$status;
		}
		$this->service_status=$d;
		$this->set($d);
		
	}

	public function billposting($fournisseur_id=null,$service_id=null,$status_id=null){
		
		$this->loadModel('Compte');
		if(!$this->Session->islogged()){
			setFlash('Vous devez vous connecter pour effectuer l\'abonnement!','info');
			$this->redirect('users/login');
		}else{
			if(!empty($status_id)){
		$this->stat($fournisseur_id,$service_id,$status_id);
		}
		$d=$this->service_status;
		$this->set($d);
		}
		
	}
    


	
 /***
ADMIN
 **/
 function admin_index($tp='article'){
	if(!in_array($tp,$this->posts_)){
		$this->e404("La page $tp n'existe pas");
	}
 	$perPage=10;
		$this->loadModel('Publication');
		$condition=array(
			'utilisateurs_id'=>$this->Session->user('id'),
			'type'=>$tp
			) ;
		$d['posts']=$this->Publication->find(array(
		'conditions'=>$condition,
		'order by'=>"Publication.modification DESC",
		'limit'=> ($perPage*($this->request->page-1)).','.$perPage
		));
		$d['total']=$this->Publication->findCount($condition);
		$d['page']=ceil($d['total']/$perPage);
		$d['type_pub']=$tp;
		$d['user_pub']=$this->Session->user('id');
		if(empty($d['posts'])){
			setFlash("Aucune $tp trouver",'info');
		}
		$this->set($d);
 }
 /***
Permet d'editer un article
 ***/
function admin_edit($id=null,$tp='article'){
	if(!in_array($tp,$this->posts_)){
		$this->e404("La page $tp n'existe pas");
	}
	$this->loadModel('Publication');
	
	$this->loadModel('Media');
	$this->loadModel('Status');
	$this->Status->primaryKey='publications_id';
	$this->Status->table='status';
	$d['id']='';
	if ($this->request->data){
		$data=$this->request->data;
		
		if ($this->Publication->validates($this->request->data)&&count($this->Publication->errors_img_import('fichier'))==0) {
			
			if($tp!=='status'){
				if($tp!=='article'){
					$this->request->data->utilisateurs_id=$this->Session->user('id');
					$this->request->data->modification=$this->Publication->sql_func("NOW()")->resultat;
					$this->request->data->type=$tp;
					
					$this->Publication->save($this->request->data);
				}else{
					
					$index_pub=array('id','nom','slug','en_ligne','contenu');
					$this->Publication->val=$this->get_elementKey($data,$index_pub);
					$this->Publication->val->utilisateurs_id=$this->Session->user('id');
					$this->Publication->val->type=$tp;
					$this->Publication->val->modification=$this->Publication->sql_func("NOW()")->resultat;
					$this->request->data=$this->Publication->val;
					$this->Publication->save($this->Publication->val);
					
					if(isset($_FILES['fichier']['name'])&&!empty($_FILES['fichier']['name'])){
					$index_med=array('nom_f','fichier');
					$this->Media->val=$this->get_elementKey($data,$index_med);
					$this->Media->val->type_f='img';
					$this->Media->val->publications_id=$this->Publication->id;
					$this->Media->val->fichier=$_FILES['fichier']['name'];
					$this->Media->save($this->Media->val);
						foreach($this->Media->val as $k=>$v){
							$this->request->data->$k=$v;
						}

					}
					

					if(isset($_FILES['fichier']['name'])&&!empty($_FILES['fichier']['name'])){
						$dir1=WEBROOT.DS.'img'.DS.$tp.'s';
						$dir2=$dir1.DS.$this->Publication->val->utilisateurs_id;
						if(!file_exists($dir1)) mkdir($dir1,0777);
						if(!file_exists($dir2)) mkdir($dir2,0777);
						move_uploaded_file($_FILES['fichier']['tmp_name'],$dir2.DS.$_FILES['fichier']['name']);

					}
				}

			}else{
				
				$index_pub=array('id','nom','slug','en_ligne');
				$this->Publication->val=$this->get_elementKey($data,$index_pub);
				$this->Publication->val->utilisateurs_id=$this->Session->user('id');
				$this->Publication->val->type=$tp;
				$this->Publication->val->modification=$this->Publication->sql_func("NOW()")->resultat;
				
				$this->Publication->save($this->Publication->val);
				
				$index_status=array('nbr_mois','prix');
				$this->Status->val=$this->get_elementKey($data,$index_status);

				$this->Status->val->publications_id=$this->Publication->id;
				
				$this->Status->save($this->Status->val);

			}
			
			

		setFlash('Le contenu a bien été modifié');
		$id=$this->Publication->id;
		
		$this->redirect('admin/posts/index/'.$tp);
		}else{
			if(!empty($this->Publication->errors_img_import('fichier'))){
				setFlash($this->Publication->errors_img_import('fichier'),'danger');
			}else{
				setFlash('Merci de corriger vos informations','danger');
			}
			
		}
		
	}else{
		
		if($id){
			
			$vals=new stdClass();
			$vals_aux=new stdClass();
			$vals=$this->Publication->findFirst(array(
				'conditions' => array('id' =>$id)));

			if($tp=='status'){
				$vals_aux=$this->Status->findFirst(array(
						'conditions' => array('publications_id' =>$id)));
					if(!empty($vals_aux)){foreach($vals_aux as $k=>$v){$vals->$k=$v;}}
			}
			
			$this->request->data=$vals;
	
	$d['id']=$id;
	}
	
	}
	$d['type_pub']=$tp;
	$d['user_pub']=$this->Session->user('id');
	$this->set($d);
}

 /***
Permet de supprimer un article
 ***/
function admin_delete($id,$tp='article'){
	if(!in_array($tp,$this->posts_)){
		$this->e404("La page $tp n'existe pas");
	}
	$this->loadModel('Publication');
	$this->loadModel('Media');
	$this->loadModel('Status');
	$this->Status->primaryKey='publications_id';
	$this->Status->table='status';
	$this->Publication->delete($id);
	$this->Status->delete($id);
	$this->Media->primaryKey='publications_id';
	$this->Media->delete($id);

	setFlash('Le contenu a bien été supprimé');
	$this->redirect('admin/posts/index/'.$tp);
}
}