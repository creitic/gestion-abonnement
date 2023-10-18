<?php

class MediasController extends Controller{
    public $data_med;
    function admin_index($id,$tp="article"){
       //$this->layout='modal';
        $this->loadModel('Media');
        
        if(!empty($this->request->data)){
            $err=$this->Media->errors_img_import('fichier');
            if(count($err)===0){
            if(!empty($_FILES['fichier']['name'])){
            $dir1=WEBROOT.DS.'img'.DS.$tp.'s';
            $dir2=$dir1.DS.$this->Session->user('id');
			if(!file_exists($dir1)) mkdir($dir1,0777);
			if(!file_exists($dir2)) mkdir($dir2,0777);
            move_uploaded_file($_FILES['fichier']['tmp_name'],$dir2.DS.$_FILES['fichier']['name']);
            $this->Media->save(array(
                'nom_f'=>$this->request->data->nom_f,
                'fichier'=>$_FILES['fichier']['name'],
                'publications_id'=>$id,
                'type_f'=>'img'
            )); 

            }else{
                setFlash('impossible d\'ajouter un fichier vide','info'); 
            }
        }else{
             setFlash($err,'danger');
        }
           
        }
        if(!empty($id)){
        $d['type_pub']=$tp;
	    $d['user_pub']=$this->Session->user('id');
        $d['publications_id']=$id;
        $d['images']=$this->Media->find(array(
            'conditions'=>array('publications_id'=>$id)
        ));
        $this->data_med= $d['images'];
        $this->set($d);

        return $this->data_med;
    }else{
        setFlash('Fichier introuvable!!','danger');
        $this->redirect('admin/posts/index');
    }
    return false;
}

    function admin_delete($id,$tp='article'){
        $this->loadModel('Media');
        $dir1=WEBROOT.DS.'img'.DS.$tp.'s';
        $dir2=$dir1.DS.$this->Session->user('id');
        
        $media=$this->Media->findFirst(array(
            'conditions'=>array('id'=>$id)
        ));
       
        if(file_exists($dir2)){
           if(unlink($dir2.DS.$media->fichier)){
             $this->Media->delete($id);
             setFlash("Le media a bien été suprime");  
           }else{
            setFlash("Erreur innattendu,Impossible de supprimer l'image!","danger");
           }
            
        }else{
            $err[]="Impossible de supprimer l'image";
            $err[]="Son emplacement a été modifié";
            setFlash($err,"warning");
        } 
   
        $this->redirect('admin/medias/index/'.$media->publications_id.'/'.$tp);
    }

}