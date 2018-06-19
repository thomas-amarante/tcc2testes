<?php
	
	//session_name('sessionuser');
	session_start();
	include('includes/connect.php');
	
	$title 	= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	$start 	= filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
	$end 	= filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);
	$quadra	= $_SESSION['QUADRA'];
	$quadra_local	= $_SESSION['QUADRA_LOCAL'];


	$teste = explode(" ", $start);
	$data_teste = $teste[1]; // variável que recebe apenas o horário agendado --> ex 10:00:00

	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	
	// ---> verificando se o usuário escolheu horário quebrado a partir da hora de início ex: 20h30, 19h30
	$formatar_hora = explode(":", $hora);
	$hora_aux = $formatar_hora[1]; // ---> verificando se o usuário escolheu horário quebrado ex: 20h30, 19h30
	$hora_aux1 = $formatar_hora[0]; // ---> Valor que será usado para validar o custo para o cliente caso seja mais de 1 hora de agendamento
	
	if($hora_aux1 < '09'){
			?>      <script>
                    	alert("O local não permite agendamento nesse horário. Por gentileza, escolha um horário que não esteja com a cor cinza! ")
						document.location.replace('horarios.php')
                    </script>
			<?php
	}
	
	if($hora_aux == 30){
		
			?>
                	<script>
                    	alert("Não é possível agendar em horários quebrados como 20h30, 14h30. Favor selecionar um horário cheio ")
						document.location.replace('horarios.php')
                    </script>
				
			<?php
	}
		
	
	// pegar o dia da semana pela data escolhida caso esteja ex: 07/06/2018 e transformar em 2018-06-07 e fazer isso antes do array com os dias abaixo
		
	//Array com os dias da semana
	$diasemana = array('Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado');

	//Aqui podemos usar a data atual ou qualquer outra data no formato Ano-mês-dia (2014-02-28)
	$data1 = $data_sem_barra;

	// Varivel que recebe o dia da semana (0 = Domingo, 1 = Segunda ...)
	$diasemana_numero = date('w', strtotime($data1));

	// Exibe o dia da semana com o Array
	$diasemana[$diasemana_numero];
	

	
	$data = explode(" ", $end);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;
	
	
	// ---> verificando se o usuário escolheu apenas meia hora de jogo a partir da hora de término ex: 20h00 às 20h30
	$formatar_hora = explode(":", $hora);
	$hora_aux = $formatar_hora[1]; // ---> verificando se o usuário escolheu horário quebrado ex: 20h30, 19h30
	$hora_aux2 = $formatar_hora[0]; // ---> ---> Valor que será usado para validar o custo para o cliente caso seja mais de 1 hora de agendamento
	
	if($hora_aux == 30){
		
		?>
                	<script>
                    	alert("Não é possível agendar apenas 30 minutos ou horários quebrados como 1h30 ou 2h30. Favor selecionar novamente... ")
						document.location.replace('horarios.php')
                    </script>
				
			<?php
	}
	
	
	
	// trecho que não permitirá agendamento duas vezes no mesmo horário
	
	$aux_cont = $hora_aux2-$hora_aux1;

	if($aux_cont > 1){
		for($i=$hora_aux1;$i<=$hora_aux2;$i++){
			$aux_sql1 = "SELECT * FROM tb_agenda WHERE id_quadra = '$quadra' AND id_quadra_local = '$quadra_local' AND data_inicio = '$data_sem_barra. $i:00:00'  ";
			$aux_query1 = mysqli_query($conn, $aux_sql1);
	
	if(mysqli_num_rows($aux_query1)>0 ){
			?>
                	<script>
                    	alert("Não é possível agendar em um horário já reservado. Favor alterar sua escolha para horários disponíveis. ")
						document.location.replace('horarios.php')
                    </script>
				
			<?php
		}
	  }
	}
	
	
	$sql1 = "SELECT id FROM tb_horas WHERE horas = '$data_teste'";
	$query1 = mysqli_query($conn, $sql1);
	$dados1 = mysqli_fetch_array($query1);
	$id_horas = $dados1['id']; // id da hora do jogo
	
	$sql2 = "SELECT * FROM tb_dias WHERE dia = '$diasemana[$diasemana_numero]'";
	$query2 = mysqli_query($conn, $sql2);
	$dados2 = mysqli_fetch_assoc($query2);
	$id_dia = $dados2['id']; // id do dia do jogo
	
	
	
	//Trecho que determina o  valor a ser pago pelo usuário (adicionado após opção de marcação de mais de uma hora de jogo)
	$aux_contador = $hora_aux2-$hora_aux1;
	$valor = 0;
	if($aux_contador > 1){
		for($i=$hora_aux1;$i<$hora_aux2;$i++){
			$sql3 = "SELECT id from tb_horas WHERE horas = '$i:00:00'"; // pesquisa 
			$query3	= mysqli_query($conn, $sql3);
			$dados3 = mysqli_fetch_array($query3);
			$aux_cont = $dados3['id'];
			
			$sql4 = "SELECT valor FROM `tb_valores_quadras` WHERE `id_dia` = '$id_dia' AND `id_horas` = '$aux_cont' AND`id_quadra` = '$quadra' AND `id_quadra_local` = '$quadra_local';";
			$query4	= mysqli_query($conn, $sql4);
			$dados4 = mysqli_fetch_array($query4);
			$aux_cont1 = $dados4['valor']; 
						
			
			$valor = $valor + $aux_cont1; // valor final (somado em caso de mais de 1 hora no agendamento)
		}
	} else {
		
			$sql3 = "SELECT id from tb_horas WHERE horas = '$hora_aux1:00:00'"; 
			$query3	= mysqli_query($conn, $sql3);
			$dados3 = mysqli_fetch_array($query3);
			$aux_cont = $dados3['id'];
			
			$sql4 = "SELECT valor FROM `tb_valores_quadras` WHERE `id_dia` = '$id_dia' AND `id_horas` = '$aux_cont' AND`id_quadra` = '$quadra' AND `id_quadra_local` = '$quadra_local';";
			$query4	= mysqli_query($conn, $sql4);
			$dados4 = mysqli_fetch_array($query4);
			$valor = $dados4['valor'];
		
	}
	
	$valor = $valor.'.00';
	
					// resumo de variaveis para o Pagseguro
					
					//$_SESSION['QUADRA'] 
					//$_SESSION['QUADRA_LOCAL']
					//$_SESSION['NOME']
					$_SESSION['ID_DIA'] 		= $id_dia;
					$_SESSION['VALOR']			= $valor;
					$_SESSION['DATA_INICIO']	= $start_sem_barra;
					$_SESSION['DATA_FIM']		= $end_sem_barra;
					
					
					//
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pedido de teste</title> 
	
	
	<link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.js" type="text/javascript"></script>
	 <script src="js/jquery.js"></script>
	
 

	<script>
	 function enviaPagseguro(codigo){ <!-- função que salva o pedido no banco, recupera a coluna id e passa via post para a pagina pagseguro.php, além de passar dinamicamente a variável code junto com a url do form acima -->
	 
	   $.post('salvarPedido.php','',function(idPedido){
	 
		 $('#loading').css("visibility","visible");
	 
		 $.post('pagseguro.php',{idPedido:idPedido},function(data){

		   $('#code').val(data);
		   $('#comprar').submit();

		   $('#loading').css("visibility","hidden");
		 })
	   })
	 }
	 </script>
