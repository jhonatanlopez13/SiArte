<?php
require_once '../modelo/convocatoriaModel.php';

class ConvocatoriaController {
    private $convocatoriaModel;

    public function __construct() {
        $this->convocatoriaModel = new ConvocatoriaModel();
    }

    public function crearConvocatoria($datos) {
        // Validar datos requeridos
        if (empty($datos['nombre_convocatoria']) || empty($datos['id_programa']) || 
            empty($datos['fecha_inicio']) || empty($datos['fecha_fin']) || 
            empty($datos['cupos'])) {
            return [
                'success' => false,
                'message' => 'Todos los campos son obligatorios'
            ];
        }

        // Validar que las fechas sean válidas
        $fecha_inicio = strtotime($datos['fecha_inicio']);
        $fecha_fin = strtotime($datos['fecha_fin']);
        
        if ($fecha_inicio === false || $fecha_fin === false) {
            return [
                'success' => false,
                'message' => 'Las fechas proporcionadas no son válidas'
            ];
        }

        // Validar que la fecha de fin no sea anterior a la de inicio
        if ($fecha_fin < $fecha_inicio) {
            return [
                'success' => false,
                'message' => 'La fecha de fin no puede ser anterior a la fecha de inicio'
            ];
        }

        // Validar que el cupo sea positivo
        if ($datos['cupos'] <= 0) {
            return [
                'success' => false,
                'message' => 'El número de cupos debe ser mayor a 0'
            ];
        }

        // Validar que no exista una convocatoria con el mismo nombre
        if ($this->convocatoriaModel->validarConvocatoria($datos['nombre_convocatoria'])) {
            return [
                'success' => false,
                'message' => 'Ya existe una convocatoria con ese nombre'
            ];
        }

        // Intentar crear la convocatoria
        $resultado = $this->convocatoriaModel->crearConvocatoria($datos);
        
        if (!$resultado['success']) {
            return [
                'success' => false,
                'message' => 'Error al crear la convocatoria: ' . $resultado['message']
            ];
        }

        return [
            'success' => true,
            'message' => 'Convocatoria creada correctamente'
        ];
    }

    public function editarConvocatoria($id, $datos) {
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

        return $this->convocatoriaModel->editarConvocatoria($id, $datos);
    }

    public function eliminarConvocatoria($id) {
        if (empty($id)) {
            return [
                'success' => false,
                'message' => 'ID de convocatoria no válido'
            ];
        }

        return $this->convocatoriaModel->eliminarConvocatoria($id);
    }

    public function obtenerConvocatoria($id) {
        if (empty($id)) {
            return false;
        }

        return $this->convocatoriaModel->obtenerConvocatoria($id);
    }

    public function listarConvocatorias() {
        return $this->convocatoriaModel->listarConvocatorias();
    }

    public function listarProgramas() {
        return $this->convocatoriaModel->listarProgramas();
    }

    public function buscarConvocatoria($busqueda) {
        if (empty($busqueda)) {
            return $this->listarConvocatorias();
        }

        return $this->convocatoriaModel->buscarConvocatoria($busqueda);
    }

    public function cambiarEstado($id, $estado) {
        if (empty($id) || !in_array($estado, [0, 1])) {
            return [
                'success' => false,
                'message' => 'Parámetros inválidos'
            ];
        }

        return $this->convocatoriaModel->cambiarEstado($id, $estado);
    }
}
?> 