<?php
	/**
	 * Função que mostra mensagem de sucesso, personalizada para este site.
	 * Altere as cores no CSS do site e da função para personalizá-lo.
	 * 
	 * Todos os parâmetros são opcionais, mas terão valores padrão.
	 *
	 * @param Texto de Sucesso $mensagem
	 * @param Link de redirecionamento $url
	 * @param Texto do botão $botao
	 */
	 
	function sucesso($mensagem='Sucesso ao completar a operação',$url='panel.php',$botao='Voltar')
	{
		?>
		<table class="table" style="background-color:#a31312" align="center">
			<tr class="tr" style="background-color:#a31312">
				<td align="center">
					<strong style="color:#FFFFFF" class="title">Sucesso</strong>
				</td>
			</tr>
			<tr class="tr" style="background-color:#D7D7D7">
				<td align="center">
					<br>
					<strong><?php $mensagem ?></strong>
					<br>
					<br>
					<input align="middle" style="background-color:#FFFFFF" type="button" class="botao" value="<?=$botao?>" onclick="document.location.replace('<?php $url ?>')">
				</td>
			</tr>
		</table>
		<?php
	}
	
	/**
	 * Função que mostra mensagem de erro, personalizada para este site.
	 * Altere as cores no CSS do site e da função para personalizá-lo.
	 * 
	 * Todos os parâmetros são opcionais, mas terão valores padrão.
	 *
	 * @param Texto de Erro $mensagem
	 * @param Link de redirecionamento $url
	 * @param TExto do botão $botao
	 */
	function erro($mensagem='Erro ao completar a operação',$url='panel.php',$botao='Voltar')
	{
		?>
		<table class="table" style="background-color:#a31312" align="center">
			<tr class="tr" style="background-color:#a31312">
				<td align="center">
					<strong style="color:#FFFFFF" class="title">Erro</strong>
				</td>
			</tr>
			<tr class="tr" style="background-color:#D7D7D7">
				<td align="center">
					<br>
					<strong><?php $mensagem ?></strong>
					<br>
					<br>
					<input align="middle" style="background-color:#FFFFFF" type="button" class="botao" value="<?=$botao?>" onclick="document.location.replace('<?php $url ?>')">
				</td>
			</tr>
		</table>
		<?
	}
	
	/**
	 * Função que mostra um alerta javascript
	 *
	 * @param string $mensagem
	 */
	function alert($mensagem){
		echo "<script>";
		echo "		alert('$mensagem')";
		echo "</script>";
	}
	
	/**
	 * Função que redireciona para outra página
	 *
	 * @param String $url
	 */
	function redir($url){
		echo "<script>";
		echo "	document.location.replace('$url');";
		echo "</script>";
	}
	
	/**
	 * Converte uma data xx/xx/xxxx para xxxx-xx-xx
	 *
	 * @param String $data
	 * @return String
	 */
	function dateToMysql($data){
		$date = explode('/',$data);
		return $date[2].'-'.$date[1].'-'.$date[0];
	}
	
	function DateMysqlToBr($data){
		$date = explode('-',$data);
		return $date[2].'/'.$date[1].'/'.$date[0];
	}
	
    /**
     * Função que retorna um date formatado para dd/mm/yyyy
     *
     * @param String $date
     * @return String
     */
    function date2portugues($date){
    	$date = explode('-',$date);
    	return $date[2].'/'.$date[1].'/'.$date[0];
    }		
    
    /**
     * Identifica a forma de pagamento utilizada para o pagamento
     *
     * @param string $forma_pg
     */
    function forma_pg($forma_pg){
    	switch ($forma_pg) {
    		case 'DI': echo "Depósito Identificado";
    			break;
    		case 'CC': echo "Cartão de Crédito";
    			break;    			
    		case 'TR': echo "Transferência On-line";
    			break;    			
    		case 'DB': echo "Boleto Bancário";
    			break;    			
    	}
    }
    
    /**
     * Fecha a janela modal
     *
     */
    function close_modal(){
    	echo "<script>";
    	echo "		window.top.hidePopWin()";
    	echo "</script>";
    }
    
    /**
     * Verifia o tamanho da imagem
     *
     * @param file $imagem
     * @param int $width
     * @param int $height
     * @return boolean
     */
    function size_image($imagem,$width,$height){
		$pixels = getimagesize($imagem);
		
		if ($pixels[0]!=$width || $pixels[1]!=$height) {
			return false;
		}else {
			return true;
		}
    }
    
    /**
     * Função que retorna um dateTime formatado para dd/mm/yyyy H:i:s
     *
     * $String unknown_type $dateTime
     * String unknown
     */
    function dateTime2portugues($dateTime){
    	$date = explode('-',$dateTime);
    	$time = explode(' ',$date[2]);
    	if (!@checkdate($date[1],$time[0],$date[0])) {
    		return 'Data inválida';
    	}else {
    		return $time[0].'/'.$date[1].'/'.$date[0].' '.$time[1];    		
    	}
    }  
    

    /**
     * Mostra tantos caracteres, se maior exibe ...
     *
     * @param String $texto
     * @param Int $tamanho
     * @return String
     */
    function truncate_text($texto,$tamanho)  {
    	if (strlen($texto)>$tamanho) {
    		return substr($texto,0,$tamanho).'...';
    	}else {
    		return $texto;
    	}
    }
    
