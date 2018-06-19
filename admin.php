<?php
	
	//session_name('sessionempresa');
	session_start();
	include('includes/connect.php');
	
	$user = $_SESSION['COD_E'];
	//$nome = $_SESSION['NOME_E'];
		
		// query para pesquisar e retornar valores para exibir no fullcalendar	
		$result_events = "SELECT a.id as id2, a.id_user, nome_cliente, fone, data_inicio, data_fim, c.nome_quadra_local FROM tb_agenda a INNER JOIN tb_usuario b ON a.id_user = b.id INNER JOIN tb_quadras_locais c ON a.id_quadra_local = c.id WHERE a.id_quadra = '$user'";	
		$resultado_events = mysqli_query($conn, $result_events);
		
		// total recebido com os jogos marcados para hoje
		$sql = "SELECT SUM(valor) AS 'valores_dia' FROM tb_agenda WHERE id_quadra = '$user' AND DATE(data_inicio) = CURDATE()"; 
		$query = mysqli_query($conn, $sql);
		$dados = mysqli_fetch_array($query); 
		
		// total de jogos hoje
		echo $sql1 = "SELECT COUNT(*) as total FROM tb_agenda WHERE id_quadra = '$user' AND DATE(data_inicio) = CURDATE()"; 
		$query1 = mysqli_query($conn, $sql1);
		$num_rows1 = mysqli_fetch_array($query1); 
		$jogos_hoje = $num_rows1['total'];
		
		// Query com subquery para pegar o dia mais selecionado e o número de vezes que ele aparece
		$sql2 = "SELECT dayname(`data_inicio`) as dia, COUNT(*) as total FROM `tb_agenda` WHERE dayname(`data_inicio`) = (SELECT dayname(`data_inicio`) FROM `tb_agenda` WHERE id_quadra = '$user' GROUP by dayname(`data_inicio`) ORDER BY COUNT(dayname(`data_inicio`)) DESC limit 1)";
		$query2 = mysqli_query($conn, $sql2);
		$num_rows2 = mysqli_fetch_array($query2);
		
?>		

<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
 
		
		<link href='css/fullcalendar.min.css' rel='stylesheet' />
		<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
		<link href='css/personalizado.css' rel='stylesheet' />
		<script src='js/jquery.min.js'></script>
		<script src='js/bootstrap.min.js'></script>
		<script src='js/moment.min.js'></script>
		<script src='js/fullcalendar.min.js'></script>
		<script src='locale/pt-br.js'></script>
  
  <link rel="stylesheet" href="now-ui-kit.css" type="text/css">
  <link rel="stylesheet" href="assets/css/nucleo-icons.css" type="text/css">
  <script src="assets/js/navbar-ontop.js"></script>
  
  <script>
  
   // daqui pra baixo são eventos do FullCalendar
		  
		  
		  $(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: false,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event) {
						
						$('#visualizar #id').text(event.id);
						$('#visualizar #id').val(event.id);
						$('#visualizar #title').text(event.title);
						$('#visualizar #title').val(event.title);
						$('#visualizar #color').val(event.color);
						$('#visualizar #color').text(event.color);						
						$('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));							
						
						$('#visualizar').modal('show');
						return false;

					},
					
					selectable: true,
					selectHelper: true,
					select: function(start, end){
						$('#cadastrar #start').val(moment(start).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar #end').val(moment(end).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar').modal('show');						
					},
					events: [
						<?php
							while($row_events = mysqli_fetch_array($resultado_events)){
									
								?>
								{
								id: '<?php echo $id2 = $row_events['id2']; ?>',
								title: '<?php echo $row_events['nome_quadra_local']; ?> - <?php echo $row_events['nome_cliente']; ?>',
								color: '<?php echo $row_events['fone']; ?>',
								start: '<?php echo $row_events['data_inicio']; ?>',	
								end: '<?php echo $row_events['data_fim']; ?>',									
								},<?php
							}
						?>
					]
				});
			});
			
			//Mascara para o campo data e hora
			function DataHora(evento, objeto){
				var keypress=(window.event)?event.keyCode:evento.which;
				campo = eval (objeto);
				if (campo.value == '00/00/0000 00:00:00'){
					campo.value=""
				}
			 
				caracteres = '0123456789';
				separacao1 = '/';
				separacao2 = ' ';
				separacao3 = ':';
				conjunto1 = 2;
				conjunto2 = 5;
				conjunto3 = 10;
				conjunto4 = 13;
				conjunto5 = 16;
				if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19)){
					if (campo.value.length == conjunto1 )
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto2)
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto3)
					campo.value = campo.value + separacao2;
					else if (campo.value.length == conjunto4)
					campo.value = campo.value + separacao3;
					else if (campo.value.length == conjunto5)
					campo.value = campo.value + separacao3;
				}else{
					event.returnValue = false;
				}
			}
  
  </script>
  
  

  <title>Marquejá</title>

