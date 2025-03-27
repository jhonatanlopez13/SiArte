<?php
    require_once '../modelo/userModel.php';
    session_start();
    if($_SESSION['PERFIL']=='admin')
    {

    }else
    {
        header('Location: ../../index.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Menú Principal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --hover-color: #3a56d4;
            --text-light: #f8f9fa;
            --bg-light: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-custom {
            background-color: var(--bg-light);
            box-shadow: var(--shadow);
            padding: 0.8rem 1rem;
        }
        
        .navbar-brand-custom {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .nav-link-custom {
            color: #495057;
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-link-custom:hover, .nav-link-custom:focus {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .dropdown-menu-custom {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-item-custom {
            padding: 0.5rem 1.5rem;
            color: #495057;
            transition: all 0.2s ease;
        }
        
        .dropdown-item-custom:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .active-menu {
            color: var(--primary-color) !important;
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }
        
        .navbar-toggler-custom {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler-custom:focus {
            box-shadow: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="index.php">
                <i class="bi bi-stack me-2"></i>Sistema
            </a>
            
            <button class="navbar-toggler navbar-toggler-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list" style="font-size: 1.75rem;"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Menú Usuarios -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-people me-1"></i>Usuarios
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="usuariosDropdown">
                            <li><a class="dropdown-item dropdown-item-custom" href="personas/vistas/crear.php"><i class="bi bi-person-plus me-2"></i>Crear Usuario</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="personas/vistas/editar.php"><i class="bi bi-pencil-square me-2"></i>Editar Usuario</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="personas/vistas/listasUsuarios.php"><i class="bi bi-list-ul me-2"></i>Lista de Usuarios</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="personas/vistas/vistaUsuario.php"><i class="bi bi-eye me-2"></i>Vista Usuario</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="recuperar_clave.php"><i class="bi bi-key me-2"></i>Recuperar Clave</a></li>
                        </ul>
                    </li>
                    
                    <!-- Menú Programas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="programasDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-collection-play me-1"></i>Programas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="programasDropdown">
                            <li><a class="dropdown-item dropdown-item-custom" href="programas/vistas/crearProgramas.php"><i class="bi bi-plus-circle me-2"></i>Crear Programa</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="programas/vistas/editarProgramas.php"><i class="bi bi-pencil me-2"></i>Editar Programa</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="programas/vistas/listaProgramas.php"><i class="bi bi-card-list me-2"></i>Lista de Programas</a></li>
                        </ul>
                    </li>
                    
                    <!-- Menú Convocatorias -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="convocatorias/vistas/">
                            <i class="bi bi-megaphone me-1"></i>Convocatorias
                        </a>
                    </li>
                </ul>
                
                <!-- Menú derecha -->
                <div class="d-flex">
                    <div class="dropdown">
                        <a class="btn btn-primary-custom text-white dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>Mi Cuenta
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item dropdown-item-custom" href="#"><i class="bi bi-person me-2"></i><?php echo $_SESSION['NOMBRE'] ?></a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="#"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="#"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<h1>usuario</h1>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Marcar elemento activo
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop() || 'index.php';
            const navLinks = document.querySelectorAll('.nav-link-custom, .dropdown-item-custom');
            
            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href').split('/').pop();
                if (currentPage.includes(linkPage) {
                    link.classList.add('active-menu');
                    
                    // Subir hasta el menú padre para activarlo también
                    let parent = link.closest('.dropdown-menu');
                    if (parent) {
                        const parentLink = document.querySelector(`[aria-labelledby="${parent.getAttribute('aria-labelledby')}"]`);
                        if (parentLink) {
                            parentLink.classList.add('active-menu');
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>