<?php
//Incluir a conexão com banco de dados
include_once 'includes/connect.php';

$usuarios = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT nome, email FROM tb_usuario WHERE nome LIKE '%$usuarios%' LIMIT 20";
$resultado_user = mysqli_query($conn, $result_user);

if(($resultado_user) AND ($resultado_user->num_rows != 0 )){
	while($row_user = mysqli_fetch_assoc($resultado_user)){
		echo "<li> Nome: ".$row_user['nome']." - Email: <b>".$row_user['email']."</b> </li>";
	}
}else{
	echo "Nenhum usuário encontrado ...";
}