<?php
require_once '../controlador/convocatoriaController.php';

$convocatoriaController = new ConvocatoriaController();
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id)) {
    echo '<script>
        alert("ID de convocatoria no proporcionado");
        window.location.href = "listaConvocatorias.php";
    </script>';
    exit;
}

$resultado = $convocatoriaController->eliminarConvocatoria($id);

if ($resultado['success']) {
    echo '<script>
        alert("' . $resultado['message'] . '");
        window.location.href = "listaConvocatorias.php";
    </script>';
} else {
    echo '<script>
        alert("' . $resultado['message'] . '");
        window.history.back();
    </script>';
} 