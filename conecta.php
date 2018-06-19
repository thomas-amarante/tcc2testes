<?php


include_once 'config.php';
//session_name('sessionuser');
session_start();
	
				
// funções prontas para consulta no banco de dados
class conecta extends config{
 var $pdo;

 
 function __construct(){
 $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->usuario, $this->senha); 
 }
 
 function salvarPedido(){
	 
 $nome_cliente = $_SESSION['NOME'];
 $id_quadra= $_SESSION['QUADRA'];
 $id_quadra_local = $_SESSION['QUADRA_LOCAL'];
 $id_user = $_SESSION['COD']; 
 $data_inicio = $_SESSION['DATA_INICIO']; 
 $data_fim = $_SESSION['DATA_FIM'];
 $valor= $_SESSION['VALOR'];
 
 	
					
 $stmt = $this->pdo->prepare("INSERT INTO tb_agenda (nome_cliente, id_quadra, id_quadra_local, id_user, data_inicio, data_fim, valor, status, descricao) VALUES ('$nome_cliente', '$id_quadra', '$id_quadra_local', '$id_user', '$data_inicio','$data_fim', '$valor', '1', 'via pag seg')");
//$stmt->bindValue(":codigo",$codigo); 
 $run = $stmt->execute();
 
 }
 
 function consultarPedido($reference){
 $stmt = $this->pdo->prepare("SELECT * FROM tb_agenda where id = :reference");
 $stmt->bindValue(":reference",$reference);
 $run = $stmt->execute();
 $rs = $stmt->fetch(PDO::FETCH_ASSOC);
 return $rs; 
 
 }

 function atualizaPedido($reference, $status){
 $stmt = $this->pdo->prepare("UPDATE tb_agenda SET status = :status where id = :reference");
 $stmt->bindValue(":reference",$reference);
 $stmt->bindValue(":status",$status);
 $run = $stmt->execute();
 
 }
 
function listarPedidos(){
 $stmt = $this->pdo->prepare("SELECT p.descricao, p.id, s.status FROM tb_agenda as p INNER JOIN tb_status_pedido as s on p.status = s.id order by p.id");
 $run = $stmt->execute();
 $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $rs; 
 
 }
 
 function consultarUltimoPedido(){
 $stmt = $this->pdo->prepare("SELECT * FROM tb_agenda order by id DESC");
 $run = $stmt->execute();
 $rs = $stmt->fetch(PDO::FETCH_ASSOC);
 return $rs; 
 
 }

}

?>