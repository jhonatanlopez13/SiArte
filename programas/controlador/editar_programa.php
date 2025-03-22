<?php
require_once '../modelo/programaModel.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del programa
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    
    // Obtener y validar los datos del formulario
    $nombre_programa = isset($_POST['nombre_programa']) ? trim($_POST['nombre_programa']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $fecha_inicio = isset($_POST['fecha_inicio']) ? trim($_POST['fecha_inicio']) : '';
    $fecha_fin = isset($_POST['fecha_fin']) ? trim($_POST['fecha_fin']) : '';

    // Validar que todos los campos estén llenos
    if (empty($nombre_programa) || empty($descripcion) || empty($fecha_inicio) || empty($fecha_fin)) {
        echo "<script>
            alert('Por favor, completa todos los campos obligatorios.');
            window.history.back();
        </script>";
        exit;
    }

    // Validar que la fecha de fin no sea anterior a la fecha de inicio
    if ($fecha_fin < $fecha_inicio) {
        echo "<script>
            alert('La fecha de fin no puede ser anterior a la fecha de inicio.');
            window.history.back();
        </script>";
        exit;
    }

    try {
        // Crear instancia del modelo
        $programaModel = new ProgramaModel();

        // Intentar editar el programa
        $resultado = $programaModel->editarPrograma($id, $nombre_programa, $descripcion, $fecha_inicio, $fecha_fin);

        if ($resultado['success']) {
            echo "<script>
                alert('Programa actualizado correctamente');
                window.location.href = '../vistas/listaProgramas.php';
            </script>";
        } else {
            echo "<script>
                alert('" . $resultado['message'] . "');
                window.history.back();
            </script>";
        }
    } catch (Exception $e) {
        echo "<script>
            alert('Error al actualizar el programa: " . $e->getMessage() . "');
            window.history.back();
        </script>";
    }
} else {
    // Si no es POST, redirigir a la lista de programas
    header("Location: ../vistas/listaProgramas.php");
    exit;
}
?>