<?php

class UsersController extends Controller{
    function index($id=null){
        if(empty($id)){
            $d['user']=$this->userProperty($this->Session->user('id'));
        }else{
            $d['user']=$this->userProperty($id);
        }
        
        $this->set($d);
    }
    function edit(){
        if($this->request->data){
            
            $data=$this->request->data;
            $this->loadModel('Utilisateur');
            $this->loadModel('Entreprise');
            $this->Entreprise->primaryKey='utilisateurs_id';
            $this->Entreprise->id=$this->Session->user('id');
            $index2=array('nom_e','activite');
            $this->Entreprise->val=$this->get_elementKey($data,$index2);
            $index=array('id','nom','prenom','pseudo','ville','pays','sexe');
            $this->Utilisateur->val=$this->get_elementKey($data,$index);
            
            
            if(isset($_FILES['photo']['name'])&&!empty($_FILES['photo']['name'])){
                $this->Utilisateur->val->photo=$_FILES['photo']['name'];
            }
            $this->Utilisateur->save($this->Utilisateur->val);
            if(isset($_FILES['photo']['name'])&&!empty($_FILES['photo']['name'])){
                $dir1=WEBROOT.DS.'img'.DS.'profiles';
                $dir2=$dir1.DS.$this->Session->user('id');
                if(!file_exists($dir1)) mkdir($dir1,0777);
                if(!file_exists($dir2)) mkdir($dir2,0777);
                move_uploaded_file($_FILES['photo']['tmp_name'],$dir2.DS.$_FILES['photo']['name']);
                
            }
            //modification de session users
            foreach($this->Session->read('User') as $k =>$v){
                foreach($this->Utilisateur->val as $ke=>$vl){
                    if($k===$ke){
                      $this->Session->read('User')->$k=$vl;  
                    }
                }
                foreach($this->Entreprise->val as $ke=>$vl){
                    if($k===$ke){
                      $this->Session->read('User')->$k=$vl;  
                    }
                }
            }
            $this->Entreprise->val->utilisateurs_id=$this->Utilisateur->id;
            $this->Entreprise->save($this->Entreprise->val);
            setFlash('Votre profile a été mis à jour avec succés!!');
            $this->redirect('users/');

        }else{
    $this->loadModel('TemporaryTable');
    $table_tmp[]='utilisateurs';
    $table_tmp[]='entreprises';
    $this->TemporaryTable->useMulti_table($table_tmp);
    $fields[]='utilisateurs.*';//
    $fields[]='entreprises.nom_e';
    $fields[]='entreprises.activite';
        
    $conditions=array(
                'utilisateurs.id'=>$this->Session->user('id'),
                'entreprises.utilisateurs_id'=>'utilisateurs.id'
                );
    
    $d['user']=$this->TemporaryTable->findFirst(array(
                    'fields'=>$fields,
                    'conditions'=>$conditions
            ));
    $this->set($d);
        }
    
    }
    
function register(){
    
    if(isset($this->request->data)&&isset($this->request->data->register)){
    $data=$this->request->data;

    $this->loadModel('Utilisateur');
    $this->loadModel('Entreprise');
    $this->Entreprise->primaryKey='utilisateurs_id';    
    $errors=$this->Utilisateur->regist_validates($data);

            if(count($errors)==0){
                
                //Envoi d'un Email d'activation
                $to=$data->email;
                $subject=WEBSITE_NAME."-ACTIVATION DE COMPTE";
                $data->mot_de_passe=$this->Utilisateur->bcrypt_hash_password($data->mot_de_passe);//blowfish
                $data->password_confirm=$this->Utilisateur->bcrypt_hash_password($data->password_confirm);
                $token=sha1($data->pseudo.$data->email.$data->mot_de_passe);
                ob_start();
                require ROOT.DS.'view'.DS.'activations'.DS.'emails.php';
                $content=ob_get_clean();
                
                $headers='MIME-Version: 1.0' ."\r\n";
                $headers.='content-type:text/html; charset= iso-8859-1' ."\r\n";
                mail($to, $subject, $content,$headers);
                
                $index2=array('nom_e','activite');
                $this->Entreprise->val=$this->get_elementKey($data,$index2);
                $index=array('id','nom','prenom','pseudo','email','mot_de_passe','cin','ville','pays','sexe');
                $this->Utilisateur->val=$this->get_elementKey($data,$index);
                
                
                if(isset($_FILES['photo']['name'])&&!empty($_FILES['photo']['name'])){
                    $this->Utilisateur->val->photo=$_FILES['photo']['name'];
                }
                $this->Utilisateur->save($this->Utilisateur->val);
                if(isset($_FILES['photo']['name'])&&!empty($_FILES['photo']['name'])){
                    $dir1=WEBROOT.DS.'img'.DS.'profiles';
                    $dir2=$dir1.DS.$this->Utilisateur->id;
                    if(!file_exists($dir1)) mkdir($dir1,0777);
                    if(!file_exists($dir2)) mkdir($dir2,0777);
                    move_uploaded_file($_FILES['photo']['tmp_name'],$dir2.DS.$_FILES['photo']['name']);
                    
                }
                $this->Entreprise->id=$this->Utilisateur->id;
                $this->Entreprise->primaryKey='utilisateurs_id';
                $this->Entreprise->val->utilisateurs_id=$this->Utilisateur->id;
                $this->Entreprise->save($this->Entreprise->val);
                //Informer l'utilisateurs pour qu'il verifie sa boite de reception
                setflash("Mail d'activation envoyé!");
                $this->redirect('/');
        
                }else{
                setFlash($errors,'danger');
            }
    }
}



function forgot_password(){

}

function login(){

if(isset($this->request->data->connection)){
    //chargement des models
    $this->loadModel('Utilisateur');
    $this->loadModel('Auth_token');

    $data=$this->request->data;
    $id_user=new stdClass();
    $id_user=$data->identifiant;

    $req['conditions']='email="'.$id_user.'" OR pseudo="'.$id_user.'" AND acces=1';

    $user=$this->Utilisateur->findFirst($req);
 
    if(!empty($user)&&$this->Utilisateur->bcrypt_verify_password($data->mot_de_passe,$user->mot_de_passe)){
        $user=$this->userProperty($user->id);
        $this->Session->write('User',$user);
        //Si l'utilisateur a choisi de garder sa session active
 			if (isset($data->remember_me) && $data->remember_me=='1'){
                $this->Auth_token->remember_me($user->id);
            }
        $index=array('mot_de_passe','nom','prenom','cin','utilisateurs_id');
        //efface le mot de passe et email dans la session User
        $_SESSION['User']=$this->del_dataElementKey($_SESSION['User'],$index);

    }else{
        setFlash("combinaison identifiant/Mot de passe incorrecte!",'danger');
    }
   $this->request->data->mot_de_passe='';
   if($this->Session->islogged()){
        $this->redirect('users/');
   }
    
}
}

function logout(){
//Supprimer l'entrer en bdd au niveau de auth_tokens

$this->loadModel('Auth_token');
$this->Auth_token->primaryKey='utilisateurs_id';
$this->Auth_token->delete($this->Session->user('id'));
$error=false;
if($this->Session->islogged()){
    $error=true;
}
 unset($_SESSION['User']);
 
 //Supprimer les cookies et dettruire la session
setcookie('saas','',time()-3600);
if($error){
setFlash('Vous êtes maintenant déconnecté');
}else{
setFlash("Jeton de securité invalide",'danger');
}
 
 $this->redirect('/');
}
}