<?php
    require_once("../modelo/convocatoriaModel.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
    $ConvocatoriaModel = new ConvocatoriaModel();
    $datos=[
       'nombre_convocatoria'=>$_POST['nombre_convocatoria'],'id_programa'=>$_POST['id_programa'],
       'descripcion'=>$_POST['descripcion'],
       'id_estado_convocatoria'=>$_POST['id_estado_convocatoria']

    ];
    if($ConvocatoriaModel->crearConvocatoria($datos)){
      echo 
        '<script>
            alert("covocatoria creado exitosamente");
            window.location.href = "../vistas/listaConvocatorias.php";
        </script>';
    }else {
        echo '<script>
            alert("Error al crear la convocatoria");
            window.history.back();
        </script>';
    }
}
?>