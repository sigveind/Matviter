
<?php
require_once 'db.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klassekode = $_POST['klassekode'] ?? '';

    try {
        $sql = "DELETE FROM klasse WHERE klassekode = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$klassekode]);

        $melding = 'Klassen ble slettet.';
    } catch (PDOException $e) {
        $melding = 'Klassen kunne ikke slettes. Den kan ha studenter tilknyttet seg.';
    }
}

$stmt = $pdo->query("SELECT * FROM klasse ORDER BY klassekode");
$klasser = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Alle klasser</title>
</head>
<body>

<h1>Alle klasser</h1>

<p><a href="index.php">Tilbake til hovedsiden</a></p>
<p><a href="klasse_ny.php">Registrer ny klasse</a></p>

<?php if ($melding !== ''): ?>
    <p><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>Klassekode</th>
        <th>Klassenavn</th>
        <th>Studiumkode</th>
        <th>Handling</th>
    </tr>

    <?php foreach ($klasser as $klasse): ?>
        <tr>
            <td><?= htmlspecialchars($klasse['klassekode']) ?></td>
            <td><?= htmlspecialchars($klasse['klassenavn']) ?></td>
            <td><?= htmlspecialchars($klasse['studiumkode']) ?></td>
            <td>
                <form method="post"
                      onsubmit="return confirm('Vil du slette klassen?');">
                    <input type="hidden" name="klassekode"
                           value="<?= htmlspecialchars($klasse['klassekode']) ?>">
                    <button type="submit">Slett</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
