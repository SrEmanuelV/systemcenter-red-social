<?php
session_start();
include 'php/conexion.php'; // Incluir conexión

// Asegúrate de que el ID del usuario esté almacenado en la sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: php/login.php");
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta para obtener los datos del usuario
$sql = "SELECT u.nombres, u.apellidos, du.foto_perfil, du.nombre_usuario, du.numero_telefono, du.correo,
        (SELECT COUNT(*) FROM publicaciones WHERE usuario_id = ?) AS total_publicaciones,
        (SELECT COUNT(*) FROM seguidores WHERE id_seguido = ?) AS total_seguidores,
        (SELECT COUNT(*) FROM seguidores WHERE id_seguidor = ?) AS total_siguiendo
        FROM usuarios u
        JOIN datos_usuarios du ON u.id = du.usuario_id
        WHERE u.id = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $usuario_id); // Vincula el usuario_id
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Guardar datos en un array
    $usuario = $result->fetch_assoc();
} else {
    echo "No se encontraron resultados.";
}

$stmt->close();
$conexion->close();

// Ruta de la foto de perfil por defecto
$ruta_foto_perfil_predeterminada = 'assets/foto_perfil/user_photo_predeterminada.jpg';
$foto_perfil = !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : $ruta_foto_perfil_predeterminada;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>

<div class="contenedor">
    <!-- Barra Lateral -->
    <div class="barra-lateral">
        <div class="logo">
            <img class="logo-imagen" src="<?php echo $foto_perfil; ?>" alt="Foto de perfil">
        </div>
        <ul class="menu-opciones">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Perfil</a></li>
            <li><a href="#">Buscar</a></li>
            <li><a href="#">Mensajes</a></li>
            <li><a href="#">Notificaciones</a></li>
            <li><a href="#">Configuración</a></li>
        </ul>
    </div>

    <!-- Contenedor del Perfil -->
    <div class="perfil">
        <div class="foto-perfil">
            <img class="imagen-perfil" src="<?php echo $foto_perfil; ?>" alt="Foto de usuario">
        </div>
        <div class="info-perfil">
            <h2 class="nombre-usuario"><?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?></h2>
            <h3 class="nombre-de-usuario">@<?php echo $usuario['nombre_usuario']; ?></h3>
            <div class="estadisticas">
                <div class="estadistica">
                    <p><strong><?php echo $usuario['total_seguidores']; ?></strong> seguidores</p>
                </div>
                <div class="estadistica">
                    <p><strong><?php echo $usuario['total_siguiendo']; ?></strong> siguiendo</p>
                </div>
                <div class="estadistica">
                    <p><strong><?php echo $usuario['total_publicaciones']; ?></strong> publicaciones</p>
                </div>
            </div>
        </div>

        <!-- Bloque para editar perfil -->
        <div class="editar-perfil">
            <h3>Editar Perfil</h3>
            <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombres'] . ' ' . $usuario['apellidos']; ?>">

                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" value="<?php echo $usuario['nombre_usuario']; ?>">


                <label for="foto_perfil">Cambiar Foto de Perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil">

                <input type="submit" value="Guardar Cambios">
            </form>
        </div>
    </div>
</div>

</body>
</html>
