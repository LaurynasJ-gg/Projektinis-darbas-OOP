<?php

class SlapEncryptor
{
    private $metodas = "AES-256-CBC";

    public function encrypt($text, $key)
    {
        $random = openssl_random_pseudo_bytes(16);
        $SlapEncrypted = openssl_encrypt($text, $this->metodas, hash('sha256', $key, true), 0, $random);
            return base64_encode($random . $SlapEncrypted);
    }

    public function decrypt($SlapEncryptedText, $key)
    {
        $data = base64_decode($SlapEncryptedText);
        $random = substr($data, 0, 16);
        $SlapEncryptedText = substr($data, 16);
            return openssl_decrypt($SlapEncryptedText, $this->metodas, hash('sha256', $key, true), 0, $random);
    }
}