<?php

/**
 * 
 */

class Controller{

public $request;//Objet Request
public $vars=array();//variable à passer à la vue
public $layout='default';//Layout à utiliser pour rendre la vue
private $rendered = false;//Si le rendu a été fait ou pas?
public $var_posts;
public $data_page;
public $tp='article';

/**
*Constructeur
*@param $request Objet request de notre application
**/
	public function __construct($request=null)
	{	$this->var_posts=new stdClass();
		$this->Session=new Session();
		$this->Form=new Form($this);
		$this->auto_login();

			if(!$this->log_security())
			$this->redirect('users/logout');
				
		if($request){
		$this->request=$request;//On stocke la request dans l'instance 
		require ROOT.DS.'config'.DS.'hook.php';}
	}

/**
*Permet de rendre une vue @param $view Fichier à rendre (chemin depuis view ou nom de la vue
*/
	public function render($view){
		
		$user_act=new stdClass();
		$users_connected=new stdClass();
		
		if ($this->rendered) {
			return false;
		}
		
	extract($this->vars);
		
	if(strpos($view,"/")===0){ 
			$view=ROOT.DS.'view'.$view.'.php';
		}
		else{
			$view=ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
		}

	ob_start();
	
	require($view);
	$content_for_layout=ob_get_clean();
	
		require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php';
		$this->rendered=true;
		
	
	}
	
	/**
	 * Supprimer un ou pluisieurs element @param $index dans un objet @param $data
	 * 
	 */
	function del_dataElementKey($data,$index=[]){

		if(isset($data)&&isset($index)){
			foreach($data as $k=>$v){
				foreach($index as $key){
					if($k==$key){
						unset($data->$k);
					}
				}
			}
			return $data;
		}
		
	}

	/**
	 * retourne un ou pluisieurs element @param $index dans un objet @param $data
	 * 
	 */
	function get_elementKey($data,$index=[]){
		$datas=new stdClass();
		if(isset($data)&&isset($index)){
			foreach($data as $k=>$v){
				foreach($index as $key){
					if($k==$key){
						$datas->$key=$data->$key;
					}
				}
			}
			return $datas;
		}
		
	}


	/**
	 * retourne  les fichiers
	 * 
	 */
	function get_dataFileKey($nom_fichier,$option){
		
		return $_FILES[$nom_fichier][$option];
	}

/**
*@param $key nom de la variable ou tableau de variables
*@param $value valeur de la variable
**/
	public function set($key,$value=null)
	{
		if (is_array($key)) {
			$this->vars += $key;
		}
		else
		{
			$this->vars[$key] = $value;
		}
	}
/***
Permet de charger un model
***/
	function loadModel($name){
		
		if(!isset($this->$name)){
			$file = ROOT.DS.'model'.DS.$name.'.php';
		require_once($file);
		$this->$name = new $name();
		if (isset($this->Form)) {
			$this->$name->Form = $this->Form;
		}
		}
		
	}

/**
*Permet de gerer les erreur 404
*/
	function e404($message){
		header('HTTP/1.0 404 Not Found');
		$this->set('message',$message);
		$this->render('/errors/404');
		die();
	
	}

	/***
	Permet d'appeller un controller depuis une vue

	**/
	function request($controller,$action){
		$controller .='controller';
		require_once ROOT.DS.'controller'.DS.$controller.'.php';
		$c = new $controller();
		return $c->$action();
	}

