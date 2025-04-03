<?php
require_once '../modelo/programaModel.php';

// Verificar si se recibió el ID
if (!isset($_GET['id'])) {
    echo '<script>
        alert("ID de programa no proporcionado");
        window.location.href = "../vistas/listaProgramas.php";
    </script>';
    exit;
}

$id = $_GET['id'];

// Crear instancia del modelo
$programaModel = new ProgramaModel();

// Intentar eliminar el programa
$resultado = $programaModel->eliminarPrograma($id);

if ($resultado['success']) {
    echo '<script>
        alert("' . $resultado['message'] . '");
        window.location.href = "../vistas/listaProgramas.php";
    </script>';
} else {
    echo '<script>
        alert("' . $resultado['message'] . '");
        window.location.href = "../vistas/listaProgramas.php";
    </script>';
}
?> 