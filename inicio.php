<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // corregido: antes apuntaba a login.html
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio - PhishGuard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <!-- Menú de usuario -->
            <div class="user-menu">
                <!-- Avatar con inicial -->
                <div class="avatar" id="userAvatar">
                    <?php echo strtoupper(substr(htmlspecialchars($_SESSION['usuario']), 0, 1)); ?>
                </div>
                <!-- Dropdown oculto -->
                <div class="dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                    </div>
                    <a href="#"><i class="fas fa-user"></i> Perfil</a>
                    <a href="#"><i class="fas fa-cog"></i> Configuración</a>
                    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    <hr>
                    <button id="toggleTheme" class="theme-btn">
                        <i class="fas fa-adjust"></i> Cambiar Tema
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Dashboard principal -->
    <section class="dashboard" style="margin-top:100px;">
        <div class="container">
            <h2 class="section-title">Explorar y Aprender</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon-wrapper green"><i class="fas fa-envelope-open-text"></i></div>
                    <h3>Simulador de Phishing</h3>
                    <p>Practica identificando correos sospechosos.</p>
                    <a href="#simulador" class="btn-primary">Iniciar</a>
                </div>
                <div class="feature-card">
                    <div class="icon-wrapper blue"><i class="fas fa-link"></i></div>
                    <h3>Verificador de Enlaces</h3>
                    <p>Analiza URLs y aprende a detectar riesgos.</p>
                    <a href="#verificador" class="btn-primary">Probar</a>
                </div>
                <div class="feature-card">
                    <div class="icon-wrapper orange"><i class="fas fa-question-circle"></i></div>
                    <h3>Quiz Rápido</h3>
                    <p>Responde preguntas y gana puntos.</p>
                    <a href="#quiz" class="btn-primary">Comenzar</a>
                </div>
                <div class="feature-card">
                    <div class="icon-wrapper purple"><i class="fas fa-book"></i></div>
                    <h3>Recursos</h3>
                    <p>Tips y documentos para reforzar tu conocimiento.</p>
                    <a href="#recursos" class="btn-primary">Ver más</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Simulador -->
    <section class="simulador" id="simulador">
        <div class="container">
            <h2 class="section-title">Simulador de Phishing</h2>
            <div id="correoSimulado" class="correo-card"></div>
            <div class="simulador-buttons">
                <button onclick="verificarRespuesta('phishing')" class="btn-primary">Es Phishing</button>
                <button onclick="verificarRespuesta('seguro')" class="btn-primary">Es Seguro</button>
            </div>
        </div>
    </section>

    <!-- Verificador de Enlaces -->
    <section class="verificador" id="verificador">
        <div class="container">
            <h2 class="section-title">Verificador de Enlaces</h2>
            <div class="url-card">
                <div class="url-header">
                    <i class="fas fa-shield-alt"></i>
                    <span>Analiza tu enlace</span>
                </div>
                <div class="url-input">
                    <i class="fas fa-link"></i>
                    <input type="text" id="linkInput" placeholder="Pega aquí un enlace sospechoso" />
                    <button onclick="verificarEnlace()" class="btn-primary">Verificar</button>
                </div>
                <div id="resultadoLink" class="url-result">Ingresa un enlace para analizarlo</div>
            </div>
        </div>
    </section>

    <!-- Quiz -->
    <section class="quiz" id="quiz">
        <div class="container">
            <h2 class="section-title">Quiz Rápido</h2>
            <div id="quizContainer">
                <p>Comienza el quiz para reforzar tu aprendizaje.</p>
                <button onclick="iniciarQuiz()" class="btn-primary">Iniciar Quiz</button>
            </div>
        </div>
    </section>

    <!-- Recursos del Usuario -->
    <section class="user-resources" id="recursos">
        <div class="container">
            <h2 class="section-title">Documentos sobre Phishing</h2>

            <!-- Solo el administrador puede subir -->
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="documento" required />
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-upload"></i> Subir documento
                    </button>
                </form>
            <?php endif; ?>

            <!-- Listado dinámico de documentos -->
            <ul class="docs-list">
                <?php
                $uploadDir = "uploads/";
                if (is_dir($uploadDir)) {
                    $files = scandir($uploadDir);
                    foreach ($files as $file) {
                        if ($file != "." && $file != "..") {
                            echo "<li><a href='" . htmlspecialchars($uploadDir . $file) . "' target='_blank'>" . htmlspecialchars($file) . "</a></li>";
                        }
                    }
                } else {
                    echo "<li>No hay documentos subidos aún.</li>";
                }
                ?>
            </ul>
        </div>
    </section>

    <!-- Ranking global -->
    <section class="ranking" id="ranking">
        <div class="container">
            <h2 class="section-title">Tu Progreso</h2>
            <p id="rankingGlobal">Puntos totales: 0</p>
        </div>
    </section>

    <!-- Script -->
    <script src="script.js"></script>
</body>

</html>