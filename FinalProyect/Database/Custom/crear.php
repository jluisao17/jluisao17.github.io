<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "data";

$conn = new mysqli($servername, $username, $password, $database) or die("problemas con la conexión");

// definir todas las variables en 0

$Nombre = "";
$FechaInicio = "";
$FechaSalida = "";
$TipoSala = "";
$Personas = "";
$errorMessage = "";
$successMessage = "";


// selecionar una habitacion la cual no este ocupada con un maximo de solo guardar 1

$query = mysqli_query($conn, "SELECT id FROM habitaciones WHERE ocupada = 0 LIMIT 1");
if ($row = mysqli_fetch_assoc($query)) {
    // guardar la habitacion desocupada en una variable
    $habitacion = $row['id'];
    //actualizar la base de datos donde la habitacion seleccionada cambie a que ya este ocupada
    mysqli_query($conn, "UPDATE habitaciones SET ocupada = 1 WHERE id = $habitacion");


    // ver que el metodo de request sea POST
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        //guardar los datos introducidos del html que esta más abajo en variables para despues subirlos a la base de datos
        $Nombre = $_POST['Nombre'];
        $FechaInicio = $_POST['FechaInicio'];
        $FechaSalida = $_POST['FechaSalida'];
        $TipoSala = $_POST['TipoSala'];
        $Personas = $_POST['Personas'];


        do{
            // en caso de que los inputs del html esten vacios mandar mensaje diciendo que todos los campos son requeridos
            if( empty($Nombre) || empty($FechaInicio) || empty($FechaSalida) || empty($TipoSala) || empty($Personas)) {
                $errorMessage = "Todos los campos son requeridos";
                break;
            }

            //insertar nueva reserva a la base de datos

            $sql = "INSERT INTO reservas(Nombre, FechaInicio, FechaSalida, TipoSala, Personas, NumeroHabitacion)
            VALUES ('$Nombre', '$FechaInicio', '$FechaSalida', '$TipoSala', '$Personas', '$habitacion')";
            $result = $conn->query($sql);

            // en caso de que haya algun error en el query mandar mensaje de query invalido y el motivo del error
            if( !$result ) {
                $errorMessage = "Query Invalida: " . $conn->error;
                break;
            }

            // volver a inicializar las variables en 0 por si quiere volver a meter alguna otra reserva
            $Nombre = "";
            $FechaInicio = "";
            $FechaSalida = "";
            $TipoSala = "";
            $Personas = "";

            // en caso de que todo lo anterior haya salido correctamente mandar mensaje de que la reserva se a subido a la base de datos 
            // correctamente
            $successMessage = "Reserva añadida correctamente";
        }while(false);
    }
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
        <h2>Nueva Reserva</h2>



        <?php 
        if( !empty($errorMessage) ) {
            echo "<div class = 'alert alert-warning alert-dismissible fade show' role = 'alert'>
            <strong>$errorMessage</strong>
            <button type = 'button' class = 'btn-close' data-bs-dismiss = 'alert' aria-label='Close'></button>
            </div>";
        }
        
        
        ?>





        <form method = "POST">
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
                    <a class = "btn btn-outline-primary" href = "/FinalProyect/Database/dashboard.php" role = "button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>