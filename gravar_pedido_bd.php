<?php
	//session_name('sessionuser');
	session_start();
	include('/includes/connect.php');
 

   $nome_cliente = $_SESSION['NOME'];
   $quadra = $_POST['quadra'];
   $quadra_local = $_POST['quadra_local'];
   $id_user = $_SESSION['COD']; 
   $data_inicial = $_POST['data_inicio'];
   $data_final = $_POST['data_fim'];	
   $valor = $_POST['valor'];
 
 
	$sql1	="SELECT * FROM tb_agenda WHERE id_quadra = '$quadra' AND id_quadra_local = '$quadra_local' AND data_inicio = '$data_inicial' AND data_fim = '$data_final' ";
	$query1	= mysqli_query($conn, $sql1);
	

							  
	if(mysqli_num_rows($query1)>0) 
							{
								?>
									<script>
										alert('Horário não disponível para essa data, por favor escolha outro...');
										document.location.replace('user.php');				
									</script>s
								<?php
								
								
							} else {
									$sql = "INSERT INTO tb_agenda (nome_cliente, id_quadra, id_quadra_local, id_user, data_inicio, data_fim, valor, status, descricao) VALUES ('$nome_cliente','$quadra','$quadra_local','$id_user','$data_inicial','$data_final','$valor','11','Reserva')";
									$query = mysqli_query ($conn, $sql);
									
									
									if(!$query){ 
									?>
											<script>
												alert('Erro ao realizar o agendamento :(');
												document.location.replace('user.php');				
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

