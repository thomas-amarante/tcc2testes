<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Pedido de teste</title>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>﻿
</head>

<body>
 
 <div>
 <h1>Produto de Teste</h1>
 <p>Valor: 299,00</p>
 <button onclick="enviaPagseguro();">Comprar</button><br />  <!-- botão com função ao clicar: executar a função enviaPagseguro -->
 <img src="loading.gif" id="loading" style="visibility: hidden">
 </div>


 <form id="comprar" action="https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
 <input type="hidden" name="code" id="code" value="" /> 
 </form>

 <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script> <!-- js necessário para execução da lightbox -->

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
 
</body>
</html>	