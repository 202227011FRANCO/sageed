<?php
require_once '../config/database.php';
require_once '../vendor/autoload.php'; // PHPWord

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $periodo       = $_POST['periodo'];
    $horas         = $_POST['horas'];
    $descripcion   = $_POST['descripcion'];
    $observaciones = $_POST['observaciones'];

    $nombreArchivo = "anexo54_" . time() . ".docx";
    $ruta = "../uploads/" . $nombreArchivo;

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

    $section->addTextBreak(2);
    $table = $section->addTable();
    $table->addRow();
    $table->addCell(3000)->addText("FIRMA DEL ESTUDIANTE");
    $table->addCell(3000)->addText("Vo.Bo. MENTOR ACADÉMICO");
    $table->addCell(3000)->addText("FIRMA MENTOR UE");

    $phpWord->save($ruta, 'Word2007');

    $conn = getConnection();
    $sql = "INSERT INTO anexos_subidos 
            (estudiante_id, tipo_anexo, nombre_archivo, ruta_archivo, fecha_carga) 
            VALUES (1, '5.4', '$nombreArchivo', '$ruta', NOW())";

    if ($conn->query($sql)) {
        echo "✅ Anexo 5.4 generado y guardado.";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>
