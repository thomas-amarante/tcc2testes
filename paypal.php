<?php

if($_GET['tipo']=='paypal'){
	
	$query==array();
	
	$query['cmd'] = '_cart';
	$query['upload'] = '1';
	$query['business'] = 'meu email';
	$query['item_name_1'] = 'reserva de teste';
	$query['amount_1'] = '100.00';
	$query['quantity_1'] = '1';
	$query['notify_url'] = 'url de notificação';
	$query['return'] = 'url de retorno';
	$query['rm'] = '2';
	$query['cbt'] = 'retrno para a loja';
	$query['cancel_return'] = 'url de compra cancelada';
	$query['lc'] = 'BR';
	$query['currency_code'] = 'BRL';
	
	$query_string = http_build_query($query);
	
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr?' .$query_string);
}

?>

<a href="?tipo=paypal">
	<img src="https://1.bp.blogspot.com/-e6f3ZIb8S6k/V0HZu4Sn-iI/AAAAAAAAAXk/lLLVyo-Oo1EpekwOCNUBd-Z1_-97P47bACLcB/s1600/paypal.png" alt="Realizar pagamento" title="Realizar pagamento"/>
</a>