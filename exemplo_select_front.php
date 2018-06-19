<?php
       include('includes/connect.php');
?>

<html>
  <head>
    <title>Atualizando combos com jquery</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="js/jquery-1.6.4.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#quadra').change(function(){
            $('#quadralocal').load('exemplo_select_end.php?quadra='+$('#quadra').val());
        });
    });
    </script>
  </head>
  <body>
  <h1>Atualizando combos com jquery</h1>
    
    <select name="quadra" id="quadra">
    <?php 
		$sql = "SELECT id, nome FROM tb_quadras";
		$query = mysqli_query($conn, $sql);
		while($reg = mysqli_fetch_array($query)){ ?>
        <option value="<?php echo $reg['id'] ?>"><?php echo $reg['nome'] ?></option>
    <?php } ?>
    </select>
    <br /><br />
    <div id="quadralocal"></div>
  </body>	
</html>


