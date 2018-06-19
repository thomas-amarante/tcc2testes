<?php
	//session_name('sessionuser');
	session_start();
	include_once 'includes/connect.php';	
 
 $nome_f = $_POST['nome_f'];  
 $email_f = $_POST['email_f'];  
 $cep = $_POST['cep'];
 $cel = $_POST['cel'];
 $end = $_POST['end'];
 $num = $_POST['num'];
 
 $sql	="SELECT email FROM tb_usuario WHERE email = '$email_f'";
 $query	= mysqli_query($conn, $sql);

							  
if(mysqli_num_rows($query)>0) 
							{
								?>
									<script>
										alert('Já existe um usuário com esse email na nossa base de dados. Por favor, verifique se você já não possui cadastro conosco');
										document.location.replace('cadastro.php');				
									</script>s
								<?php
								
								
							} else {
									$sql = "INSERT INTO tb_usuario(email, endereco, fone, nome, cep) VALUES ('$email_f','$end','$cel','$nome_f','$cep')";
									$query = mysqli_query ($conn, $sql);
									
									if(!$query){
										?>
											<script>
												alert('Erro ao realizar o agendamento :(');
												document.location.replace('cadastro.php');				
											</script>
								<?php
									} else {
										?>
											<script>
												alert('Agendamento realizado com sucesso!');
												document.location.replace('user.php');				
											</script>
								<?php
									}
									}

