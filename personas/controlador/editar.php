<?php
require_once("../../config/db.php");
require_once("../modelo/userModel.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario con validación
    //$id_tipo_persona_fk = $_POST['id_tipo_persona_fk'] ?? null;
    //$id_tipo_proponente_fk = $_POST['id_tipo_proponente_fk'] ?? null;
    //$id_tipo_Documento_fk = $_POST['id_tipo_Documento_fk'] ?? null;   cxv
    $id= $_POST['id'];
    $numero_documento = $_POST['numero_documento'] ?? null;
    $nombres = $_POST['nombres'] ?? null;
    $apellidos = $_POST['apellidos'] ?? null;
    //$genero_fk = $_POST['genero_fk'] ?? null;
    $vereda_centro_poblado = $_POST['vereda_centro_poblado'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $celular = $_POST['celular'] ?? null;
    $correo = $_POST['correo'] ?? null;
    //$pass = $_POST['pass'] ?? null;
    $nombre_representante = $_POST['nombre_representante'] ?? null;
    $tiempo_residencia = $_POST['tiempo_residencia'] ?? null;
    var_dump($_POST);
    // Verificar que todos los campos obligatorios estén llenos
    if (
    !empty($numero_documento) &&
    !empty($nombres) && !empty($apellidos) && !empty($vereda_centro_poblado) &&
    !empty($direccion) && !empty($celular) && !empty($correo)&& !empty($nombre_representante) &&
    !empty($tiempo_residencia)) {
        // Verificar si la clase UserModel está definida
        $consulta = new UserModel();
        if (class_exists('UserModel')) {
            //$consulta = new UserModel();
            // Llamar al método modificarUsuario con todos los datos
            $mensaje = $consulta->modificarUsuario($id,
                $numero_documento,$nombres,$apellidos,$vereda_centro_poblado,$direccion,$celular,$correo,$nombre_representante,$tiempo_residencia
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