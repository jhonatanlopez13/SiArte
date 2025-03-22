<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario con validación
    $id_tipo_persona_fk = $_POST['id_tipo_persona_fk'] ?? null;
    $id_tipo_proponente_fk = $_POST['id_tipo_proponente_fk'] ?? null;
    $id_tipo_Documento_fk = $_POST['id_tipo_Documento_fk'] ?? null;
    $numero_documento = $_POST['numero_documento'] ?? null;
    $nombres = $_POST['nombres'] ?? null;
    $apellidos = $_POST['apellidos'] ?? null;
    $genero_fk = $_POST['genero_fk'] ?? null;
    $vereda_centro_poblado = $_POST['vereda_centro_poblado'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $celular = $_POST['celular'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $pass = $_POST['pass'] ?? null;
    $nombre_representante = $_POST['nombre_representante'] ?? null;
    $tiempo_residencia = $_POST['tiempo_residencia'] ?? null;

    // Verificar que todos los campos obligatorios estén llenos
    if (!empty($id_tipo_persona_fk) && !empty($id_tipo_proponente_fk) && !empty($id_tipo_Documento_fk) && !empty($numero_documento) && !empty($nombres) && !empty($apellidos) && !empty($genero_fk) && !empty($vereda_centro_poblado) && !empty($direccion) && !empty($celular) && !empty($correo) && !empty($pass) && !empty($nombre_representante) && !empty($tiempo_residencia)) {
        // Verificar si la clase UserModel está definida
        if (class_exists('UserModel')) {
            $consulta = new UserModel();
            // Llamar al método modificarUsuario con todos los datos
            $mensaje = $consulta->modificarUsuario(
                $id_tipo_persona_fk,$id_tipo_proponente_fk,$id_tipo_Documento_fk,$numero_documento,$nombres,$apellidos,$genero_fk,$vereda_centro_poblado,$direccion,$celular,$correo,$pass,$nombre_representante,$tiempo_residencia
            );
            
            // Redirigir después de una actualización exitosa
            if ($mensaje === "Usuario actualizado correctamente") {
                header("Location: ../vistas/listar.php?mensaje=" . urlencode($mensaje));
                exit;
            }
        } else {
            $mensaje = "La clase UserModel no está definida. Verifica la inclusión del archivo.";
        }
    } else {
        $mensaje = "Por favor, completa todos los campos obligatorios.";
    }
} else {
    $mensaje = "Acceso no autorizado.";
}

// Si llegamos aquí, algo salió mal, mostrar el mensaje de error
echo "<div class='alert alert-danger'>$mensaje</div>";
?>