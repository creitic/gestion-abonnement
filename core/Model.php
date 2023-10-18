<?php
/**
 * 
 */
class Model
{
	static $connections=array();
	public $conf='default';
	public $table=false;
	public $db;
	public $primaryKey = 'id';
	public $id;
	public $errors = array();
	public $form;
	public $val;

	function useMulti_table($table_tmp=[]){
		if(count($table_tmp)>=1){
			$this->table=$this->separed_by($table_tmp,',');
		}			
	}
	function __construct()
	{ 
//J'initialise qques variable
	$this->val=new stdClass();
		if($this->table==false){
			$this->table=strtolower(get_class($this)).'s';
		}


		//Je me connecte à la base

		$conf=Conf::$databases[$this->conf];
		if(isset(Model::$connections[$this->conf])){
			$this->db=Model::$connections[$this->conf];

			return true;
		}
		try {
			$pdo=new PDO(
				'mysql:host='.$conf['host'].';
				dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8')
			);
			
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

		Model::$connections[$this->conf]=$pdo;
		$this->db=$pdo;
		} catch (Exception $e) {
			if(Conf::$debug>=1){
				die($e->getMessage());
			}else{
				die('Impossible de se connecter à la base de donnée');
			}
			
		}
		
	}
	function errors_img_import($name_file='photo'){
		$errors=[];
		if(isset($_FILES[$name_file]['name'])&&!empty($_FILES[$name_file]['name'])){
			if($_FILES[$name_file]['error']!==0){
				$errors[]="Erreur de telechargement de fichier!";
			}elseif(strpos($_FILES[$name_file]['type'],'image')!==0){
				$errors[]="Le fichier n'est pas une image!";
			}
		}
		return $errors;
	}
	function escape_string($str){
		return $this->db->quote($str);
	}
	public function separed_by($data=[],$coordination='AND'){
		if(isset($data)){
			$rqt='';
			if($coordination===','||$coordination===' '){
				$rqt.= implode($coordination,$data);
			}else{
				$rqt='(';
				$rqt.= implode(' '.$coordination.' ',$data);
				$rqt=$rqt.')';
			}
			
			return $rqt;
		}
		return false;
	}

	public function Compared_by($data=array(),$comparator='='){
		
		$cond=array();
		if(isset($data)&& is_array($data)&&!empty($comparator)){
			foreach ($data as $k => $v) {
				if (!is_numeric($v)&&!strpos($v,'.')){
				$v=$this->escape_string($v);
				}
				$cond[]="$k$comparator$v";
				}
				return $cond;//tableau indexé numeric
		}
		return false;
	}

	public function find($req){
	$sql='SELECT ';

		if (isset($req['fields'])) {
			if(is_array($req['fields'])){
				$sql .= $this->separed_by($req['fields'],',');
			
		}else{
			$sql .= $req['fields'];
		}
	}else{
		$sql .= '*';
	}
	if(strpos($this->table,',')){
		$sql .=' FROM '.$this->table;
	}else{
		$sql .=' FROM '.$this->table.' as '.get_class($this).' ';
	}
	if(isset($req['join'])){
		if(!is_array($req['join'])){
			$sql .=$req['join'];
		}else{
			$sql .= $this->separed_by($req['join'],' ');
		}
	}	
	elseif(isset($req['inner join'])||isset($req['left join'])||isset($req['right join'])){
		if(isset($req['inner join'])){
			if (!is_array($req['inner join']))
				$sql .=' INNER JOIN '.$req['inner join'];
		}
		if(isset($req['left join'])){
				if(!is_array($req['left join']))
					$sql .=' LEFT JOIN '.$req['left join'];	
		}
		if(isset($req['right join'])){
			if(!is_array($req['right join'])) 
				$sql .=' RIGHT JOIN '.$req['right join'];
		}
		if(isset($req['on'])){
			if (!is_array($req['on'])) 
			$sql .=' ON '.$req['on'];
		}
	if(isset($req['using'])){
		if (!is_array($req['using']))
		$sql .=' USING '.$req['using'];
		}

	}
	
//construction de la condition
	if(isset($req['conditions'])){

		$sql .=' WHERE ';
			if (!is_array($req['conditions'])) {
				$sql .=$req['conditions'];
				}else{
					$cond=[];
					$cond=$this->compared_by($req['conditions']);
				if(isset($req['coordinations'])&&!empty($req['coordinations'])){
					$sql .= $this->separed_by($cond,$req['coordinations']);
				}else{
					$sql .= $this->separed_by($cond);
				}
			}
		}
		if(isset($req['order by'])){
			$sql .=' ORDER BY '.$req['order by'];
			}

		if(isset($req['limit'])){
		$sql .=' LIMIT '.$req['limit'];
		}
		
		if(isset($req['just_req'])&&$req['just_req']==true){
			$reqt=new stdClass();
			$reqt->sql=$sql;
			return $reqt->sql;
		}else{
		$pre=$this->db->prepare($sql);
		$pre->execute();
		
		return $pre->fetchAll(PDO::FETCH_OBJ);
		}
		

	}
	public function findFirst($req){
		return current($this->find($req));
	}

	public function findCount($conditions){
		
		$res =$this->findFirst(array(
			'fields' => 'COUNT('.$this->primaryKey.') as count',
			'conditions' => $conditions
		));
		return $res->count;
	}
	public function delete($id){
$sql="DELETE FROM {$this->table} WHERE {$this->primaryKey} = $id";
$this->db->query($sql);
	}
	//execute function sql
function sql_func($str){
	$sql="SELECT $str as resultat";

	$pre=$this->db->prepare($sql);
	$pre->execute();
	return $pre->fetch(PDO::FETCH_OBJ);
}
	public function save($data){

		$key=$this->primaryKey;
		$fields=array();
		$d=array();
		/*if (isset($data->$key)) unset($data->$key);*/
		
		foreach ($data as $k => $v) {
			if ($k!=$this->primaryKey) {
			$fields[] =" $k=:$k";
			$d[":$k"]=$v;
		}elseif (!empty($v)) {
			$d[":$k"]=$v;
		}
		
		}
		
		if (isset($data->$key)&& !empty($this->findCount(array($key=>$data->$key)))){
			$sql='UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE '.$key.'=:'.$key;
			$this->id=$data->$key;
			$action='update';
		}else{
			if($this->primaryKey!=='id'){
				$fields[]="$this->primaryKey=:$this->primaryKey";
			}
			$sql='INSERT INTO '.$this->table.' SET '.implode(',',$fields);
			
			
			$action='insert';
		}
		$pre=$this->db->prepare($sql);
		$pre->execute($d);
		if ($action == 'insert') {
			$this->id=$this->db->lastInsertId();
		}
		return true;
	}
//post
	function not_empty($fields=[]){
		if (count($fields)!=0) {
			# code...
			foreach ($fields as $field) {
				# code...
				if(empty($_POST[$field])|| trim($_POST[$field])==""){
					return false;
				}
			}
			return true;
		}
	}

	
}
