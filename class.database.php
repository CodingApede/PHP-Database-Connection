<?php
class database
{
	var $localhost;
	var $username;
	var $db_pwd;
	var $db;
	var $db_link;
	var $err;
	var $status;
	
	function __construct(){
		$this->localhost= 'localhost';
		//$this->username= 'web106';
		$this->username='root';
		$this->db_pwd='root';
		//$this->db_pwd='fc41ab';
		//$this->db='usr_web106_1';
		$this->db='database';
		$this->db_link='';
		$this->err='';
		$this->status='';
		error_reporting(E_ALL);
		//echo "Hallo Database<br>";
	}
	
	function databse(){
		self::__construct();
	}
	
	function connect(){
		//echo "connect<br>";
		$this->db_link = mysqli_connect($this->localhost, $this->username, $this->db_pwd);
		if(!$this->db_link){
				  $this->err.="Fehler0001: Es konnte keiene Verbindung zur Datenbank erstellt werden!<br />";
		}else{
			if(mysqli_select_db($this->db_link,$this->db)) {
				$this->status.="Die Datenbank ". $this->db ." wurde ausgewählt<br />";
			} else {
				$this->err.="Fehler0002: Datenbank wurde nicht gefunden<br />";
			}
		}
	}
	
	function insertAt($table,$arrParameter){
		if((isset($table))&&(is_array($arrParameter))){
			$insert="INSERT INTO ".$table." VALUES(";
			$i=0;
			foreach($arrParameter as $para){
				if($i==0){
					$insert.="'".$para."'";
				}else{
					$insert.=",'".$para."'";
				}
				$i++;
			}
			$insert.=")";
			echo $insert."<br>";
			$result=mysqli_query($insert)or die ($this->err.="Fehler0003: ungültiger SQL-Befehl in insertAt()<br />");
		}else{
			$this->err.="Fehler0004: Parameter nicht richtig gesetzt in insertAt()<br />";
		}
	}
	
	function selectFrom($table,$arrQuery,$AsArrPara){
		if((isset($table))&&(is_array($AsArrPara))){
			if(is_array($arrQuery)){	
				$select="SELECT ";
				$i=0;
				foreach($arrQuery as $q){
					if($i==0){
						$select.=$q;
					}else{
						$select.=",".$q;
					}
					$i++;
				}
			}else{
				$select.="SELECT *";
			}
			$select.=" FROM ".$table." ";
			$select.=" WHERE ";
			//$reset($AsArrPara);
			$i=0;
			foreach($AsArrPara as $key=> $val){
				if($i==0){
					$select.=$key."='".$val."' ";
				}else{
					$select.="AND ".$key."='".$val."' ";
				}
				$i++;
			}
			
			echo $select.'<br>';
			$result = mysqli_query($select) OR die($this->err=mysql_error());
			while($row = mysql_fetch_assoc($result)) {
				foreach($row as $key=> $val){
					$res[$key]=$val;
				}
			}

		}else{
			$this->err.="Feheler0005: Parameter nicht richtig gesetzt in selectFrom()<br />";
		}
		if(isset($res)){
			return $res;
		}else{
			return $this->err;
		}
	}
	
	function query($query){
		if(isset($query)){
			$result = mysqli_query($query) OR die($this->err=mysql_error());
			$i=0;
			while($row = mysqli_fetch_assoc($result)) {
				$res[$i++]=$row;
				
				/*foreach($row as $key=> $val){
					echo" $key | $val ||$i";
					$res[$key]=$val;
				}*/
			}

		}else{
			$this->err.="Feheler0006: Parameter nicht richtig gesetzt in query()<br />";
		}
		if(isset($res)){
			return $res;
		}else{
			return $this->err;
		}
	}
			
		
}
?>



    