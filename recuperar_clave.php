<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Contraseña</title>
    <!-- Bootstrap CSS (opcional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cambio de Contraseña</h1>
        <?php
        require_once 'app/controllers/UsuarioController.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioController = new UsuarioController();
            $numero_documento = $_POST['numero_documento'];
            $nueva_contrasena = $_POST['nuevaContrasena'];
            
            $resultado = $usuarioController->cambiarContrasena($numero_documento, $nueva_contrasena);
            
            if ($resultado['success']) {
                echo '<div class="alert alert-success">' . $resultado['message'] . '</div>';
                // Redirigir después de 2 segundos
                echo '<script>setTimeout(function() { window.location.href = "login.php"; }, 2000);</script>';
            } else {
                echo '<div class="alert alert-danger">' . $resultado['message'] . '</div>';
            }
        }
        ?>
        <form id="cambioContraseñaForm" method="POST" onsubmit="return validarFormulario()">
            <div class="mb-3">
                <label for="numero_documento" class="form-label">Número de Documento:</label>
                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
            </div>
            <div class="mb-3">
                <label for="nuevaContrasena" class="form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="nuevaContrasena" name="nuevaContrasena" required>
            </div>

            <div class="mb-3">
                <label for="confirmarContrasena" class="form-label">Confirmar Nueva Contraseña:</label>
                <input type="password" class="form-control" id="confirmarContrasena" name="confirmarContrasena" required>
            </div>

            <div id="mensajeError" class="alert alert-danger d-none"></div>

            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script de validación -->
    <script>
        function validarFormulario() {
            // Obtener valores de los campos
            const nuevaContrasena = document.getElementById('nuevaContrasena').value;
            const confirmarContrasena = document.getElementById('confirmarContrasena').value;

            // Validar que la nueva contraseña y la confirmación coincidan
            if (nuevaContrasena !== confirmarContrasena) {
                mostrarError("Las contraseñas no coinciden.");
                return false; // Evitar que el formulario se envíe
            }

            // Validar la fortaleza de la contraseña (opcional)
            if (!validarFortalezaContrasena(nuevaContrasena)) {
                mostrarError("La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un carácter especial.");
                return false; // Evitar que el formulario se envíe
            }

            // Si todo está bien, permitir el envío del formulario
            return true;
        }

        // Función para mostrar mensajes de error
        function mostrarError(mensaje) {
            const mensajeError = document.getElementById('mensajeError');
            mensajeError.textContent = mensaje;
            mensajeError.classList.remove('d-none'); // Mostrar el mensaje
        }

        // Función para validar la fortaleza de la contraseña
        function validarFortalezaContrasena(contrasena) {
            // Expresión regular para validar la contraseña
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return regex.test(contrasena);
        }
    </script>
</body>
</html>