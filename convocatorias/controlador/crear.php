<?php
require_once("../modelo/convocatoriaModel.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $ConvocatoriaModel = new ConvocatoriaModel();
   
    // Get individual values from POST
    $id_persona_fk =$_POST['id_persona_fk'];
    $nombre_convocatoria = $_POST['nombre_convocatoria'];
    $id_programa = $_POST['id_programa'];
    $descripcion = $_POST['descripcion'];
    $estado_convocatoria = $_POST['estado_convocatoria'];

    // Call the method with separate parameters
    if($ConvocatoriaModel->crearConvocatoria($id_persona_fk, $nombre_convocatoria, $id_programa, $descripcion, $estado_convocatoria)){
        echo '<script>
            alert("Convocatoria creada exitosamente");
            window.location.href = "../convocatoria/listaConvocatorias.php";
        </script>';
    } else {
        echo '<script>
            alert("Error al crear la convocatoria");
            window.history.back();
        </script>';
    }
} else {
    header('Location: ../convocatoria/listaConvocatorias.php');
}
?>