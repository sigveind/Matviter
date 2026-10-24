
<?php

$host = 'b-studentsql-1.usn.no';
$dbname = 'moram0559';
$username = 'moram0559';
$password = '36d4moram0559';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Kunne ikke koble til databasen.");
}
?>
