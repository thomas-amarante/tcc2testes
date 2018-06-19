<!DOCTYPE HTML>
<?php
header("access-control-allow-origin: https://ws.sandbox.pagseguro.uol.com.br");

$_GET['id_pagseguro'] = ( isset($_GET['id_pagseguro']) ) ? $_GET['id_pagseguro'] : null;

$id_pagseguro = $_GET['id_pagseguro'];
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.min.css">
	<link rel="stylesheet" href="now-ui-kit.css" type="text/css">

	
 <title>PEDIDO FINALIZADO</title>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>﻿
</head>

	<body>
		Compra realizada! O Status da compra é <?php echo $id_pagseguro ?>
	</body>
</html>