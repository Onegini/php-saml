<?php

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

    public function getXml()
    {
        $saveUsername = htmlspecialchars($this->_username);
        $encryptedPasswordBase64 = base64_encode($this->_encryptedPassword);
        $ivBase64 = base64_encode($this->_iv);

        $extensionXml = <<<EXTXML
<md:Extensions xmlns:md="urn:oasis:names:tc:SAML:2.0:metadata">
  <onegini:InlineLogin xmlns:onegini="urn:com:onegini:saml:InlineLogin"
                       IdpType="unp_idp">
    <onegini:Credentials Username="$saveUsername"
                         Password="$encryptedPasswordBase64"
                         EncryptionParameter="$ivBase64"/>
  </onegini:InlineLogin>
</md:Extensions>
EXTXML;

        return $extensionXml;
    }

    private function encrypt($plaintext, &$iv = null)
    {
        $iv = openssl_random_pseudo_bytes(16, $cstrong);
        if (!$cstrong) {
            throw new Exception("Could not generate secure random bytes");
        }

        if (!in_array(self::METHOD, openssl_get_cipher_methods())) {
            throw new Exception("This system does not support the required encryption algorithm");
        }

        $ciphertext = openssl_encrypt($plaintext, self::METHOD, $this->_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv, $tag);
        if (!$ciphertext) {
            throw new Exception("Could not encrypt plaintext");
        }

        return $ciphertext . $tag;
    }
}
