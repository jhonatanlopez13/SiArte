<?php
require_once dirname(__DIR__, 2) . '/config/db.php';

class ProgramaModel {
    private $db;

    public function __construct() {
        $modelo = new Conexion();
        $this->db = $modelo->get_conexion();
    }

    public function obtenerPrograma($id) {
        try {
            $sql = "SELECT * FROM programas WHERE id_programa = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerPrograma: " . $e->getMessage());
            return false;
        }
    }

    public function crearPrograma($nombre_programa, $descripcion, $fecha_inicio, $fecha_fin) {
        try {
            $sql = "INSERT INTO programas (nombre_programa, descripcion, fecha_inicio, fecha_fin) 
                    VALUES (:nombre_programa, :descripcion, :fecha_inicio, :fecha_fin)";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':nombre_programa', $nombre_programa);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Programa creado correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al crear el programa'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function editarPrograma($id, $nombre_programa, $descripcion, $fecha_inicio, $fecha_fin) {
        try {
            $sql = "UPDATE programas 
                    SET nombre_programa = :nombre_programa,
                        descripcion = :descripcion,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin
                    WHERE id_programa = :id";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre_programa', $nombre_programa);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Programa actualizado correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar el programa'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function listarProgramas() {
        try {
            $sql = "SELECT * FROM programas ORDER BY nombre_programa";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en listarProgramas: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarPrograma($id) {
        try {
            // Primero verificar si el programa existe
            $programa = $this->obtenerPrograma($id);
            if (!$programa) {
                return [
                    'success' => false,
                    'message' => 'El programa no existe'
                ];
            }

            $sql = "DELETE FROM programas WHERE id_programa = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Programa eliminado correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al eliminar el programa'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function buscarPrograma($termino) {
        try {
            $sql = "SELECT * FROM programas 
                    WHERE nombre_programa LIKE :termino 
                    OR descripcion LIKE :termino";
            $statement = $this->db->prepare($sql);
            $termino = "%$termino%";
            $statement->bindParam(':termino', $termino);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function validarPrograma($nombre_programa) {
        try {
            $sql = "SELECT COUNT(*) FROM programas WHERE nombre_programa = :nombre_programa";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':nombre_programa', $nombre_programa);
            $statement->execute();
            return $statement->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
