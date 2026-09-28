<?php
session_start();

// Destruimos la sesión actual
session_destroy();

// Creamos una nueva sesión y guardamos el flag de logout
session_start();
$_SESSION['logout_success'] = "✅ Sesión cerrada correctamente. Vuelve a iniciar sesión.";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sesión Cerrada - PhishGuard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Redirige en 5 segundos al login.php -->
    <meta http-equiv="refresh" content="5;url=login.php">
</head>

<body>
    <!-- Header con menú -->
    <header class="header">
        <div class="container">
            <a href="index.html" class="logo">
                <i class="fas fa-shield-alt"></i>
                <span>PhishGuard</span>
            </a>
            <nav class="nav">
                <a href="index.html">Inicio</a>
                <a href="index.html#caracteristicas">Características</a>
                <a href="index.html#educacion">Aprende</a>
                <a href="index.html#contacto">Contacto</a>
            </nav>
        </div>
    </header>

    <!-- Pantalla de confirmación -->
    <section class="hero"
        style="height:100vh; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, var(--primary-blue), var(--dark-blue));">
        <div
            style="background:white; padding:3rem; border-radius:20px; max-width:600px; width:90%; box-shadow:0 12px 30px rgba(0,0,0,0.4); text-align:center;">
            <div style="margin-bottom:2rem;">
                <i class="fas fa-door-open" style="font-size:3rem; color:var(--accent-green);"></i>
                <h1 style="margin-top:1rem; color:var(--dark-blue);">Sesión Cerrada</h1>
                <p style="color:var(--text-light);">
                    Has cerrado tu sesión correctamente.<br>
                    Serás redirigido al login en unos segundos.
                </p>
            </div>
            <a href="login.php" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Ir al Login
            </a>
        </div>
    </section>
</body>

</html>