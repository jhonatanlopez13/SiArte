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
       $rows =null ;
       $modelo= new Conexion();
       $conexion= $modelo ->get_conexion();
       $sql ="SELECT a.id_detalle,b.nombre_programa,c.nombres,c.apellidos,d.nombre_estado,a.convocatoria_estado FROM convocatoria a , programas b, personas c,estado_proceso d";
       $statement =$conexion ->prepare($sql);
       $statement->execute();
       while($result = $statement->fetch()){
        $rows[]=$result;
       } 
       return$rows;
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

    
}
?> 