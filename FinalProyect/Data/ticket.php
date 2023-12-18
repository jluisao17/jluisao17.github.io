<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel = "stylesheet" href = "styles/ticket.css">
    </head>
    <body>
        <script src="" async defer></script>
    </body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "data";

$conn = mysqli_connect($servername, $username, $password, $database) or die("Problemas con la conexión");

// Consultar el número de habitación disponible
$query = mysqli_query($conn, "SELECT id FROM habitaciones WHERE ocupada = 0 LIMIT 1");

if ($row = mysqli_fetch_assoc($query)) {
    $habitacion = $row['id'];

    mysqli_query($conn, "UPDATE habitaciones SET ocupada = 1 WHERE id = $habitacion");

    // Calcular el total según el tipo de sala, el número de personas y la duración de la estancia
    $tipoSala = $_POST['TipoSala'];
    $precioPorPersona = 0;

    switch ($tipoSala) {
        case 'Casual':
            $precioPorPersona = 49;
            break;
        case 'Comfort':
            $precioPorPersona = 249;
            break;
        case 'Lujo':
            $precioPorPersona = 499;
            break;
        // Puedes agregar más casos según sea necesario
    }

    // Calcular la duración de la estancia en días
    $fechaInicio = new DateTime($_POST['FechaInicio']);
    $fechaSalida = new DateTime($_POST['FechaSalida']);
    $duracionEstancia = $fechaInicio->diff($fechaSalida)->days;

    $total = $precioPorPersona * $_POST['Personas'] * $duracionEstancia;

    // Resto del código para mostrar el "Ticket de Compra"
    echo "
    <center>
    <div class='ticket'>
        <div class = 'card'>
            <div class = 'card-header'>
                Revision de Compra
            </div>
                <div class = 'card-body'>
                    <h5 class = 'card-title'>¡Gracias por su preferencia!</h5>
                    <p class = 'card-text'> <strong>Nombre:</strong> &nbsp;&nbsp;&nbsp;   " . $_POST['Nombre'] . " </p>
                    <p class = 'card-text'><strong>Fecha de llegada:</strong> &nbsp;&nbsp;&nbsp;  " . $_POST['FechaInicio'] . " </p>
                    <p class = 'card-text'><strong>Fecha de salida:</strong> &nbsp;&nbsp;&nbsp;  " . $_POST['FechaSalida'] . "</p>
                    <p class = 'card-text'><strong>Tipo de sala:</strong> &nbsp;&nbsp;&nbsp;  " . $_POST['TipoSala'] . " </p>
                    <p class = 'card-text'><strong>Numero de personas:</strong> &nbsp;&nbsp;&nbsp;  " . $_POST['Personas'] . "</p>
                    <p class = 'card-text'><strong>Numero de habitacion:</strong> &nbsp;&nbsp;&nbsp;  " . $habitacion . "</p>
                    <p class = 'card-text'><strong>Duración de la estancia:</strong> &nbsp;&nbsp;&nbsp;  " . number_format($duracionEstancia) . " días</p>
                    <p class = 'card-text'><strong>Total a Pagar:</strong> &nbsp;&nbsp;&nbsp;  $" . number_format($total) . " USD</p>
                    <a href = 'pago.php'><button class = 'btn btn-primary'> Pagar </button></a>
                </div>
        </div>
    </div>
    </center>";

    // Insertar la reserva en la tabla reservas
    mysqli_query($conn, "INSERT INTO reservas(Nombre, FechaInicio, FechaSalida, TipoSala, Personas, NumeroHabitacion)
    VALUES('$_POST[Nombre]', '$_POST[FechaInicio]', '$_POST[FechaSalida]', '$_POST[TipoSala]', '$_POST[Personas]', 
    '$habitacion')") or die("Problemas al reservar");

    $obtener = "SELECT * FROM tb_data";
    $result = $conn->query($obtener);
    $row = $result->fetch_assoc();
    $p = $row['Ingresos'];
    $row['Ingresos'] = $row['Ingresos'] + $total;
    $percent = (($row['Ingresos'] - $p) / $p) * 100;
    mysqli_query($conn, "UPDATE tb_data SET Percent = $percent");
    mysqli_query($conn, "UPDATE tb_data SET Ingresos=$row[Ingresos]") or die("Problemas");
    mysqli_query($conn, "UPDATE tb_data SET Current = $total");
} else {
    echo "<center><h1 class = 'error'>Error 503</h1>
    <h2 class = 'full'>¡Oops! Parece que todas las habitaciones están ocupadas,<br> lamentamos los inconvenientes</h2> <a href='/FinalProyect/index.html'><button class='btn'>Regresar</button></a></center>";
}

$conn->close();
?>