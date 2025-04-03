<?php
require_once("../../config/db.php");
require_once("../modelo/proyectoModel.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
//   $id_proyecto =$_POST['id_proyecto'];
  $id_programa_fk =$_POST['id_programa_fk'];
  $titulo =$_POST['titulo'];
  $objetivo_general =$_POST['objetivo_general'];
  $productos =$_POST['productos'];
  $comentarios =$_POST['comentarios'];
  $id_programa_fk =$_POST['id_programa_fk'];
  $productos_servicios =$_POST['productos_servicios'];
  $archivo_formato_presentacion =$_POST['archivo_formato_presentacion'];
  $archivo_presupuesto =$_POST['archivo_presupuesto'];
  $archivo_cronograma =$_POST['archivo_cronograma'];
  $archivo_soportes_experiencia =$_POST['archivo_soportes_experiencia'];
  $archivo_documentos_adicionales =$_POST['archivo_documentos_adicionales'];
  $id_estado_proceso_fk =$_POST['id_estado_proceso_fk'];
  $fecha_cambio_estado =$_POST['fecha_cambio_estado'];
  $id_usuario_cambio =$_POST['id_usuario_cambio'];
  $id_area_fk =$_POST['id_area_fk'];

    
    $ruta_carpeta = '../../ARCHIVOS/PROYECTOS/DOCUMENTOSPROYECTO'.$id_persona_fk ;
    if(!file_exists($ruta_carpeta)) {
        if (!mkdir($ruta_carpeta, 0777, true)) {
            die("No se pudo crear el directorio para los archivos");
        }
    }
    // Manejo de archivos (verificar si se subieron)
    $archivo_formato_presentacion = $_FILES['archivo_formato_presentacion'] ?? null;
    $archivo_presupuesto = $_FILES['archivo_presupuesto'] ?? null;
    $archivo_cronograma = $_FILES['archivo_cronograma'] ?? null;
    $archivo_soportes_experiencia = $_FILES['archivo_soportes_experiencia'] ?? null;
    $archivo_documentos_adicionales = $_FILES['archivo_documentos_adicionales'] ?? null;
     "Acceso no autorizado. El formulario debe enviarse por POST.";
}

?>