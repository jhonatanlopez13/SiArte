<?php
require_once("../modelo/convocatoriaModel.php");

if(isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];
    
    // Validar que el estado sea 0 o 1
    if($estado != 0 && $estado != 1) {
        echo '<script>
            alert("Estado no válido");
            window.location.href = "../vistas/listaConvocatorias.php";
        </script>';
        exit;
    }
    
    $ConvocatoriaModel = new ConvocatoriaModel();
    
    if($ConvocatoriaModel->cambiarEstado($id, $estado)) {
        echo '<script>
            alert("Estado de la convocatoria actualizado correctamente");
            window.location.href = "../vistas/listaConvocatorias.php";
        </script>';
    } else {
        echo '<script>
            alert("Error al actualizar el estado de la convocatoria");
            window.location.href = "../vistas/listaConvocatorias.php";
        </script>';
    }
} else {
    header('Location: ../vistas/listaConvocatorias.php');
}
?> 