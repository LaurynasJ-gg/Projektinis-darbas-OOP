<?php

class SlapGenerator
{
    private string $lowerChars = "abcdefghijklmnopqrstuvwxyz";
    private string $upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private string $numberChars = "0123456789";
    private string $specialChars = "!@#$%^&*?";

    public function generate($length, $lower, $upper, $numbers, $specials)
    {
        $total = $lower + $upper + $numbers + $specials;

        if ($total != $length) {
            return "Klaida!! Pasirinktas simbolių kiekis nesutampa su ilgiu!";
        }

        $password = "";

        $password .= $this->addCharacters($this->lowerChars, $lower);
        $password .= $this->addCharacters($this->upperChars, $upper);
        $password .= $this->addCharacters($this->numberChars, $numbers);
        $password .= $this->addCharacters($this->specialChars, $specials);

        return str_shuffle($password);
    }

    private function addCharacters($characters, $count)
    {
        $result = "";

        for ($i = 0; $i < $count; $i++) {
            $randomIndex = random_int(0, strlen($characters) - 1);
            $result .= $characters[$randomIndex];
        }

        return $result;
    }
}