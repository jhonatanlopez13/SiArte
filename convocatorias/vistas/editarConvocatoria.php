<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Convocatoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Editar Convocatoria</h1>

        <?php
        require_once '../controlador/convocatoriaController.php';
        
        $convocatoriaController = new ConvocatoriaController();
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        // Obtener los datos de la convocatoria
        $convocatoria = $convocatoriaController->obtenerConvocatoria($id);
        $programas = $convocatoriaController->listarProgramas();

        if (!$convocatoria) {
            echo '<div class="alert alert-danger">Convocatoria no encontrada</div>';
            echo '<a href="listaConvocatorias.php" class="btn btn-primary">Volver</a>';
            exit;
        }

        if ($programas === false) {
            echo '<div class="alert alert-danger">Error al cargar los programas</div>';
            echo '<a href="listaConvocatorias.php" class="btn btn-primary">Volver</a>';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre_convocatoria' => $_POST['nombre_convocatoria'],
                'descripcion' => $_POST['descripcion'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'id_programa' => $_POST['id_programa'],
                'cupos' => $_POST['cupos']
            ];
            
            $resultado = $convocatoriaController->editarConvocatoria($id, $datos);
            
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
        }
        ?>

        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nombre_convocatoria" class="form-label">Nombre de la Convocatoria:</label>
                <input type="text" class="form-control" id="nombre_convocatoria" name="nombre_convocatoria" 
                    value="<?php echo htmlspecialchars($convocatoria['nombre_convocatoria']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_programa" class="form-label">Programa:</label>
                <select class="form-select" id="id_programa" name="id_programa" required>
                    <option value="">Seleccione un programa</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['id_programa']; ?>" 
                                <?php echo ($programa['id_programa'] == $convocatoria['id_programa']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($programa['nombre_programa']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" 
                        rows="3" required><?php echo htmlspecialchars($convocatoria['descripcion']); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                        value="<?php echo htmlspecialchars($convocatoria['fecha_inicio']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                        value="<?php echo htmlspecialchars($convocatoria['fecha_fin']); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="cupos" class="form-label">Cupos Disponibles:</label>
                <input type="number" class="form-control" id="cupos" name="cupos" 
                    value="<?php echo htmlspecialchars($convocatoria['cupos']); ?>" min="1" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="listaConvocatorias.php" class="btn btn-secondary">Volver</a>
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