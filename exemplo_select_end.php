 <?php 
  include_once 'includes/connect.php';


$id_quadra = $_GET['quadra'];

$rs = mysqli_query($conn,"SELECT id, nome FROM tb_quadras_locais WHERE id_quadra = '$id_quadra' ");

echo "<label>Quadras Locais: </label><select name='quadralocal'>";
while($reg = mysqli_fetch_object($rs)){
    echo "<option value='$reg->id'>$reg->nome</option>";
}
echo "</select>";

?>