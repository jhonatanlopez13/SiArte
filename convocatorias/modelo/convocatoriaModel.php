<?php
require_once __DIR__ . '/../../config/db.php';

class ConvocatoriaModel {
    private $db;
    private $convocatorias = 'convocatorias';
    private $programas = 'programas';

    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->get_conexion();
    }

    public function crearConvocatoria($datos) {
        try {
            // Validar fechas contra el programa
            $validacionFechas = $this->validarFechasPrograma(
                $datos['id_programa'],
                $datos['fecha_inicio'],
                $datos['fecha_fin']
            );

            if (!$validacionFechas['success']) {
                return $validacionFechas;
            }

            $sql = "INSERT INTO {$this->convocatorias} (nombre_convocatoria, descripcion, fecha_inicio, fecha_fin, id_programa, cupos, estado) 
                    VALUES (:nombre_convocatoria, :descripcion, :fecha_inicio, :fecha_fin, :id_programa, :cupos, 1)";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':nombre_convocatoria', $datos['nombre_convocatoria']);
            $stmt->bindParam(':descripcion', $datos['descripcion']);
            $stmt->bindParam(':fecha_inicio', $datos['fecha_inicio']);
            $stmt->bindParam(':fecha_fin', $datos['fecha_fin']);
            $stmt->bindParam(':id_programa', $datos['id_programa']);
            $stmt->bindParam(':cupos', $datos['cupos']);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Convocatoria creada correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al crear la convocatoria'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function editarConvocatoria($id, $datos) {
        try {
            // Validar fechas contra el programa
            $validacionFechas = $this->validarFechasPrograma(
                $datos['id_programa'],
                $datos['fecha_inicio'],
                $datos['fecha_fin']
            );

            if (!$validacionFechas['success']) {
                return $validacionFechas;
            }

            $sql = "UPDATE {$this->convocatorias} 
                    SET nombre_convocatoria = :nombre_convocatoria,
                        descripcion = :descripcion,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin,
                        id_programa = :id_programa,
                        cupos = :cupos
                    WHERE id_convocatoria = :id";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre_convocatoria', $datos['nombre_convocatoria']);
            $stmt->bindParam(':descripcion', $datos['descripcion']);
            $stmt->bindParam(':fecha_inicio', $datos['fecha_inicio']);
            $stmt->bindParam(':fecha_fin', $datos['fecha_fin']);
            $stmt->bindParam(':id_programa', $datos['id_programa']);
            $stmt->bindParam(':cupos', $datos['cupos']);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Convocatoria actualizada correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar la convocatoria'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function eliminarConvocatoria($id) {
        try {
            $sql = "DELETE FROM {$this->convocatorias} WHERE id_convocatoria = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Convocatoria eliminada correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al eliminar la convocatoria'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function obtenerConvocatoria($id) {
        try {
            $sql = "SELECT c.*, p.nombre_programa 
                    FROM {$this->convocatorias} c 
                    INNER JOIN {$this->programas} p ON c.id_programa = p.id_programa 
                    WHERE c.id_convocatoria = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarConvocatorias() {
        try {
            $sql = "SELECT c.*, p.nombre_programa 
                    FROM {$this->convocatorias} c 
                    INNER JOIN {$this->programas} p ON c.id_programa = p.id_programa 
                    WHERE c.estado = 1 
                    ORDER BY c.fecha_inicio DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarProgramas() {
        try {
            $sql = "SELECT id_programa, nombre_programa, fecha_inicio, fecha_fin 
                    FROM {$this->programas} 
                    WHERE estado = 1 
                    ORDER BY nombre_programa";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function buscarConvocatoria($busqueda) {
        try {
            $sql = "SELECT c.*, p.nombre_programa 
                    FROM {$this->convocatorias} c 
                    INNER JOIN {$this->programas} p ON c.id_programa = p.id_programa 
                    WHERE c.estado = 1 
                    AND (c.nombre_convocatoria LIKE :busqueda 
                    OR c.descripcion LIKE :busqueda 
                    OR p.nombre_programa LIKE :busqueda)
                    ORDER BY c.fecha_inicio DESC";
            
            $busqueda = "%{$busqueda}%";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':busqueda', $busqueda);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function validarConvocatoria($nombre) {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->convocatorias} WHERE nombre_convocatoria = :nombre AND estado = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function cambiarEstado($id, $estado) {
        try {
            $sql = "UPDATE {$this->convocatorias} SET estado = :estado WHERE id_convocatoria = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':estado', $estado);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Estado de la convocatoria actualizado correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar el estado de la convocatoria'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }

    public function validarFechasPrograma($id_programa, $fecha_inicio, $fecha_fin) {
        try {
            $sql = "SELECT fecha_inicio, fecha_fin FROM {$this->programas} WHERE id_programa = :id_programa";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_programa', $id_programa);
            $stmt->execute();
            $programa = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$programa) {
                return [
                    'success' => false,
                    'message' => 'Programa no encontrado'
                ];
            }

            if ($fecha_inicio < $programa['fecha_inicio'] || $fecha_fin > $programa['fecha_fin']) {
                return [
                    'success' => false,
                    'message' => 'Las fechas de la convocatoria deben estar dentro del rango de fechas del programa'
                ];
            }

            return [
                'success' => true,
                'message' => 'Fechas válidas'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error al validar fechas: ' . $e->getMessage()
            ];
        }
    }
}
?> 