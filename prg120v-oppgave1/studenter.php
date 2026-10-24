
<?php
require_once 'db.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brukernavn = $_POST['brukernavn'] ?? '';

    $sql = "DELETE FROM student WHERE brukernavn = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brukernavn]);

    $melding = 'Studenten ble slettet.';
}

$stmt = $pdo->query(
    "SELECT brukernavn, fornavn, etternavn, klassekode
     FROM student
     ORDER BY etternavn, fornavn"
);
$studenter = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Alle studenter</title>
</head>
<body>

<h1>Alle studenter</h1>

<p><a href="index.php">Tilbake til hovedsiden</a></p>
<p><a href="student_ny.php">Registrer ny student</a></p>

<?php if ($melding !== ''): ?>
    <p><?= htmlspecialchars($melding) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>Brukernavn</th>
        <th>Fornavn</th>
        <th>Etternavn</th>
        <th>Klassekode</th>
        <th>Handling</th>
    </tr>

    <?php foreach ($studenter as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['brukernavn']) ?></td>
            <td><?= htmlspecialchars($student['fornavn']) ?></td>
            <td><?= htmlspecialchars($student['etternavn']) ?></td>
            <td><?= htmlspecialchars($student['klassekode']) ?></td>
            <td>
                <form method="post"
                      onsubmit="return confirm('Vil du slette studenten?');">
                    <input type="hidden" name="brukernavn"
                           value="<?= htmlspecialchars($student['brukernavn']) ?>">
                    <button type="submit">Slett</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
