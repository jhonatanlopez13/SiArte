<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Convocatoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Crear Nueva Convocatoria</h1>

        <?php
        require_once '../controlador/convocatoriaController.php';
        $convocatoriaController = new ConvocatoriaController();
        $programas = $convocatoriaController->listarProgramas();

        // if ($programas === false) {
        //     echo '<div class="alert alert-danger">Error al cargar los programas</div>';
        //     echo '<a href="listaConvocatorias.php" class="btn btn-primary">Volver</a>';
        //     exit;
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que todos los campos estén presentes
            if (empty($_POST['nombre_convocatoria']) || empty($_POST['id_programa']) || 
                empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin']) || 
                empty($_POST['cupos'])) {
                echo '<div class="alert alert-danger">Todos los campos son obligatorios</div>';
            } else {
                $datos = [
                    'nombre_convocatoria' => trim($_POST['nombre_convocatoria']),
                    'descripcion' => trim($_POST['descripcion']),
                    'fecha_inicio' => $_POST['fecha_inicio'],
                    'fecha_fin' => $_POST['fecha_fin'],
                    'id_programa' => $_POST['id_programa'],
                    'cupos' => (int)$_POST['cupos']
                ];
                
                $resultado = $convocatoriaController->crearConvocatoria($datos);
                
                if ($resultado['success']) {
                    echo '<script>
                        alert("' . $resultado['message'] . '");
                        window.location.href = "listaConvocatorias.php";
                    </script>';
                } else {
                    echo '<div class="alert alert-danger">' . $resultado['message'] . '</div>';
                }
            }
        }
        ?>

        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nombre_convocatoria" class="form-label">Nombre de la Convocatoria:</label>
                <input type="text" class="form-control" id="nombre_convocatoria" name="nombre_convocatoria" required>
            </div>

            <div class="mb-3">
                <label for="id_programa" class="form-label">Programa:</label>
                <select class="form-select" id="id_programa" name="id_programa" required onchange="actualizarFechasPrograma()">
                    <option value="">Seleccione un programa</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['id_programa']; ?>" 
                                data-fecha-inicio="<?php echo $programa['fecha_inicio']; ?>"
                                data-fecha-fin="<?php echo $programa['fecha_fin']; ?>">
                            <?php echo htmlspecialchars($programa['nombre_programa']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="fechasPrograma" class="form-text text-muted"></div>
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

            <div class="mb-3">
                <label for="cupos" class="form-label">Cupos Disponibles:</label>
                <input type="number" class="form-control" id="cupos" name="cupos" min="1" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Crear Convocatoria</button>
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

        // Establecer fecha mínima para fecha_inicio como hoy
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha_inicio').min = today;

        function actualizarFechasPrograma() {
            const selectPrograma = document.getElementById('id_programa');
            const fechasPrograma = document.getElementById('fechasPrograma');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            
            if (selectPrograma.value) {
                const option = selectPrograma.options[selectPrograma.selectedIndex];
                const fechaInicioPrograma = option.dataset.fechaInicio;
                const fechaFinPrograma = option.dataset.fechaFin;
                
                fechasPrograma.textContent = `Período del programa: ${formatearFecha(fechaInicioPrograma)} - ${formatearFecha(fechaFinPrograma)}`;
                
                // Establecer límites de fechas
                fechaInicio.min = fechaInicioPrograma;
                fechaInicio.max = fechaFinPrograma;
                fechaFin.min = fechaInicioPrograma;
                fechaFin.max = fechaFinPrograma;
                
                // Validar fechas actuales
                validarFechas();
            } else {
                fechasPrograma.textContent = '';
                fechaInicio.min = '';
                fechaInicio.max = '';
                fechaFin.min = '';
                fechaFin.max = '';
            }
        }

        function formatearFecha(fecha) {
            return new Date(fecha).toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function validarFechas() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            
            if (fechaInicio.value && fechaFin.value) {
                if (fechaFin.value < fechaInicio.value) {
                    alert('La fecha de fin no puede ser anterior a la fecha de inicio');
                    fechaFin.value = fechaInicio.value;
                }
            }
        }

        // Agregar event listeners
        document.getElementById('fecha_inicio').addEventListener('change', validarFechas);
        document.getElementById('fecha_fin').addEventListener('change', validarFechas);
        document.getElementById('id_programa').addEventListener('change', actualizarFechasPrograma);

        // Inicializar fechas si hay un programa seleccionado
        if (document.getElementById('id_programa').value) {
            actualizarFechasPrograma();
        }
    </script>
</body>
</html> 