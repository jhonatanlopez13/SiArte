<?php

// session_start();
// if($_SESSION['PERFIL']=='admin')
// {

// }else
// {
//     header('Location: ../../index.php');
// }
?>


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
        <h1 class="text-center mb-4">Crear Nueva Convocatoria <?php echo $_SESSION['NOMBRE'] ?></h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
                <label for="nombre_convocatoria" class="form-label">id persona:</label>
                <input type="text" class="form-control" id="id_persona" name="id_persona" 
                       value="<?php echo $_SESSION['ID'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre_convocatoria" class="form-label">Nombre de la Convocatoria:</label>
                <input type="text" class="form-control" id="nombre_convocatoria" name="nombre_convocatoria" 
                       value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_programa" class="form-label">Programa:</label>
                <select class="form-select" id="id_programa" name="id_programa" required>
                    <option value="">Seleccione un programa</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['id_programa']; ?>" 
                                data-fecha-inicio="<?php echo $programa['fecha_inicio']; ?>"
                                data-fecha-fin="<?php echo $programa['fecha_fin']; ?>"
                                <?php echo (isset($id_programa) && $id_programa == $programa['id_programa']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($programa['nombre_programa']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="fechasPrograma" class="form-text text-muted"></div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php 
                    echo isset($descripcion) ? htmlspecialchars($descripcion) : ''; 
                ?></textarea>
            </div>

            <div class="mb-3">
                <label for="id_estado_convocatoria" class="form-label">Estado de la Convocatoria:</label>
                <select class="form-select" id="id_estado_convocatoria" name="id_estado_convocatoria" required>
                    <option value="">Seleccione un estado</option>
                    <?php foreach ($estados_convocatoria as $estado): ?>
                        <option value="<?php echo $estado['id']; ?>"
                                <?php echo (isset($id_estado) && $id_estado == $estado['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($estado['nombre_estado']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Crear Convocatoria</button>
                <a href="listar_convocatorias.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>