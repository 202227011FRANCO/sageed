<?php
// api/anexo54.php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estudiante_id = $_POST['estudiante_id'] ?? 1;
    $periodo       = $_POST['periodo'] ?? '';
    $horas         = $_POST['horas'] ?? 0;
    $descripcion   = $_POST['descripcion'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';

    $nombreArchivo = "anexo54_" . time() . ".pdf";
    $ruta = "uploads/" . $nombreArchivo;

    // Si tienes instalado PHPWord mediante Composer, se genera el .docx opcionalmente
    if (file_exists('../vendor/autoload.php')) {
        require_once '../vendor/autoload.php';
        $nombreArchivo = "anexo54_" . time() . ".docx";
        $ruta = "../uploads/" . $nombreArchivo;

        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $section->addText('"2026. Año del Humanismo Mexicano en el Estado de México".', ['bold' => true]);
        $section->addText("ANEXO 5.4", ['size' => 14, 'bold' => true]);
        $section->addText("REPORTE DE ACTIVIDADES DE APRENDIZAJE", ['size' => 12]);
        $section->addText("Periodo Reportado: $periodo");
        $section->addText("Horas en Periodo: $horas");
        $section->addText("Actividades Realizadas:");
        $section->addText($descripcion);
        $section->addText("Observaciones:");
        $section->addText($observaciones);

        $phpWord->save($ruta, 'Word2007');
    }

    try {
        // Usamos getDB() definido en config/database.php (PDO)
        $pdo = getDB();
        $sql = "INSERT INTO anexos_subidos 
                (estudiante_id, tipo_anexo, nombre_archivo, ruta_archivo, fecha_carga) 
                VALUES (:estudiante_id, '5.4', :nombre_archivo, :ruta_archivo, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estudiante_id'  => $estudiante_id,
            ':nombre_archivo' => $nombreArchivo,
            ':ruta_archivo'   => $ruta
        ]);

        jsonResponse([
            'success' => true,
            'message' => 'Anexo 5.4 registrado en la base de datos correctamente.'
        ]);
    } catch (PDOException $e) {
        jsonResponse([
            'success' => false,
            'error'   => 'Error en base de datos: ' . $e->getMessage()
        ], 500);
    }
}