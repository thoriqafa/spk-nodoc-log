<?php
$dataPost = file_get_contents('php://input');

$xml = simplexml_load_string($dataPost);

$no_doc       = (string) $xml->IDOC[0]->ZSPK01[0]->ZSPK01_DTL[0]->NODOC;
$file_name    = (string) $xml->IDOC[0]->ZSPK01[0]->FILE_NAME;

$host   = "";
$db     = "";
$userdb = "";
$passdb = "";

$mysqli = new mysqli($host, $userdb, $passdb, $db);

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to connect MySQL"]);
    exit;
}

if (empty($no_doc)) {
    exit;
}

// echo json_encode("Connected to: " . $mysqli->host_info);

$stmt = $mysqli->prepare("INSERT INTO bmi_doc_log_sap (no_doc, file_name) VALUES (?,?)");
$stmt->bind_param("ss", $no_doc, $file_name);
// $stmt->execute();

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Insert failed: " . $stmt->error
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "message" => "Data berhasil disimpan",
        "no_doc" => $no_doc,
        "file_name" => $file_name,
    ]);
}

$stmt->close();
$mysqli->close();
?>