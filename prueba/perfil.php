<?php
session_start();
include 'php/conexion.php'; // Incluir conexión

// Asegúrate de que el ID del usuario esté almacenado en la sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "No estás logueado. Por favor inicia sesión.";
    exit(); // Salir si no hay usuario logueado
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
$ruta_foto_perfil_predeterminada = 'assets/foto_perfil/predeterminada.png';
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

<div class="perfil">
<div class="foto-perfil">
        <img src="<?php echo $foto_perfil; ?>" alt="Foto de perfil" class="imagen-perfil">
    </div>
    <div class="info-perfil">
        <h2 class="nombre-usuario">
            <?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?>
            <span class="nombre-de-usuario">@<?php echo $usuario['nombre_usuario']; ?></span>
        </h2>
        <div class="estadisticas">
            <div class="estadistica">
                <strong id="seguidores"><?php echo $usuario['total_seguidores']; ?></strong> seguidores
            </div>
            <div class="estadistica">
                <strong id="siguiendo"><?php echo $usuario['total_siguiendo']; ?></strong> siguiendo
            </div>
            <div class="estadistica">
                <strong id="publicaciones"><?php echo $usuario['total_publicaciones']; ?></strong> publicaciones
            </div>
        </div>
    </div>
</div>

</body>
</html>
