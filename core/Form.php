<?php  

class Form{	
	public $controller;
	public $errors;


	public function __construct($controller){
		$this->controller=$controller;
	}
	public function input($name,$label,$options=array()){
		$error=false;
		$classError='';
		if (isset($this->errors[$name])){
			$error=$this->errors[$name];
			$this->classError=' error';
		}

		if (!isset($this->controller->request->data->$name)) {
			$value='';
		}else{
			$value=$this->controller->request->data->$name;
			if(!is_numeric($value)){
				$value=e($value);
			}
			$value=$value;
		}
	

		if($label=='hidden'){
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}
		
		$html='<div class="clearfix'.$classError.'">
		<label class="control-label" for="input'.$name.'">'.$label.'</label>
		<div class="input">';


		$attr=' ';
		foreach ($options as $k => $v) {
			if ($k!='type'&& $k!='values') {
				$attr .=" $k=\"$v\"";
			}
			
		}
	

	if (!isset($options['type'])) {
	$html .='<input type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';

	}elseif ($options['type']=='textarea') {
		$html .='<textarea id="input'.$name.'" name="'.$name.'"'.$attr.'>'.nl2br(e($value)).'</textarea>';	

	}elseif ($options['type']=='checkbox') {

		$html .='<input type="hidden" name="'.$name.'" value="0">
		<input type="checkbox" name="'.$name.'" value="1" '.(empty($value)?'':'checked').'>';	

	}elseif ($options['type']=='file') {

		$html .='<input type="file" class="input-file" id="input'.$name.'" name="'.$name.'"'.$attr.'>';
			
	}elseif ($options['type']=='password') {

		$html .='<input type="password" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
			
	}elseif ($options['type']=='number') {
		$html .='<input type="number" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
	}elseif ($options['type']=='double') {
		$html .='<input type="double" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
	}


	elseif ($options['type']=='radio') {
		if(isset($options['values'])){
			$i=0;
			$cls=false;
			foreach($options['values'] as $k=>$v){
				
				if("$k"===$value){
					$cls=true;
				$html .='<input type="radio" id="input'.$name.'" name="'.$name.'" value="'.$v.'" checked="checked" '.$attr.'/>';
				$html .=" ".ucfirst($v)."  ";	
				}elseif(!$cls){
						$html .='<input type="radio" id="input'.$name.'" name="'.$name.'" value="'."$k".'" checked="checked" '.$attr.'/>';
						$html .=" ".ucfirst($v)."  ";
						$cls=true;
					}else{
						$html .='<input type="radio" id="input'.$name.'" name="'.$name.'" value="'."$k".'" '.$attr.'/>';
						$html .=" ".ucfirst($v);
					}
					
			}
		}
			
	}
	if($error){
		$html .='<span class="help-inline">'.$error.'</span>';
	} 
	$html .='</div></div>';	
	return $html;
} 

function select($name,$label,$options=array()){
	$error=false;
	$classError='';
	if (isset($this->errors[$name])){
		$error=$this->errors[$name];
		$this->classError=' error';
	}

	if (!isset($this->controller->request->data->$name)) {
		$value='';
	}else{
		$value=$this->controller->request->data->$name;
	}

	$html='<div class="clearfix'.$classError.'">
	<label class="control-label" for="select'.$name.'">'.$label.'</label>
	<div class="select">';


	$attr=' ';
	foreach ($options as $k => $v) {
		if ($k!='values') {
			$attr .=" $k=\"$v\"";
		}
		
	}

	$html .='<select id="select'.$name.'" name="'.$name.'"'.$attr.'>';
	if (isset($options['values'])){
		foreach($options['values'] as $k=>$v){
			if(isset($value)&&!empty($value)){
				if($value==="$k" || $value===$v){
				$html .='<option selected="selected" value="'."$k".'">'.$v.'</option>';
				}else{
					$html .='<option value="'."$k".'">'.$v.'</option>';
				}
			}else{
				$html .='<option value="'."$k".'">'.$v.'</option>';
			}
		}
	}
	
	$html .='</select></div></div>';	
	return $html;

}

}
