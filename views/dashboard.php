<?php

require_once 'classes/Database.php';
require_once 'classes/Encryptor.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$database = new Database();
$conndb = $database->connect();

$SlapEncryptor = new SlapEncryptor();

$sql = "SELECT * FROM slaptazodziai WHERE vartotojo_id = :vartotojo_id ORDER BY sukurta DESC";
$dbjoin = $conndb->prepare($sql);
$dbjoin->execute([
    ':vartotojo_id' => $_SESSION['user_id']
]);

$slaptazodziai = $dbjoin->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Valdymo skydelis</title>
</head>
<body>

<h1>Slaptažodžių saugykla</h1>

<p>Labas, <?= $_SESSION['vardas'] ?>! Čia yra jūsų slaptažodžių saugykla, kurioje laisvai galite kurti ir saugoti savo slaptažodžius!!</p>

<p>
    <a href="index.php?page=add_password">Pridėti slaptažodį</a> |
    <a href="index.php?page=logout">Atsijungti</a>
</p>

<h2>Jūsų sukurti slaptažodžiai:</h2>

<?php if (count($slaptazodziai) == 0): ?>
    <p>Dar neturite išsaugotų slaptažodžių!!</p>
<?php else: ?>

<table border="1" cellpadding="8">
    <tr>
        <th>Pavadinimas</th>
        <th>Slaptažodis</th>
        <th>Sukurta</th>
    </tr>

    <?php foreach ($slaptazodziai as $irasas): ?>
        <tr>
            <td><?= $irasas['pavadinimas'] ?></td>
            <td>
                <?php
                echo $SlapEncryptor->decrypt($irasas['koduotas_slaptazodis'], $_SESSION['raktas']);
                ?>
            </td>
            <td><?= $irasas['sukurta'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>

</body>
</html>