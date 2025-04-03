<?php
require_once '../modelo/programaModel.php';

var_dump($_POST);
echo "<br> </br>";

if (isset($_POST)){
    $nombre_programa  = $_POST['nombre_programa'];
    $descripcion      = $_POST['descripcion'];
    $fecha_inicio     = $_POST['fecha_inicio'];
    $fecha_fin        = $_POST['fecha_fin'];

    if(!empty($nombre_programa) && !empty($descripcion) && !empty($fecha_inicio) && !empty($fecha_fin)){
        if(class_exists('ProgramaModel')){
            $consulta =new ProgramaModel();
            $mensaje =$consulta->crearPrograma($nombre_programa,$descripcion,$fecha_inicio,$fecha_fin);
        }else{
            $mensaje = "La clase UserModel no está definida. Verifica la inclusión del archivo.";
        }
    }else{
        $mensaje = "Por favor, completa todos los campos obligatorios.";
    }

} else {
    $mensaje = "Acceso no autorizado.";
}

?>