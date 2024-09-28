<?php

include "conexion.php";

// VALIDAR REGISTRO DE USUARIOS

function validarRegistroUsuarios($nombre, $apellido, $fecha_nacimiento, $numero_documento) {
    $errores = [];

    // Validar nombre
    if (strlen($nombre) > 25) {
        $errores[] = "El nombre no debe superar los 25 caracteres.";
    }

    // Validar apellido
    if (strlen($apellido) > 25) {
        $errores[] = "El apellido no debe superar los 25 caracteres.";
    }

    // Validar fecha de nacimiento
    $fecha_actual = new DateTime();
    $fecha_nacimiento = new DateTime($fecha_nacimiento);
    $edad = $fecha_actual->diff($fecha_nacimiento)->y;
    if ($edad < 15) {
        $errores[] = "Debes tener al menos 15 años para registrarte.";
    }

    // Validar número de documento
    if (!preg_match('/^\d{8,12}$/', $numero_documento)) {
        $errores[] = "El número de documento debe tener entre 8 y 12 dígitos.";
    }

    return $errores;
}

function validarRegistroDatosUsuarios($datos_usuario, $correo_electronico, $contrasena, $nombre_usuario) {
    global $conexion;
    $errores = [];

    // Validar correo electrónico
    if (strlen($correo_electronico) > 100) {
        $errores[] = "El correo electrónico no debe superar los 100 caracteres.";
    } elseif (existeCorreo($correo_electronico)) {
        $errores[] = "El correo electrónico ya está en uso.";
    }

    // Validar contraseña
    if (strlen($contrasena) < 6 || strlen($contrasena) > 15) {
        $errores[] = "La contraseña debe tener entre 6 y 15 caracteres.";
    }

    // Validar nombre de usuario
    if (strlen($nombre_usuario) < 5 || strlen($nombre_usuario) > 20) {
        $errores[] = "El nombre de usuario debe tener entre 5 y 20 caracteres.";
    } elseif (existeNombreUsuario($nombre_usuario)) {
        $errores[] = "El nombre de usuario ya está en uso.";
    }

    return $errores;
}

function registrarUsuario($datos_usuario, $numero_telefono, $correo_electronico, $contrasena, $nombre_usuario) {
    global $conexion;

    // Inserción en la tabla usuarios
    $query = "INSERT INTO usuarios (nombres, apellidos, fecha_nacimiento, fecha_registro, numero_documento) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = $conexion->prepare($query);
    
    // Extraer variables
    $nombre = $datos_usuario['nombres'];
    $apellido = $datos_usuario['apellidos'];
    $fecha_nacimiento = $datos_usuario['fecha_nacimiento'];
    $numero_documento = $datos_usuario['numero_documento'];
    
    // Vincular parámetros
    $stmt->bind_param("ssss", $nombre, $apellido, $fecha_nacimiento, $numero_documento);
    $stmt->execute();

    $usuario_id = $conexion->insert_id; // Obtener el ID del nuevo usuario

    // Inserción en la tabla datos_usuarios
    $query2 = "INSERT INTO datos_usuarios (usuario_id, numero_telefono, correo, contrasena, nombre_usuario, rol) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt2 = $conexion->prepare($query2);
    
    // Preparar la contraseña
    $hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    
    // Vincular parámetros
    $stmt2->bind_param("issss", $usuario_id, $numero_telefono, $correo_electronico, $hashed_contrasena, $nombre_usuario);
    $stmt2->execute();

    return true; // Retorna verdadero si se registró correctamente
}

function existeCorreo($correo_electronico) {
    global $conexion;
    $query = "SELECT id FROM datos_usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $correo_electronico);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

function existeNombreUsuario($nombre_usuario) {
    global $conexion;
    $query = "SELECT id FROM datos_usuarios WHERE nombre_usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}


// --------- VALIDAR INICIO DE SESION ----------- //

// Función para procesar el inicio de sesión
function iniciarSesion($usuario, $contrasena) {
    // Conexión a la base de datos
    global $conexion;
    
    // Consulta SQL para encontrar al usuario por correo electrónico o nombre de usuario
    $query = "SELECT du.usuario_id, du.correo, du.nombre_usuario, du.contrasena, du.rol FROM datos_usuarios du WHERE du.correo = ? OR du.nombre_usuario = ?";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $usuario, $usuario); // Se usan los dos mismos parámetros para correo y nombre de usuario
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // El usuario existe, se obtiene la información
        $fila = $resultado->fetch_assoc();
        $hash_contrasena = $fila['contrasena']; // Contraseña hash guardada en la base de datos
        
        // Verificar la contraseña con password_verify()
        if (password_verify($contrasena, $hash_contrasena)) {
            // Contraseña correcta, proceder con la validación del rol

            session_start(); // Iniciar la sesión
            $_SESSION['usuario_id'] = $fila['usuario_id'];


            $rol = $fila['rol'];
            
            // Redirigir según el rol del usuario
            switch ($rol) {
                case 0: // Usuario básico
                    header("Location: ../index.php");
                    exit();
                case 1: // Usuario estándar
                    header("Location: pagina_estandar.php");
                    exit();
                case 2: // Administrador
                    header("Location: admin_dashboard.php");
                    exit();
                default:
                    echo "Rol no válido.";
                    exit();
            }
        } else {
            // Contraseña incorrecta
            echo "Error: Contraseña incorrecta.";
        }
    } else {
        // No se encontró el usuario
        echo "Error: Usuario no encontrado.";
    }
}


?>
