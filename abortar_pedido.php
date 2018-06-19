<?php 
session_start();

unset($_SESSION['QUADRA_LOCAL'], $_SESSION['QUADRA'], $_SESSION['ID_DIA'], $_SESSION['VALOR'], $_SESSION['DATA_INICIO'], $_SESSION['DATA_FIM']);

header("Location: user.php");
?>