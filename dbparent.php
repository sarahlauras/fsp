<?php  
require_once("data.php");

class DBParent {
	protected $mysqli;

	public function __construct(){
		$this->mysqli = 
			new mysqli(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
            if($this->mysqli->connect_errno){ //kalau ada nilai selain 0, maka ada KEGAGALAN KONEKSI
                echo "Koneksi database gagal: ".$this->mysqli->connect_error;
                exit();
            }
	}
}
?>
