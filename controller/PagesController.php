<?php

class PagesController extends Controller{
    function accueil(){
    
        }

    function view($id){

        $this->loadModel('Publication');
        $d['page']=$this->Publication->findFirst(array(
            'conditions'=>array('online'=>1,'id'=>$id,'type'=>'page') 
        ));
        if(empty($d['page'])){
            $this->e404('Page introuvable');
        }
        
        $this->set($d);
    
        }
     /***
    Permet de récupérer les pages pour le menu
     **/
    
    function getMenu(){
        $this->loadModel('Publication');
        return $this->Post->find(array(
            'conditions' => array('online'=>1,'type'=>'page')
        ));
    }
     /***
ADMIN
 **/
 function admin_index(){
    $perPage=10;
       $this->loadModel('Publication');
       $condition=array(
           'type'=>'page',
           'utilisateurs_id'=>$this->Session->user('id')
           ) ;
       $d['posts']=$this->Publication->find(array(
           'fields'=>'id,name,en_ligne',
       'conditions'=>$condition,
       'limit'=> ($perPage*($this->request->page-1)).','.$perPage
       ));
       $d['total']=$this->Publication->findCount($condition);
       $d['page']=ceil($d['total']/$perPage);
       $this->set($d);
}
/***
Permet d'editer un article
***/
function admin_edit($id=null){

   $this->loadModel('Publication');
   $d['id']='';
   if ($this->request->data) {
       if ($this->Publication->validates($this->request->data)) {
           $this->request->data->utilisateurs_id=$this->Session->user('id');
           $this->request->data->type='page';
           $this->request->data->created=date('y-m-d h:i:s');

           $this->Publication->save($this->request->data);
       setFlash('Le contenu a bien été modifié');
       $id=$this->Publication->id;
       $this->redirect('admin/posts/index');
       }else{
           setFlash('Merci de corriger vos informations','error');
       }
       
   }else{
       if($id){
   $this->request->data=$this->Publication->findFirst(array(
       'conditions' => array('id' =>$id)
   ));
   $d['id']=$id;
   }
   
   }
   $this->set($d);
}

/***
Permet de supprimer un article
***/
function admin_delete($id){
   $this->loadModel('Publication');
   $this->Post->delete($id);
   setFlash('Le contenu a bien été supprimé');
   $this->redirect('admin/posts/index');
}
 
}