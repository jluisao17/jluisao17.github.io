<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "data";
// en esto no tengo nada que explicar ya que todo es muy obvio 
$conn = new mysqli($servername, $username, $password, $database) or die("problemas con la conexión");

    $sqlDeleteContactos = "DELETE FROM data . contactos";
    $conn->query($sqlDeleteContactos);

    $sqlUpdateEspacio = "UPDATE Habitaciones SET espacio = '0'";
    $conn->query($sqlUpdateEspacio);

header("location:  /FinalProyect/Database/dashboard.php");
exit;
?>