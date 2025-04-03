<?php
// Incluir la conexión a la base de datos
include_once '../../config/db.php';
 session_start();
    if($_SESSION['PERFIL']=='aspirante')
    {

    }else
    {
        header('Location: ../../index.php');
    }

// Crear una instancia de la clase ConectarDB
$conectarDB = new Conexion();
$conn = $conectarDB->get_conexion(); // Obtener la conexión PDO

// Verificar si la conexión está definida
if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Consultar los tipos de proponente
try {
    $query_tipos_proponente = "SELECT id, nombre FROM tipo_proponente ORDER BY id";
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
    <style>
        .campo-condicional {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">FORMULARIO DE INSCRIPCIÓN ARTENJO</h1>
        <form action="../controlador/crear.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para el tipo de persona -->
            <input type="text" class="form-control" id="id_tipo_persona_fk" name="id_tipo_persona_fk" <?php echo $_SESSION['ID'] ?> readonly>

            <!-- Selector de Tipo de Proponente -->
            <div class="mb-3">
                <label for="id_tipo_proponente_fk" class="form-label">Tipo de Proponente:</label>
                <select class="form-select" id="id_tipo_proponente_fk" name="id_tipo_proponente_fk" required>
                    <option value="">Seleccione el tipo de proponente</option>
                    <?php foreach ($tipos_proponente as $tipo) : ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campos comunes a todos los tipos -->
            <div class="mb-3">
                <label for="numero_documento" class="form-label">Número de documento de identidad o  NIT (Aplica solo para Personas Jurídicas de Naturaleza Privada )</label>
                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección de residencia (De la Persona Natural, Representante del Grupo Constituido o dirección de la entidad u organización proponente ):</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>

            <!-- Campos condicionales para Persona Natural -->
            <div id="campos-persona-natural" class="campo-condicional">
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres">
                </div>
                
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos">
                </div>
                
                <div class="mb-3">
                    <label for="genero_fk" class="form-label">Género:</label>
                    <select class="form-select" id="genero_fk" name="genero_fk">
                        <option value="">Seleccione un género</option>
                        <?php foreach ($generos as $genero) : ?>
                            <option value="<?= htmlspecialchars($genero['id']) ?>"><?= htmlspecialchars($genero['nombre_Genero']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Campos condicionales para Grupo Constituido -->
            <div id="campos-grupo-constituido" class="campo-condicional">
                <div class="mb-3">
                    <label for="nombre_grupo" class="form-label">Nombre del Grupo:</label>
                    <input type="text" class="form-control" id="nombre_grupo" name="nombres">
                </div>
                
                <div class="mb-3">
                    <label for="nombre_representante_grupo" class="form-label">Nombre del Representante:</label>
                    <input type="text" class="form-control" id="nombre_representante_grupo" name="nombre_representante">
                </div>
                
                <div class="mb-3">
                    <label for="documento_representante_grupo" class="form-label">Documento del Representante:</label>
                    <input type="text" class="form-control" id="documento_representante_grupo" name="documento_representante">
                </div>
            </div>

            <!-- Campos condicionales para Persona Jurídica -->
            <div id="campos-persona-juridica" class="campo-condicional">
                <div class="mb-3">
                    <label for="razon_social" class="form-label">Razón Social (nombre de la organización o entidad que presenta el proyecto según como aparece registrada en el RUT):</label>
                    <input type="text" class="form-control" id="razon_social" name="nombres">
                </div>
                
                <!-- <div class="mb-3">
                    <label for="nit" class="form-label">NIT:</label>
                    <input type="text" class="form-control" id="nit" name="nit">
                </div> -->
                
                <div class="mb-3">
                    <label for="nombre_representante_juridica" class="form-label">Nombre del Representante Legal(tal como aparece en el documento de identidad):</label>
                    <input type="text" class="form-control" id="nombre_representante_juridica" name="nombre_representante">
                </div>
                
                <div class="mb-3">
                    <label for="documento_representante_juridica" class="form-label">Número del Representante Legal :</label>
                    <input type="text" class="form-control" id="documento_representante_juridica" name="documento_representante">
                </div>
            </div>

            <!-- Campos comunes adicionales -->
            <div class="mb-3">
                <label for="vereda_centro_poblado" class="form-label">Vereda y/o Centro Poblado (De la Persona Natural, Representante del Grupo Constituido o Representante Legal de Persona Jurídica de Naturaleza Privada )</label>
                <select class="form-select" name="vereda_centro_poblado" id="vereda_centro_poblado">
                    <option value="">Seleccione una opción</option>
                    <option value="1.Carrasquilla">1.Carrasquilla</option>
                    <option value="2.Chacal">2.Chacal</option>
                    <option value="3.Chincé">3.Chincé</option>
                    <option value="4.Chitasugá">4.Chitasugá</option>
                    <option value="5.Chu-cua">5.Chu-cua</option>
                    <option value="6.Churuguaco">6.Churuguaco</option>
                    <option value="7.El Estanco">7.El Estanco</option>
                    <option value="8.Guangatá">8.Guangatá</option>
                    <option value="9.Jacalito">9.Jacalito</option>
                    <option value="10.Juaica">10.Juaica</option>
                    <option value="11.La punta">11.La punta</option>
                    <option value="12.Martín Espino">12.Martín Espino</option>
                    <option value="13.Poveda 1">13.Poveda 1</option>
                    <option value="14.Poveda 2">14.Poveda 2</option>
                    <option value="15.Santa Cruz">15.Santa Cruz</option>
                    <option value="16.Casco Urbano">16.Casco Urbano</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="celular" class="form-label">Celular (De la Persona Natural, Representante del Grupo Constituido, Representante Legal de Persona Jurídica de Naturaleza Privada o Encargado del proyecto) Este es número telefónico principal y único para la comunicación durante el proceso:</label>
                <input type="text" class="form-control" id="celular" name="celular" required>
            </div>

            <!-- <div class="mb-3">
                <label for="correo" class="form-label">Email:</label>
                <input type="hidden" class="form-control" id="correo" name="correo" required>
            </div> -->
            
            <!-- 
            <div class="mb-3">
                <label for="pass" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div> -->

            <div class="mb-3">
                <label for="tiempo_residencia" class="form-label">Tiempo de residencia:</label>
                <input type="text" class="form-control" id="tiempo_residencia" name="tiempo_residencia">
            </div>

            <!-- Documentos condicionales -->
            <div id="documentos-persona-natural" class="campo-condicional">
                <div class="mb-3">
                    <label for="anexo1_persona_natural" class="form-label">ANEXO 1: Persona natural - Formatos de autorización (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="anexo1_persona_natural" name="anexo1_persona_natural" accept=".pdf">
                </div>
            </div>

            <div id="documentos-grupo-constituido" class="campo-condicional">
                <div class="mb-3">
                    <label for="anexo2_grupos_constituidos" class="form-label">ANEXO 2: Grupos constituidos - Formatos de autorización y acta de conformación (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="anexo2_grupos_constituidos" name="anexo2_grupos_constituidos" accept=".pdf">
                </div>
            </div>

            <div id="documentos-persona-juridica" class="campo-condicional">
                <div class="mb-3">
                    <label for="anexo3_persona_juridica" class="form-label">ANEXO 3: Persona jurídica - Formatos de autorización (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="anexo3_persona_juridica" name="anexo3_persona_juridica" accept=".pdf">
                </div>
                
                <div class="mb-3">
                    <label for="copia_rut" class="form-label">Copia del RUT (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="copia_rut" name="copia_rut" accept=".pdf">
                </div>
            </div>

            <!-- Documentos comunes -->
            <div class="mb-3">
                <label for="copia_documento_identidad" class="form-label">Copia del documento de identidad (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="copia_documento_identidad" name="copia_documento_identidad" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="certificado_residencia" class="form-label">Certificado de residencia (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="certificado_residencia" name="certificado_residencia" accept=".pdf" required>
            </div>

            <div id="documentos-persona-juridica-grupo" class="campo-condicional">
                <div class="mb-3">
                    <label for="certificado_sicut" class="form-label">Certificado de registro en el SICUT (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="certificado_sicut" name="certificado_sicut" accept=".pdf">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoProponente = document.getElementById('id_tipo_proponente_fk');
            
            // Función para mostrar/ocultar campos según el tipo de proponente
            function actualizarCampos() {
                const valor = tipoProponente.value;
                
                // Ocultar todos los campos condicionales primero
                document.querySelectorAll('.campo-condicional').forEach(div => {
                    div.style.display = 'none';
                });
                
                // Mostrar campos según la selección
                if (valor === '1') { // Persona Natural
                    document.getElementById('campos-persona-natural').style.display = 'block';
                    document.getElementById('documentos-persona-natural').style.display = 'block';
                } else if (valor === '2') { // Grupo Constituido
                    document.getElementById('campos-grupo-constituido').style.display = 'block';
                    document.getElementById('documentos-grupo-constituido').style.display = 'block';
                    document.getElementById('documentos-persona-juridica-grupo').style.display = 'block';
                } else if (valor === '3') { // Persona Jurídica
                    document.getElementById('campos-persona-juridica').style.display = 'block';
                    document.getElementById('documentos-persona-juridica').style.display = 'block';
                    document.getElementById('documentos-persona-juridica-grupo').style.display = 'block';
                }
                
                // Actualizar campos requeridos
                actualizarRequeridos();
            }
            
            // Función para actualizar los campos requeridos según el tipo de proponente
            function actualizarRequeridos() {
                const valor = tipoProponente.value;
                
                // Persona Natural
                document.getElementById('nombres').required = valor === '1';
                document.getElementById('apellidos').required = valor === '1';
                document.getElementById('genero_fk').required = valor === '1';
                document.getElementById('anexo1_persona_natural').required = valor === '1';
                
                // Grupo Constituido
                document.getElementById('nombre_grupo').required = valor === '2';
                document.getElementById('nombre_representante_grupo').required = valor === '2';
                document.getElementById('documento_representante_grupo').required = valor === '2';
                document.getElementById('anexo2_grupos_constituidos').required = valor === '2';
                
                // Persona Jurídica
                document.getElementById('razon_social').required = valor === '3';
                document.getElementById('nit').required = valor === '3';
                document.getElementById('nombre_representante_juridica').required = valor === '3';
                document.getElementById('documento_representante_juridica').required = valor === '3';
                document.getElementById('anexo3_persona_juridica').required = valor === '3';
                document.getElementById('copia_rut').required = valor === '3';
                
                // Documentos comunes condicionales
                document.getElementById('certificado_sicut').required = valor === '2' || valor === '3';
            }
            
            // Escuchar cambios en el select
            tipoProponente.addEventListener('change', actualizarCampos);
            
            // Ejecutar al cargar la página por si hay un valor seleccionado
            actualizarCampos();
        });
    </script>
</body>
</html>