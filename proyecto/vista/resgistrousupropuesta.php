<?php
// Incluir la conexión a la base de datos
include_once '../../config/db.php';

session_start();
if($_SESSION['PERFIL']!='aspirante') {
    header('Location: ../../index.php');
    exit();
}

$conectarDB = new Conexion();
$conn = $conectarDB->get_conexion();

if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Consultar datos necesarios para los selects
try {
    // Tipos de proponente
    $query_tipos_proponente = "SELECT id, nombre FROM tipo_proponente";
    $stmt_tipos_proponente = $conn->prepare($query_tipos_proponente);
    $stmt_tipos_proponente->execute();
    $tipos_proponente = $stmt_tipos_proponente->fetchAll(PDO::FETCH_ASSOC);
    // programas
    $query_tipos_programas = "SELECT* FROM programas";
    $stmt_tipos_programas = $conn->prepare($query_tipos_programas);
    $stmt_tipos_programas->execute();
    $tipos_programas = $stmt_tipos_programas->fetchAll(PDO::FETCH_ASSOC);



    // Tipos de documento
    $query_tipos_documento = "SELECT id, tipoDocumento FROM tipo_documento";
    $stmt_tipos_documento = $conn->prepare($query_tipos_documento);
    $stmt_tipos_documento->execute();
    $tipos_documento = $stmt_tipos_documento->fetchAll(PDO::FETCH_ASSOC);

    // Géneros
    $query_generos = "SELECT id, nombre_Genero FROM genero";
    $stmt_generos = $conn->prepare($query_generos);
    $stmt_generos->execute();
    $generos = $stmt_generos->fetchAll(PDO::FETCH_ASSOC);

    // Tipos de estímulo
    $query_tipos_estimulo = "SELECT id, `nombre de estimulo` FROM tipo_estimulo";
    $stmt_tipos_estimulo = $conn->prepare($query_tipos_estimulo);
    $stmt_tipos_estimulo->execute();
    $tipos_estimulo = $stmt_tipos_estimulo->fetchAll(PDO::FETCH_ASSOC);

    // Áreas IMCTT (asumo que necesitas crear esta tabla)
    $query_areas_imctt = "SELECT * FROM area";
    $stmt_areas_imctt = $conn->prepare($query_areas_imctt);
    $stmt_areas_imctt->execute();
    $areas_imctt = $stmt_areas_imctt->fetchAll(PDO::FETCH_ASSOC);

    // Categorías generales
    $query_categorias = "SELECT id_categoria, nombreCategoria FROM categoria";
    $stmt_categorias = $conn->prepare($query_categorias);
    $stmt_categorias->execute();
    $categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

    // Líneas de trabajo (asumo que necesitas crear esta tabla)
    $query_lineas_trabajo = "SELECT *FROM subcategoria";
    $stmt_lineas_trabajo = $conn->prepare($query_lineas_trabajo);
    $stmt_lineas_trabajo->execute();
    $lineas_trabajo = $stmt_lineas_trabajo->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al obtener datos de la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Propuesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        textarea.form-control {
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Formulario de propuestas - Documentos técnicos para evaluación</h1>
       
        <form action="../controlador/crear.php" method="POST" enctype="multipart/form-data">
             <!-- Nombre del proyecto -->
           

            <!-- Nombre del estímulo -->
            <div class="mb-3">
                <label for="tipo_estimulo" class="form-label">Nombre del estímulo y campo estratégico al que pertenece:</label>
                <select class="form-select" id="id_programa_fk" name="id_programa_fk" required>
                    <option value="">Seleccione un estímulo</option>
                    <?php foreach ($tipos_programas as $programa) : ?>
                        <option value="<?= htmlspecialchars($programa['id_programa']) ?>"><?= htmlspecialchars($programa['nombre_estimulo']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipo de estímulo -->
            <div class="mb-3">
                <label for="tipo_estimulo" class="form-label">TIPO DE ESTÍMULO:</label>
                <select class="form-select" id="tipo_estimulo" name="tipo_estimulo" required>
                    <option value="">Seleccione un tipo de estímulo</option>
                    <?php foreach ($tipos_estimulo as $estimulo) : ?>
                        <option value="<?= htmlspecialchars($estimulo['id']) ?>"><?= htmlspecialchars($estimulo['nombre de estimulo']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Área del IMCTT -->
            <div class="mb-3">
                <label for="area_imctt" class="form-label">Área del IMCTT (Seleccione según la descripción del estímulo):</label>
                <select class="form-select" id="area_imctt" name="area_imctt" required>
                    <option value="">Seleccione un área</option>
                    <?php foreach ($areas_imctt as $area) : ?>
                        <option value="<?= htmlspecialchars($area['id_area']) ?>"><?= htmlspecialchars($area['nombre_area']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Categorías generales (checkbox para múltiple selección) -->
            <div class="mb-3">
                <label class="form-label">Categorías generales (Puede seleccionar más de una):</label>
                <div class="row">
                    <?php foreach ($categorias as $categoria) : ?>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categorias[]" 
                                    id="categoria_<?= $categoria['id_categoria'] ?>" 
                                    value="<?= htmlspecialchars($categoria['id_categoria']) ?>">
                                <label class="form-check-label" for="categoria_<?= $categoria['id_categoria'] ?>">
                                    <?= htmlspecialchars($categoria['nombreCategoria']) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Línea de trabajo -->
            <div class="mb-3">
                <label class="form-label">Línea de trabajo (Puede seleccionar más de una):</label>
                <div class="row">
                    <?php foreach ($lineas_trabajo as $linea) : ?>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="lineas_trabajo[]" 
                                    id="linea_<?= $linea['id_sub'] ?>" 
                                    value="<?= htmlspecialchars($linea['id_sub']) ?>">
                                <label class="form-check-label" for="linea_<?= $linea['id_sub'] ?>">
                                    <?= htmlspecialchars($linea['nombreSub']) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- id_persona -->
            <div class="mb-3">
                <label for="nombre_proyecto" class="form-label">id persona:</label>
                <input type="text" class="form-control" id="id_persona_fk" name="id_persona_fk"  value="<?php echo $_SESSION['ID']?>">
            </div>
           
            <!-- Nombre del proyecto -->
            <div class="mb-3">
                <label for="nombre_proyecto" class="form-label">Nombre del proyecto:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <!-- Objetivo general -->
            <div class="mb-3">
                <label for="objetivo_general" class="form-label">Objetivo general:</label>
                <textarea class="form-control" id="objetivo_general" name="objetivo_general" required></textarea>
            </div>

            <!-- Productos o servicios -->
            <div class="mb-3">
                <label for="productos" class="form-label">Productos o servicios culturales finales:</label>
                <textarea class="form-control" id="productos" name="productos" required></textarea>
            </div>

            <!-- Documentos a subir -->
            <div class="mb-3">
                <label for="formato_presentacion" class="form-label">Formato único de presentación de propuestas:</label>
                <input type="file" class="form-control" id="formato_presentacion" name="formato_presentacion" accept=".pdf" required>
                <small class="text-muted">Descarga el formulario en la sección Artenjo del IMCTT. Completa todos los ítems requeridos, guárdalo en PDF y súbelo. Tamaño máximo: 100 MB.</small>
            </div>

            <div class="mb-3">
                <label for="presupuesto" class="form-label">Presupuesto:</label>
                <input type="file" class="form-control" id="presupuesto" name="presupuesto" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="cronograma" class="form-label">Cronograma:</label>
                <input type="file" class="form-control" id="cronograma" name="cronograma" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="soportes_experiencia" class="form-label">Soportes de experiencia o trayectoria:</label>
                <input type="file" class="form-control" id="soportes_experiencia" name="soportes_experiencia" accept=".pdf" required>
                <small class="text-muted">Crea un PDF con documentos que respalden tu trayectoria. Tamaño máximo: 100 MB.</small>
            </div>

            <div class="mb-3">
                <label for="documentos_adicionales" class="form-label">Documentos adicionales:</label>
                <input type="file" class="form-control" id="documentos_adicionales" name="documentos_adicionales" accept=".pdf">
                <small class="text-muted">Materiales de apoyo como bocetos, planos, guiones o cartas de invitación. Tamaño máximo: 100 MB.</small>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Propuesta</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación de archivos
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                const feedback = document.createElement('div');
                feedback.className = 'mt-2';
                
                if (file) {
                    if (file.size > 100 * 1024 * 1024) { // 100MB
                        feedback.textContent = 'El archivo excede el tamaño máximo permitido (100 MB).';
                        feedback.style.color = 'red';
                    } else if (file.type !== 'application/pdf') {
                        feedback.textContent = 'El archivo debe ser un PDF.';
                        feedback.style.color = 'red';
                    } else {
                        feedback.textContent = 'Archivo válido.';
                        feedback.style.color = 'green';
                    }
                } else {
                    feedback.textContent = 'No se ha seleccionado ningún archivo.';
                    feedback.style.color = 'orange';
                }
                
                this.parentNode.appendChild(feedback);
            });
        });
    </script>
</body>
</html>