//MOstra uma data longa, no formato Dia XX de xxxxx de xxxx
    function data_longa($data)
    {
    	$data_array=explode ('-',$data);
    	
    	$dia=$data_array[2];
    	$mes=$data_array[1];
    	$ano=$data_array[0];
    	
    	switch ($mes)
    	{
    		case '01':
    			$mes='Janeiro';
    			break;
    			
    		case '02':
    			$mes='Fevereiro';
    			break;
    			
    		case '03':
    			$mes='Março';
    			break;
    			
    		case '04':
    			$mes='Abril';
    			break;
    			
    		case '05':
    			$mes='Maio';
    			break;
    			
    		case '06':
    			$mes='Junho';
    			break;
    			
    		case '07':
    			$mes='Julho';
    			break;
    			
    		case '08':
    			$mes='Agosto';
    			break;
    			
    		case '09':
    			$mes='Setembro';
    			break;
    			
    		case '10':
    			$mes='Outubro';
    			break;
    			
    		case '11':
    			$mes='Novembro';
    			break;
    			
    		case '12':
    			$mes='Dezembro';
    			break;
    	}
    	
    	return "Dia $dia de $mes de $ano";
    }
    
    function data_capa($data)
    {
    	$data_array=explode ('-',$data);
    	
    	$dia=$data_array[2];
    	$mes=$data_array[1];
    	$ano=$data_array[0];
    	
    	return "$dia.$mes.$ano";
    }

	function tres_pontinhos($texto,$tamanho)
	{
		if(strlen($texto)>$tamanho)
		{
			return substr($texto,0,$tamanho).'...';
		}
		else
		{
			return $texto;
		}
	}
	
	//retornar o dia da semana (enviar data no formato mysql)
	function diasemana($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

	switch($diasemana) {
		case"0": $diasemana = "domingo";       break;
		case"1": $diasemana = "segunda-feira"; break;
		case"2": $diasemana = "terça-feira";   break;
		case"3": $diasemana = "quarta-feira";  break;
		case"4": $diasemana = "quinta-feira";  break;
		case"5": $diasemana = "sexta-feira";   break;
		case"6": $diasemana = "sábado";        break;
	}

	return $diasemana;
}
	//enviar data no formato mysql
	function getMes($data){
		$data = explode("-", $data);
		$mes = $data[1];
		
		switch ($mes) {
			case 1: $mes =  "janeiro";   break;
			case 2: $mes =  "fevereiro"; break;
			case 3: $mes =  "março";     break;
			case 4: $mes =  "abril";     break;
			case 5: $mes =  "maio";      break;
			case 6: $mes =  "junho"; 	 break;
			case 7: $mes =  "julho"; 	 break;
			case 8: $mes =  "agosto"; 	 break;
			case 9: $mes =  "setembro";  break;
			case 10: $mes = "outubro";   break;
			case 11: $mes = "novembro";  break;
			case 12: $mes = "dezembro";  break;
		}	
		return $mes;
}
	//ex.: "segunda, 9 de setembro de 2009" - enviar data no formato mysql
	function escreveDataExtenso($data){
					   $aux = explode("-", $data);                     
					   $dia = $aux[2];
					   $ano = $aux[0];
					   echo diasemana($data).", ".$dia." de ".getMes($data)." de ".$ano;
	}
	
//////*  valida imagem [mime-type] *////////
////									////
////  Retorna: 							////
////  false se for validado    			////
////  true se ocorrer algum erro.		////
////									////
////////////////////////////////////////////
function val_img($img_type){
	
	$erro=FALSE;	
	
	//////////////// validação feita pelo mime-type.
	if(!eregi("^image\/(jpg|pjpg|JPG|PJPG|jpeg|pjpeg|JPEG|PJPEG)$",$img_type)){
		$erro=TRUE;
	}
	
	return $erro;
	
}

function verifica_menu($usuario,$tipo,$codigo_menu)
{
	$query = "SELECT *FROM menu_usuarios WHERE cod_user='$usuario' AND $tipo='S' AND cod_menu='$codigo_menu' ";
	$query = mysql_query($query);

	if(mysql_num_rows($query)<1)
	{
		return false;
	}else
	{
		return true;
	}
}

function voltar()
{
		?>
        	<script>
				history.go(-1);
			</script>
        <?php
		
}
?>