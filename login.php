<?php
session_start();
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Login - PhishGuard</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .error-msg {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.8rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: center;
        }

        .success-msg {
            background: #d1fae5;
            color: #065f46;
            padding: 0.8rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
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

    <!-- Sección de Login -->
    <section class="hero"
        style="height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--primary-blue),var(--dark-blue));">
        <div
            style="background:white;padding:3rem;border-radius:20px;max-width:500px;width:90%;box-shadow:0 12px 30px rgba(0,0,0,0.4);text-align:center;">
            <div style="margin-bottom:2rem">
                <i class="fas fa-user-lock" style="font-size:3rem;color:var(--accent-green)"></i>
                <h2 style="margin-top:1rem;color:var(--dark-blue)">Iniciar Sesión</h2>
                <p style="color:var(--text-light)">Accede a tu cuenta para continuar</p>
            </div>

            <!-- Mensajes dinámicos -->
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="error-msg">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['logout_success'])) {
                echo '<div class="success-msg">' . htmlspecialchars($_SESSION['logout_success']) . '</div>';
                unset($_SESSION['logout_success']);
            }
            ?>

            <!-- Formulario de login -->
            <form action="login_process.php" method="POST" style="display:flex;flex-direction:column;gap:1.2rem">
                <input type="email" name="correo" placeholder="Correo electrónico" required
                    style="padding:1rem;border:2px solid #e2e8f0;border-radius:10px;font-size:1rem;" />
                <input type="password" name="password" placeholder="Contraseña" required
                    style="padding:1rem;border:2px solid #e2e8f0;border-radius:10px;font-size:1rem;" />
                <button type="submit" class="btn-submit" style="margin-top:1rem">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </form>

            <div style="margin-top:2rem;font-size:0.9rem;color:var(--text-light)">
                <p>
                    ¿No tienes cuenta? Regístrate desde la
                    <a href="index.html" style="color:var(--accent-green);font-weight:bold">pantalla principal</a>.
                </p>
            </div>
        </div>
    </section>
</body>

</html>