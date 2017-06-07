<?php
class Conexion extends PDO {
//Esta clase esta encargada de hacer la conexion

		///En esta parte se declara los atributos de la clase de manera privada
		private $tipo_de_base = 'mysql';
		private $host = 'localhost';
		private $nombre_de_base = 'eventos';
		private $usuario = 'root';
		private $contrasena = '';

		//El constructor establece la conexion a la base de datos,y si no se establece se manda una exception 
		public function __construct() {
		try{
		 	
		   parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena);
      

				}catch(PDOException $e){
						echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
						exit;

				}

		}

	}


?>