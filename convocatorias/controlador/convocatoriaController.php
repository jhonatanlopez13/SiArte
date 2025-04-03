<?php
require_once '../modelo/convocatoriaModel.php';

class ConvocatoriaController {
    private $convocatoriaModel;

    public function __construct() {
        $this->convocatoriaModel = new ConvocatoriaModel();
    }

   

    public function editarConvocatoria($id_detalle , $datos) {
        // Validar que todos los campos requeridos estén presentes
        if (empty($datos['nombre_convocatoria']) || empty($datos['descripcion']) || 
            empty($datos['fecha_inicio']) || empty($datos['fecha_fin']) || 
            empty($datos['id_programa']) || empty($datos['cupos'])) {
            return [
                'success' => false,
                'message' => 'Todos los campos son obligatorios'
            ];
        }

        // Validar que la fecha de fin no sea anterior a la fecha de inicio
        if ($datos['fecha_fin'] < $datos['fecha_inicio']) {
            return [
                'success' => false,
                'message' => 'La fecha de fin no puede ser anterior a la fecha de inicio'
            ];
        }

        // Validar que el número de cupos sea positivo
        if ($datos['cupos'] <= 0) {
            return [
                'success' => false,
                'message' => 'El número de cupos debe ser mayor a 0'
            ];
        }

        return $this->convocatoriaModel->editarConvocatoria($id_detalle , $datos);
    }

    public function eliminarConvocatoria($id_detalle ) {
        if (empty($id_detalle )) {
            return [
                'success' => false,
                'message' => 'ID de convocatoria no válido'
            ];
        }

        return $this->convocatoriaModel->eliminarConvocatoria($id_detalle );
    }

    public function obtenerConvocatoria($id_detalle ) {
        if (empty($id_detalle )) {
            return false;
        }

        return $this->convocatoriaModel->obtenerConvocatoria($id_detalle );
    }

    public function listarConvocatorias() {
        return $this->convocatoriaModel->listarConvocatorias();
    }


    public function buscarConvocatoria($busqueda) {
        if (empty($busqueda)) {
            return $this->listarConvocatorias();
        }

        return $this->convocatoriaModel->buscarConvocatoria($busqueda);
    }

    public function cambiarEstado($id_detalle , $estado) {
        if (empty($id_detalle ) || !in_array($estado, [0, 1])) {
            return [
                'success' => false,
                'message' => 'Parámetros inválidos'
            ];
        }

        return $this->convocatoriaModel->cambiarEstado($id_detalle , $estado);
    }
}
?> 