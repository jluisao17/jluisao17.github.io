<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "data";

$conn = new mysqli($servername, $username, $password, $database) or die ("Problemas con la conexión");


if(isset($_GET['data'])) {
  $nombre = urldecode($_GET['data']);
}
$sql = "SELECT * FROM tb_data";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$ingresos = $row['Ingresos'];
$percent = $row['Percent'];

$pago = $ingresos * 0.30;

$iva = $ingresos * 0.16;

$ganancia = $ingresos - ($pago + $iva);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src = "/FinalProyect/components/tailwind.config.js"></script>
    <link rel="stylesheet" href="/FinalProyect/components/css/odometer.min.css">
    <script src="/FinalProyect/js/odometer.js"></script>
    <title>Panel de Administración | Azure Paradise</title>
</head>
<body>
<div class="bg-blue-200 p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Bienvenido de nuevo, <?php echo $nombre;?>.</h1>
        <a class = "bg-blue-500 text-white rounded p-2" href = "/FinalProyect/index.html"> Volver a la Pagina Principal</a>
  </div>
  <div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Ingresos Totales</h2>
      <p class="text-3xl font-bold num " data-val = "<?php echo $ingresos; ?>">0</p>
      <p class="text-sm text-green-500"><?php if($percent > 0) { echo " +" .  number_format($percent, 2, '.', ','); }
      else{ echo " -" . number_format($percent, 2, '.', ','); } ?>% desde la última reserva</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Impuestos 16%</h2>
      <p class="text-3xl font-bold num" data-val = "<?php echo $iva; ?>">0</p>
      <p class="text-sm text-red-500">-16% de los impuestos</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Siguiente Pago</h2>
      <p class="text-3xl font-bold num" data-val = "<?php echo $pago; ?>">0</p>
      <p class="text-sm text-green-500">30% del ingreso total</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Ganancias</h2>
      <p class="text-3xl font-bold num" data-val = "<?php echo $ganancia; ?>">0</p>
      <p class="text-sm text-green-500">54% del ingreso total</p>

    </div>
  </div>
  <div class="bg-white p-4 rounded-lg shadow mb-6">
    <h2 class="text-lg font-semibold mb-4">Eventos próximos</h2>
    <div class="grid grid-cols-3 gap-4">
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full" data-v0-t="card">
        <div class="p-6">
          <div class="flex items-center space-x-4">
            <img
              src="/tiquin/images/nochebuena.jpeg"
              alt="Event"
              class="h-16 w-16 rounded-lg"
              width="64"
              height="64"
              style="aspect-ratio: 64 / 64; object-fit: cover;"
            />
            <div>
              <h3 class="font-semibold">Noche Buena</h3>
              <p class="text-sm">Domingo, Diciembre 24, 2023</p>
              <p class="text-sm">104 / 150 tickets vendidos</p>
            </div>
          </div>
        </div>
      </div>
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full" data-v0-t="card">
        <div class="p-6">
          <div class="flex items-center space-x-4">
            <img
              src="/tiquin/images/gourmet.jpeg"
              alt="Event"
              class="h-16 w-16 rounded-lg"
              width="64"
              height="64"
              style="aspect-ratio: 64 / 64; object-fit: cover;"
            />
            <div>
              <h3 class="font-semibold">Karely Ruiz</h3>
              <p class="text-sm">Lunes, Diciembre 25, 2023</p>
              <p class="text-sm">150 / 150 tickets vendidos</p>
            </div>
          </div>
        </div>
      </div>
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full" data-v0-t="card">
        <div class="p-6">
          <div class="flex items-center space-x-4">
            <img
              src="/tiquin/images/marshmello.webp"
              alt="Event"
              class="h-16 w-16 rounded-lg"
              width="64"
              height="64"
              style="aspect-ratio: 64 / 64; object-fit: cover;"
            />
            <div>
              <h3 class="font-semibold">Marshmello — DJ Set</h3>
              <p class="text-sm">Jueves, Diciembre 28, 2023</p>
              <p class="text-sm">72 / 150 tickets vendidos</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-white p-4 rounded-lg shadow overflow-y-auto max-h-96">
    <h2 class="text-lg font-semibold mb-4">Reservas Recientes</h2>
    <a class="bg-blue-500 p-2 rounded text-white" href="Custom/crear.php" role="button">Agregar Reserva</a>
    <a class="bg-red-500 text-white rounded p-2" href="#" onclick="confirmVaciar('/FinalProyect/Database/Custom/vaciar.php')"> Vaciar Todo </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" class="border border-color-gray-200 relative px-5" id="searchInput" oninput="searchReservations()" placeholder="Buscar Nombre o Fecha">
    <div id="errorMensaje"></div>
    <div class="w-full divide-y  divide-gray-200">
        <div class="w-full flex justify-between items-center py-2">
            <div class="w-full flex items-center space-x-4">
            <table class="w-full bg-white border  border-gray-300" id = "reservationsTable">
            <thead>
                <tr>
                    <th class = "border-b p-2">Nombre</th>
                    <th class = "border-b p-2">Fecha de Inicio</th>
                    <th class = "border-b p-2">Fecha de salida</th>
                    <th class = "border-b p-2">TipoSala</th>
                    <th class = "border-b p-2">Personas</th>
                    <th class = "border-b p-2">Numero de Habitacion</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "data";

                $conn = new mysqli($servername, $username, $password, $database) or die ("Problemas con la conexión");
                $sql = "SELECT * FROM reservas";
                $result = $conn->query($sql);

                if(!$result) {
                    die("Sesion invalida" . $conn->error);
                }

                while($row = $result->fetch_assoc()){
                    echo "
                    <tr>
                        <td class = 'border-b p-2 text-center'>$row[Nombre]</td>
                        <td class = 'border-b p-2 text-center'>$row[FechaInicio]</td>
                        <td class = 'border-b p-2 text-center'>$row[FechaSalida]</td>
                        <td class = 'border-b p-2 text-center'>$row[TipoSala]</td>
                        <td class = 'border-b p-2 text-center'>$row[Personas]</td>
                        <td class = 'border-b p-2 text-center' text-center>$row[NumeroHabitacion]</td>
                    <td>
                        <a class='bg-blue-500 rounded text-white p-2' href='Custom/editar.php?NumeroHabitacion=$row[NumeroHabitacion]'>Editar</a>
                        <a class='bg-red-500 rounded text-white p-2 '  href='Custom/borrar.php?NumeroHabitacion=$row[NumeroHabitacion]'>Borrar</a>
                    </td>
                </tr>";
                }
                ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="bg-blue-200 p-8">
  <div class="bg-white p-4 rounded-lg shadow flex">
    <!-- Sección de Mensajes -->
    <div class="w-1/2 mr-4">
      <h2 class="text-lg font-semibold mb-4">Mensajes Recibidos</h2>
      <a class="bg-red-500 text-white rounded p-2" href="#" onclick="confirmVaciar('/FinalProyect/Database/Messages/vaciar.php')"> Vaciar Todo </a>
      <table class="w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="border-b p-2">Nombre:</th>
            <th class="border-b p-2">Apellidos:</th>
            <th class="border-b p-2">Email:</th>
            <th class="border-b p-2">Opciones:</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "data";

            $conn = new mysqli($servername, $username, $password, $database) or die("Problemas con la conexión");
            $sql = "SELECT * FROM contactos";
            $result = $conn->query($sql);

            if (!$result) {
              die("Sesion invalida" . $conn->error);
            }
            while ($row = $result->fetch_assoc()) {
              echo "
                <tr>
                  <td class='border-b p-2 text-center'>$row[nombre]</td>
                  <td class='border-b p-2 text-center'>$row[apellidos]</td>
                  <td class='border-b p-2 text-center'>$row[email]</td>
                  <td class='text-center'>
                    <a class='bg-blue-500 rounded text-white p-2' href='/FinalProyect/Database/Messages/ver.php?id=$row[id]'>Ver Mensaje</a>
                    <a class='bg-red-500 rounded text-white p-2' href='/FinalProyect/Database/Messages/borrar.php?id=$row[id]'>Borrar Mensaje</a>
                  </td>
                </tr>";
            }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Sección de Solicitudes de Trabajo -->
    <div class="w-1/2">
      <h2 class="text-lg font-semibold mb-4">Solicitudes de trabajo</h2>
      <a class="bg-red-500 text-white rounded p-2" href="#" onclick="confirmVaciar('/FinalProyect/Database/Job/vaciar.php')"> Vaciar Todo </a>
      <table class="w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="border-b p-2">Nombre:</th>
            <th class="border-b p-2">Apellido Paterno:</th>
            <th class="border-b p-2">Apellido Materno:</th>
            <th class="border-b p-2">Opciones:</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT * FROM trab_solicitud";
            $result = $conn->query($sql);
            if (!$result) {
              die("Sesion invalida" . $conn->error);
            }
            while ($row = $result->fetch_assoc()) {
              echo "
                <tr>
                  <td class='border-b p-2 text-center'>$row[nombre]</td>
                  <td class='border-b p-2 text-center'>$row[apellido1]</td>
                  <td class='border-b p-2 text-center'>$row[apellido2]</td>
                  <td class='text-center'>
                    <a class='bg-blue-500 rounded text-white p-2' href='/FinalProyect/Database/Job/ver.php?id=$row[id]'>Ver Solicitud</a>
                    <a class='bg-red-500 rounded text-white p-2' href='/FinalProyect/Database/Job/borrar.php?id=$row[id]'>Rechazar Solicitud</a>
                  </td>
                </tr>";
            }
            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src = "/FinalProyect/lib/sweetalert/sweetA.js"></script>
