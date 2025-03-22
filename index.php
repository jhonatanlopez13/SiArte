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
       <div class="col-md-4">
        <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title">INICIO DE SESSION</h1>
                        <form action="PERSONAS/CONTROLADOR/login.php" method="post" class="formulario2">
                        NÚMERO DE DOCUMENTO:
                        <input type="text" name="numdoc" required autocomplete="off" placeholder="Número de Documento">
                        pass: 
                        <input type="password" name="clave" required autocomplete="off" placeholder="pass">
                        <input type="submit" value="Entrar">
                        </form>

                        
                        <a href="recuperar_clave.php" class="boton-menu">¿olvidaste tu clave?</a>
                        <a href="./personas/vistas/crear.php" class="boton-menu">registrarse</a>
                </div>
            </div>
       </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>