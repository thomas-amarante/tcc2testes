<?php
	
	
	session_name('sessionuser');
	session_start();
	include('includes/connect.php');

?>

<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
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
        </ul>
      </div>
    </div>
  </nav>
  <body>
	<div>
		 <h4 class="mb-3">Escolha um horário disponível</h4>
			<?php
				
				$data="28/03/2018";
				$dataformat = explode("/",$data);
				$data_bd = $dataformat[2].'-'.$dataformat[1].'-'.$dataformat[0];
				
				$sql3= "SELECT hora FROM tb_agenda WHERE data='$data_bd' AND id_quadra='7'";
				$query3	= mysqli_query($conn, $sql3);
				($dados3 = mysqli_fetch_array($query3))
				
			?>
				<div>
					<div class='row'>
						
				
							<?php
							foreach ( array("9:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00") as $n ) {
								
								if($n == $dados3['hora']){
									
									$n='Horário agendado';									
									
								} ?>
								<div class="col-sm">
									<div class="form-group is-valid">
										<input type="text" class="form-control" placeholder="Success" value="<?php echo $n ?>"> 
									</div>
								</div>
								
								<?php } ?>
						
					</div>			
				</div>	
	</div>
  </body>
      
      
  
  

  
</body>

</html>