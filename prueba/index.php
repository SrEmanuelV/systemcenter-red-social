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
?>