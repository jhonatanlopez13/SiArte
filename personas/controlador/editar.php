<?php
require_once("../../config/db.php");
require_once("../modelo/userModel.php");

// Habilitar mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que el formulario tenga enctype multipart/form-data
    if (empty($_FILES)) {
        die("No se recibieron archivos. Verifica el formulario.");
    }

    // Obtener todos los datos del formulario
    $id_persona = $_POST['id_persona'] ?? null;
    if (empty($id_persona)) {
        die("ID de persona no válido");
    }

    // Crear ruta para documentos de la persona
    $ruta_carpeta = '../../ARCHIVOS/'.$id_persona;
    if(!file_exists($ruta_carpeta)) {
        if (!mkdir($ruta_carpeta, 0777, true)) {
            die("No se pudo crear el directorio para los archivos");
        }
    }

    function uploadFile($file, $upload_dir) {
        // Verificar si el archivo fue subido correctamente
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validar tipo de archivo
        $allowed_types = ['application/pdf'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            return null;
        }

        // Generar nombre único para el archivo
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_ext;
        $file_path = $upload_dir . '/' . $file_name;
        
        // Mover el archivo al directorio de subidas
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return $file_name;
        }

        return null;
    }

    // Subir archivos y obtener sus nombres
    $archivos_subidos = [
        'anexo1_persona_natural' => null,
        'anexo2_grupos_constituidos' => null,
        'anexo3_persona_juridica' => null,
        'copia_documento_identidad' => null,
        'certificado_residencia' => null,
        'copia_rut' => null,
        'certificado_sicut' => null
    ];

    foreach ($archivos_subidos as $campo => $valor) {
        if (!empty($_FILES[$campo]['name'])) {
            $archivos_subidos[$campo] = uploadFile($_FILES[$campo], $ruta_carpeta);
            if ($archivos_subidos[$campo] === null) {
                die("Error al subir el archivo $campo. Asegúrate de que sea un PDF válido.");
            }
        }
    }

    // Obtener otros datos del formulario
    $id_tipo_proponente_fk = $_POST['id_tipo_proponente_fk'] ?? null;
    $numero_documento = $_POST['numero_documento'] ?? null;
    $nombres = $_POST['nombres'] ?? null;
    $apellidos = $_POST['apellidos'] ?? null;
    $genero_fk = $_POST['genero_fk'] ?? null;
    $id_vereda_fk = $_POST['id_vereda_fk'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $celular = $_POST['celular'] ?? null;
    $nombre_representante = $_POST['nombre_representante'] ?? null;
    $documento_representante = $_POST['documento_representante'] ?? null;
    $tiempo_residencia = $_POST['tiempo_residencia'] ?? null;

    // Verificar campos obligatorios
    $camposObligatorios = [
        'id_persona' => $id_persona,
        'id_tipo_proponente_fk' => $id_tipo_proponente_fk,
        'numero_documento' => $numero_documento,
        'direccion' => $direccion,
        'celular' => $celular,
        'id_vereda_fk' => $id_vereda_fk
    ];

    // Campos condicionales según tipo de proponente
    if ($id_tipo_proponente_fk == '1') { // Persona Natural
        $camposObligatorios['nombres'] = $nombres;
        $camposObligatorios['apellidos'] = $apellidos;
        $camposObligatorios['genero_fk'] = $genero_fk;
    } elseif ($id_tipo_proponente_fk == '2') { // Grupo Constituido
        $camposObligatorios['nombre_representante'] = $nombre_representante;
        $camposObligatorios['documento_representante'] = $documento_representante;
    } elseif ($id_tipo_proponente_fk == '3') { // Persona Jurídica
        $camposObligatorios['nombre_representante'] = $nombre_representante;
    }

    // Verificar campos vacíos
    $camposVacios = array_filter($camposObligatorios, function($campo) {
        return empty($campo);
    });

    if (empty($camposVacios)) {
        if (class_exists('UserModel')) {
            $consulta = new UserModel();
            
            // Llamar al método modificarUsuario con todos los datos
            $mensaje = $consulta->modificarUsuario(
                $id_persona,
                $id_tipo_proponente_fk,
                $numero_documento,
                $nombres,
                $apellidos,
                $genero_fk,
                $id_vereda_fk,
                $direccion,
                $celular,
                $nombre_representante,
                $documento_representante,
                $tiempo_residencia,
                $archivos_subidos
            );
            
            if (strpos($mensaje, 'correctamente') !== false) {
                // Para depuración, mostrar información
                echo "<pre>";
                echo "Proceso exitoso. Archivos subidos:\n";
                print_r($archivos_subidos);
                echo "</pre>";
                
                // En producción, redirigir
             header("Location: ../vistas/vistaUsuario.php?success=1");
                exit;
            } else {
                die("Error al actualizar: " . $mensaje);
            }
        } else {
            die("La clase UserModel no está definida. Verifica la inclusión del archivo.");
        }
    } else {
        die("Por favor, completa todos los campos obligatorios. Faltan: " . implode(', ', array_keys($camposVacios)));
    }
} else {
    die("Acceso no autorizado.");
}
?>