<?php 
if ($this->request->prefix=='admin') {
	if($this->Session->islogged()){
		if(!$this->user_Abonned(null)&&$this->Session->user('role')!='admin'){
			$this->redirect('users/login');
		}else{
			$this->layout=$this->Session->user('role');
		}
	}else{
		$this->redirect('users/login');
	}
}	
	