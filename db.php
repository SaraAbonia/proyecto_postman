<?php
// Conexion - datos 
$servername = "localhost";
$username = "root";
$password = "1234567A";
$database = "usuario";

// Realizar la conexion 
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
}

// Registrar usuario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registro"])) {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    // Verificar si el usuario ya esta registrado 
    $verificar_usuario = "SELECT * FROM registro WHERE usuario = '$usuario'";
    $result = $conn->query($verificar_usuario);

    if ($result->num_rows > 0) {
        echo "Error: El usuario ya existe";
    } else {
        // Insertar nuevo usuario 
        $insertar_usuario = "INSERT INTO registro (usuario, contraseña) VALUES ('$usuario', '$contraseña')";
        if ($conn->query($insertar_usuario) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error en el registro: " . $conn->error;
        }
    }
}

// Iniciar sesion 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["inicio_sesion"])) {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    // Comprobar datos de la base de datos 
    $verificar_autenticacion = "SELECT * FROM registro WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
    $result = $conn->query($verificar_autenticacion);

    if ($result->num_rows > 0) {
        // Uasuario logra ingrsar 
        header("Location: inicio.html");
        // Usuario no puede ingresar 
    } else {
        echo "Error en la autenticación. Credenciales incorrectas.";
    }
}


// Cierre de la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro</title>
</head>
<body>
    <div class="container">
    <h2>Registro de Usuario</h2>
    <form method="post" action="db.php">
        <label for="usuario" class="registro">Usuario:</label>
        <input type="text" name="usuario" required class="llenar"><br><br>

        <label for="contraseña" class="registro">Contraseña:</label>
        <input type="password" name="contraseña" required class="llenar"><br><br>
        <input type="submit" name="registro" value="Registrar" class="botones">
        <input type="submit" name="inicio_sesion" value="Iniciar Sesión" class="botones">
</div>
    </form>


<style>
 body {
    background-image: linear-gradient(-225deg, #E3FDF5 0%, #FFE6FA 100%);
    background-image: linear-gradient(to top, #a8edea 0%, #fed6e3 100%);
    background-attachment: fixed;
    background-repeat: no-repeat;
    font-family: 'Vibur', cursive;
    font-family: 'Abel', sans-serif;
    opacity: .95;
    }
.container{
    position:relative;
    top:100px;
    left:35%;
    display:block;
    margin-bottom:80px;
    width:500px;
    height:360px;
    background:#fff;
    border-radius:5px;
    overflow:hidden;
    z-index:1;
   }
   h2{
    margin-left: 60px;
    margin-bottom: 60px;
    font-family: 'Courier New', Courier, monospace;
    font-size: 30px;
    color: #000230;
   }

   .registro{
   position:relative;
  z-index:1;
  border-bottom:1px solid rgba(0,0,0,.1);
  padding-left:20px;
  font-family: 'Open Sans', sans-serif;
  text-transform:uppercase;
  color:#858585;
  font-weight:lighter;
  -webkit-transition:.5s;
  transition:.5s;
}

.llenar{
    display:block;
  height:50px;
  width:90%;
  margin:0 auto;
  border:none;
  -webkit-transform:translateY(0px);
      transform:translateY(0px);
    -webkit-transition:.5s;
      transition:.5s;
}

.botones{
cursor:pointer; 
background-color: #fed6e3;
margin-left: 5px;
width:240px;
height:30px;
border:none;
font-family: 'Open Sans', sans-serif;
text-transform:uppercase;
color:#000;
}
    </style>
</body>
</html>

