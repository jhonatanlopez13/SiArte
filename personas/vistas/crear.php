<?php
// Incluir la conexión a la base de datos
include_once '../../config/db.php';
require_once '../modelo/userModel.php';

// Crear una instancia de la clase ConectarDB
$conectarDB = new Conexion();
$conn = $conectarDB->get_conexion(); // Obtener la conexión PDO

// Verificar si la conexión está definida
if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Consultar los tipos de proponente (MANTENIENDO TU CONSULTA ORIGINAL)
try {
    $query_tipos_proponente = "SELECT * FROM convocatoria";
    $stmt_tipos_proponente = $conn->prepare($query_tipos_proponente);
    $stmt_tipos_proponente->execute();
    $tipos_proponente = $stmt_tipos_proponente->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los tipos de proponente: " . $e->getMessage());
}

// Consultar los tipos de documento (MANTENIENDO TU CONSULTA ORIGINAL)
try {
    $query_tipos_documento = "SELECT id, tipoDocumento FROM tipo_documento";
    $stmt_tipos_documento = $conn->prepare($query_tipos_documento);
    $stmt_tipos_documento->execute();
    $tipos_documento = $stmt_tipos_documento->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los tipos de documento: " . $e->getMessage());
}

// Consultar los géneros (MANTENIENDO TU CONSULTA ORIGINAL)
try {
    $query_generos = "SELECT id, nombre_Genero FROM genero";
    $stmt_generos = $conn->prepare($query_generos);
    $stmt_generos->execute();
    $generos = $stmt_generos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los géneros: " . $e->getMessage());
}

