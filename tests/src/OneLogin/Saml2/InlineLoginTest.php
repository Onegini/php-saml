<?php

use AESGCM\AESGCM;

/**
 *  Unit test for Inline Login extension
 */
class OneLogin_Saml2_InlineLoginTest extends PHPUnit_Framework_TestCase
{
    private $_key = 'Not a terribly secure key at all';
    private $_inlineLogin;
    private $_password = 'foobar';

    /**
     * Tests the OneLogin_Saml2_InlineLogin Constructor.
     * The creation of a deflated SAML Request
     *
     * @covers OneLogin_Saml2_Error
     */
    public function setup()
    {
        $this->_inlineLogin = new OneLogin_Saml2_InlineLogin($this->_key, $this->_password);
    }

    public function testEncryptedPassword()
    {
        $encryptedPassword = $this->_inlineLogin->getEncryptedPassword();
        $this->assertNotEquals($encryptedPassword, $this->_password);

        $iv = $this->_inlineLogin->getIv();
        $decryptedPassword = AESGCM::decryptWithAppendedTag($this->_key, $iv, $encryptedPassword);
        $this->assertEquals($this->_password, $decryptedPassword);
    }
}
