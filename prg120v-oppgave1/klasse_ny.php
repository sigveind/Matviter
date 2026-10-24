
<?php
require_once 'db.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klassekode = trim($_POST['klassekode'] ?? '');
    $klassenavn = trim($_POST['klassenavn'] ?? '');
    $studiumkode = trim($_POST['studiumkode'] ?? '');

    if ($klassekode === '' || $klassenavn === '' || $studiumkode === '') {
        $melding = 'Fyll ut alle feltene.';
    } else {
        try {
            $sql = "INSERT INTO klasse (klassekode, klassenavn, studiumkode)
                    VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$klassekode, $klassenavn, $studiumkode]);

            $melding = 'Klassen ble registrert!';
        } catch (PDOException $e) {
            $melding = 'Kunne ikke registrere klassen. Kontroller klassekoden.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Registrer klasse</title>
</head>
<body>

    <h1>Registrer klasse</h1>

    <p>
        <a href="index.php">Tilbake til hovedsiden</a>
    </p>

    <p><?= htmlspecialchars($melding) ?></p>

    <form method="post">
        <label>Klassekode:</label>
        <input type="text" name="klassekode" maxlength="5" required>
        <br><br>

        <label>Klassenavn:</label>
        <input type="text" name="klassenavn" maxlength="50" required>
        <br><br>

        <label>Studiumkode:</label>
        <input type="text" name="studiumkode" maxlength="50" required>
        <br><br>

        <button type="submit">Registrer klasse</button>
    </form>

</body>
</html>
