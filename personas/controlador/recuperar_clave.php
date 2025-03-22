<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
    // Obtener datos del formulario con validación
 
    $numero_documento = $_POST['numero_documento'] ?? null;
    $pass             = $_POST['pass']

    // Verificar que todos los campos obligatorios estén llenos
    if ( !empty($numero_documento)  && !empty($pass)) {
        // Verificar si la clase UserModel está definida
        if (class_exists('UserModel')) {
            $consulta = new UserModel();
            // Llamar al método modificarUsuario con todos los datos
            $mensaje = $consulta->modificarUsuario(
                $id_tipo_persona_fk, $id_tipo_proponente_fk, $id_tipo_Documento_fk, $numero_documento, $nombres, $apellidos, $genero_fk, $vereda_centro_poblado, $direccion, $celular, $correo, $pass, $nombre_representante, $tiempo_residencia
            );
        } else {
            $mensaje = "La clase UserModel no está definida. Verifica la inclusión del archivo.";
        }
    } else {
        $mensaje = "Por favor, completa todos los campos obligatorios.";
    }
} else {
    $mensaje = "Acceso no autorizado.";
}

echo $mensaje; // Mostrar el mensaje de resultado
?>