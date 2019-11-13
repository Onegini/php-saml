<?php

use AESGCM\AESGCM;

class OneLogin_Saml2_InlineLogin
{
    private $_key;
    private $_encryptedPassword;
    private $_iv;

    public function __construct($key, $password)
    {
        $this->_key = $key;
        $this->_encryptedPassword = $this->encrypt($password, $iv);
        $this->_iv = $iv;
    }

    public function getEncryptedPassword()
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
