<?php
include "conexion.php";
require 'funciones.php';
session_start(); // Para manejar la sesión

// Inicializar variables
$mostrar_datos_usuario = false;
$errores = [];

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $numero_documento = $_POST['numero_documento'];

        // Validar datos del primer formulario
        $errores = validarRegistroUsuarios($nombre, $apellido, $fecha_nacimiento, $numero_documento);

        if (empty($errores)) {
            $_SESSION['datos_usuario'] = [
                'nombres' => $nombre,
                'apellidos' => $apellido,
                'fecha_nacimiento' => $fecha_nacimiento,
                'numero_documento' => $numero_documento,
            ];
            $mostrar_datos_usuario = true;
        }
    }

    if (isset($_POST['correo_electronico'])) {
        $numero_telefono = $_POST['numero_telefono'];
        $correo_electronico = $_POST['correo_electronico'];
        $contrasena = $_POST['contrasena'];
        $nombre_usuario = $_POST['nombre_usuario'];

        // Validar datos del segundo formulario
        $errores = validarRegistroDatosUsuarios($_SESSION['datos_usuario'], $correo_electronico, $contrasena, $nombre_usuario);

        if (empty($errores)) {
            // Registrar al usuario
            if (registrarUsuario($_SESSION['datos_usuario'], $numero_telefono, $correo_electronico, $contrasena, $nombre_usuario)) {
                echo "<p class='success'>Registro exitoso.</p>";
            } else {
                $errores[] = "Error al registrar el usuario. Intenta nuevamente.";
            }
            session_unset();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Registro</title>
</head>
<body>
    <div class="container">
        <?php if (!$mostrar_datos_usuario): ?>
            <form id="form-usuarios" class="form" action="register.php" method="POST">
                <h2>Registro de Usuario</h2>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
                
                <label for="fecha-nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha-nacimiento" name="fecha_nacimiento" required>
                
                <label for="numero-documento">Número de Documento:</label>
                <input type="text" id="numero-documento" name="numero_documento" required>
                
                <button type="submit">Registrar</button>
            </form>
        <?php elseif ($mostrar_datos_usuario): ?>
            <form id="form-datos-usuarios" class="form" action="register.php" method="POST">
                <h2>Datos de Usuario</h2>
                <label for="numero-telefono">Número de Teléfono:</label>
                <input type="text" id="numero-telefono" name="numero_telefono">
                
                <label for="correo-electronico">Correo Electrónico:</label>
                <input type="email" id="correo-electronico" name="correo_electronico" required>
                
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
                
                <label for="nombre-usuario">Nombre de Usuario:</label>
                <input type="text" id="nombre-usuario" name="nombre_usuario" required>
                
                <button type="submit">Completar Registro</button>
            </form>
        <?php endif; ?>

        <?php
        // Mostrar mensajes de error
        if (!empty($errores)) {
            foreach ($errores as $error) {
                echo "<p class='error'>Error: $error</p>";
            }
        }
        ?>
    </div>
</body>
</html>
