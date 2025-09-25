<?php
header('Content-Type: application/json; charset=utf-8');

require_once "conn.php"; 

$json_string = file_get_contents('php://input');

if (empty($json_string)) {
    http_response_code(400); 
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

$data_array = json_decode($json_string, true);

if (json_last_error() !== JSON_ERROR_NONE || $data_array === null) {
    http_response_code(400); 
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON received']);
    exit;
}

$no_doc    = isset($data_array['Var1']) ? $data_array['Var1'] : null;
$file_name = isset($data_array['Var2']) ? $data_array['Var2'] : null;

if (empty($no_doc) || empty($file_name)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

$stmt = $mysqli->prepare("INSERT INTO bmi_doc_log_sap (no_doc, file_name) VALUES (?, ?)");
$stmt->bind_param("ss", $no_doc, $file_name);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Insert failed: " . $stmt->error
    ]);
} else {
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "Data berhasil disimpan",
        "no_doc" => $no_doc,
        "file_name" => $file_name
    ]);
}

$stmt->close();
$mysqli->close();
?>
