<?php

use AESGCM\AESGCM;

class OneLogin_Saml2_InlineLogin
{
    const METHOD = 'aes-256-gcm';

    private $_key;
    private $_username;
    private $_encryptedPassword;
    private $_iv;

    public function __construct($key, $username, $password)
    {
        $this->_key = $key;
        $this->_username = $username;
        $this->_encryptedPassword = $this->encrypt($password, $iv);
        $this->_iv = $iv;
    }

    public function getEncryptedPassword(): string
    {
        return $this->_encryptedPassword;
    }

    public function getIv()
    {
        return $this->_iv;
    }

    private function encrypt($plaintext, &$iv = null)
    {
        $iv = openssl_random_pseudo_bytes(16, $cstrong);
        $ciphertext = AESGCM::encryptAndAppendTag($this->_key, $iv, $plaintext);

        return $ciphertext;
    }
}
