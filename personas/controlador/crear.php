<?php
require_once("../../config/db.php");
require_once("../modelo/userModel.php");

var_dump($_POST);
echo "<br> </br>";

// Verificar si se envió el formularioaaaaaxd
if (isset($_POST)) {
    // Obtener datos del formulario
    $id_tipo_persona_fk           = $_POST['id_tipo_persona_fk'];
    $id_tipo_proponente_fk        = $_POST['id_tipo_proponente_fk'];
    $id_tipo_Documento_fk         = $_POST['id_tipo_Documento_fk'];
    $numero_documento             = $_POST['numero_documento'];
    $nombres                      = $_POST['nombres'];
    $apellidos                    = $_POST['apellidos'];
    $genero_fk                    = $_POST['genero_fk'];
    $vereda_centro_poblado        = $_POST['vereda_centro_poblado'];
    $direccion                    = $_POST['direccion'];
    $celular                      = $_POST['celular'];
    $correo                       = $_POST['correo'];
    $pass                         = $_POST['pass']; 
    $nombre_representante         = $_POST['nombre_representante'];
    $tiempo_residencia            = $_POST['tiempo_residencia'];
    $estado_anexo1                = $_POST['estado_anexo1'];
    $estado_anexo2                = $_POST['estado_anexo2'];
    $estado_anexo3                = $_POST['estado_anexo3'];
    $estado_copia_documento       = $_POST['estado_copia_documento'];
    $estado_certificado_residencia= $_POST['estado_certificado_residencia'];
    $estado_copia_rut             = $_POST['estado_copia_rut'];
    $estado_certificado_sicut     = $_POST['estado_certificado_sicut'];

  
    // Verificar que todos los campos obligatorios estén llenos
    if (!empty($id_tipo_persona_fk) && !empty($id_tipo_proponente_fk) && !empty($id_tipo_Documento_fk) && !empty($numero_documento) && !empty($nombres) && !empty($apellidos) && !empty($genero_fk) && !empty($vereda_centro_poblado) && !empty($direccion) && !empty($celular) && !empty($correo) && !empty($pass) && !empty($nombre_representante) && !empty($tiempo_residencia) && !empty($estado_anexo1) && !empty($estado_anexo2) && !empty($estado_anexo3) && !empty($estado_copia_documento) && !empty($estado_certificado_residencia) && !empty($estado_copia_rut) && !empty($estado_certificado_sicut)) {

        // Directorio para guardar archivos subidos
        $upload_dir = "../../uploads/";

        // Crear el directorio si no existe
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Función para subir archivos
        function uploadFile($file, $upload_dir) {
            if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
                var_dump($file["name"]);
                echo "<br> </br>";
                $file_name = basename($file["name"]); // Obtener el nombre del archivo
                $file_tmp = $file["tmp_name"];
                $file_path = $upload_dir . $file_name;
                
                // Mover el archivo al directorio de subidas
                if (move_uploaded_file($file_tmp, $file_path)) {
                    return $file_name; // Retornar el nombre del archivo
                } else {
                    return null; // Retornar null si falla la subida
                }
            }
            return null; // Retornar null si no se subió el archivo
        }

        // Subir archivos y obtener sus nombres
        $anexo1_persona_natural = uploadFile($_FILES['anexo1_persona_natural'], $upload_dir);
        $anexo2_grupos_constituidos = uploadFile($_FILES['anexo2_grupos_constituidos'], $upload_dir);
        $anexo3_persona_juridica = uploadFile($_FILES['anexo3_persona_juridica'], $upload_dir);
        $copia_documento_identidad = uploadFile($_FILES['copia_documento_identidad'], $upload_dir);
        $certificado_residencia = uploadFile($_FILES['certificado_residencia'], $upload_dir);
        $copia_rut = uploadFile($_FILES['copia_rut'], $upload_dir);
        $certificado_sicut = uploadFile($_FILES['certificado_sicut'], $upload_dir);
        
        // Verificar si la clase UserModel está definida
        if (class_exists('UserModel')) {
            $consulta = new UserModel();
            // Llamar al método createUser con todos los datos, incluyendo los nombres de los archivos
            $mensaje = $consulta->createUser(
                $id_tipo_persona_fk, $id_tipo_proponente_fk, $id_tipo_Documento_fk, $numero_documento, $nombres, $apellidos, $genero_fk, $vereda_centro_poblado, $direccion, $celular, $correo, $pass, $nombre_representante, $tiempo_residencia, $anexo1_persona_natural, $anexo2_grupos_constituidos, $anexo3_persona_juridica, $copia_documento_identidad, $certificado_residencia, $copia_rut, $certificado_sicut, $estado_anexo1, $estado_anexo2, $estado_anexo3, $estado_copia_documento, $estado_certificado_residencia, $estado_certificado_sicut,$estado_copia_rut
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

echo $mensaje;
?>