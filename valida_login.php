<?php
	
	include('js/functions.php');
	//session_name('sessionuser');
	session_start();
	include('includes/connect.php');

	
?>   
<html>
	<head>
		<title>Validação de Login</title>
	</head>
	<body bgcolor="#FFFFFF">
		<?php
		
		$user = $_POST['login'];
		$senha = $_POST['senha'];
		

			if (empty($user)) 
			{
				$mensagem = "Preencha corretamente o campo Usuário!!";
				$erro = true;
				?>
				<script>
				         alert("Nenhum campo pode ficar em branco...");
						<?php $_SESSION = array();
				         session_destroy(); ?>
						 document.location.replace('index.html');                            
                </script>
				<?php
			}
			
			else if (empty($senha)) {
				?>
				<script>
				         alert("Nenhum campo pode ficar em branco...");
						 <?php $_SESSION = array();
				         session_destroy(); ?>
						 document.location.replace('index.html');                            
                </script>
				<?php		
			}
					
			else {
				//Verifica usuário e senha!!			
						
				$sql = "SELECT * FROM tb_usuario WHERE email='$user' AND senha='$senha'";
				$query = mysqli_query($conn, $sql);
				$dados = mysqli_num_rows($query);
								
				if( $dados === 0) {
					?>
				<script>
				         alert("Usuário não encontrado");
						<?php $_SESSION = array();
				         session_destroy(); ?>
						 document.location.replace('index.html');                            
                </script>
				<?php
				   
				} 
				
				else {
				   							
					//Caso encontre administradores com as informações fornecidas registra a data e a hora do login, assim como as variáveis de sessão
					$dados1 = mysqli_fetch_array($query);
					
					//$query_update = mysql_query("UPDATE tb_cadastro_usuarios SET ultimo_login='".date("Y-m-d H:i:s")."' WHERE id='{$dados['codigo']}'",$conexao);		

					
					$_SESSION['COD'] 			= $dados1['id'];
					$_SESSION['ADMINISTRADOR'] 	= $dados1['login'];
					$_SESSION['NOME'] 			= $dados1['nome'];
					$_SESSION['IS_LOGADO'] 		= true;	
					
					
					?>
						<script>
							alert('Login efetuado com sucesso...'); 
                            document.location.replace('user.php');
                        </script>
					<?php	

				}
			}	
		?>	
	</body>
</html>




