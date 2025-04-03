<?php
require_once '../modelo/programaModel.php';

// Obtener el ID del programa
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Si no hay ID, redirigir a la lista
if (empty($id)) {
    header("Location: ../vistas/listaProgramas.php");
    exit;
}

// Crear instancia del modelo
$programaModel = new ProgramaModel();

// Obtener datos del programa
$programa = $programaModel->obtenerPrograma($id);

// Si no se encuentra el programa, redirigir a la lista
if (!$programa) {
    echo "<script>
        alert('Programa no encontrado');
        window.location.href = '../vistas/listaProgramas.php';
    </script>";
    exit;
}

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    // Si no es POST, mostrar el formulario con los datos del programa
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Programa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Editar Programa</h2>
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="nombre_programa" class="form-label">Nombre del Programa</label>
                    <input type="text" class="form-control" id="nombre_programa" name="nombre_programa" 
                           value="<?php echo htmlspecialchars($programa['nombre_programa']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($programa['descripcion']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                           value="<?php echo date('Y-m-d', strtotime($programa['fecha_inicio'])); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                           value="<?php echo date('Y-m-d', strtotime($programa['fecha_fin'])); ?>" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Actualizar Programa</button>
                    <a href="../vistas/listaProgramas.php" class="btn btn-secondary">Cancelar</a>
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
                    this.value = fechaInicio;
                }
            });
        </script>
    </body>
    </html>
    <?php
}
?>