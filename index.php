<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>siArte</title>
</head>
<body>
    <div class="container">
       <div class="col-md-7 fondoprincipal">
       </div>
       <div class="col-md-12">
        <div class="card CARD1" style="width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title text-center">Inicio de sesión</h1>
                        <form action="./personas/controlador/login.php" method="post" class="formulario2">
                        
                            <input type="text"  class="form-control" name="numdoc" required autocomplete="off" placeholder="Número de documento o NIT ">
                        
                            <input type="password"  class="form-control" name="clave" required autocomplete="off" placeholder="Contraseña">
                            <br>
                            
                            <input class="btn btn-outline-primary" type="submit" value="INGRESAR">
                        </form>

                        
                        <a href="recuperar_clave.php" class="boton-menu">¿Olvidaste tu contraseña?</a>
                        <a href="./personas/vistas/crear.php" class="boton-menu">Registrarse</a>
                </div>
            </div>
       </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>