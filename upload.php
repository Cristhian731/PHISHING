<?php
session_start();

// Verificar que el usuario esté logueado y sea administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "❌ No tienes permisos para subir documentos.";
    echo "<p><a href='inicio.php'>Volver al Dashboard</a></p>";
    exit();
}

// Carpeta donde se guardarán los archivos
$uploadDir = "uploads/";

// Crear carpeta si no existe
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Verificar si se subió un archivo
if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['documento']['tmp_name'];
    $fileName = $_FILES['documento']['name'];

    // Limpiar nombre de archivo para evitar problemas
    $fileNameClean = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $fileName);

    // Ruta final
    $destPath = $uploadDir . $fileNameClean;

    // Mover archivo
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        echo "<p>✅ Documento subido correctamente: <a href='$destPath' target='_blank'>$fileNameClean</a></p>";
    } else {
        echo "<p>❌ Error al mover el archivo al directorio destino.</p>";
    }
} else {
    echo "<p>⚠️ No se seleccionó ningún archivo o hubo un error en la subida.</p>";
}

// Botón para volver al dashboard
echo "<p><a href='inicio.php'>Volver al Dashboard</a></p>";
?>