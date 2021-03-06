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


/*------COMANDOS para busca-------*/
	public function loadById($id) {

		$sql = new Sql();

		$results = $sql -> select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(

			":ID" => $id
		));

		if (count($results) > 0) {

			$this -> setDados($results[0]);
		}
	}

	public static function getList() {

		$sql = new Sql();

		return $sql -> select("SELECT * FROM tb_usuarios ORDER BY descrlogin;");
	}

	public static function search($login) {

		$sql = new Sql();

		return $sql -> select("SELECT * FROM tb_usuarios WHERE descrlogin LIKE :SEARCH ORDER BY descrlogin", array(
			':SEARCH' => "%".$login."%"
		));

	}

	public function login($login, $password) {

		$sql = new Sql();

		$results = $sql -> select("SELECT * FROM tb_usuarios WHERE descrlogin = :LOGIN AND descrsenha = :PASSWORD", array(

			":LOGIN" => $login,
			":PASSWORD" => $password
		));

		if (count($results) > 0) {

			$this -> setDados($results[0]);
			
		} else {

			throw new Exception("Login e/ou senha inválidos.");
		}	

	}

/*-------COMANDOS para inserção--------*/
	public function insert() {

		$sql = new Sql();

		$results = $sql -> select("CALL sp_usuarios_insert (:LOGIN, :PASSWORD
		)", array(

			':LOGIN' => $this -> getDescrlogin(),
			':PASSWORD' => $this -> getDescrsenha()

		));

		if (count($results) > 0) {
			$this -> setDados($results[0]);
		}

	}

/*------COMANDOS para modificação------*/
	public function update($login, $password) {

		$this -> setDescrlogin($login);
		$this -> setDescrsenha($password);

		$sql = new Sql();

		$sql -> query("UPDATE tb_usuarios SET descrlogin = :LOGIN, descrsenha = :PASSWORD WHERE idusuario = :ID", array(

			':LOGIN' => $this -> getDescrlogin(),
			':PASSWORD' => $this -> getDescrsenha(),
			':ID' => $this -> getIdusuario()	
		));
	}

/*------COMANDOS para apagar------*/
	public function delete() {

		$sql = new Sql();

		$sql -> query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(

			':ID' => $this -> getIdusuario()
		));

		$this -> setIdusuario(0);
		$this -> setDescrlogin("");
		$this -> setDescrsenha("");
		$this -> setDtcadastro(new DateTime());
	}

//-----------------------------------------------\\
	public function setDados($dados) {

		$this -> setIdusuario($dados['idusuario']);
			$this -> setDescrlogin($dados['descrlogin']);
			$this -> setDescrsenha($dados['descrsenha']);
			$this -> setDtcadastro(new DateTime($dados['dtcadastro']));
	}

	public function __construct($login = "", $password = "") {

		$this -> setDescrlogin($login);
		$this -> setDescrsenha($password);

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