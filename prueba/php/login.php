<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'funciones.php'; // Cargar el archivo de funciones
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if (empty($usuario) || empty($contrasena)) {
        echo "Por favor, complete todos los campos.";
    } else {
        iniciarSesion($usuario, $contrasena); // Llamada a la función de inicio de sesión
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>

    <style>
    :root {
    --color-negro-claro: #1a1a1a;
    --color-azul-principal: #007BFF;
    --color-blanco: #ffffff;
    --color-gris-claro: #f2f2f2;
    --color-azul-oscuro: #0056b3;
    --color-amarillo-claro: #ffc107;
    --color-sombra: rgba(0, 0, 0, 0.15);
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: var(--color-gris-claro);
    padding: 20px;
}

.form-container {
    background-color: var(--color-blanco);
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 16px var(--color-sombra);
    max-width: 400px;
    width: 100%;
}

h2 {
    text-align: center;
    color: var(--color-azul-principal);
    margin-bottom: 30px;
    font-size: 24px;
}

.login-form .input-group {
    margin-bottom: 20px;
}

.login-form label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    color: var(--color-negro-claro);
}

.login-form input {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}

.login-form input:focus {
    border-color: var(--color-azul-principal);
    box-shadow: 0 0 5px var(--color-azul-principal);
}

button {
    width: 100%;
    padding: 12px;
    background-color: var(--color-azul-principal);
    color: var(--color-blanco);
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: var(--color-azul-oscuro);
}

/* Responsivo para pantallas pequeñas */
@media (max-width: 600px) {
    .form-container {
        padding: 20px;
    }

    h2 {
        font-size: 20px;
    }

    button {
        font-size: 16px;
    }
}
</style>
</head>
<body>
<form class="login-form" method="POST" action="login.php">
    <h2>Iniciar Sesión</h2>
    <div class="input-group">
        <label for="usuario">Correo o Nombre de Usuario</label>
        <input type="text" id="usuario" name="usuario" placeholder="Ingrese su correo o usuario" required>
    </div>
    <div class="input-group">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
    </div>
    <button type="submit">Iniciar Sesión</button>
</form>

</body>
</html>
