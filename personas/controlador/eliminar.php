<?php


    require_once("../../config/db.php");
    require_once("../modelo/userModel.php");
   
    
    if(isset ($_GET['id'])){
        $id=$_GET['id'];
        $consultas = new UserModel();
        $mensaje=$consultas->Eliminiar($id);
        echo $mensaje;
        echo  '
            <script type="text/javascript">
                    alert("se elimino correctamente");
                    window.location.href="../vistas/listasUSuarios.php";
            </script>';
    }
    



?>