<script>
  function searchReservations() {
    // Obtener elementos del DOM
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("reservationsTable");
    tr = table.getElementsByTagName("tr");

    // Bandera para verificar si se encuentra alguna coincidencia
    var anyMatchFound = false;

    // buscar a través de las filas de la tabla
    for (i = 0; i < tr.length; i++) {
        // Excluir la primera fila de la tabla, que contiene indicadores
        if (i === 0) {
            continue;
        }

        var matchFound = false;

        // Array de índices de columnas a buscar
        var searchColumns = [0, 1];

        // buscar a través de las columnas específicas
        for (var j = 0; j < searchColumns.length; j++) {
            // Obtener la celda de la fila actual
            td = tr[i].getElementsByTagName("td")[searchColumns[j]];
            if (td) {
                // Obtener el texto de la celda
                txtValue = td.textContent || td.innerText;
                
                // Verificar si hay coincidencia
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    matchFound = true;
                    anyMatchFound = true;
                    break;
                }
            }
        }

        // Mostrar u ocultar filas según la coincidencia
        tr[i].style.display = matchFound ? "" : "none";
    }

    // Mostrar un mensaje si no se encuentran coincidencias
    var message = document.getElementById("errorMensaje");
    if (!anyMatchFound) {
        message.textContent = "No se han encontrado datos con '" + input.value + "' en la base de datos.";
        message.style.color = "red";
        message.style.fontSize = "25px";
    } else {
        message.textContent = "";
    }
  }
    
  //  Asegurarse de que no vacien las tablas por accidente
  function confirmVaciar(url) {
    Swal.fire({
    title: "Estas seguro de que deseas vaciar la tabla?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, estoy seguro"
    }).then((result) => {
    if (result.isConfirmed) {
      let timerInterval;
    Swal.fire({
    title: "Borrado Exitosamente!",
    html: "Actualizando en <b></b> milisegundos.",
    timer: 1500,
    timerProgressBar: true,
    didOpen: () => {
    Swal.showLoading();
    const timer = Swal.getPopup().querySelector("b");
    timerInterval = setInterval(() => {
      timer.textContent = `${Swal.getTimerLeft()}`;
    }, 10);
    },
    willClose: () => {
    clearInterval(timerInterval);
    }
  }).then((result) => {
});
    setTimeout(() => {
      window.location.href = url;
    }, 1500);
  }
});
  }
</script>
<script src = "/FinalProyect/js/dashboard2.js"></script>
</body>
</html>