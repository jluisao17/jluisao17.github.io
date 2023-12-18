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

$errorMessage = "";
$successMessage = "";
// verificar si el metodo con el que se traen las variables es GET
if( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    // en caso de no encontrar el numero de habitacion redireccionar al dashboard
    if ( !isset($_GET['NumeroHabitacion']) ){
        header("location:  /FinalProyect/Database/dashboard.php");
        exit;
    }
    // en caso de que si encuentre el numero de habitacion guardarlo en una variable 
    $NumeroHabitacion = $_GET['NumeroHabitacion'];
    // sacar toda la informacion de la habitacion y guardarla en una variable
    $sql = "SELECT * FROM reservas WHERE NumeroHabitacion=$NumeroHabitacion";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // en caso de que no se encuentre nada  dentro de ese numero de habitacion redireccionarlo nuevamente al dashboard
    if( !$row ){
        header("location: /FinalProyect/Database/dashboard.php");
        exit;
    }
    
    // en caso de no entrar al if anterior guardar toda la informacion de esa habitacion en variables con su respectivo nombre
$Nombre = $row["Nombre"];
$FechaInicio = $row["FechaInicio"];
$FechaSalida = $row["FechaSalida"];
$TipoSala = $row["TipoSala"];
$Personas = $row["Personas"];
}else{
    // al estar fuera del if y estar dentro del else mandar a llamar a las variables anteriores para guardarlas dentro de otras
    // variables que se puedan usar dentro de este else
    $NumeroHabitacion = $_POST['NumeroHabitacion'];
    $Nombre = $_POST['Nombre'];
    $FechaInicio = $_POST['FechaInicio'];
    $FechaSalida = $_POST['FechaSalida'];
    $TipoSala = $_POST['TipoSala'];
    $Personas = $_POST['Personas'];

    do{
        // En caso de que alguno de los campos estan vacios mandar un mensaje de error diciendo que todos los campos son requeridos

        if( empty($Nombre) || empty($FechaInicio) || empty($FechaSalida) || empty($TipoSala) || empty($Personas)) {
            $errorMessage = "Todos los campos son requeridos";
            break;
        }
        // actualizar la información a la base de datos 
        $sql = "UPDATE reservas SET Nombre = '$Nombre', FechaInicio = '$FechaInicio', FechaSalida = '$FechaSalida',
        TipoSala = '$TipoSala', Personas = '$Personas' WHERE NumeroHabitacion = '$NumeroHabitacion'";
        // ejecutar el sel anterior
        $result = $conn->query($sql);
        // en caso de algun error en el sql anterior mandar un mensaje diciendo query invalida junto al motivo del error
        if( !$result ){
            $errorMessage = "Query Invalida: " . $conn->error;
            break;
        }
        // en caso de que todo lo anterior sea correcto mandar mensaje de que el usuario con el numero de habitacion dado a sido
        // actualizado correctamente
        $successMessage = "Reserva editada correctamente";
    }while(false);
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
        <h2>Editar Reserva</h2>

        <?php 
        if( !empty($errorMessage) ) {
            echo "<div class = 'alert alert-warning alert-dismissible fade show' role = 'alert'>
            <strong>$errorMessage</strong>
            <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label='Close'></button>
            </div>";
        }
        
        
        ?>

        <form method = "POST">
        <input type="hidden" name="NumeroHabitacion" value="<?php echo $NumeroHabitacion; ?>">
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class = "form-control" name = "Nombre" value = "<?php echo $Nombre; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Fecha de Inicio</label>
                <div class="col-sm-6">
                    <input type="text" class = "form-control" name = "FechaInicio" value = "<?php echo $FechaInicio; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Fecha de Salida</label>
                <div class="col-sm-6">
                    <input type="text" class = "form-control" name = "FechaSalida" value = "<?php echo $FechaSalida; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Tipo de Sala</label>
                <div class="col-sm-6">
                    <input type="text" class = "form-control" name = "TipoSala" value = "<?php echo $TipoSala; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Numero de personas</label>
                <div class="col-sm-6">
                    <input type="text" class = "form-control" name = "Personas" value = "<?php echo $Personas; ?>">
                </div>
            </div>

            <?php 
            if( !empty($successMessage) ) {
                echo "<div class = 'row mb-3'>
                    <div class = 'offset-sm-3 col-sm-6'>
                        <div class = 'alert alert-success alert-dismissible fade show' role = 'alert'>
                            <strong>$successMessage</strong>
                            <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>";
            }
            ?>

            <div class = "row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type = "submit" class = "btn btn-primary"> Finalizar </button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class = "btn btn-outline-primary" href = "/FinalProyect/Database/dashboard.php?data=" role = "button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>