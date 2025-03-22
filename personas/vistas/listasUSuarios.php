<?php
require_once '../modelo/userModel.php';

function Cargar() {
    $consultas = new UserModel();
    $filas = $consultas->CargarUsuario();
    if ($filas == null) {
        $filas = [];
    }
    return $filas; // Devolver el valor de $filas
}

// Llamar a la función Cargar() y asignar su valor a $filas
$filas = Cargar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Listado de usuarios</h1>
        <a href='./crear.php' class="btn btn-info">crear usuarios</a>
        <div class="mb-3">
            <input type="text" id="buscador" class="form-control" placeholder="Buscar usuario...">
        </div>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Número de documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($filas)): ?>
                    <?php foreach($filas as $fila): ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo $fila['numero_documento']; ?></td>
                            <td><?php echo $fila['nombres']; ?></td>
                            <td><?php echo $fila['apellidos']; ?></td>
                            <td><?php echo $fila['celular']; ?></td>
                            <td><?php echo $fila['correo']; ?></td>
                            <td><?php echo $fila['direccion']; ?></td>
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

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para el buscador -->
    <script>
        function filtrarTabla() {
            const input = document.getElementById('buscador');
            const filter = input.value.toUpperCase();
            const table = document.querySelector('table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let mostrarFila = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const text = cell.textContent || cell.innerText;
                        if (text.toUpperCase().indexOf(filter) > -1) {
                            mostrarFila = true;
                            break;
                        }
                    }
                }

                if (mostrarFila) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        document.getElementById('buscador').addEventListener('input', filtrarTabla);
    </script>
</body>
</html>