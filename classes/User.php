<?php

require_once 'Encryptor.php';

class User
{
    private PDO $Database;
    private SlapEncryptor $SlapEncryptor;

    public function __construct(PDO $Database)
    {
        $this->Database = $Database;
        $this->SlapEncryptor = new SlapEncryptor();
    }

    public function register(string $vardas, string $slaptazodis): bool
    {
        if ($vardas === '' || $slaptazodis === '') {
            return false;
        }

        if ($this->userExists($vardas)) {
            return false;
        }

        $slapHash = password_hash($slaptazodis, PASSWORD_DEFAULT);

        $raktas = bin2hex(random_bytes(16));

        $koduotasRaktas = $this->SlapEncryptor->encrypt($raktas, $slaptazodis);

        $sql = "INSERT INTO vartotojai (vardas, slap_hash, koduotas_raktas)
                VALUES (:vardas, :slap_hash, :koduotas_raktas)";

        $uzklausa = $this->Database->prepare($sql);

        return $uzklausa->execute([
            ':vardas' => $vardas,
            ':slap_hash' => $slapHash,
            ':koduotas_raktas' => $koduotasRaktas
        ]);
    }

    public function login(string $vardas, string $slaptazodis): bool
    {
        $sql = "SELECT * FROM vartotojai WHERE vardas = :vardas";

        $uzklausa = $this->Database->prepare($sql);
        $uzklausa->execute([
            ':vardas' => $vardas
        ]);

        $user = $uzklausa->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (!password_verify($slaptazodis, $user['slap_hash'])) {
            return false;
        }

        $raktas = $this->SlapEncryptor->decrypt($user['koduotas_raktas'], $slaptazodis);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['vardas'] = $user['vardas'];
        $_SESSION['raktas'] = $raktas;

        return true;
    }

    private function userExists(string $vardas): bool
    {
        $sql = "SELECT id FROM vartotojai WHERE vardas = :vardas";

        $uzklausa = $this->Database->prepare($sql);
        $uzklausa->execute([
            ':vardas' => $vardas
        ]);

        return $uzklausa->fetch() !== false;
    }
}