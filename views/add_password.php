<?php

require_once 'classes/Database.php';
require_once 'classes/Encryptor.php';
require_once 'classes/PasswordGenerator.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$message = '';
$generatedPassword = '';

$database = new Database();
$conndb = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['generate'])) {
        $length = $_POST['length'];
        $lower = $_POST['lower'];
        $upper = $_POST['upper'];
        $numbers = $_POST['numbers'];
        $specials = $_POST['specials'];

        $generator = new SlapGenerator();
        $generatedPassword = $generator->generate($length, $lower, $upper, $numbers, $specials);
    }

    if (isset($_POST['save'])) {
        $pavadinimas = $_POST['pavadinimas'] ?? '';
        $slaptazodis = $_POST['slaptazodis'] ?? '';

        if ($pavadinimas == '' || $slaptazodis == '') {
            $message = 'Užpildykite visus laukus.';
        } else {
            $SlapEncryptor = new SlapEncryptor();

            $koduotasSlaptazodis = $SlapEncryptor->encrypt($slaptazodis, $_SESSION['raktas']);

            $sql = "INSERT INTO slaptazodziai (vartotojo_id, pavadinimas, koduotas_slaptazodis)
                    VALUES (:vartotojo_id, :pavadinimas, :koduotas_slaptazodis)";

            $uzklausa = $conndb->prepare($sql);
            $uzklausa->execute([
                ':vartotojo_id' => $_SESSION['user_id'],
                ':pavadinimas' => $pavadinimas,
                ':koduotas_slaptazodis' => $koduotasSlaptazodis
            ]);

            $message = 'Slaptažodis išsaugotas.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Slaptažodžių generavimas</title>
</head>
<body>
<Div style="width: 700px; margin: 40px auto; text-align: center;">
<h1>Susikurkite savo slaptažodį</h1>

<p><?= $message ?></p>

<h2>Generuoti slaptažodį</h2>

<form method="POST">
    <label>Ilgis:</label><br>
    <input type="number" name="length" value="9" required><br><br>

    <label>Mažųjų raidžių skaičius - </label><br>
    <input type="number" name="lower" value="2" required><br><br>

    <label>Didžiųjų raidžių skaičius - </label><br>
    <input type="number" name="upper" value="3" required><br><br>

    <label>Skaičių skaičius - </label><br>
    <input type="number" name="numbers" value="2" required><br><br>

    <label>Specialių simbolių skaičius - </label><br>
    <input type="number" name="specials" value="2" required><br><br>

    <button type="submit" name="generate">Generuoti slaptažodį</button>
</form>

<hr>

<h2>Išsaugoti savo slaptažodį</h2>

<form method="POST">
    <label>Slaptažodžio pavadinimas:</label><br>
    <input type="text" name="pavadinimas" placeholder="PVZ - Youtube" required><br><br>

    <label>Slaptažodis:</label><br>
    <input type="text" name="slaptazodis" value="<?= $generatedPassword ?>" required><br><br>

    <button type="submit" name="save">Išsaugoti šį slaptažodį</button>
</form>

<p>
    <a href="index.php?page=dashboard">Grįžti atgal į valdymo puslapį</a>
</p>
</div>
</body>
</html>