<?php  

require_once("config.php");

/*--COMANDOS de busca--*/
//traz apenas uma linha por vez
/*$user = new Usuario();
$user -> loadById(1);
echo $user;*/

//traz uma lista
/*$lista = Usuario::getList();
echo json_encode($lista);*/

//traz uma lista de usuarios buscado pelo login
/*$search = Usuario::search("r");
echo json_encode($search);*/

//traz um usuario buscado pelo login e senha(autenticados)
$usuario = new Usuario();
$usuario -> login("fabiano", "1234");
echo $usuario;




?>