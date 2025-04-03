<?php
require_once("../../config/db.php");
require_once("../modelo/userModel.php");

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario con valores por defecto
    $id_tipo_persona_fk = $_POST['id_tipo_persona_fk'] ?? '';
    $id_tipo_proponente_fk = $_POST['id_tipo_proponente_fk'] ?? '';
    $id_tipo_Documento_fk = $_POST['id_tipo_Documento_fk'] ?? '';
    $numero_documento = $_POST['numero_documento'] ?? '';
    $nombres = $_POST['nombres'] ?? ''; // Ahora opcional
    $apellidos = $_POST['apellidos'] ?? ''; // Ahora opcional
    $genero_fk = $_POST['genero_fk'] ?? null; // Ahora opcional
    $vereda_centro_poblado = $_POST['vereda_centro_poblado'] ?? '';
    $direccion = $_POST['direccion'] ?? ''; // Ahora opcional
    $celular = $_POST['celular'] ?? ''; // Ahora opcional
    $correo = $_POST['correo'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $nombre_representante = $_POST['nombre_representante'] ?? '';
    $tiempo_residencia = $_POST['tiempo_residencia'] ?? '';
    
    // Estados con valores por defecto
    $estado_anexo1 = $_POST['estado_anexo1'] ?? 'pendiente';
    $estado_anexo2 = $_POST['estado_anexo2'] ?? 'pendiente';
    $estado_anexo3 = $_POST['estado_anexo3'] ?? 'pendiente';
    $estado_copia_documento = $_POST['estado_copia_documento'] ?? 'pendiente';
    $estado_certificado_residencia = $_POST['estado_certificado_residencia'] ?? 'pendiente';
    $estado_copia_rut = $_POST['estado_copia_rut'] ?? 'pendiente';
    $estado_certificado_sicut = $_POST['estado_certificado_sicut'] ?? 'pendiente';

    // SOLO CAMPOS REALMENTE OBLIGATORIOS
    $camposObligatorios = [
        'id_tipo_persona_fk' => $id_tipo_persona_fk,
        'id_tipo_proponente_fk' => $id_tipo_proponente_fk,
        'id_tipo_Documento_fk' => $id_tipo_Documento_fk,
        'numero_documento' => $numero_documento,
        'correo' => $correo,
        'pass' => $pass
    ];

    // Verificar campos obligatorios
    $camposFaltantes = [];
    foreach ($camposObligatorios as $campo => $valor) {
        if (empty($valor)) {
            $camposFaltantes[] = $campo;
        }
    }

    if (!empty($camposFaltantes)) {
        $mensaje = "Por favor, complete los siguientes campos obligatorios: " . implode(', ', $camposFaltantes);
    } else {
        // Resto del código para procesar el formulario...
        // (Mantén aquí la lógica de subida de archivos y creación de usuario)
        
        if (class_exists('UserModel')) {
            $consulta = new UserModel();
            $mensaje = $consulta->createUser(
                // var_dump($_FILE);
                // Todos los parámetros, los opcionales pueden ir vacíos
                $id_tipo_persona_fk, $id_tipo_proponente_fk, $id_tipo_Documento_fk, 
                $numero_documento, $nombres, $apellidos, $genero_fk, 
                $vereda_centro_poblado, $direccion, $celular, $correo, $pass, 
                $nombre_representante, $tiempo_residencia, 
                $_FILES['anexo1_persona_natural'] ?? null, 
                $_FILES['anexo2_grupos_constituidos'] ?? null, 
                $_FILES['anexo3_persona_juridica'] ?? null, 
                $_FILES['copia_documento_identidad'] ?? null, 
                $_FILES['certificado_residencia'] ?? null, 
                $_FILES['copia_rut'] ?? null, 
                $_FILES['certificado_sicut'] ?? null, 
                $estado_anexo1, $estado_anexo2, $estado_anexo3, 
                $estado_copia_documento, $estado_certificado_residencia, 
                $estado_copia_rut, $estado_certificado_sicut
            );
        } else {
            $mensaje = "Error: La clase UserModel no está disponible.";
        }
    }
} else {
    $mensaje = "Acceso no autorizado. El formulario debe enviarse por POST.";
}

echo $mensaje;
?>