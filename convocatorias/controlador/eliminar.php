<?php
require_once("../../config/db.php");
require_once("../modelo/convocatoriaModel.php");

if(isset($_GET['id_detalle'])){
    $id_detalle =$_GET['id_detalle '];
    $consulta =new ConvocatoriaModel();
    $mensaje = $consulta->eliminarConvocatoria($id_detalle);
    echo $mensaje;
    echo  '
        <script type="text/javascript">
                alert("se elimino correctamente");
                window.location.href="../vistas/Convocatorias.php";
        </script>';
}