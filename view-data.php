<?php
require_once "conn.php";

$sql = "SELECT id, no_doc, file_name, created_at FROM bmi_doc_log_sap ORDER BY id DESC";
$result = $mysqli->query($sql);

echo "<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center; /* supaya judul di tengah */
        }
        table {
            margin: 20px auto; /* ini yang bikin tabel ke tengah */
            border-collapse: collapse;
            width: 80%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
        }
        td, th {
            padding: 8px;
        }
      </style>";

echo "<h2>DATA LOG SAP</h2>";
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr>
        <th>NO</th>
        <th>NO DOC</th>
        <th>FILE NAME</th>
        <th>CREATED AT</th>
      </tr>";

if ($result && $result->num_rows > 0) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['no_doc']}</td>
                <td>{$row['file_name']}</td>
                <td style='text-align: center;'>{$row['created_at']}</td>
              </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='4'>Data tidak ditemukan</td></tr>";
}

echo "</table>";

$mysqli->close();
?>
