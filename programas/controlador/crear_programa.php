<?php
require_once '../modelo/programaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programaModel = new ProgramaModel();
    
    // Recoger datos del formulario
    $datos = [
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion'],
        'fecha_inicio' => $_POST['fecha_inicio'],
        'fecha_fin' => $_POST['fecha_fin'],
        'cupos' => $_POST['cupos']
    ];

    if ($programaModel->crearPrograma($datos)) {
        echo '<script>
            alert("Programa creado exitosamente");
            window.location.href = "../../index.php";
        </script>';
    } else {
        echo '<script>
            alert("Error al crear el programa");
            window.history.back();
        </script>';
    }
} else {
    header('Location: ../../index.php');
} 