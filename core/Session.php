<?php 

/**
 * 
 */
class Session
{

  public function write($key,$value){
	$_SESSION[$key]=$value;
	}

	public function read($key=null){
		if($key){
			if(isset($_SESSION[$key])){
				return $_SESSION[$key];
			}else{
				return false;
			}
			
		}else{
			return $_SESSION;
		}
		
		}

		public function islogged(){
			return isset($_SESSION['User']->role);
			}
		
			public function user($key){
				if($this->read('User')){
					if(isset($this->read('User')->$key)){
						return $this->read('User')->$key;
					}else{
						return false;
					}
				}
				return false;
			}

			function locales($localesName=[]){
				require 'locales.php';
				$this->var=new stdClass();
				if(!empty($localesName)){
					foreach($localesName as $val){
						if(isset($$val)&&is_array($$val)){
							$this->$val=new stdClass();
							foreach($$val as $k=>$v){
								$this->$val->$k=$v;
							}
							$this->var->$val=$this->$val;
						}
					}
				}else{//par defaut
					$this->locales(['country']);
				}
				return $this->var;
			}

}
if (!function_exists('getExrait')) {	
	function getExrait($contenu,$max=100,$min=0){
		$str=substr($contenu,$min,$max).'...';
		return $str;
		}
	}

if (!function_exists('setFlash')) {	
function setFlash($message,$type='success'){
	if(!empty($message)){
		$_SESSION['flash']=array(
			'message' =>$message,
			'type' =>$type
		);
	}
	}
}

if (!function_exists('flash')) {
 function flash(){
	if (isset($_SESSION['flash']['message'])) {
		$html='<div class="alert alert-'.$_SESSION['flash']['type'].'">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>';
		if(is_array($_SESSION['flash']['message'])){
			foreach ($_SESSION['flash']['message'] as $k=>$v) {
		  $html.=$v.'<br/>';
			  }
		}else{
		  $html.= $_SESSION['flash']['message'];
		}
		$_SESSION['flash']=array();
		$html.='</h4></div>';
		return $html; 
	}
}}



/***echaper les caratères html 
**@param string
 * ***/
if (!function_exists('e')) {
	function e($string){
		if ($string) {
		return htmlspecialchars($string);
		} 
	}
}

//Get avatar url
if (!function_exists('get_avatar_url')) {
	function get_avatar_url($email,$size=25){
			return "http://gravatar.com/avatar/".md5(strtolower(trim(e($email))))."?s=".
			$size.'&d=mm';
		
	}
}