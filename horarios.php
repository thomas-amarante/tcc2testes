<?php
	
	//session_name('sessionuser');
	session_start();
	include('includes/connect.php');
	
	$user = $_SESSION['COD'];
	
	if($_SESSION['QUADRA_LOCAL'] == null) { // primeira vez na página			
		echo $id_quadra_local = $_POST['quadra_local'];
		echo $_SESSION['QUADRA_LOCAL'] = $id_quadra_local;
		
		echo "Essa é a primeira vez na página";	
			
	} 
	if($id_quadra_local == null) { // segunda vez na pagina com variável de sessão definida ou erro no select da pagina anterior		
		echo $id_quadra_local = $_SESSION['QUADRA_LOCAL'];		
		echo $_SESSION['QUADRA_LOCAL'] = $_SESSION['QUADRA_LOCAL'];		
		echo "Essa é a segunda vez na página";	
	}	
	 
					
		
				$sql = "SELECT * FROM tb_agenda WHERE id_quadra_local = '$id_quadra_local'"; //pesquisa no banco para popular o calendário com jogos já feitos
				$query	= mysqli_query($conn, $sql);
				$dados = mysqli_fetch_array($query);
				
				echo $sql2 = "SELECT * FROM tb_quadras_locais WHERE id = '$id_quadra_local'"; //pesquisa no banco para pegar o id principal da tabela tb_quadras_locais
				$query2	= mysqli_query($conn, $sql2);
				$dados2 = mysqli_fetch_array($query2);				
				echo $_SESSION['QUADRA'] = $dados2['id_quadra'];
				
				$sql1 = "SELECT * FROM tb_agenda a INNER JOIN tb_quadras b ON a.id_quadra = b.id WHERE id_quadra_local = '$id_quadra_local'" ; // Pesquisa para pegar o nome do local do jogo
				$query1	= mysqli_query($conn, $sql1);
				$dados1 = mysqli_fetch_array($query1);			
						
			?>

			
	



<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
						right: 'agendaDay' //agendaWeek (para semana) - mounth (para mes)
					},
					defaultDate: Date(),
					defaultView: 'agendaDay', // mostrar apenas o dia para marcação de horários
					navLinks: true, // can click day/week names to navigate views
					editable: false,
					eventLimit: false, // allow "more" link when too many events
					
					
					
					validRange: function(nowDate){
					return {start: nowDate} //trecho para bloquear o usuário de marcar jogos em data anterior 
					},
					
					businessHours: [ // specify an array instead
						{
							dow: [ 1, 2, 3, 4, 5, 6, 7], // Monday, Tuesday, Wednesday
							start: '09:00', // 8am
							end: '23:00' // 6pm
						},						
						],
					
					// trecho para limitar o horário de funcionamento entre 09h00 e 23h00
					//viewRender: function(view, element) {
					//if (view.name.substr(0, 6) === 'agenda') {
					//$(element).find('div.fc-slats table tr[data-time]').filter(function() {
					//var _t = $(this).data('time');
					/* find times not in the ranges we want */
					//return ((_t >= '09:00' && _t <= '23:00')) === false;
					//}).each(function() {
					//$(this).hide(); /* hide the rows */
					//	  });
					//	};
					 // },
					
					//select: function(start, end, jsEvent, view) {
					//if (moment().diff(start, 'days') > 1) {
					//$('#calendar').fullCalendar('unselect');					
					//return false;
					//} },
					
					eventClick: function(event) {
						
						$('#visualizar #id').text(event.id);
						$('#visualizar #id').val(event.id);
						$('#visualizar #title').text(event.title);
						$('#visualizar #title').val(event.title);
						$('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));						
						$('#visualizar #color').val(event.color);
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
							while($dados = mysqli_fetch_array($query)){
									$dados1 = mysqli_fetch_array($query1);;
								?>
								{
								id: '<?php echo $dados['id']; ?>',
								title: 'HORÁRIO INDISPONÍVEL',								
								start: '<?php echo $dados['data_inicio']; ?>',								
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
					campo.value="00/00/0000 00:00:00"
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
      <a class="navbar-brand" title="Designed by Invision. Coded by Creative Tim and Pingendo" data-placement="bottom" data-toggle="tooltip" href="#firststep">#MarqueJá</a>
      <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarNowUIKitFree">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbarNowUIKitFree">
        <ul class="navbar-nav">
          <li class="nav-item mx-1 align-items-center d-flex justify-content-center">
            <a class="nav-link" href="#download">
              <i class="now-ui-icons arrows-1_cloud-upload-94 x2 mr-2"></i>&nbsp;DOWNLOAD</a>
          </li>
          <li class="nav-item mx-1 align-items-center d-flex justify-content-center">
            <a class="nav-link" href="#">
              <i class="now-ui-icons files_paper x2 mr-2"></i>COMPONENTS</a>
          </li>
        </ul>
        <a class="btn btn-light text-primary" href="#pro">
          <i class="now-ui-icons arrows-1_share-66 mr-1"></i>Upgrade to PRO</a>
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
  <div class="py-5 bg-secondary">
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
  	
		<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						
					</div>
					<h4 class="modal-title text-center">Reserva de horário</h4>
					<div class="modal-body">
						<form class="form-horizontal" method="POST" action="confirma_pedido.php">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Titulo</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" name="title" value="Reserva de quadra ">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Data Inicial</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
								</div>
							</div>
							<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Data Final</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
									</div>
								</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="hidden" name="id_quadra_local" value="<?php echo $_SESSION['QUADRA_LOCAL']?>" placeholder="<?php echo $_SESSION['QUADRA_LOCAL']?>"></input>
									<input type="hidden" name="id_quadra" value="<?php echo $_SESSION['QUADRA']?>" placeholder="<?php echo $_SESSION['QUADRA']?>"></input>
									<button type="submit" class="btn btn-success">Confirmar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
      
  
     
      
  
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</body>

</html>