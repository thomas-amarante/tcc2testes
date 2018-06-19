<?php
	//session_name('sessionuser');
	session_start();
	include_once 'includes/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Marque seu jogo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.js" type="text/javascript"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
<div class="container">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
          <h2 class="text-center"><br>
            Cadastro de novo local</h2>
        </div>
        <div class="modal-body row">
          <h6 class="text-center">Preencha todos os campos para prosseguir...</h6>
		  
          <form action="gravar_user_bd.php" method="post" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Nome do local" name="nome_f">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Email"  name="email_f">
            </div>
			<div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="CEP" name="cep">
            </div>
			<div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Fone celular (DDD+seu número)" name="cel">
            </div>
			<div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Endereço" name="end">
            </div>
					
			<div class="form-group">
              <input type="submit" value="Cadastrar usuário" class="btn btn-info btn-lg btn-block" >
            </div>
          </form>
        </div>
        <div class="modal-footer"> 
			<div class="form-group">
				<a href='index.html'>
              <input type="button" value="Cancelar" class="btn btn-danger btn-lg btn-block" >
				</a>
            </div>
        </div>
      </div>
    </div>
</div>
</body>
</html>