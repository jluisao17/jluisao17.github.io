<?php
//en caso de que este el numero de habitacion ejecutar dentro de lo que esta en el if
if(isset($_GET['NumeroHabitacion']) ) {
    $NumeroHabitacion = $_GET['NumeroHabitacion'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "data";

$conn = new mysqli($servername, $username, $password, $database) or die("problemas con la conexión");

    $sqlDeleteReservas = "DELETE FROM reservas WHERE NumeroHabitacion=$NumeroHabitacion";
    $conn->query($sqlDeleteReservas);

    $sqlUpdateHabitaciones = "UPDATE Habitaciones SET ocupada = '0' WHERE id=$NumeroHabitacion";
    $conn->query($sqlUpdateHabitaciones);
}
// en caso de que no se ejecute dentro de lo del if redireccionar al dashboard nuevamente,
// aplica lo mismo en caso de que el if se aplique 
header("location:  /FinalProyect/Database/dashboard.php");
exit;
?>