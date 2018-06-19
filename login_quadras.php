<?php
	include('/includes/connect.php');
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
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h2 class="text-center"><img src="//placehold.it/130" class="img-circle"><br>
            Login empresarial</h2>
        </div>
        <div class="modal-body row">
          <h6 class="text-center">Preencha todos os campos para prosseguir...</h6>
          <form action="valida_login_empresa.php" method="post" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Login..." name="login_e">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" placeholder="Senha..." name="senha_e">
            </div>
            <div class="form-group">
              <input type="submit" value="login" class="btn btn-info btn-lg btn-block" >
            </div>
          </form>
        </div>
        <div class="modal-footer"> 
         <h6 class="text-center"><a href=""> Não possuo cadastro</a></h6> <!-- desativado -->
        </div>
      </div>
    </div>
</div>
</body>
</html>