<?php
$loginSuccess = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $usuario = $_REQUEST["Nombre"];
    $contra = $_REQUEST["Password"];

    // Conexión a la base de datos
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "data"; 

    // Crear una conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT * FROM administradores WHERE usuario = '$usuario' AND contra = '$contra'";
    $result = $conn->query($sql);
    // en caso de tener una columna con los datos ingresados enviar al panel general
    $loginSuccess = ($result->num_rows > 0);
    if( $loginSuccess > 0){
      $row = $result->fetch_assoc();
      $nombre = $row['usuario'];
      header("Location: /FinalProyect/Database/dashboard.php?data=" . urlencode($nombre));
      exit;
    }
    if (!$loginSuccess) {
      echo "<div style = 'color: red; font-size: 13px; position: absolute;
      z-index: 99; bottom: 295px;' id = 'errorMessage'> Nombre o Contraseña incorrectos</div>
      <script>const animation = true;</script>";
  }
    // Incluir la variable del JS
    echo '<script>var loginSuccess = ' . json_encode($loginSuccess) . ';</script>';

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de sesión || Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel = "stylesheet" href = "FinalProyect/security/assets/verify.css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
</head>
<body class="bg-info d-flex justify-content-center align-items-center vh-100">
    <div class="loader"></div>
    <div
    class="bg-white p-5 rounded-5 text-secondary shadow"
    style="width: 25rem"
    >
    <form action = "" method = "POST">
      <div class="d-flex justify-content-center">
        <img src="/FinalProyect/security/assets/login-icon.png" alt="login-icon" style="height: 7rem"/>
      </div>
      <div class="text-center fs-1 fw-bold">Administrador </div>
      <div class="input-group mt-4">
        <div class="input-group-text bg-info">
          <img src="/FinalProyect/security/assets/username-icon.png" alt="username-icon" style="height: 1rem"/>
        </div>
        <input class="form-control bg-light" type="text" name = "Nombre"  placeholder="Nombre de Usuario"/>
      </div>
      <div class="input-group mt-1" id = "passwordContainer">
        <div class="input-group-text bg-info">
          <img src="/FinalProyect/security/assets/password-icon.png" alt="password-icon" style="height: 1rem"/>
        </div>
        <input class="form-control bg-light" type="password" name = "Password" id = "passwordInput" placeholder="Contraseña"/>
        <button class="btn bg-info" type="button" id="togglePasswordBtn">
          <i class="bi bi-eye text-white"></i>
        </button>
      </div>
      <div class="d-flex justify-content-around mt-1">
        <div class="pt-1">
          <a href="#" class="text-decoration-none text-info fw-semibold fst-italic" style="font-size: 0.9rem" >Olvidaste la contraseña?</a>
        </div>
      </div>
      <div id="errorMessage"></div>
      <div class="text-white text-center w-100 mt-4 fw-semibold shadow-sm">
        <button type = "submit" class = "btn btn-info w-100">Iniciar Sesión</button> 
      </div>
    </form>
      <div class="p-3">
        <div class="border-bottom text-center" style="height: 0.9rem">
          <span class="bg-white px-3"><a class = "text-decoration-none text-primary" href = "/FinalProyect/index.html">Regresar</a></span>
        </div>
      </div>
    </div>



<script>
   // Espera a que el contenido HTML se cargue completamente antes de ejecutar el script
  document.addEventListener("DOMContentLoaded", function () {
      // Obtén referencias a los elementos del From
      const passwordInput = document.getElementById("passwordInput");
      const togglePasswordBtn = document.getElementById("togglePasswordBtn");

      // Agrega un evento de "click" al botón de alternar contraseña
      togglePasswordBtn.addEventListener("click", function () {
      // Obtiene el tipo actual del campo de contraseña (visible o no)
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      // Establece el nuevo tipo del campo de contraseña
      passwordInput.setAttribute("type", type);

      // Determina la clase del ícono en función de si la contraseña es visible o no
      const iconClass = type === "password" ? "bi bi-eye text-white" : "bi bi-eye-slash text-white";

      // Actualiza el contenido del botón con el ícono apropiado
      togglePasswordBtn.innerHTML = `<i class="${iconClass}"></i>`;

    });
  });
  const errorA = document.getElementById("passwordContainer");
  if (animation === true){
    errorA.classList.add("");
  }
</script>
  </body>
</html>
