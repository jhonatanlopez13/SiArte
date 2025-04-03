<?php
// Incluir la conexión a la base de datos
include_once '../../config/db.php';
session_start();
 
if($_SESSION['PERFIL'] != 'aspirante') {
    header('Location: ../../index.php');
    exit();
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

// Consultar veredas
try {
    $query_veredas = "SELECT id_vereda, nombre_vereda FROM vereda ORDER BY id_vereda";
    $stmt_veredas = $conn->prepare($query_veredas);
    $stmt_veredas->execute();
    $veredas = $stmt_veredas->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener las veredas: " . $e->getMessage());
}

// consultar persona activa - VERSIÓN CORREGIDA
try {
    $id_persona = $_SESSION['ID'];
    
    // Verificar que el ID de persona sea válido
    if(empty($id_persona) || !is_numeric($id_persona)) {
        throw new Exception("ID de usuario no válido");
    }

    $query = "SELECT a.*, b.nombre_Genero, d.tipoDocumento, e.nombreTipopersona, f.nombre as tipo_proponente 
              FROM personas a 
              LEFT JOIN genero b ON a.genero_fk = b.id 
              LEFT JOIN tipo_documento d ON a.id_tipo_Documento_fk = d.id 
              LEFT JOIN tipo_persona e ON a.id_tipo_persona_fk = e.id 
              LEFT JOIN tipo_proponente f ON a.id_tipo_proponente_fk = f.id 
              WHERE a.id_persona = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_persona]);
    $persona = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no encuentra la persona, inicializar array vacío
    if(!$persona) {
        $persona = [
            'id_persona' => $id_persona,
            'id_tipo_proponente_fk' => '',
            'numero_documento' => '',
            'nombres' => '',
            'apellidos' => '',
            'genero_fk' => '',
            'direccion' => '',
            'celular' => '',
            'nombre_representante' => '',
            'documento_representante' => '',
            'tiempo_residencia' => '',
            'id_vereda_fk' => ''
        ];
    }
} catch (Exception $e) {
    die("Error al obtener los datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($persona['nombres']) ? 'Registrar' : 'Editar' ?> Persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .campo-condicional {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">FORMULARIO DE INSCRIPCIÓN ARTENJO 2025</h1>
        
        <form action="../controlador/editar.php"  method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para el ID de persona -->
            <input type="hidden" name="id_persona" value="<?= htmlspecialchars($persona['id_persona'] ?? '') ?>">

            <!-- Selector de Tipo de Proponente -->
            <div class="mb-3">
                <label for="id_tipo_proponente_fk" class="form-label">Tipo de Proponente:</label>
                <select class="form-select" id="id_tipo_proponente_fk" name="id_tipo_proponente_fk" required>
                    <option value="">Seleccione el tipo de proponente</option>
                    <?php foreach ($tipos_proponente as $tipo) : ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>" 
                            <?= ($tipo['id'] == ($persona['id_tipo_proponente_fk'] ?? '')) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campos comunes a todos los tipos -->
            <div class="mb-3">
                <label for="numero_documento" class="form-label">Número de documento de identidad o NIT (Aplica solo para Personas Jurídicas de Naturaleza Privada)</label>
                <input type="text" class="form-control" id="numero_documento" name="numero_documento" 
                       value="<?= htmlspecialchars($persona['numero_documento'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección de residencia (De la Persona Natural, Representante del Grupo Constituido o dirección de la entidad u organización proponente):</label>
                <input type="text" class="form-control" id="direccion" name="direccion" 
                       value="<?= htmlspecialchars($persona['direccion'] ?? '') ?>" required>
            </div>

            <!-- Campos condicionales para Persona Natural -->
            <div id="campos-persona-natural" class="campo-condicional">
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres"
                           value="<?= htmlspecialchars($persona['nombres'] ?? '') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                           value="<?= htmlspecialchars($persona['apellidos'] ?? '') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="genero_fk" class="form-label">Género:</label>
                    <select class="form-select" id="genero_fk" name="genero_fk">
                        <option value="">Seleccione un género</option>
                        <?php foreach ($generos as $genero) : ?>
                            <option value="<?= htmlspecialchars($genero['id']) ?>" 
                                <?= ($genero['id'] == ($persona['genero_fk'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($genero['nombre_Genero']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Campos condicionales para Grupo Constituido -->
            <div id="campos-grupo-constituido" class="campo-condicional">
                <div class="mb-3">
                    <label for="nombre_grupo" class="form-label">Nombre del Grupo:</label>
                    <input type="text" class="form-control" id="nombre_grupo" name="nombres"
                           value="<?= htmlspecialchars($persona['nombres'] ?? '') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="nombre_representante_grupo" class="form-label">Nombre del Representante:</label>
                    <input type="text" class="form-control" id="nombre_representante_grupo" name="nombre_representante"
                           value="<?= htmlspecialchars($persona['nombre_representante'] ?? '') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="documento_representante_grupo" class="form-label">Numero de  Documento de identidad Representante:</label>
                    <input type="text" class="form-control" id="documento_representante_grupo" name="documento_representante"
                           value="<?= htmlspecialchars($persona['documento_representante'] ?? '') ?>">
                </div>
            </div>

            <!-- Campos condicionales para Persona Jurídica -->
            <div >
                <div class="mb-3">
                    <label for="razon_social" class="form-label">Razón Social (nombre de la organización o entidad que presenta el proyecto según como aparece registrada en el RUT):</label>
                    <input type="text" class="form-control" id="razon_social" name="nombres"
                           value="<?= htmlspecialchars($persona['nombres'] ?? '') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="nombre_representante_juridica" class="form-label">Nombre del Representante Legal(tal como aparece en el documento de identidad):</label>
                    <input type="text" class="form-control" id="nombre_representante_juridica" name="nombre_representante"
                           value="<?= htmlspecialchars($persona['nombre_representante'] ?? '') ?>">
                </div>
                
            </div>

            <!-- Vereda -->
            <div class="mb-3">
                <label for="id_vereda_fk" class="form-label">Vereda y/o Centro Poblado:</label>
                <select class="form-select" name="id_vereda_fk" id="id_vereda_fk" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($veredas as $vereda) : ?>
                        <option value="<?= htmlspecialchars($vereda['id_vereda']) ?>" 
                            <?= ($vereda['id_vereda'] == ($persona['id_vereda_fk'] ?? '')) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($vereda['nombre_vereda']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="celular" class="form-label">Celular (De la Persona Natural, Representante del Grupo Constituido, Representante Legal de Persona Jurídica de Naturaleza Privada o Encargado del proyecto) Este es número telefónico principal y único para la comunicación durante el proceso:</label>
                <input type="text" class="form-control" id="celular" name="celular" 
                       value="<?= htmlspecialchars($persona['celular'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="tiempo_residencia" class="form-label">Tiempo de residencia:</label>
                <input type="text" class="form-control" id="tiempo_residencia" name="tiempo_residencia"
                       value="<?= htmlspecialchars($persona['tiempo_residencia'] ?? '') ?>">
            </div>

            <!-- Documentos condicionales -->
            <div id="documentos-persona-natural" class="campo-condicional">
                <div class="mb-3">
                    <label for="anexo1_persona_natural" class="form-label">ANEXO 1: Persona natural - Formatos de autorización (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="anexo1_persona_natural" name="anexo1_persona_natural" accept=".pdf">
                    <span>Documento debidamente diligenciado y firmado en archivo PDF. NO SUBSANABLE</span>
                </div>
            </div>

            <div id="documentos-grupo-constituido" class="campo-condicional">
                <div class="mb-3">
                    <label for="anexo2_grupos_constituidos" class="form-label">ANEXO 2: Grupos constituidos - Formatos de autorización y acta de conformación (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="anexo2_grupos_constituidos" name="anexo2_grupos_constituidos" accept=".pdf">
                    <span>Documento debidamente diligenciado y firmado en archivo PDF. NO SUBSANABLE</span>
                </div>
            </div>

            <div id="documentos-persona-juridica" class="campo-condicional">
            
                <div class="mb-3">
                    <label for="anexo3_persona_juridica" class="form-label">ANEXO 3: Persona jurídica - Formatos de autorización (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="anexo3_persona_juridica" name="anexo3_persona_juridica" accept=".pdf">
                    <span>(Debidamente diligenciado con la información de identificación de la organización participante, firmado por el  representante legal en archivo PDF. NO SUBSANABLE)</span>
                </div>
                
                <div class="mb-3">
                    <label for="copia_rut" class="form-label">Copia del RUT (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="copia_rut" name="copia_rut" accept=".pdf">
                </div>
            </div>

            <!-- Documentos comunes -->
            <div class="mb-3">
                <label for="copia_documento_identidad" class="form-label">Copia del documento de identidad (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="copia_documento_identidad" name="copia_documento_identidad" accept=".pdf">
                <span>(En caso de grupo constituido se solicita el documento de cada uno de los integrantes y en un solo archivo PDF. SUBSANABLE)</span>
            </div>

            <div class="mb-3">
                <label for="certificado_residencia" class="form-label">Certificado de residencia (PDF, máximo 10MB):</label>
                <input type="file" class="form-control" id="certificado_residencia" name="certificado_residencia" accept=".pdf">
                <span>(Emitido por el CISAT con fecha de expedición no mayor a 30 días. La expedición se realiza en el Centro Integral de Servicios Administrativos De Tenjo - CISAT, Cl. 3 #3-28)<br/>(En caso de grupo constituido se solicita el certificado de cada uno de los integrantes y en un solo archivo PDF. SUBSANABLE)</span>
            </div>
           <div>
                <div class="mb-3">
                    <label for="copia_rut" class="form-label">Copia del RUT (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="copia_rut" name="copia_rut" accept=".pdf">
                    <span>Copia legible del RUT (Con expedición no mayor a 30 días. No se aceptará la solicitud de inscripción, ni el borrador ni el documento en trámite)</span>
                </div>
           </div>
            <div >
                <div class="mb-3">
                    <label for="certificado_sicut" class="form-label">Certificado de registro en el SICUT (PDF, máximo 10MB):</label>
                    <input type="file" class="form-control" id="certificado_sicut" name="certificado_sicut" accept=".pdf">
                    <span>(En caso de grupo constituido se solicita el comprobante de registro  de cada uno de los integrantes y en un solo archivo PDF. SUBSANABLE)</span>
                   
                </div>
            </div>
            

            <button type="submit" class="btn btn-primary"><?= empty($persona['nombres']) ? 'Registrar' : 'Actualizar' ?> Información</button>
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
            }
            
            // Ejecutar al cargar la página para mostrar los campos según el tipo actual
            actualizarCampos();
            
            // Escuchar cambios en el select
            tipoProponente.addEventListener('change', actualizarCampos);
        });
    </script>
</body>
</html>