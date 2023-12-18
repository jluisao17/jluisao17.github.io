<?php
// Conectar a la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'data';

$conn = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del form
$usuario = $_POST['usuario'];
$contra = $_POST['contra'];

//Seleccionar los datos de la base evitando inyecciones SQL
$sql = "SELECT * FROM administradores WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();

// Verificar si hay resultados
if ($stmt->num_rows > 0) {
    // Buscar resultados
    $stmt->bind_result($db_usuario, $db_contra);
    $stmt->fetch();

    // Verificar contraseña usando Password_Verify
    if (password_verify($contra, $db_contra)) {
        // Usuario verificado
        header("location: /FinalProyect/Database/dashboard.php");
        exit;
    } else {
        // Contraseña incorrecta
        echo "Credenciales incorrectas. Vuelve a intentarlo.";
    }
} else {
    // Usuario no encontrado
    echo "Usuario no encontrado. Vuelve a intentarlo.";
}

// Close the connection
$stmt->close();
$conn->close();
?>