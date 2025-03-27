<?php
require_once '../../config/db.php';

class ProgramaModel {
    private $conexion;

    public function __construct() {
        $modelo = new Conexion();
        $this->conexion = $modelo->get_conexion();
    }

    public function crearPrograma($nombre_programa, $descripcion, $fecha_inicio, $fecha_fin) {
        try {
            $sql = "INSERT INTO programas (nombre_programa, descripcion, fecha_inicio, fecha_fin) 
                    VALUES (:nombre_programa, :descripcion, :fecha_inicio, :fecha_fin)";
            
            $statement = $this->conexion->prepare($sql);
            //$statement->bindParam(':nombre_programa', $nombre_programa);
            $statement->bindParam(':nombre_programa', $nombre_programa);
            $statement->bindParam(':descripcion', $descripcion);
            $statement->bindParam(':fecha_inicio', $fecha_inicio);
            $statement->bindParam(':fecha_fin', $fecha_fin);

            if (!$statement) {
                return "Error al preparar la consulta";
            } else {
                $statement->execute();
                return true;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function editarPrograma($id, $nombre_programa, $descripcion, $fecha_inicio, $fecha_fin) {
        try {
            $sql = "UPDATE programas SET 
                    nombre_programa = :nombre_programa,
                    descripcion = :descripcion,
                    fecha_inicio = :fecha_inicio,
                    fecha_fin = :fecha_fin
                    WHERE id = :id";
            
            $statement = $this->conexion->prepare($sql);
            $statement->bindParam(':id', $id);
            $statement->bindParam(':nombre_programa', $nombre_programa);
            $statement->bindParam(':descripcion', $descripcion);
            $statement->bindParam(':fecha_inicio', $fecha_inicio);
            $statement->bindParam(':fecha_fin', $fecha_fin);

            if (!$statement) {
                return "Error al preparar la consulta";
            } else {
                $statement->execute();
                return true;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function eliminarPrograma($id) {
        try {
            $sql = "DELETE FROM programas WHERE id = :id";
            $statement = $this->conexion->prepare($sql);
            $statement->bindParam(':id', $id);

            if (!$statement) {
                return "Error al preparar la consulta";
            } else {
                $statement->execute();
                return true;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function obtenerPrograma($id) {
        try {
            $sql = "SELECT * FROM programas WHERE id = :id";
            $statement = $this->conexion->prepare($sql);
            $statement->bindParam(':id', $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarProgramas() {
        try {
            $sql = "SELECT * FROM programas ORDER BY nombre_programa";
            $statement = $this->conexion->query($sql);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function buscarPrograma($termino) {
        try {
            $sql = "SELECT * FROM programas 
                    WHERE nombre_programa LIKE :termino 
                    OR descripcion LIKE :termino";
            $statement = $this->conexion->prepare($sql);
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
            $statement = $this->conexion->prepare($sql);
            $statement->bindParam(':nombre_programa', $nombre_programa);
            $statement->execute();
            return $statement->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
