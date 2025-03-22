<?php
require_once '../controlador/convocatoriaController.php';

$convocatoriaController = new ConvocatoriaController();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

if (empty($id) || !in_array($estado, [0, 1])) {
    echo '<script>
        alert("Parámetros inválidos");
        window.location.href = "listaConvocatorias.php";
    </script>';
    exit;
}

$resultado = $convocatoriaController->cambiarEstado($id, $estado);

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