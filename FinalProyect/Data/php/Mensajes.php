<?php
// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'data';

$conn = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT id FROM habitaciones WHERE espacio = 0 LIMIT 1");

if ($row = mysqli_fetch_assoc($query)) {
    $id = $row['id'];

    mysqli_query($conn, "UPDATE habitaciones SET espacio = 1 WHERE id = $id");
// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

// Insertar datos en la tabla
$sql = "INSERT INTO contactos (id, nombre, apellidos, email, mensaje) VALUES ('$id', '$nombre', '$apellidos', '$email', '$mensaje')";

if ($conn->query($sql) === TRUE) {
    echo "Datos insertados con éxito.";
} else {
    echo "Error al insertar datos: " . $conn->error;
}
}
// Cerrar la conexión a la base de datos
$conn->close();
?>