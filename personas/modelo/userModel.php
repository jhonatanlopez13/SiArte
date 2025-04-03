<?php
require_once '../../config/db.php';

class UserModel {
   
    public function login($numdoc, $clave) {
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        
        $sql = "SELECT a.*, b.nombreTipopersona 
                FROM personas a
                JOIN tipo_persona b ON a.id_tipo_persona_fk = b.id
                WHERE a.numero_documento = :numdoc";
        
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':numdoc', $numdoc);
        $statement->execute();
        
        if ($statement->rowCount() == 1) {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            // Comparación directa de contraseña (sin password_verify)
            if ($clave == $result['pass']) {
                $_SESSION['ID'] = $result['id_persona'];
                $_SESSION['NOMBRE'] = $result['nombres'];
                $_SESSION['PERFIL'] = $result['nombreTipopersona'];
                $_SESSION['NUMERO'] = $result['numero_documento']; 
                return true;
            }
        }
        
        return false;
    }

    public function createUser(
        $id_tipo_persona_fk, $id_tipo_proponente_fk, $id_tipo_Documento_fk, 
        $numero_documento, $nombres, $apellidos, $genero_fk, 
        $vereda_centro_poblado, $direccion, $celular, $correo, $pass, 
        $nombre_representante, $tiempo_residencia,
        $anexo1_persona_natural, $anexo2_grupos_constituidos, $anexo3_persona_juridica,
        $copia_documento_identidad, $certificado_residencia, $copia_rut, $certificado_sicut,
        $estado_anexo1, $estado_anexo2, $estado_anexo3,
        $estado_copia_documento, $estado_certificado_residencia,
        $estado_copia_rut, $estado_certificado_sicut
    ) {
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        
        $sql = "INSERT INTO personas (
                id_tipo_persona_fk, id_tipo_proponente_fk, id_tipo_Documento_fk,
                numero_documento, nombres, apellidos, genero_fk,
                vereda_centro_poblado, direccion, celular, correo, pass,
                nombre_representante, tiempo_residencia,
                estado_anexo1, estado_anexo2, estado_anexo3,
                estado_copia_documento, estado_certificado_residencia,
                estado_copia_rut, estado_certificado_sicut
            ) VALUES (
                :id_tipo_persona_fk, :id_tipo_proponente_fk, :id_tipo_Documento_fk,
                :numero_documento, :nombres, :apellidos, :genero_fk,
                :vereda_centro_poblado, :direccion, :celular, :correo, :pass,
                :nombre_representante, :tiempo_residencia,
                :estado_anexo1, :estado_anexo2, :estado_anexo3,
                :estado_copia_documento, :estado_certificado_residencia,
                :estado_copia_rut, :estado_certificado_sicut
            )";
        
        try {
            $statement = $conexion->prepare($sql);
            
            // Vincular parámetros
            $statement->bindParam(':id_tipo_persona_fk', $id_tipo_persona_fk);
            $statement->bindParam(':id_tipo_proponente_fk', $id_tipo_proponente_fk);
            $statement->bindParam(':id_tipo_Documento_fk', $id_tipo_Documento_fk);
            $statement->bindParam(':numero_documento', $numero_documento);
            $statement->bindParam(':nombres', $nombres);
            $statement->bindParam(':apellidos', $apellidos);
            $statement->bindParam(':genero_fk', $genero_fk);
            $statement->bindParam(':vereda_centro_poblado', $vereda_centro_poblado);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':celular', $celular);
            $statement->bindParam(':correo', $correo);
            $statement->bindParam(':pass', $pass);
            $statement->bindParam(':nombre_representante', $nombre_representante);
            $statement->bindParam(':tiempo_residencia', $tiempo_residencia);
            $statement->bindParam(':estado_anexo1', $estado_anexo1);
            $statement->bindParam(':estado_anexo2', $estado_anexo2);
            $statement->bindParam(':estado_anexo3', $estado_anexo3);
            $statement->bindParam(':estado_copia_documento', $estado_copia_documento);
            $statement->bindParam(':estado_certificado_residencia', $estado_certificado_residencia);
            $statement->bindParam(':estado_copia_rut', $estado_copia_rut);
            $statement->bindParam(':estado_certificado_sicut', $estado_certificado_sicut);
            
            $statement->execute();
            
            // Obtener el ID del nuevo registro
            $id_persona = $conexion->lastInsertId();
            
            // Procesar archivos subidos (aquí deberías implementar tu lógica para guardar los archivos)
            // ...
            
            // return "Usuario creado correctamente con ID: " . $id_persona;
          
            echo  '
            <script type="text/javascript">
                    alert("se creo correctamente el usuario");
                    window.location.href="../";
            </script>';
          
            
        } catch (PDOException $e) {
            error_log("Error en createUser: " . $e->getMessage());
            return "Error al crear el usuario: " . $e->getMessage();
        }
    }
    public function CargarUsuario() {
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql = "SELECT * FROM personas";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function Eliminiar($id_persona) {
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        
        try {
            // 1. Primero eliminar registros relacionados en `convocatoria`
            $sql_delete_convocatorias = "DELETE FROM convocatoria WHERE id_persona_fk = :id_persona";
            $stmt_convocatorias = $conexion->prepare($sql_delete_convocatorias);
            $stmt_convocatorias->bindParam(':id_persona', $id_persona);
            $stmt_convocatorias->execute();
    
            // 2. Ahora eliminar el usuario
            $sql_delete_persona = "DELETE FROM personas WHERE id_persona = :id_persona";
            $stmt_persona = $conexion->prepare($sql_delete_persona);
            $stmt_persona->bindParam(':id_persona', $id_persona);
            $stmt_persona->execute();
    
            return "Usuario y registros relacionados eliminados correctamente.";
        } catch (PDOException $e) {
            return "Error al eliminar: " . $e->getMessage();
        }
    }

    public function BuscarPersona($nombres){
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $nombres = "%".$nombres."%";
        $sql = "SELECT * FROM personas where nombres like :nombres";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(":nombres",$nombres);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function cargarusuaro1($id_persona) {
        $rows = null;
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $sql = "SELECT * FROM personas WHERE id_persona = :id_persona"; // ✅ Nombre correcto
        $statement = $conexion->prepare($sql);
        $statement->bindParam(":id_persona", $id_persona);
        $statement->execute();
        
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function modificarUsuario(
        $id_persona, 
        $id_tipo_proponente_fk, 
        $numero_documento, 
        $nombres, 
        $apellidos, 
        $genero_fk, 
        $id_vereda_fk, 
        $direccion, 
        $celular, 
        $nombre_representante, 
        $documento_representante, 
        $tiempo_residencia,
        $archivos
    ) {
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        
        // Construir la consulta SQL dinámica
        $sql = "UPDATE personas SET
                id_tipo_proponente_fk = :id_tipo_proponente_fk,
                numero_documento = :numero_documento,
                nombres = :nombres,
                apellidos = :apellidos,
                genero_fk = :genero_fk,
                id_vereda_fk = :id_vereda_fk,
                direccion = :direccion,
                celular = :celular,
                nombre_representante = :nombre_representante,
                documento_representante = :documento_representante,
                tiempo_residencia = :tiempo_residencia";
        
        // Agregar campos de archivos solo si no son null
        foreach ($archivos as $campo => $valor) {
            if ($valor !== null) {
                $sql .= ", $campo = :$campo";
            }
        }
        
        $sql .= " WHERE id_persona = :id_persona";
        
        try {
            $stmt = $conexion->prepare($sql);
            
            // Bind de parámetros básicos
            $stmt->bindParam(':id_persona', $id_persona);
            $stmt->bindParam(':id_tipo_proponente_fk', $id_tipo_proponente_fk);
            $stmt->bindParam(':numero_documento', $numero_documento);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':genero_fk', $genero_fk);
            $stmt->bindParam(':id_vereda_fk', $id_vereda_fk);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':nombre_representante', $nombre_representante);
            $stmt->bindParam(':documento_representante', $documento_representante);
            $stmt->bindParam(':tiempo_residencia', $tiempo_residencia);
            
            // Bind de archivos solo si no son null
            foreach ($archivos as $campo => $valor) {
                if ($valor !== null) {
                    $stmt->bindParam(":$campo", $archivos[$campo]);
                }
            }
            
            if ($stmt->execute()) {
                return "Usuario actualizado correctamente";
            } else {
                return "Error al ejecutar la consulta";
            }
        } catch (PDOException $e) {
            error_log("Error en modificarUsuario: " . $e->getMessage());
            return "Error al modificar el usuario: " . $e->getMessage();
        }
    }
    // public function cambiarClave($id, $pass){
    //     $modelo = new Conexion();
    //     $conexion = $modelo->get_conexion();
    //     $sql = "UPDATE personas SET pass=:pass WHERE id=:id";

    //     $statement = $conexion->prepare($sql);

    //     $statement->bindParam(':pass', $pass);
    //     $statement->bindParam(':id', $id);
        
    //     if (!$statement) {
    //         return "Error al modificar la contraseña.";
    //     } else {
    //        $statement->execute();
    //         return "Se modificó la contraseña correctamente.";
    //     }
    // }
}
?>