</head>

<body>
 

    
	<div class="container py-5 ">
	
	 </div>

	<div class="container">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header text-center">
				<h2 class="text-center">Dados do agendamento</h2>
				</div>
					<div class="modal-body row">
					
						<form action="gravar_pedido_bd.php" method="post" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
						<div class="form-group">
							<h4><p class="text-center">Local: Quadra Zona Sul</p></h4>
						</div>
						<div class="form-group">
							<h4><p class="text-center">Quadra: Quadra B</p></h4>
						</div>
						<div class="form-group">
							<h4><p class="text-center">Dia do jogo:Segunda-feira</p></h4>
						</div>
						<div class="form-group">
							<h4><p class="text-center">Data selecionada: 29/06/2018</p></h4>
						</div>
						<div class="form-group">
							 <h4><p class="text-center">Valor: R$ 110,00</p></h4>
						</div>
						<div class="modal-footer text-center">
						<div class="col-md-6 text-center">
							<button class="btn btn-success"  onclick="enviaPagseguro();">PagSeguro</button>  <!-- botão com função ao clicar: executar a função enviaPagseguro -->
						</div>
						<div class="col-md-6 text-center">
						
							<button type="submit" class="btn btn-info" >Pagar no local</button>
							<!-- hiddens -->
							<input type="hidden" name="data_inicio" id="data" value="<?php echo $start_sem_barra ?>" placeholder="<?php echo $start_sem_barra ?>" />
							<input type="hidden" name="data_fim" id="data" value="<?php echo $end_sem_barra ?>" placeholder="<?php echo $end_sem_barra ?>" />
							<input type="hidden" name="quadra" id="quadra" value="<?php echo $quadra ?>" placeholder="<?php echo $quadra ?>" />
							<input type="hidden" name="quadra_local" id="quadra_local" value="<?php echo $quadra_local ?>" placeholder="<?php echo $quadra_local ?>" />
							<input type="hidden" name="valor" id="valor" value="<?php echo $valor ?>" placeholder="<?php echo $valor ?>" />
							
							</form>
							</div>
						</div>
						<div class="modal-footer text-center">
						<div class="col-md-12 text-center">
							<form action="abortar_pedido.php" method="post" class="text-center">
								<button class="btn btn-danger" type="submit" > Cancelar agendamento </button>
							</form>
						</div>
						</div>
					
			
			</div>
		</div>
	</div>
	 

 
	<img src="loading.gif" id="loading" style="visibility: hidden">
 
	<form id="comprar" action="https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html" method="post";">
		<input type="hidden" name="code" id="code" value="" />
	</form>
	<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script> <!-- js necessário para execução da lightbox -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="js/bootstrap.js" type="text/javascript"></script>

	 
 
</body>
</html>	