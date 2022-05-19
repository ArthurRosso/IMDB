<?php 

require_once("config.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "SELECT * FROM USUARIO WHERE EMAIL = '$email'"; //O teste inicial deve ser só no email
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result); //Se não retornou nenhuma linha, é porque não existe ninguém com esse email

if($email == "" || $email == null || $name == "" || $name == null){
  echo"<script language='javascript' type='text/javascript'>alert('Todos os campos devem ser preenchidos');window.location.href='cadastro.html';</script>";
}else {
  if ($linhas > 0) {
    echo"<script language='javascript' type='text/javascript'>alert('Esse email já está cadastrado');window.location.href='cadastro.html';</script>";
  } else {
    $sql = "INSERT INTO USUARIO (senha, nome, email) VALUES ('$password', '$name', '$email');";
    setcookie("email", $email);
    if (pg_query($link, $sql)) {
      echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='index.php'</script>";
    } else {
      echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='cadastro.html'</script>";
    }
  }
}
?>