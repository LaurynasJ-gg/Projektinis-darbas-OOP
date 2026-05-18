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
<Div style="width: 700px; margin: 40px auto; text-align: center;">
<h1>Slaptažodžių saugykla</h1>

<p>Labas, <?= $_SESSION['vardas'] ?>! </p>
<p>Čia yra jūsų slaptažodžių saugykla, kurioje laisvai galite kurti ir saugoti savo slaptažodžius!!</p>

<p>
    <a href="index.php?page=add_password">Pridėti slaptažodį</a> |
    <a href="index.php?page=logout">Atsijungti</a>
</p>

<h2>Jūsų sukurti slaptažodžiai:</h2>

<?php if (count($slaptazodziai) == 0): ?>
    <p>Dar neturite išsaugotų slaptažodžių!!</p>
<?php else: ?>

<table border="1" style="margin: 0 auto; border-collapse: collapse;">
    <tr>
        <th style="padding: 10px;"> Pavadinimas</th>
        <th style="padding: 10px;"> Slaptažodis</th>
        <th style="padding: 10px;"> Sukurta</th>
    </tr>

    <?php foreach ($slaptazodziai as $irasas): ?>
        <tr>
            <td style="padding: 10px;"><?= $irasas['pavadinimas'] ?></td>
            <td style="padding: 10px;">
                <?php
                echo $SlapEncryptor->decrypt($irasas['koduotas_slaptazodis'], $_SESSION['raktas']);
                ?>
            </td>
            <td style="padding: 10px;"><?= $irasas['sukurta'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>

<?php endif; ?>

</body>
</html>