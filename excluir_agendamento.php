<?php
	include('includes/connect.php');
	
	$id 	= $_GET['key'];	
	$sql	= "DELETE FROM tb_agenda WHERE id ='$id'";
	$query	= mysqli_query($conn, $sql);
	
	if(!$query)
		{
			?>
            	<script>
					alert('Erro ao cancelar. Contate diretamente a quadra para finalizar o cancelamento.');
					document.location.replace('user.php');
                </script>
			<?php
		}
			else
				{
						
			?>
            	<script>
					alert('Agendamento cancelado');
					window.history.back();
                </script>
			<?php
		
				}
?>