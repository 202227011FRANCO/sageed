<?php
// api/estudiantes.php
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

switch ($method) {
    case 'GET':
        $stmt = $db->query("
            SELECT e.*, 
                   emp.nombre AS empresa_nombre,
                   ma.nombre AS mentor_acad_nombre,
                   mu.nombre AS mentor_ue_nombre
            FROM estudiantes e
            LEFT JOIN empresas emp ON e.empresa_id = emp.id
            LEFT JOIN mentores_academicos ma ON e.mentor_acad_id = ma.id
            LEFT JOIN mentores_ue mu ON e.mentor_ue_id = mu.id
            ORDER BY e.created_at DESC
        ");
        jsonResponse($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("
            INSERT INTO estudiantes (control, curp, nombre, genero, carrera, empresa_id, mentor_acad_id, mentor_ue_id, tipo_ingreso, estatus)
            VALUES (:control, :curp, :nombre, :genero, :carrera, :empresa_id, :mentor_acad_id, :mentor_ue_id, :tipo_ingreso, 'ACTIVO')
        ");
        $stmt->execute([
            ':control' => $data['control'],
            ':curp' => $data['curp'],
            ':nombre' => $data['nombre'],
            ':genero' => $data['genero'],
            ':carrera' => $data['carrera'],
            ':empresa_id' => $data['empresaId'],
            ':mentor_acad_id' => $data['mentorAcadId'],
            ':mentor_ue_id' => $data['mentorUeId'],
            ':tipo_ingreso' => $data['tipoIngreso']
        ]);
        jsonResponse(['id' => $db->lastInsertId(), 'mensaje' => 'Estudiante registrado'], 201);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE estudiantes SET estatus = :estatus WHERE id = :id");
        $stmt->execute([':estatus' => $data['estatus'], ':id' => $data['id']]);
        jsonResponse(['mensaje' => 'Estudiante actualizado']);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);
        $stmt = $db->prepare("DELETE FROM estudiantes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        jsonResponse(['mensaje' => 'Estudiante eliminado']);
        break;

    default:
        jsonResponse(['error' => 'Método no permitido'], 405);
}