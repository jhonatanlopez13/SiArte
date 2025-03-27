<?php
require_once '../modelo/convocatoriaModel.php';

function Cargar() {
    $consultas = new ConvocatoriaModel();
    $filas = $consultas->listarConvocatorias();
    if ($filas == null) {
        $filas = [];
    }
    return $filas; // Devolver el valor de $filasasdasdasdasdds
}

// Llamar a la función Cargar() y asignar su valor a $filasasdasd
$filas = Cargar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Convocatorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Convocatorias</h1>
            <a href="crearConvocatoria.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Convocatoria
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
                       id="buscadorConvocatorias" 
                       placeholder="Buscar convocatorias..."
                       onkeyup="buscarConvocatorias()">
            </div>
        </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tablaConvocatorias">
                    <thead>
                        <tr>
                            <th>id_detalle</th>
                            <th>nombre_programa</th>
                            <th>nombres</th>
                            <th>apellidos</th>
                            <th>convocatoria_estado</th>
                            <th>convocatoria_estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($filas)): ?>
                            <?php foreach($filas as $fila): ?>
                                <tr>
                                    <td><?php echo $fila['id_detalle']; ?></td>
                                    <td><?php echo $fila['nombre_programa']; ?></td>
                                    <td><?php echo $fila['nombres']; ?></td>
                                    <td><?php echo $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['convocatoria_estado']; ?></td>
                                    <td><?php echo $fila['convocatoria_estado']; ?></td>
                                    <td>
                                        <a href='../controlador/eliminar.php?id=<?php echo $fila['id']; ?>' class="btn btn-danger btn-sm">Eliminar</a>
                                        <a href='./editar.php?id=<?php echo $fila['id']; ?>' class="btn btn-primary btn-sm">Editar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar esta convocatoria?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let convocatoriaId = null;
        const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));

        function confirmarEliminacion(id) {
            convocatoriaId = id;
            modalEliminar.show();
        }

        document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
            if (convocatoriaId) {
                window.location.href = `eliminarConvocatoria.php?id=${convocatoriaId}`;
            }
        });

        // Función de búsqueda en tiempo real
        function buscarConvocatorias() {
            const buscador = document.getElementById('buscadorConvocatorias');
            const textoBusqueda = buscador.value.toLowerCase();
            const tabla = document.getElementById('tablaConvocatorias');
            const filas = tabla.getElementsByTagName('tr');

            // Ocultar todas las filas excepto el encabezado
            for (let i = 1; i < filas.length; i++) {
                const fila = filas[i];
                const nombre = fila.getElementsByTagName('td')[0].textContent.toLowerCase();
                const programa = fila.getElementsByTagName('td')[1].textContent.toLowerCase();
                const fechaInicio = fila.getElementsByTagName('td')[2].textContent.toLowerCase();
                const fechaFin = fila.getElementsByTagName('td')[3].textContent.toLowerCase();
                const cupos = fila.getElementsByTagName('td')[4].textContent.toLowerCase();

                // Buscar en todos los campos
                if (nombre.includes(textoBusqueda) ||
                    programa.includes(textoBusqueda) ||
                    fechaInicio.includes(textoBusqueda) ||
                    fechaFin.includes(textoBusqueda) ||
                    cupos.includes(textoBusqueda)) {
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
                    mensaje.textContent = 'No se encontraron convocatorias que coincidan con la búsqueda';
                    tabla.parentNode.insertBefore(mensaje, tabla.nextSibling);
                }
            } else if (mensajeNoResultados) {
                mensajeNoResultados.remove();
            }
        }

        function cambiarEstado(id, estadoActual) {
            if (confirm('¿Está seguro de que desea ' + (estadoActual == 1 ? 'desactivar' : 'activar') + ' esta convocatoria?')) {
                window.location.href = `cambiarEstado.php?id=${id}&estado=${estadoActual == 1 ? 0 : 1}`;
            }
        }
    </script>
</body>
</html> 