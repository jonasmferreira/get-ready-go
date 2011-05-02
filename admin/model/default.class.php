<?php
$path_root_dbClass = dirname(__FILE__);
$DS = DIRECTORY_SEPARATOR;
$path_root_dbClass = "{$path_root_dbClass}{$DS}..{$DS}..{$DS}";
require_once "{$path_root_dbClass}lib{$DS}DataBaseClass.php";
session_name('GET_READY_GO_2011');
if(session_id()==''){
	session_start();
}
class defaultClass {
	protected $dbConn;
	protected $values;
	protected $files;
	public function __construct() {
		$this->dbConn = new DataBaseClass();
	}
	
	public function setValues($values) {
		$this->values = $values;
	}
	
	public function setFiles($files) {
		$this->files = $files;
	}

			
	public function destroySession() {
		unset($_SESSION['GET_READY_GO']);
		session_destroy();
	}
	public function setSession($session,$value=null) {
		if(!is_array($session)){
			$_SESSION['GET_READY_GO'][$session] = $value;
		}else if(is_array($session) && count($session)>0){
			foreach($session AS $k=>$v){
				$_SESSION['GET_READY_GO'][$k] = $v;
			}
		}
	}
	public function getSessions(){
		return $_SESSION['GET_READY_GO'];
	}
	public function unsetSession($session) {
		if(!is_array($session)){
			unset($_SESSION['GET_READY_GO'][$session]);
		}else{
			foreach($session AS $k=>$v){
				unset($_SESSION['GET_READY_GO'][$v]);
			}
		}
	}
	public function utf8Encode2Decode($string) {
		if (strtoupper(mb_detect_encoding($string . "x", 'UTF-8, ISO-8859-1')) == 'UTF-8') {
			return $string;
		} else {
			return utf8_encode($string);
		}
	}

	public function utf8_array_encode($input) {
		$return = array();
		foreach ($input as $key => $val) {
			if (is_array($val)) {
				$return[$key] = $this->utf8_array_encode($val);
			} else {
				$return[$key] = $this->utf8Encode2Decode($val);
			}
		}
		return $return;
	}

	public function antiInjection($input) {
		if(is_array($input)){
			foreach ($input as $key => $val) {
				$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/", "", $val);
				$sql = trim($sql);
				$sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
				$input[$key] = $sql;
			}
			return $input;
		}
		$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/", "", $input);
		$sql = trim($sql);
		$sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
		return $sql;
	}
	public function alert($msg,$url=''){
		$aScript = array();
		$aScript[] = '<script type="text/javascript">';
		$aScript[] = "alert('{$msg}');";
		$aScript[] = (!is_null($url)&&trim($url)!='')?"window.location.href = '{$url}';":'';
		$aScript[] = '</script>';
		echo implode("\r\n",$aScript);
	}
	public function consoleLog($mixed=''){
		$msg = print_r($mixed,true);
		$aScript = array();
		$aScript[] = '<script type="text/javascript">';
		$aScript[] = "console.log('{$msg}');";
		$aScript[] = '</script>';
		echo implode("\r\n",$aScript);
	}
	public function verifyLogin(){
		$session = $this->getSessions();
		if(!isset($session['usuario_id'])&&trim($session['usuario_id'])==''){
			header('Location: index.php');
		}
	}
	public function convertExtReturn($data,$success,$totalCount){
		$arr = array(
			'data'=>$data
			,'totalCount'=>$totalCount
			,'success'=>$success
		);
		return $arr;
	}
}
?>