// Consultar los tipos de proponente (MANTENIENDO TU CONSULTA ORIGINAL)
try {
    $query_tipos_proponente = "SELECT id, nombre FROM tipo_proponente ORDER BY id";
    $stmt_tipos_proponente = $conn->prepare($query_tipos_proponente);
    $stmt_tipos_proponente->execute();
    $tipos_proponente = $stmt_tipos_proponente->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los tipos de proponente: " . $e->getMessage());
}
// Consultar los programas (convocatorias) - MODIFICADO
try {
    $query_programas = "SELECT * FROM area";
    $stmt_programas = $conn->prepare($query_programas);
    $stmt_programas->execute();
    $programas = $stmt_programas->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los programas: " . $e->getMessage());
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
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registro de usuario para crear una propuesta</h1>

        <span>
        Registro de usuario para crear una propuesta 
        Para crear una cuenta es necesario que usted seleccione el tipo de participante y diligencie los datos solicitados según el orden. El correo electrónico ingresado será el principal medio de comunicación durante el proceso. Recuerde que todos los datos son obligatorios.
        </span>
        <br><br>

        <!-- Manteniendo tu formulario original, solo agregando validaciones -->
        <form id="registroForm" action="../controlador/crear.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para el tipo de persona (MANTENIENDO TU CAMPO ORIGINAL) -->
            <input type="hidden" class="form-control" id="id_tipo_persona_fk" name="id_tipo_persona_fk" value="1" readonly>

            <!-- Tipo de proponente (MANTENIENDO TU SELECT ORIGINAL) -->
            <div class="mb-3">
                <h4 for="id_tipo_proponente_fk" class="form-label">Seleccione la convocatoria a la cual desea aplicar</h4><br>
                <select class="form-select" id="id_programa_fk" name="id_programa_fk" required>
                    <option value="">Seleccione una convocatoria</option>
                    <?php foreach ($programas as $programa) : ?>
                        <option value="<?= htmlspecialchars($programa['id_area']) ?>">
                            <?= htmlspecialchars($programa['nombre_area']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipo de participante (MANTENIENDO TU SELECT ORIGINAL) -->
            <div class="mb-3">
                <h4 for="id_tipo_proponente_fk" class="form-label">Seleccione el tipo de participante</h4><br>
                <span>(Persona Natural, Persona Jurídica o Grupo Constituido)</span>
                <select class="form-select" id="id_tipo_proponente_fk" name="id_tipo_proponente_fk" required>
                    <option value="">Seleccione el tipo de proponente</option>
                    <?php foreach ($tipos_proponente as $tipo) : ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tipo de documento (MANTENIENDO TU SELECT ORIGINAL) -->
            <div class="mb-3">
                <h4 for="tipo_documento" class="form-label">Seleccione tipo de documento:</h4><br>
                <span>(Persona Natural, Persona Jurídica o Grupo Constituido)</span>
                <select class="form-select" id="tipo_documento" name="id_tipo_Documento_fk" required>
                    <option value="">Seleccione un tipo de documento</option>
                    <?php foreach ($tipos_documento as $tipo) : ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['tipoDocumento']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombres" required>
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>

            <!-- Número de documento (MANTENIENDO TU CAMPO ORIGINAL) -->
            <div class="mb-3">
                <h4 for="numero_documento" class="form-label">Ingrese el número del documento:</h4>
                <br><span>Ingresar solo números sin guiones, ni puntos, en el caso del NIT agregar el digito de verificación</span>
                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
            </div>
            <!-- Tiempo_residencia: -->
            <div class="mb-3">
                <label for="tiempo_residencia" class="form-label"> Tiempo_residencia:</label>
                <input type="text" class="form-control" id=" tiempo_residencia" name=" tiempo_residencia" >
            </div>
            <!-- Email (AGREGANDO VALIDACIÓN) -->
            <div class="mb-3">
                <h4 for="email" class="form-label">Correo (Correo institucional o del Representante legal de la entidad)</h4>
                <input type="email" class="form-control" id="email" name="correo" required>
                <div id="emailError" class="error-message"></div>
            </div>
            
            <!-- Confirmación de email (NUEVO CAMPO) -->
            <div class="mb-3">
                <h4 for="email" class="form-label">Confirmar correo electrónico</h4>
                <input type="email" class="form-control" id="confirmar_email" name="confirmar_correo" required>
                <div id="emailMatchError" class="error-message"></div>
            </div>

            <!-- Contraseña (AGREGANDO VALIDACIÓN) -->
            <div class="mb-3">
                <h4 for="password" class="form-label">Contraseña:</h4> <br>
                <span>La contraseña debe contener mínimo 8 caracteres entre números y letras, al menos una letra mayúscula, al menos una letra minúscula, caracteres especiales y sin espacios en blanco.</span>
                <input type="password" class="form-control" id="pass" name="pass" required>
                <div id="passwordError" class="error-message"></div>
                <div id="passwordStrength" class="success-message"></div>
            </div>
            
            <!-- Confirmación de contraseña (NUEVO CAMPO) -->
            <div class="mb-3">
                <h4 for="password" class="form-label">Confirmar la contraseña:</h4> <br>
                <input type="password" class="form-control" id="confirmar_pass" name="confirmar_pass" required>
                <div id="passwordMatchError" class="error-message"></div>
            </div>

            <!-- Botón de envío (MANTENIENDO TU BOTÓN ORIGINAL) -->
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap (MANTENIENDO TUS SCRIPTS ORIGINALES) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Agregando solo las validaciones -->
    <script>
        // Validación en tiempo real del correo electrónico
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailError = document.getElementById('emailError');
            
            if (!validateEmail(email)) {
                emailError.textContent = 'Por favor ingrese un correo electrónico válido';
            } else {
                emailError.textContent = '';
            }
            checkEmailMatch();
        });

        // Validación en tiempo real de la confirmación de correo
        document.getElementById('confirmar_email').addEventListener('input', checkEmailMatch);

        function checkEmailMatch() {
            const email = document.getElementById('email').value;
            const confirmEmail = document.getElementById('confirmar_email').value;
            const emailMatchError = document.getElementById('emailMatchError');
            
            if (email && confirmEmail && email !== confirmEmail) {
                emailMatchError.textContent = 'Los correos electrónicos no coinciden';
                return false;
            } else {
                emailMatchError.textContent = '';
                return true;
            }
        }

        // Validación en tiempo real de la contraseña
        document.getElementById('pass').addEventListener('input', function() {
            const password = this.value;
            const passwordError = document.getElementById('passwordError');
            const passwordStrength = document.getElementById('passwordStrength');
            
            if (!validatePassword(password)) {
                passwordError.textContent = 'La contraseña no cumple con los requisitos';
                passwordStrength.textContent = '';
            } else {
                passwordError.textContent = '';
                passwordStrength.textContent = 'La contraseña es segura';
            }
            checkPasswordMatch();
        });

        // Validación en tiempo real de la confirmación de contraseña
        document.getElementById('confirmar_pass').addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            const password = document.getElementById('pass').value;
            const confirmPassword = document.getElementById('confirmar_pass').value;
            const passwordMatchError = document.getElementById('passwordMatchError');
            
            if (password && confirmPassword && password !== confirmPassword) {
                passwordMatchError.textContent = 'Las contraseñas no coinciden';
                return false;
            } else {
                passwordMatchError.textContent = '';
                return true;
            }
        }

        // Validación final del formulario
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const confirmEmail = document.getElementById('confirmar_email').value;
            const password = document.getElementById('pass').value;
            const confirmPassword = document.getElementById('confirmar_pass').value;
            
            // Validar correo
            if (!validateEmail(email)) {
                alert('Por favor ingrese un correo electrónico válido');
                event.preventDefault();
                return false;
            }
            
            // Validar coincidencia de correos
            if (!checkEmailMatch()) {
                alert('Los correos electrónicos no coinciden');
                event.preventDefault();
                return false;
            }
            
            // Validar contraseña
            if (!validatePassword(password)) {
                alert('La contraseña no cumple con los requisitos de seguridad');
                event.preventDefault();
                return false;
            }
            
            // Validar coincidencia de contraseñas
            if (!checkPasswordMatch()) {
                alert('Las contraseñas no coinciden');
                event.preventDefault();
                return false;
            }
            
            return true;
        });

        // Función para validar formato de correo electrónico
        function validateEmail(email) {
            const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(String(email).toLowerCase());
        }

        // Función para validar fortaleza de contraseña
        function validatePassword(password) {
            // Mínimo 8 caracteres, al menos una mayúscula, una minúscula, un número y un caracter especial
            const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return re.test(password);
        }
    </script>
</body>
</html>