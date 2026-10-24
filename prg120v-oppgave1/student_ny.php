
<?php
require_once 'db.php';

$melding = '';

$stmt = $pdo->query("SELECT klassekode, klassenavn FROM klasse ORDER BY klassenavn");
$klasser = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brukernavn = trim($_POST['brukernavn'] ?? '');
    $fornavn = trim($_POST['fornavn'] ?? '');
    $etternavn = trim($_POST['etternavn'] ?? '');
    $klassekode = trim($_POST['klassekode'] ?? '');

    if ($brukernavn === '' || $fornavn === '' ||
        $etternavn === '' || $klassekode === '') {
        $melding = 'Fyll ut alle feltene.';
    } else {
        try {
            $sql = "INSERT INTO student
                    (brukernavn, fornavn, etternavn, klassekode)
                    VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $brukernavn,
                $fornavn,
                $etternavn,
                $klassekode
            ]);

            $melding = 'Studenten ble registrert!';
        } catch (PDOException $e) {
            $melding = 'Kunne ikke registrere studenten. Kontroller brukernavn og klasse.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Registrer student</title>
</head>
<body>

<h1>Registrer student</h1>

<p><a href="index.php">Tilbake til hovedsiden</a></p>

<p><?= htmlspecialchars($melding) ?></p>

<form method="post">
    <label>Brukernavn:</label>
    <input type="text" name="brukernavn" maxlength="7" required>
    <br><br>

    <label>Fornavn:</label>
    <input type="text" name="fornavn" maxlength="50" required>
    <br><br>

    <label>Etternavn:</label>
    <input type="text" name="etternavn" maxlength="50" required>
    <br><br>

    <label>Klasse:</label>
    <select name="klassekode" required>
        <option value="">Velg klasse</option>
        <?php foreach ($klasser as $klasse): ?>
            <option value="<?= htmlspecialchars($klasse['klassekode']) ?>">
                <?= htmlspecialchars($klasse['klassenavn']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Registrer student</button>
</form>

</body>
</html>

