<?php
require_once('../modelo/userModel.php');

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
            case 'aspirante':
                header('Location: ../vistas/vistaUsuario.php');
                echo('estudiante');   
                echo $_SESSION;
                var_dump($_SESSION);      
            break;

            case 'jurado':
                header('Location: ../vistas/vistajurado.php');
                echo('mandarlo a la listaadmin');
                var_dump($_SESSION);
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
