<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "data";
// en esto no tengo nada que explicar ya que todo es muy obvio 
$conn = new mysqli($servername, $username, $password, $database) or die("problemas con la conexión");

    $sqlDeleteReservas = "DELETE FROM data . reservas";
    $conn->query($sqlDeleteReservas);

    $sqlUpdateHabitaciones = "UPDATE Habitaciones SET ocupada = '0'";
    $conn->query($sqlUpdateHabitaciones);

header("location:  /FinalProyect/Database/dashboard.php");
exit;
?>