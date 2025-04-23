<?php
if (!isset($_SESSION['doc'])){
unset($_SESSION['id_rol']);
$_SESSION = array();
session_destroy();
session_write_close();
echo "<script> alert ('Ingrese Credenciales de login') </script>";
echo "<script> window.location = '../login.php' </script>";
}
?>
