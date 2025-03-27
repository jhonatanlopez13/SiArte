<?php
require_once('../MODELO/userModel.php');
session_start();
if (isset($_POST['numdoc'])) {
    $numdoc = $_POST['numdoc'];
    $clave= $_POST['clave'];

    $Modelo = new UserModel();
     
    if ($Modelo->login($numdoc, $clave)) 
    {
        //var_dump($_SESSION);
        switch ($_SESSION['PERFIL']) 
        {
            case 1:
                echo('estudiante');         
            break;

            case 2:
                //header('Location: ../../PERSONAS/VISTA/index_profesor.php');
                echo('profesor');
            break;

            case 'admin':
                header('Location: ../vistas/vistaadmin.php');
                echo('mandarlo a la listaadmin');
                var_dump($_SESSION);
            break;
            
            default:
                header('Location: ../../index.php');
            break;
        }
    }
    else 
    {
        echo  "
        <script> alert('USUARIO Y/O CLAVE INCORRECTOS');  
        window.location.href = '../../index.php';
        </script>
        ";
        //header('Location: ../../index.php');
    }
}else
{
    header('Location: ../../index.php');
}


?>
