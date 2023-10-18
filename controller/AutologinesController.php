<?php
class AutologinesController extends Controller{
    
        function auth_filter(){
            if(!$this->Session->islogged()){
                $_SESSION['last_current_url']=$_SERVER['REQUEST_URI'];
                setFlash('Vous devez etre connecter pour acceder à cette page.','danger');
                $this->redirect('users/login/');
            }
        }
        function guest_filter(){
            if($this->Session->islogged()){
                $this->redirect('users/');
            }
        }

}