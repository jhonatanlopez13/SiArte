<?php
require_once("../../config/db.php");
require_once("../modelo/convocatoriaModel.php");



$nombre_convocatoria    =$_POST['nombre_convocatoria'];
$id_programa            =$_POST['id_programa'];
$descripcion            =$_POST['descripcion'];
$nombre_estado          =$_POST['nombre_estado'];
$id_estado_convocatoria =$_POST['id_estado_convocatoria'];
var_dump($_POST);

if (!empty($nombre_convocatoria) && !empty($id_programa) && !empty($descripcion) && !empty($nombre_estado) && !empty($id_estado_convocatoria)){

    $consulta = new ConvocatoriaModel();
    
    if(class_exists('crearConvocatoria')){
        $mensaje =$consulta->editarConvocatoria($nombre_convocatoria, $id_programa,$descripcion,$nombre_estado,$id_estado_convocatoria);
        
        if($mensaje ==="convocatoria actualizada corectamente"){
            header("location:../vistas/listaConvocatoria.php");
            exit;
        }
    }else{
        $mensaje="La clase UserModel no está definida. Verifica la inclusión del archivo.";
    }
}else {
    $mensaje = "Acceso no autorizado.";
}