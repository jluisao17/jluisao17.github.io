<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$database = "data";

$conn = new mysqli($servername, $username, $password, $database) or die("problemas con la conexión");

//  definiendo las variables en nada de momento 


$NumeroHabitacion = "";
$Nombre = "";
$FechaInicio = "";
$FechaSalida = "";
$TipoSala = "";
$Personas = "";

// verificar si el metodo con el que se traen las variables es GET
if( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    // en caso de no encontrar el numero de id redireccionar al dashboard
    if ( !isset($_GET['id']) ){
        header("location:  /FinalProyect/Database/dashboard.php");
        exit;
    }
    // en caso de que si encuentre el numero de id guardarlo en una variable 
    $id = $_GET['id'];
    // sacar toda la informacion de la tabla y guardarla en una variable
    $sql = "SELECT * FROM contactos WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // en caso de que no se encuentre nada  dentro de ese numero de id redireccionarlo nuevamente al dashboard
    if( !$row ){
        header("location:  /FinalProyect/Database/dashboard.php");
        exit;
    }
    $mensaje = $row['mensaje'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container my-5">
        <h2>Ver Mensaje</h2>

        <form method = "POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Mensaje: </label>
                <div class="col-sm-6">
                    <textarea style = "height: 200px;" readonly class = "form-control"> <?php echo $mensaje; ?> </textarea>
                </div>
            </div>
            <div class = "row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                </div>
                <div class="col-sm-3 d-grid">
                    <a class = "btn btn-outline-primary" href = "/FinalProyect/Database/dashboard.php" role = "button">Finalizar</a>
                </div>
            </div>
    </div>
</body>
</html>