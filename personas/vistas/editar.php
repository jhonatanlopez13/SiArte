<?php
// Incluir el modelo
require_once '../modelo/userModel.php';

// Función para obtener los datos del usuario
function seleccionar() {
    if (isset($_GET['id'])) {
        $consultas = new UserModel();
        $id = $_GET['id'];
        $filas = $consultas->cargarusuaro1($id); // Método para obtener los datos del usuario

        if (!empty($filas)) {
            return $filas; // Retorna los datos del usuario
        } else {
            echo "No se encontró el usuario.";
            return [];
        }
    } else {
        echo "ID no proporcionado.";
        return [];
    }
}

// Llamar a la función seleccionar() y obtener los datos
$filas = seleccionar();
$fila = !empty($filas) ? $filas[0] : []; // Tomar la primera fila (si existe)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS (opcional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Editar Usuario</h1>
        <form action="../controlador/editar.php" method="POST">
            <!-- Campo oculto para el ID del usuario -->
            <input type="hidden" name="id" value="<?php echo isset($fila['id']) ? $fila['id'] : ''; ?>">

            <div class="mb-3">
                <label for="numero_documento" class="form-label">Número de Documento:</label>
                <input type="text" class="form-control" id="numero_documento" name="numero_documento" value="<?php echo isset($fila['numero_documento']) ? $fila['numero_documento'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombres" value="<?php echo isset($fila['nombres']) ? $fila['nombres'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo isset($fila['apellidos']) ? $fila['apellidos'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="vereda_centro_poblado" class="form-label">Vereda/Centro Poblado:</label>
                <input type="text" class="form-control" id="vereda_centro_poblado" name="vereda_centro_poblado" value="<?php echo isset($fila['vereda_centro_poblado']) ? $fila['vereda_centro_poblado'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo isset($fila['direccion']) ? $fila['direccion'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="celular" class="form-label">Celular:</label>
                <input type="text" class="form-control" id="celular" name="celular" value="<?php echo isset($fila['celular']) ? $fila['celular'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="correo" value="<?php echo isset($fila['correo']) ? $fila['correo'] : ''; ?>" required>
            </div>
            <!--  nombre_representante -->
            <div class="mb-3">
                <label for=" nombre_representante" class="form-label"> nombre de representante:</label>
                <input type="text" class="form-control" id=" nombre_representante" name=" nombre_representante" value="<?php echo isset($fila['nombre_representante']) ? $fila['nombre_representante'] : ''; ?>" >
            </div>
            <div class="mb-3">
                <label for=" tiempo_residencia" class="form-label"> nombre de representante:</label>
                <input type="text" class="form-control" id=" tiempo_residencia" name=" tiempo_residencia" value="<?php echo isset($fila['tiempo_residencia']) ? $fila['tiempo_residencia'] : ''; ?>" >
            </div>

          

            <button type="submit" class="btn btn-primary">Modificar</button>
        </form>
    </div>
</body>
</html>