<?php  

class Usuario {

	private $idusuario;
	private $descrlogin;
	private $descrsenha;
	private $dtcadastro;

	public function getIdusuario() {
		return $this -> idusuario;
	}

	public function setIdusuario($value) {
		$this -> idusuario = $value;
	}

	public function getDescrlogin() {
		return $this -> descrlogin;
	}

	public function setDescrlogin($value) {
		$this -> descrlogin = $value;
	}

	public function getDescrsenha() {
		return $this -> descrsenha;
	}

	public function setDescrsenha($value) {
		$this -> descrsenha = $value;
	}

	public function getDtcadastro() {
		return $this -> dtcadastro;
	}

	public function setDtcadastro($value) {
		$this -> dtcadastro = $value;
	}

	public function loadById($id) {

		$sql = new Sql();

		$results = $sql -> select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(

			":ID" => $id
		));

		if (count($results) > 0) {

			$row = $results[0];

			$this -> setIdusuario($row['idusuario']);
			$this -> setDescrlogin($row['descrlogin']);
			$this -> setDescrsenha($row['descrsenha']);
			$this -> setDtcadastro(new DateTime($row['dtcadastro']));
		}
	}

	public function __toString() {

		return json_encode(array(

			"idusuario" => $this -> getIdusuario(),
			"descrlogin" => $this -> getDescrlogin(),
			"descrsenha" => $this -> getDescrsenha(),
			"dtcadastro" => $this -> getDtcadastro() -> format("d/m/Y H:i:s")
		));
	}
}
?>