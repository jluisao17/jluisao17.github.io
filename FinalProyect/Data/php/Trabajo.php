<?php
// Conectar a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'data';

$conn = new mysqli($host, $username, $password, $database);

// Chquear la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT id FROM habitaciones WHERE trabajo = 0 LIMIT 1");

if ($row = mysqli_fetch_assoc($query)) {
    $id = $row['id'];

    mysqli_query($conn, "UPDATE habitaciones SET trabajo = 1 WHERE id = $id");
// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$apellido1 = $_POST['apellido_paterno'];
$apellido2 = $_POST['apellido_materno'];
$position = $_POST['position'];
$motivo = $_POST['motivo'];

// Insertar los datos a la base de datos
$sql = "INSERT INTO trab_solicitud (id, nombre, email, apellido1, apellido2, position, motivo) VALUES ('$id', '$nombre', '$email', '$apellido1', '$apellido2', '$position', '$motivo')";

if ($conn->query($sql) === TRUE) {
    echo "Formulario enviado con éxito.";
} else {
    echo "Error al enviar el formulario: " . $conn->error;
}
}

// Cerrar la conexión de la base de datos
$conn->close();
?>