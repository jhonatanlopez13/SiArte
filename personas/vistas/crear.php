<?php
// Archivo: primer_registro_estudiante.php

// Incluir la conexión a la base de datos
include_once '../../config/db.php';

// Crear una instancia de la clase ConectarDBwwwwww
$conectarDB = new Conexion();
$conn = $conectarDB->get_conexion(); // Obtener la conexión PDO

// Verificar si la conexión está definida
if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Consultar los tipos de proponente
try {
    $query_tipos_proponente = "SELECT id, nombre FROM tipo_proponente";
    $stmt_tipos_proponente = $conn->prepare($query_tipos_proponente);
    $stmt_tipos_proponente->execute();
    $tipos_proponente = $stmt_tipos_proponente->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los tipos de proponente: " . $e->getMessage());
}

// Consultar los tipos de documento
try {
    $query_tipos_documento = "SELECT id, tipoDocumento FROM tipo_documento";
    $stmt_tipos_documento = $conn->prepare($query_tipos_documento);
    $stmt_tipos_documento->execute();
    $tipos_documento = $stmt_tipos_documento->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los tipos de documento: " . $e->getMessage());
}

// Consultar los géneros
try {
    $query_generos = "SELECT id, nombre_Genero FROM genero";
    $stmt_generos = $conn->prepare($query_generos);
    $stmt_generos->execute();
    $generos = $stmt_generos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los géneros: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">FORMULARIO DE INSCRIPCIÓN ARTENJO 2024</h1>
        <!-- Asegúrate de agregar enctype="multipart/form-data" para permitir la subida de archivos -->
        <form action="../controlador/crear.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para el tipo de persona -->
            <input type="hidden" class="form-control" id="id_tipo_persona_fk" name="id_tipo_persona_fk" value="3" readonly>

            <!-- Tipo de proponente -->
            <div class="mb-3">
                <label for="id_tipo_proponente_fk" class="form-label">Tipo de Proponente:</label>
                <select class="form-select" id="id_tipo_proponente_fk" name="id_tipo_proponente_fk" required>
                    <option value="">Seleccione el tipo de proponente</option>
                    <?php foreach ($tipos_proponente as $tipo) : ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipo de documento -->
            <div class="mb-3">
                <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                <select class="form-select" id="tipo_documento" name="id_tipo_Documento_fk" required>
                    <option value="">Seleccione un tipo de documento</option>
                    <?php foreach ($tipos_documento as $tipo) : ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['tipoDocumento']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Número de documento -->
            <div class="mb-3">
                <label for="numero_documento" class="form-label">Número de Documento o nit:</label>
                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
            </div>

            <!-- Nombres -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombres" required>
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>

            <!-- Género -->
            <div class="mb-3">
                <label for="genero_fk" class="form-label">Género:</label>
                <select class="form-select" id="genero_fk" name="genero_fk" required>
                    <option value="">Seleccione un género</option>
                    <?php foreach ($generos as $genero) : ?>
                        <option value="<?= htmlspecialchars($genero['id']) ?>"><?= htmlspecialchars($genero['nombre_Genero']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Vereda/Centro Poblado -->
            <div class="mb-3">
                <label for="vereda_centro_poblado" class="form-label">Vereda/Centro Poblado:</label>
                <input type="text" class="form-control" id="vereda_centro_poblado" name="vereda_centro_poblado" required>
            </div>

            <!-- Dirección -->
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>

            <!-- Celular -->
            <div class="mb-3">
                <label for="celular" class="form-label">Celular:</label>
                <input type="text" class="form-control" id="celular" name="celular" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="correo" required>
            </div>

            <!-- pass -->
            <div class="mb-3">
                <label for="password" class="form-label">contraseña:</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>

             <!--  nombre_representante -->
             <div class="mb-3">
                <label for=" nombre_representante" class="form-label"> nombre de representante:</label>
                <input type="text" class="form-control" id=" nombre_representante" name=" nombre_representante" >
            </div>

            <!--  tiempo_residencia -->
            <div class="mb-3">
                <label for="tiempo_residencia" class="form-label"> tiempo_residencia:</label>
                <input type="text" class="form-control" id=" tiempo_residencia" name=" tiempo_residencia" >
            </div>
            <div class="mb-3">
                <label for="anexo1_persona_natural" class="form-label">ANEXO 1: Persona natural - Formatos de autorización (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="anexo1_persona_natural" name="anexo1_persona_natural" accept=".pdf" required>
                <input type="hidden" id="estado_anexo1" name="estado_anexo1" value="en proceso">
                <div id="notificacion_anexo1" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="anexo2_grupos_constituidos" class="form-label">ANEXO 2: Grupos constituidos - Formatos de autorización y acta de conformación (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="anexo2_grupos_constituidos" name="anexo2_grupos_constituidos" accept=".pdf">
                <input type="hidden" id="estado_anexo2" name="estado_anexo2" value="en proceso">
                <div id="notificacion_anexo2" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="anexo3_persona_juridica" class="form-label">ANEXO 3: Persona jurídica - Formatos de autorización (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="anexo3_persona_juridica" name="anexo3_persona_juridica" accept=".pdf">
                <input type="hidden" id="estado_anexo3" name="estado_anexo3" value="en proceso">
                <div id="notificacion_anexo3" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="copia_documento_identidad" class="form-label">Copia del documento de identidad (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="copia_documento_identidad" name="copia_documento_identidad" accept=".pdf" required>
                <input type="hidden" id="estado_copia_documento" name="estado_copia_documento" value="en proceso">
                <div id="notificacion_copia_documento" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="certificado_residencia" class="form-label">Certificado de residencia (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="certificado_residencia" name="certificado_residencia" accept=".pdf" required>
                <input type="hidden" id="estado_certificado_residencia" name="estado_certificado_residencia" value="en proceso">
                <div id="notificacion_certificado_residencia" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for=" copia_rut" class="form-label">Copia del RUT (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id=" copia_rut" name=" copia_rut" accept=".pdf">
                <input type="hidden" id="estado_ copia_rut" name="estado_copia_rut" value="en proceso">
                <div id="notificacion_ copia_rut" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="certificado_sicut" class="form-label">Certificado de registro en el SICUT (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="certificado_sicut" name="certificado_sicut" accept=".pdf">
                <input type="hidden" id="estado_certificado_sicut" name="estado_certificado_sicut" value="en proceso">
                <div id="notificacion_certificado_sicut" class="mt-2"></div>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para actualizar el estado de un archivo
        function actualizarEstado(inputId, estadoId, notificacionId) {
            const inputFile = document.getElementById(inputId);
            const estadoInput = document.getElementById(estadoId);
            const notificacion = document.getElementById(notificacionId);

            inputFile.addEventListener('change', function () {
                // Simular la validación del archivo (puedes cambiarlo por lógica real)
                const archivo = inputFile.files[0];
                if (archivo) {
                    if (archivo.size > 10 * 1024 * 1024) { // 10MB
                        estadoInput.value = 'no cumple';
                        notificacion.textContent = 'El archivo excede el tamaño máximo permitido.';
                        notificacion.style.color = 'red';
                    } else if (archivo.type !== 'application/pdf') {
                        estadoInput.value = 'no cumple';
                        notificacion.textContent = 'El archivo debe ser un PDF.';
                        notificacion.style.color = 'red';
                    } else {
                        estadoInput.value = 'cumple';
                        notificacion.textContent = 'El archivo cumple con los requisitos.';
                        notificacion.style.color = 'green';
                    }
                } else {
                    estadoInput.value = 'en proceso';
                    notificacion.textContent = 'Esperando la subida del archivo.';
                    notificacion.style.color = 'orange';
                }
            });
        }

        // Aplicar la función a cada campo de archivo
        actualizarEstado('anexo1_persona_natural', 'estado_anexo1', 'notificacion_anexo1');
        actualizarEstado('anexo2_grupos_constituidos', 'estado_anexo2', 'notificacion_anexo2');
        actualizarEstado('anexo3_persona_juridica', 'estado_anexo3', 'notificacion_anexo3');
        actualizarEstado('copia_documento_identidad', 'estado_copia_documento', 'notificacion_copia_documento');
        actualizarEstado('certificado_residencia', 'estado_certificado_residencia', 'notificacion_certificado_residencia');
        actualizarEstado(' copia_rut', 'estado_ copia_rut', 'notificacion_ copia_rut');
        actualizarEstado('certificado_sicut', 'estado_certificado_sicut', 'notificacion_certificado_sicut');
    </script>
</body>
</html>