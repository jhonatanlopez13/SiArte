<?php
require_once '../controlador/programaController.php';

$programaController = new ProgramaController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $programaController->crearPrograma(
        $_POST['nombre_programa'],
        $_POST['descripcion'],
        $_POST['fecha_inicio'],
        $_POST['fecha_fin']
    );

    if ($resultado['success']) {
        echo '<script>
            alert("' . $resultado['message'] . '");
            window.location.href = "listarProgramas.php";
        </script>';
    } else {
        echo '<script>
            alert("' . $resultado['message'] . '");
            window.history.back();
        </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Programa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Crear Nuevo Programa</h1>

        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nombre_programa" class="form-label">Nombre del Programa:</label>
                <input type="text" class="form-control" id="nombre_programa" name="nombre_programa" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Crear Programa</button>
                <a href="listarProgramas.php" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación del formulario
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Validación de fechas
        document.getElementById('fecha_fin').addEventListener('change', function() {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = this.value;
            
            if (fechaFin < fechaInicio) {
                alert('La fecha de fin no puede ser anterior a la fecha de inicio');
                this.value = '';
            }
        });
    </script>
</body>
</html>