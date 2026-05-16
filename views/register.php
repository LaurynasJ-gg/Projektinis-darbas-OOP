<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();	
    $conn = $database->connect();

    $user = new User($conn);

    $vardas = $_POST['vardas'] ?? '';
    $slaptazodis = $_POST['slaptazodis'] ?? '';

    if ($user->register($vardas, $slaptazodis)) {
        $message = 'Registracija pavyko. Dabar galite prisijungti.';
    } else {
        $message = 'Registracija nepavyko. Gal toks vartotojas jau yra.';
    }
}

?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
</head>
<body>

<h1>Registracija</h1>

<form method="POST">
    <label>Vartotojo vardas:</label><br>
    <input type="text" name="vardas" required><br><br>

    <label>Slaptažodis:</label><br>
    <input type="password" name="slaptazodis" required><br><br>

    <button type="submit">Registruotis</button>
</form>

<p> Turi paskyrą? <a href="index.php?page=login"> Prisijungti čia </a> </p>

</body>
</html>