
<?php
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

$notificationCode = preg_replace('/[^[:alnum:]-]/','',$_POST["notificationCode"]); // recebe por xml a variável notificationCode e trata para evitar outros caracteres 

$data['token'] = '8FDC81B6A9544EAB99B706D2411CE2E4'; // token teste sandbox.pagseguro
$data['email'] = 'thomasferreiraa@gmail.com'; // email para ambiente de teste ou de homologação

$data = http_build_query($data); // recebe o array da variável $data e separa

$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?'.$data; // url de testes concatenando com as variáveis $notificationCode, $email e $token
//$url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications'.$notificationCode.'?'.$data; // url de produção concatenando com as variáveis $notificationCode, $email e $token

//inicio do uso da biblioteca CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $url);
$xml = curl_exec($curl);
curl_close($curl);

// recebendo informações do xml do pagseguro
$xml = simplexml_load_string($xml);

$reference = $xml->reference;
$status = $xml->status;

// caso retorne uma referência e um status do pagseguro
if($reference && $status){
 include_once 'conecta.php';
 $conn = new conecta();

 $rs_pedido = $conn->consultarPedido($reference); // função para consultar o pedido no bando de dados do sistema

 if($rs_pedido){ // se encontrar uma referência igual a passada pelo pagseguro, executa a atualização do status que também é passada pelo pagseguro
 $conn->atualizaPedido($reference,$status);
 }
}

?>