<?php 

// Error handling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("config.php");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM USUARIO WHERE EMAIL = '$email';"; //O teste inicial deve ser só no email
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result); //Se não retornou nenhuma linha, é porque não existe ninguém com esse email
$linha = pg_fetch_assoc($result); //Tenta retornar a primeira linha de qualquer forma, para testar a senha

if (($linhas <= 0) || !password_verify($password, $linha['senha'])) { // Se não existia o email OU a verificação da senha falhou
	$err = "";
	if ($linhas <= 0) {
		$err .= "email";
	}
	if (!password_verify($password, $linha['senha'])){
		$err .= " e senha";	
	}
	echo"<script language='javascript' type='text/javascript'>alert('$err incorreto(s)');window.location.href='login.html';</script>";
} else {
  setcookie("email", $email);
  echo"<script language='javascript' type='text/javascript'>alert('Login efetuado com sucesso');window.location.href='index.php';</script>";
}

?>