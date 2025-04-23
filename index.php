<?php
$host = '127.0.0.1:3306';  // или IP-адрес сервера
$dbname = 'new_schema';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}


$input_id = 99895;

$sql = "
SELECT t.ID, t.EPC, t.EPL
FROM `sql` t
JOIN (
    SELECT AR, CR 
    FROM `sql` 
    WHERE ID = :input_id
) tv ON t.AR = tv.AR AND t.CR = tv.CR
ORDER BY t.ID DESC
LIMIT 20;
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':input_id', $input_id, PDO::PARAM_INT);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Вывод результатов
foreach ($results as $row) {
    echo "ID: " . $row['ID'] . " | EPC: " . $row['EPC'] . " | EPL: " . $row['EPL'] . "\n";
}


