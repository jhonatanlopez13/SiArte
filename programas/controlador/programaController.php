<?php
require_once '../modelo/programaModel.php';

class ProgramaController {
    private $programaModel;

    public function __construct() {
        $this->programaModel = new ProgramaModel();
    }

    public function crearPrograma($nombre_programa, $descripcion, $fecha_inicio, $fecha_fin) {
        if ($this->programaModel->validarPrograma($nombre_programa)) {
            return [
                'success' => false,
                'message' => 'Ya existe un programa con ese nombre'
            ];
        }

        $resultado = $this->programaModel->crearPrograma($nombre_programa, $descripcion, $fecha_inicio, $fecha_fin);
        
        if ($resultado === true) {
            return [
                'success' => true,
                'message' => 'Programa creado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => $resultado
            ];
        }
    }

    public function editarPrograma($id, $nombre_programa, $descripcion, $fecha_inicio, $fecha_fin) {
        $resultado = $this->programaModel->editarPrograma($id, $nombre_programa, $descripcion, $fecha_inicio, $fecha_fin);
        
        if ($resultado === true) {
            return [
                'success' => true,
                'message' => 'Programa actualizado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => $resultado
            ];
        }
    }

    public function eliminarPrograma($id) {
        $resultado = $this->programaModel->eliminarPrograma($id);
        
        if ($resultado === true) {
            return [
                'success' => true,
                'message' => 'Programa eliminado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => $resultado
            ];
        }
    }

    public function obtenerPrograma($id) {
        return $this->programaModel->obtenerPrograma($id);
    }

    public function listarProgramas() {
        return $this->programaModel->listarProgramas();
    }

    public function buscarPrograma($termino) {
        return $this->programaModel->buscarPrograma($termino);
    }
} 