<?php
	
	//session_name('sessionuser');
	session_start();
	unset($_SESSION['QUADRA_LOCAL'], $_SESSION['QUADRA'], $_SESSION['VALOR']);
	include('includes/connect.php');
	
	$user = $_SESSION['COD'];
?>

<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.min.css">
  <link rel="stylesheet" href="now-ui-kit.css" type="text/css">
  <link rel="stylesheet" href="assets/css/nucleo-icons.css" type="text/css">
  <script src="assets/js/navbar-ontop.js"></script>
  
  
  
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
  <div class="py-5 bg-primary">
  </div>
	<div class="py-5 bg-primary">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h5 class="">
						<b>Seja bem-vindo, <?=$_SESSION['NOME'] ?> </b>
					</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="py-5 bg-white">
		<div class="container">
	
		<div class="py-5 bg-white" id="mapa">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<h2 class="mb-4">Localize as quadras mais próximas de você!</h2>
					</div>
				</div>
				<div class="row my-5">
					<div class="col-md-12 text-center"> 					
							<button class="btn btn-primary text-center" onClick=window.location="gps.html";>Sim, abrir um mapa! </button>			
					</div>
					
				</div>
			</div>
		</div>
		
		
		<div class="row" id="proxjogos">
			<div class="col-md-12">
				<h3 class="">
					<b>Seus próximos jogos:
				</h3>
			</div>
		</div>
		<?php
			$nenhum_jogo = "Você não possui jogos agendados";
			
			$sql = "SELECT a.id as id, a.valor as valor, a.data_inicio as data_inicio, b.nome as nome, c.nome_quadra_local as nome_quadra_local FROM tb_agenda a INNER JOIN tb_quadras b ON a.id_quadra = b.id INNER JOIN tb_quadras_locais c ON a.id_quadra_local = c.id WHERE `data_inicio` > NOW() AND id_user = '$user' ORDER BY `a`.`data_inicio` DESC";			
			$query = mysqli_query($conn,$sql);
							
			?>
				<div class="table-responsive text-center">
				<table class="table table-striped">
				  <thead>
					<tr>					  
					  <th scope="col">Data</th>
					  <th scope="col">Hora</th>
					  <th scope="col">Local</th>
					  <th scope="col">Quadra</th>
					  <th scope="col">Valor</th>						  
					  <th scope="col">Ações</th>					  
					</tr>
				  </thead>
					<?php if(mysqli_num_rows($query)<1){ 
						?>						
							<tbody>	
								<tr>
									<th scope="col"> <b> <?php echo $nenhum_jogo ?></th>
								</tr>
							</tbody>						
						<?php } else {
									while($dados = mysqli_fetch_array($query)){
						?>
				  <tbody>
					<tr>
						
					 <?php 	$formatar_data_e_hora = $dados['data_inicio'];
							$dataformat = explode(" ",$formatar_data_e_hora);
							$formatar_data = $dataformat[0];
							$var_aux_formatar = $formatar_data;
							$dataformat = explode("-",$var_aux_formatar);
							$var_aux_formatar = $dataformat[2]."/".$dataformat[1]."/".$dataformat[0];

							?>
					  <td><?php echo $var_aux_formatar; ?></td>
					  <?php $formatar_hora = $dados['data_inicio'];
							$dataformat = explode(" ",$formatar_hora);
							$formatar_hora = $dataformat[1]; ?>					  
					  <td><?php echo $formatar_hora ?></td>
					  <td><?php echo $dados['nome'] ?></td>
					  <td><?php echo $dados['nome_quadra_local'] ?></td>
					  <td><?php echo 'R$'.$dados['valor'].',00' ?></td>  	  					  
					  <td> <button class="btn btn-danger" href="excluir_agendamento.php?key=<?=$dados['id']?>" onClick="if(confirm('Deseja mesmo cancelar?')){document.location.href='excluir_agendamento.php?key=<?=$dados['id']?>'}">Cancelar </button></td>
					</tr>    
				  </tbody>
				  <?php } }?>
				</table> 
				</div>
			 
			
		
		
	  
      <div class="row my-4" id="agendamento">
	  <div class="col">
		<form action="horarios.php" method="post">			
			<div class="col">				
				<h4 class="mb-3">Local do agendamento</h4>
				
				<select id="quadra_local" name="quadra_local" class="form-control">
					<?php 
						$sql = "SELECT a.id as id1, nome, nome_quadra_local FROM tb_quadras_locais a INNER JOIN tb_quadras b ON a.id_quadra = b.id";
														
						$query = mysqli_query($conn, $sql);
						
						
								while($dados = mysqli_fetch_array($query)) {                               
									?>  
									<option value="<?php echo $dados['id1'] ?>" ><?php echo $dados['nome']?> - <?php echo $dados['nome_quadra_local']?>	</option>     
						  
							<?php } ?>                       
				</select>
							 
				 </br>
				 <div class="text-center">				
					<button type="submit" value="pesquisar" class="btn btn-primary text-center">
					  Veja os horários disponíveis para essa data
					</button>
				</div>
			</div>
		 </form>
		</div>
	  </div>
	<div class="row" id="ultimosjogos">
		<div class="col-md-12">          
            <h4 class="mb-2">Ultimos agendamentos</h4>				
		</div>
	</div>
		<?php
			$sql = "SELECT * FROM tb_agenda a INNER JOIN tb_quadras b ON a.id_quadra = b.id INNER JOIN tb_quadras_locais c ON a.id_quadra_local = c.id WHERE `data_inicio` < now() AND id_user ='$user' ORDER by a.`data_inicio` DESC";			

			$query = mysqli_query($conn,$sql);
						
			 ?>
				<table class="table table-striped text-center">
				  <thead>
					<tr>					 
					  <th scope="col">Data</th>
					  <th scope="col">Hora</th>
					  <th scope="col">Local</th>					  
					  <th scope="col">Quadra</th>
					  <th scope="col">Valor</th>
					</tr>
				  </thead>
				  <?php if(mysqli_num_rows($query)<1){ ?>
				  <tbody>
						<tr>
							<th> <b> <?php echo $nenhum_jogo ?></th>
						</tr>
					</tbody>	
			<?php } else {
							
						while($dados = mysqli_fetch_array($query)){
								
			?>				
				  <tbody>
					<tr>
						
					 
					 <?php 	$formatar_data1 = $dados['data_inicio'];
							$dataformat = explode(" ",$formatar_data1);
							$formatar_data1 = $dataformat[0];
							$var_aux_formatar = $formatar_data1;
							$dataformat = explode("-",$var_aux_formatar);
							$var_aux_formatar = $dataformat[2]."/".$dataformat[1]."/".$dataformat[0];
							?>  
					  <td><?php echo $var_aux_formatar ?></td>
					   <?php $formatar_hora1 = $dados['data_inicio'];
							$dataformat = explode(" ",$formatar_hora1);
							$formatar_hora1 = $dataformat[1]; ?>	
					  <td><?php echo $formatar_hora1 ?></td>
					  <td><?php echo $dados['nome'] ?></td>
					  <td><?php echo $dados['nome_quadra_local'] ?></td>
					  <td><?php echo 'R$'.$dados['valor'].',00' ?></td>
					</tr>    
				  </tbody>
				  <?php } }?>
				</table> 
	
		</div>
	</div>
  
	   
      
  <script src="includes/datepicker-pt-BR.js"></script>
  <script src="js/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="assets/js/parallax.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
  
  <script>
    
	var date = new Date();
	date.setDate(date.getDate());
	
	$(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
            $('[data-toggle="tooltip"]').tooltip();
            $('#datepicker').datepicker({
				
				calendarWeeks: true,
                autoclose: true,
                todayHighlight: true,
				startDate: date,
				format: "dd/mm/yyyy",				
					
				            });
          });
  </script>
  
</body>

</html>