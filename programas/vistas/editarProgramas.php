<?php
require_once '../../personas/controlador/login.php';
session_start();
if($_SESSION['PERFIL']=='admin')
{

}else
{
    header('Location: ../../index.php');
}
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
        <h1 class="text-center mb-4">Editar Programa</h1>

        <?php
        require_once '../modelo/programaModel.php';
        
        
        $programaModel = new ProgramaModel();
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        // Obtener los datos del programa
        $programa = $programaModel->obtenerPrograma($id);

        if ($programa) {
            echo '<div class="alert alert-danger">Programa no encontrado</div>';
            echo '<a href="listaProgramas.php" class="btn btn-primary">Volver</a>';
            exit;
        }

              'nombre_programa' => $_POST['nombre_programa'],
         
        ?>

        <form action="../controlador/editar_programa.php?id=<?php echo $id; ?>" method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nombre_programa" class="form-label">Nombre del Programa:</label>
                <input type="text" class="form-control" id="nombre_programa" name="nombre_programa" 
                    value="<?php echo isset($programa['nombre_programa']) ? htmlspecialchars($programa['nombre_programa']) : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" 
                        rows="3" required><?php echo isset($programa['descripcion']) ? htmlspecialchars($programa['descripcion']) : ''; ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                        value="<?php echo isset($programa['fecha_inicio']) ? htmlspecialchars($programa['fecha_inicio']) : ''; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                        value="<?php echo isset($programa['fecha_fin']) ? htmlspecialchars($programa['fecha_fin']) : ''; ?>" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="listaProgramas.php" class="btn btn-secondary">Volver</a>
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