<body class="">
  <nav class="navbar navbar-expand-lg bg-primary navbar-dark fixed-top mb-5">
    <div class="container">
      <a class="navbar-brand" title="marquejá" data-placement="bottom" data-toggle="tooltip" href="#firststep">#MarqueJá</a>
      <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarNowUIKitFree">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbarNowUIKitFree">
        <ul class="navbar-nav">
          <li class="nav-item mx-1 align-items-center d-flex justify-content-center">
            <a class="nav-link" href="#proxjogos">
              <i class="now-ui-icons arrows-1_cloud-upload-94 x2 mr-2"></i>&nbsp;Próximos jogos</a>
          </li>
          <li class="nav-item mx-2 align-items-center d-flex justify-content-center">
            <a class="nav-link" href="#ultimosjogos">
              <i class="now-ui-icons files_paper x2 mr-2">Últimos jogos</i></a>
          </li>
		   <li class="nav-item mx-3 align-items-center d-flex justify-content-center">
            <a class="nav-link" href="#mapa">
              <i class="now-ui-icons files_paper x2 mr-2">Mapa de quadras</i></a>
          </li>
        </ul>
        <a class="btn btn-light text-primary" href="#agendamento">
          <i class="now-ui-icons arrows-1_share-66 mr-1"></i>Agendar</a>
        <ul class="navbar-nav flex-row justify-content-center mt-2 mt-md-0">
          <li class="nav-item mx-1">
            <a class="nav-link" href="#" data-placement="bottom" data-toggle="tooltip" title="Follow us on Twitter">
              <i class="fa fa-fw fa-twitter fa-2x"></i>
            </a>
          </li>
          <li class="nav-item mx-3 mx-md-1">
            <a class="nav-link" href="#" data-placement="bottom" data-toggle="tooltip" title="Like us on Facebook">
              <i class="fa fa-fw fa-facebook-official fa-2x"></i>
            </a>
          </li>
          <li class="nav-item ml-1">
            <a class="nav-link" href="#" data-placement="bottom" data-toggle="tooltip" title="Follow us on Instagram">
              <i class="fa fa-fw fa-instagram fa-2x"></i>
            </a>
          </li>
		  <li class="nav-item mx-1 align-items-center d-flex justify-content-center">
            <a class="nav-link" href="logoff.php">
              <i class="now-ui-icons files_paper x2 mr-2"></i>Sair</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class=" py-5 bg-dark">
  </div>
  
  <div class="py-5 bg-dark">
		<div class="container">
			<div class="row"> 
				<div class="col-md-12">
					<h3 class="">
						 Perfil de gerenciamento - <?=$_SESSION['NOME_E'] ?> 
					</h3>
				</div>
			</div>	  
		</div>
    </div>
  

	 <div class="container">
		 <div class="row">
			 <div class="col-md-12">
				<h3> </h3>
			 </div>
		 </div>
	 </div> 
	 
	 
	  <div class="container">
		 <div class="row">
			 <div class="col-md-4">
				
			 
		<div class="card mb-4"> 
			<div class="card-header">
				<h5> Receita total - Hoje: </h5>
			</div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane fade show active text-center" id="tabone" role="tabpanel">
                  <h5>R$ <?php echo $dados['valores_dia'] ?></h5>
                </div>               
              </div>
            </div>
          </div>
        </div>		
			 <div class="col-md-4">
				
				<div class="card mb-4">
				<div class="card-header">
					<h5> Jogos marcados para hoje: </h5>
				</div>				
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane fade show active text-center" id="tabone" role="tabpanel">
                 <h5> <?php echo $jogos_hoje ?></h5>
                </div>               
              </div>
            </div>
          </div>
			 </div>
			 <div class="col-md-4">
				
				<div class="card mb-4">
				<div class="card-header">
					<h5> Dia mais procurado: </h5>
				</div>	
					<div class="card-body">				 
						<div class="tab-pane fade show active text-center" id="tabone" role="tabpanel">
						 <h5> <?php echo $dia = $num_rows2['dia'];?> - Reservas: <?php echo $dia = $num_rows2['total'];?> </h5>
						</div>               
					</div>
				</div>
          </div>
			 </div>
		</div>
		
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3> Agenda de jogos: </h3>
				</div>
			</div>
		</div>
	  

																														<!-- calendario -->
 
 
 
 <div id="calendar"></div>
 
  
  <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" arial-label="Close"><span aria-hidden="true">&times;</span></button>
						
					</div>
					<h4 class="modal-title text-center">Dados do Evento</h4>
					<div class="modal-body">
						<div class="visualizar">
							<dl class="dl-horizontal">
								<dt>ID do Evento</dt>
								<dd id="id"></dd>
								<dt>Nome do Cliente</dt>
								<dd id="title"></dd>
								<dt>Telefone para contato</dt>
								<dd id="color"></dd>
								<dt>Inicio do Evento</dt>
								<dd id="start"></dd>
								<dt>Fim do Evento</dt>
								<dd id="end"></dd>								
							</dl>
							<button class="btn btn-canc-vis btn-warning">Editar</button> 				
						
							<form class="form-horizontal" method="POST" action="whatsapp.php">
								<input type="submit" class="btn btn-success"> Whatsapp </input>
								<input type="hidden" class="form-control" name="id" id="id"> <!-- pegando o ID do evento ao abrir a janela ou uma nova janela -->
							</form>
							
							<form class="form-horizontal" method="POST" action="excluir_agendamento.php">
								<button type="submit" class="btn btn-danger" onClick="if(confirm('Deseja mesmo cancelar?')){document.location.href='excluir_agendamento.php'}">Cancelar </button>
								<input type="hidden" class="form-control" name="id" id="id"> <!-- pegando o ID do evento ao abrir a janela ou uma nova janela -->
							</form>
						</div>
						<!-- Modal para edição do evento escolhido -->
						<div class="form">
							<form class="form-horizontal" method="POST" action="proc_edit_evento.php">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Titulo</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="title" id="title" placeholder="Titulo do Evento">
									</div>
								</div>								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Data Inicial</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
									</div>
								</div>
								<input type="hidden" class="form-control" name="id" id="id">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
										<button type="submit" class="btn btn-warning">Salvar Alterações</button>
									</div>
								</div>
							</form>						
						</div>
						
						
						<!-- Modal para pesquisa do usuário escolhido -->
						<div class="form">
							
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Titulo</label>
									<div class="col-sm-10">
										<form method="POST" id="form-pesquisa" action="">
											<label>Pesquisar cliente: </label>
											<input type="text" name="pesquisa" id="pesquisa" placeholder="Digite o nome do usuário">
										</form>
									</div>
								</div>								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Data Inicial</label>
									<div class="col-sm-10">
										<ul class="resultado">
											
										</ul>
									</div>
								</div>
								<input type="hidden" class="form-control" name="id" id="id">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="button" class="btn btn-canc-edit btn-primary" onClick="gravar()" />Selecionar usuário
										<button type="button" class="btn btn-canc-edit">Salvar Alterações</button>
									</div>
								</div>											
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						
					</div>
					<h4 class="modal-title text-center">Cadastrar Evento</h4>
					<div class="modal-body">
						<form class="form-horizontal" method="POST" action="proc_cad_evento.php">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Titulo</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" placeholder="Titulo do Evento">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Data Inicial</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Data de término</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
								</div>
							</div>							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">									
									<button type="submit" class="btn btn-success">Cadastrar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
																												<!-- calendario -->

<div class="container py-5">
	<div class="row">
		<div class="col-md-12">
			<h3> Informações de clientes: </h3>
		</div>
	</div>
</div>


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form method="POST" id="form-pesquisa" action="">
				<label>Pesquisar: </label>
				<input type="text" name="pesquisa" id="pesquisa" placeholder="Digite o nome do usuário">
			</form>
		</div>
		<div class="row">	
			<div class="col-md-12">
				<ul class="resultado">
			
				</ul>
			</div>
		</div>
		
	</div>
</div>																												
  
  
  
	<script type="text/javascript" src="personalizado.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="assets/js/parallax.js"></script>
	<script>
			$('.btn-canc-vis').on("click", function() {
				$('.form').slideToggle();
				$('.visualizar').slideToggle();
			});
			$('.btn-canc-edit').on("click", function() {
				$('.visualizar').slideToggle();
				$('.form').slideToggle();
			});
			$('.btn-cliente-vis').on("click", function() {
				$('.form').slideToggle();
				$('.visualizar').slideToggle();
			});
		</script>

  
</body>

</html>