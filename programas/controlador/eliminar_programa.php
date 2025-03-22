<?php
require_once '../modelo/programaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $programaModel = new ProgramaModel();
    $id = $_GET['id'];
    
    if ($programaModel->eliminarPrograma($id)) {
        echo '<script>
            alert("Programa eliminado exitosamente");
            window.location.href = "../../index.php";
        </script>';
    } else {
        echo '<script>
            alert("Error al eliminar el programa");
            window.history.back();
        </script>';
    }
} else {
    header('Location: ../../index.php');
} 