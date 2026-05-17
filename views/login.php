<?php

require_once 'classes/Database.php';
require_once 'classes/User.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $conndb = $database->connect();

    $user = new User($conndb);

    $vardas = $_POST['vardas'] ?? '';
    $slaptazodis = $_POST['slaptazodis'] ?? '';

    if ($user->login($vardas, $slaptazodis)) {
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        $message = 'Neteisingas vartotojo vardas arba slaptažodis.';
    }
}

?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
</head>
<body>

<h1>Prisijungimas</h1>

<?php if ($message != ''): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Prisijungimo vardas:</label><br>
    <input type="text" name="vardas" required><br><br>

    <label>Slaptažodis:</label><br>
    <input type="password" name="slaptazodis" required><br><br>

    <button type="submit">Prisijungti</button>
</form>

<p> Neturi susikūręs paskyros?<a href="index.php?page=register"> Registruotis čia</a> </p>

</body>
</html>