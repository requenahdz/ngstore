<?php
require_once('conexion.class.php');
class Database{
		private $conexion;
		private $table;
		private $id;
		private $atributos;
		
		public function __construct($table){
		$this->table=$table;
		$this->conexion = new conexion();
		$this->conexion->exec("SET CHARACTER SET utf8");
		
		}

		// retorna un arreglo de toda la tabla
		public function all(){
			$sql="SELECT * FROM {$this->table}";
			$consulta = $this->conexion->prepare($sql);
			$consulta->execute();			
			return $consulta->fetchAll();
		}	
		//Busca un registro en base a su id
		public function find($id){
			return $this->where('id',$id,'=')[0];
		}

		//genera una consulta  con un where 
		public function where($campo,$valor,$operador){
			$sql="SELECT * from {$this->table} WHERE $campo $operador '$valor'";
			$consulta = $this->conexion->prepare($sql);
			
			$consulta->execute();
			return $consulta->fetchAll();
		}

		public function existe($campo,$valor){
			$sql= "SELECT * from {$this->table} where $campo='$valor'";
			$consulta = $this->conexion->prepare($sql);
			$consulta->execute();
			if (count($consulta->fetchAll())>=1){
				return true;
			}else{
				return false;
			}
		
		}

		//genera una consulta de inserccion apartir de un arreglo asociativo
		public function save($atributos){
		 $atributos;	
		 $sqlprincial= "INSERT INTO {$this->table}(";
		 $sqlfinal="VALUES(";
		 foreach ($atributos as $key => $value) {
		 	$sqlprincial.=$key.",";
		 	$sqlfinal.="'".$value."',";
		 }	 
		 $sqlprincial= substr($sqlprincial,0,-1).")";
		 $sqlfinal= substr($sqlfinal,0,-1).")";
		 $sql=$sqlprincial.$sqlfinal;
			$consulta = $this->conexion->prepare($sql);
		 return $consulta->execute();
		}

		//edita un campo especifico
		public function edit($id,$campo,$valor){
		$sql="UPDATE {$this->table} SET $campo = '$valor'WHERE id ='$id' ";
		$consulta = $this->conexion->prepare($sql);
		return $consulta->execute();
		}
		//elimina un registro apartir de un id
		public function destroy($id){
		$sql="DELETE FROM {$this->table} WHERE id = '$id'";
		$consulta = $this->conexion->prepare($sql);
		return $consulta->execute();
		}


		
		public function login($correo,$password){
		$password=crypt($password,'maquinadeguerraeslaonda');
		$sql="SELECT * from {$this->table} WHERE correo= '$correo' and password='$password'";
		$consulta = $this->conexion->prepare($sql);
		$consulta->execute();
		foreach ($consulta->fetchAll() as $row) {
			session_start();
			$_SESSION["id"]=$row['id'];
			$_SESSION["nombre"]=$row['nombre'];
			$_SESSION['rol_id']=$row['rol_id'];
			return true;
		}

		return false;
		}

}

?>
