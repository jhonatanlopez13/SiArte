<?php
    require_once '../../config/db.php';

    class proyectoModel{
        private $conexion;

        public function __construct() {
            $modelo = new Conexion();
            $this->conexion = $modelo->get_conexion();
        }

        public function crearproyecto( $id_persona_fk, $titulo, $objetivo_general, $productos, $comentarios, $id_programa_fk, $productos_servicios, $archivo_formato_presentacion, $archivo_presupuesto, $archivo_cronograma, $archivo_soportes_experiencia, $archivo_documentos_adicionales, $id_estado_proceso_fk, $fecha_cambio_estado, $id_usuario_cambio, $id_area_fk) {
            try {
                // Iniciar transacción
                $this->conexion->beginTransaction();

                // Insertar el proyecto
                $sql = "INSERT INTO proyectos (
                  $id_persona_fk,$titulo,$objetivo_general,$productos,$comentarios,$id_programa_fk,$productos_servicios,$archivo_formato_presentacion,$archivo_presupuesto,$archivo_cronograma,$archivo_soportes_experiencia,$archivo_documentos_adicionales,$id_estado_proceso_fk,$fecha_cambio_estado,$id_usuario_cambio,$id_area_fk
                ) VALUES (
                    :id_persona_fk, :titulo, :objetivo_general, :productos, :comentarios, :id_programa_fk, :productos_servicios, :archivo_formato_presentacion, :archivo_presupuesto, :archivo_cronograma, :archivo_soportes_experiencia, :archivo_documentos_adicionales, :id_estado_proceso_fk, :fecha_cambio_estado, :id_usuario_cambio, :id_area_fk
                )";

                $stmt = $this->conexion->prepare($sql);

                // Vincular parámetros
                $stmt->bindParam(':id_persona_fk', $id_persona_fk);
                $stmt->bindParam(':titulo',$titulo);
                $stmt->bindParam('objetivo_general',$objetivo_general);
                $stmt->bindParam('productos',$productos);
                $stmt->bindParam('comentarios',$comentarios);
                $stmt->bindParam('id_programa_fk',$id_programa_fk);
                $stmt->bindParam('productos_servicios',$productos_servicios);
                // $stmt->bindParam('archivo_formato_presentacion',$archivo_formato_presentacion);
                // $stmt->bindParam('archivo_presupuesto',$archivo_presupuesto);
                // $stmt->bindParam('archivo_cronograma',$archivo_cronograma);
                // $stmt->bindParam('archivo_soportes_experiencia',$archivo_soportes_experiencia);
                // $stmt->bindParam('archivo_documentos_adicionales',$archivo_documentos_adicionales);
                $stmt->bindParam('id_estado_proceso_fk', $id_estado_proceso_fk);
                $stmt->bindParam('fecha_cambio_estado', $fecha_cambio_estado);
                $stmt->bindParam('id_usuario_cambio',$id_usuario_cambio);
                $stmt->bindParam('id_area_fk', $id_area_fk);

                // Ejecutar la inserción
                if (!$stmt->execute()) {
                    throw new PDOException("Error al insertar el proyecto");
                }

                // Obtener el ID del proyecto insertado
                $id_proyecto = $this->conexion->lastInsertId();

                // Confirmar la transacción
                $this->conexion->commit();

                return [
                    'success' => true,
                    'message' => 'Proyecto creado correctamente',
                    'id_proyecto' => $id_proyecto
                ];

            } catch (PDOException $e) {
                // Revertir la transacción en caso de error
                $this->conexion->rollBack();
                
                error_log("Error en crearproyecto: " . $e->getMessage());
                return [
                    'success' => false,
                    'message' => "Error al crear el proyecto: " . $e->getMessage()
                ];
            }
        }

        public function cargarProyectos() {
            try {
                $sql = "SELECT p.*, pr.nombre_estimulo
                       FROM proyectos p
                       LEFT JOIN programas pr ON p.id_programa_fk = pr.id_programa
                       ORDER BY p.id_proyecto DESC";
                
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error en cargarProyectos: " . $e->getMessage());
                return false;
            }
        }

        public function eliminarProyecto($id_proyecto) {
            try {
                // Primero obtener las rutas de los archivos
                $sql_select = "SELECT archivo_formato_presentacion, archivo_presupuesto, 
                                     archivo_cronograma, archivo_soportes_experiencia, 
                                     archivo_documentos_adicionales 
                              FROM proyectos 
                              WHERE id_proyecto = :id_proyecto";
                
                $stmt = $this->conexion->prepare($sql_select);
                $stmt->bindParam(':id_proyecto', $id_proyecto);
                $stmt->execute();
                $archivos = $stmt->fetch(PDO::FETCH_ASSOC);

                // Eliminar archivos físicos
                foreach ($archivos as $ruta) {
                    if ($ruta && file_exists($ruta)) {
                        unlink($ruta);
                    }
                }

                // Eliminar registro de la base de datos
                $sql_delete = "DELETE FROM proyectos WHERE id_proyecto = :id_proyecto";
                $stmt = $this->conexion->prepare($sql_delete);
                $stmt->bindParam(':id_proyecto', $id_proyecto);
                
                if ($stmt->execute()) {
                    return [
                        'success' => true,
                        'message' => 'Proyecto eliminado correctamente'
                    ];
                } else {
                    throw new PDOException("Error al eliminar el proyecto");
                }

            } catch (PDOException $e) {
                error_log("Error en eliminarProyecto: " . $e->getMessage());
                return [
                    'success' => false,
                    'message' => "Error al eliminar el proyecto: " . $e->getMessage()
                ];
            }
        }
    }

?>