	/***
	Redirect
	***/
function redirect($url,$code=null){
	
	if($code==301){
		header('HTTP/1.0 301 Moved Permanently');
	}
	header("Location:".Router::url($url));
	exit();
	 
}
function log_security(){
	if($this->Session->islogged()){
		$this->loadModel('Utilisateur');
		$req=[];
		$id=$this->Session->user('id');
		$pseudo=$this->Session->user('pseudo');
		$role=$this->Session->user('role');
		$req['conditions']='id ';
		$req['conditions'].=$id?"=".$id:"IS NULL ";
		$req['conditions'].=' AND pseudo ';
		$req['conditions'].=$pseudo?"='".$pseudo.'\'':"IS NULL ";
		$req['conditions'].=' AND role ';
		$req['conditions'].=$role?"='".$role.'\'':"IS NULL";
		$log_sec=new stdClass();
		
		$log_sec=$this->Utilisateur->findFirst($req);
		if(!$log_sec){
			unset($_SESSION['User']->role);
			return false;
		}else{
			$this->layout=$this->Session->user('role');
			return true;
		}
	
}else{
	return true;
}
}
function auto_login(){
	//Verifier que notre cookie 'auth' existe
	if(!$this->Session->islogged()){
if(!empty($_COOKIE['saas'])){
	
	$split=explode(':', $_COOKIE['saas']);
	
	
	if(count($split)!==2){return false;}
	
	// Recuperer via ce cookie selector, token
	 list($selector,$token)=$split;
	 //Decoder notre $selector
	$this->loadModel('Auth_token');
	$q=$this->Auth_token->db->prepare(
		"SELECT auth_tokens.token,
		auth_tokens.utilisateurs_id,
		utilisateurs.id,
		utilisateurs.pseudo 
		FROM auth_tokens 
		LEFT JOIN utilisateurs  
		ON auth_tokens.utilisateurs_id=utilisateurs.id 
		WHERE selecteur=? AND expiration >= CURDATE()");
		$q->execute([base64_decode($selector)]);
		$data=$q->fetch(PDO::FETCH_OBJ);
		
		
		if($data){
				//Si on trouve un enregistrement 
		//Comparer les deux tokens
			if(hash_equals($data->token, hash('sha256', base64_decode($token)))){
	
			$user=$this->userProperty($data->utilisateurs_id);
			$this->Session->write('User',$user);
			$index=array('mot_de_passe','nom','prenom','cin','utilisateurs_id');
			//efface le mot de passe et email dans la session User
			$_SESSION['User']=$this->del_dataElementKey($_SESSION['User'],$index);
			$this->redirect('users/');
							 return true;
						}
					
					}
		
				}
return false;	
		
	}
}
function userProperty($id){
	$this->loadModel('TemporaryTable');
    $table_tmp[]='utilisateurs';
    $table_tmp[]='entreprises';
	$this->TemporaryTable->useMulti_table($table_tmp);
	$fields[]='entreprises.*';
	$fields[]='utilisateurs.*';
	$cond0=array(
		'utilisateurs.id'=>$id
	);
	$cond1=array(
		'utilisateurs.id'=>'entreprises.utilisateurs_id'
	);
	$cond=[];
	$cond0=$this->TemporaryTable->Compared_by($cond0); 
	$cond1=$this->TemporaryTable->Compared_by($cond1);
	
	$cond[]=$cond0[0];//
	$cond[]=$cond1[0];//

	$d['userProperty']=$this->TemporaryTable->findFirst(array(
		'fields'=>$fields,
		'conditions'=>$this->TemporaryTable->separed_by($cond)
		));
	extract($d);
	if(!empty($userProperty)){return $userProperty;}else{return false;}
}
//annuler l'abonnement de l'utilisateurs 
function canceled_abonned($id){
	$this->loadModel('Abonnement');
	$req['left join']="utilisateurs";
	$req['on']="Abonnement.utilisateurs_id=utilisateurs.id";
	$req['conditions']="Abonnement.id=$id AND Abonnement.annuler=0";
	$d['users']=$this->Abonnement->findFirst($req);
	$this->set($d);
	extract($this->vars);
	if(empty($users)){
		setFlash('Cette abonnement n\'existe plus!!','info');
	}else{
		if($users->role===$this->Session->user('role')&&$users->utilisateurs_id===$this->Session->user('id')){
			$this->Abonnement->val->id=$id;
			$this->Abonnement->val->annuler=1;
			$this->Abonnement->save($this->Abonnement->val);
			setFlash('abonnement annulé avec succés');
		}else{
			setFlash('vous ne gere pas ce compte');
		}
	}
	
}

//verifie si l'utilisateur est abonnée à une service
function user_abonned($id_serv=null){
	
	$this->loadModel('Abonnement');
	$utilisateurs_id=$this->Session->user('id');
	if(empty($utilisateurs_id)){
		return false;
	}
	$expiration=$this->Abonnement->sql_func("NOW()")->resultat;
	if(empty($id_serv)){
		$cond='service_id IS NULL AND expiration>="'.$expiration.'" AND utilisateurs_id='.$utilisateurs_id.' AND annuler=0';
	}else{
		$cond='service_id ='.$id_serv.' AND expiration>="'.$expiration.'" AND utilisateurs_id='.$utilisateurs_id.' AND annuler=0';
	}
	
	$req['conditions']=$cond;
	
	$d['abonned']=$this->Abonnement->findFirst($req);
	extract($d);
	
	if(!empty($abonned)){return $abonned;}else{return false;}	
}

//verifie si l'utilisateur deja étè abonnée à une service
function user_alreadyAbonned($id_serv=null){
	$this->loadModel('Abonnement');
	$utilisateurs_id=$this->Session->user('id');
	if(empty($utilisateurs_id)){
		return false;
	}
	if(empty($id_serv)){
		$cond='service_id IS NULL';
	}else{
		$cond='service_id ='.$id_serv;
	}
	$req['conditions']=$cond;
	$d['abonnements']=$this->Abonnement->find($req);
	extract($d);
	if(!empty($abonnements)){return $abonnements;}else{return false;}	
}
function getStatus($id_stat=null){
	$this->loadModel('Publication');
	if(!empty($id_stat)){
	   $status=$this->Publication->findFirst(array(
		'conditions'=>array('id'=>$id_stat)
		));
	   
		return $status;
	}else{
		return false;
	}
}
function getService($id_serv=null){
	$this->loadModel('Publication');
	if(!empty($id_serv)){
	   $service=$this->Publication->findFirst(array(
		'conditions'=>array('id'=>$id_serv)
		));
	   
		return $service;
	}else{
		return false;
	}
}
function getPage($req,$table='Publication',$primaryKey='id',$ref='posts/index/',$nbrdataperpage=4){
	$this->loadModel($table);
	$this->$table->primaryKey=$primaryKey;
	$this->data_page=new stdClass();
	
$nbre_total_data=$this->$table->findCount($req['conditions']);

if ($nbre_total_data>=1) {
$nbre_data_par_page=$nbrdataperpage;
$nbre_pages_max_gauche_et_droite=4;
$last_page=ceil($nbre_total_data/$nbre_data_par_page);
if(isset($this->request->page) && is_numeric($this->request->page)){
	$page_num=$this->request->page;
}else{
	$page_num=1;
}
if ($page_num<1) {
	$page_num=1;
}else if($page_num>$last_page){
	$page_num=$last_page;
}
$limit=($page_num-1)*$nbre_data_par_page. ',' .$nbre_data_par_page;
$req['limit']=$limit;
$this->data_page=$this->$table->find($req);

$pagination='<nav class="text-center"><ul class="pagination">';

if ($last_page!=1) {
	if ($page_num>1) {
		$previous=$page_num-1;
		$url=Router::url($ref);
		if(!empty($this->tp)){
			$url.=$this->tp.'/?page='.$previous;
		}else{
			$url.='?page='.$previous;
		}
		
		$pagination .='<li><a href="'.$url.'" aria-label="Precedent"><span aria-hidden="true">&laquo;</span></a></li>';

		for ($i= $page_num-$nbre_pages_max_gauche_et_droite; $i < $page_num; $i++) { 
			if($i>0){
				$url=Router::url($ref);

				if(!empty($this->tp)){
					$url.=$this->tp.'/?page='.$i;
				}else{
					$url.='?page='.$i;
				}

				$pagination .='<li><a href="'.$url.'">'.$i.'</a></li>';
			}
		}
	}
	$pagination.='<li class="active"><a href="#">'.$page_num.'</a></li>';
	for ($i=$page_num+1; $i <= $last_page ; $i++) { 
		$url=Router::url($ref);
		if(!empty($this->tp)){
			$url.=$this->tp.'/?page='.$i;
		}else{
			$url.='?page='.$i;
		}
		

		$pagination .= '<li><a href="'.$url.'">'.$i.'</a></li>';
		if ($i >= $page_num+$nbre_pages_max_gauche_et_droite) {
			break;
		} 
	}

	if ($page_num != $last_page) {
		$next = $page_num +1;
		$url=Router::url($ref);
		if(!empty($this->tp)){
			$url.=$this->tp.'/?page='.$next;
		}else{
			$url.='?page='.$next;
		}
		

		$pagination .= '<li><a href="'.$url.'" aria-label="Suivant"><span aria-hidden="true">&raquo;</span></a></li>';
	}	
}
$pagination.='</ul></nav>';
return $pagination;

}
return false;
}}