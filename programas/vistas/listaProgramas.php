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
    <title>Listar Programas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Programas</h1>
            <a href="crearProgramas.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Programa
            </a>
        </div>

        <!-- Buscador -->
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       class="form-control" 
                       id="buscadorProgramas" 
                       placeholder="Buscar programas..."
                       onkeyup="buscarProgramas()">
            </div>
        </div>

        <?php
        require_once '../controlador/programaController.php';
        $programaController = new ProgramaController();
        
        $programas = $programaController->listarProgramas();

        if ($programas === false) {
            echo '<div class="alert alert-danger">Error al cargar los programas</div>';
        } else if (empty($programas)) {
            echo '<div class="alert alert-info">No hay programas registrados</div>';
        } else {
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaProgramas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($programas as $programa): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($programa['id_programa']); ?></td>
                        <td><?php echo htmlspecialchars($programa['nombre_programa']); ?></td>
                        <td><?php echo htmlspecialchars($programa['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($programa['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($programa['fecha_fin']); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="editarProgramas.php?id=<?php echo $programa['id_programa']; ?>" 
                                   class="btn btn-sm btn-warning" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="confirmarEliminacion(<?php echo $programa['id_programa']; ?>)"
                                        title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

        <!-- Modal de confirmación de eliminación -->
        <div class="modal fade" id="modalEliminar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de que desea eliminar este programa?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let programaId = null;
        const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));

        function confirmarEliminacion(id) {
            programaId = id;
            modalEliminar.show();
        }

        document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
            if (programaId) {
                window.location.href = `eliminarProgramas.php?id=${programaId}`;
            }
        });

        // Función de búsqueda en tiempo real
        function buscarProgramas() {
            const buscador = document.getElementById('buscadorProgramas');
            const textoBusqueda = buscador.value.toLowerCase();
            const tabla = document.getElementById('tablaProgramas');
            const filas = tabla.getElementsByTagName('tr');

            // Ocultar todas las filas excepto el encabezado
            for (let i = 1; i < filas.length; i++) {
                const fila = filas[i];
                const nombre = fila.getElementsByTagName('td')[1].textContent.toLowerCase();
                const descripcion = fila.getElementsByTagName('td')[2].textContent.toLowerCase();
                const fechaInicio = fila.getElementsByTagName('td')[3].textContent.toLowerCase();
                const fechaFin = fila.getElementsByTagName('td')[4].textContent.toLowerCase();

                // Buscar en todos los campos
                if (nombre.includes(textoBusqueda) ||
                    descripcion.includes(textoBusqueda) ||
                    fechaInicio.includes(textoBusqueda) ||
                    fechaFin.includes(textoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            }

            // Mostrar mensaje si no hay resultados
            const filasVisibles = Array.from(filas).slice(1).filter(fila => fila.style.display !== 'none');
            const mensajeNoResultados = document.getElementById('mensajeNoResultados');
            
            if (filasVisibles.length === 0) {
                if (!mensajeNoResultados) {
                    const mensaje = document.createElement('div');
                    mensaje.id = 'mensajeNoResultados';
                    mensaje.className = 'alert alert-info mt-3';
                    mensaje.textContent = 'No se encontraron programas que coincidan con la búsqueda';
                    tabla.parentNode.insertBefore(mensaje, tabla.nextSibling);
                }
            } else if (mensajeNoResultados) {
                mensajeNoResultados.remove();
            }
        }
    </script>
</body>
</html>