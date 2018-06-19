<?php
	
	include('js/functions.php');
	//session_name('sessionempresa');
	session_start();
	include('/includes/connect.php');

	
?>   
<html>
	<head>
		<title>Validação de Login</title>
	</head>
	<body bgcolor="#FFFFFF">
		<?php
		
		$nome = $_POST['login_e'];
		$senha = $_POST['senha_e'];
		

			if (empty($nome)) 
			{
				$mensagem = "Preencha corretamente o campo Usuário!!";
				$erro = true;
				?>
				<script>
				         alert("Nenhum campo pode ficar em branco...");
						<?php $_SESSION = array();
				         session_destroy(); ?>
						 document.location.replace('login_quadras.php');                            
                </script>
				<?php
			}
			
			else if (empty($senha)) {
				?>
				<script>
				         alert("Nenhum campo pode ficar em branco...");
						 <?php $_SESSION = array();
				         session_destroy(); ?>
						 document.location.replace('login_quadras.php');                            
                </script>
				<?php		
			}
					
			else {
				//Verifica usuário e senha!!
				
				
				$sql = "SELECT * FROM tb_quadras WHERE login='$nome' AND senha='$senha'";
				$query = mysqli_query($conn, $sql);
				$dados = mysqli_num_rows($query);
				
				if( $dados === 0) {
					?>
				<script>
				         alert("Usuário não encontrado");
						<?php $_SESSION = array();
				         session_destroy(); ?>
						 document.location.replace('login_quadras.php');                            
                </script>
				<?php
				   
				} 
				
				else {
				   							
					//Caso encontre administradores com as informações fornecidas registra a data e a hora do login, assim como as variáveis de sessão
					$dados1 = mysqli_fetch_array($query);
					//$query_update = mysql_query("UPDATE tb_cadastro_usuarios SET ultimo_login='".date("Y-m-d H:i:s")."' WHERE id='{$dados['codigo']}'",$conexao);		

					
					$_SESSION['COD_E'] 				= $dados1['id'];
					$_SESSION['LOGIN_E'] 			= $dados1['login'];
					$_SESSION['NOME_E'] 			= $dados1['nome'];
					$_SESSION['IS_LOGADO_E'] 		= true;	
				
					
					?>
						<script>
							alert('Login efetuado com sucesso...'); 
                            document.location.replace('admin.php');
                        </script>
					<?php	

				}
			}	
		?>	
	</body>
</html>




