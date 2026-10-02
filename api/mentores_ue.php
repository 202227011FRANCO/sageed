<?php
// api/mentores_ue.php
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

switch ($method) {
    case 'GET':
        // Devuelve la lista para llenar la barra desplegable
        $stmt = $db->query("SELECT * FROM mentores_ue ORDER BY nombre ASC");
        jsonResponse($stmt->fetchAll());
        break;

    case 'POST':
        // Guarda un mentor nuevo si usan el botón "+"
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO mentores_ue (nombre, empresa_id, cargo, correo) VALUES (:nombre, :empresa_id, :cargo, :correo)");
        $stmt->execute([
            ':nombre'     => $data['nombre'],
            ':empresa_id' => $data['empresa_id'],
            ':cargo'      => $data['cargo'],
            ':correo'     => $data['correo']
        ]);
        jsonResponse(['id' => $db->lastInsertId(), 'mensaje' => 'Mentor de Empresa registrado'], 201);
        break;

    default:
        jsonResponse(['error' => 'Método no permitido'], 405);
}