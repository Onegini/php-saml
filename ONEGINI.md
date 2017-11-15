# Fork of OneLogin/php-saml

This library is forked to support Onegini Inline login.

## Security settings

To enable inline login, make sure your `$settings['security]` include the following:

Set the required authentication context:
```php
'requestedAuthnContext' => array('urn:com:onegini:saml:InlineLogin'),
```

Set a save encryption key in your SP and your CIM:
```php
// Inline login password encryption key (256 bits). Must be set when 'using urn:com:onegini:saml:InlineLogin' auth context.
// This key must also be set in the IDP with the 'IDP_AUTHENTICATION_PASSWORD_ENCRYPTION_KEY' env variable
// Example key generation (shell):
//  $ dd if=/dev/random bs=32 count=1 | base64
// Then set the key with:
//  'inlineLoginKey' => base64_decode('[base64 encoded key]'),
'inlineLoginKey' => '[My secure random generated key]',
```

## Usage

Once you are setup, simply supply the username and password parameters with `OneLogin_Saml2_Auth()->login()`

```php
$auth = new OneLogin_Saml2_Auth($settings);
$auth->login($returnTo = null,
    $parameters = array(),
    $forceAuthn = false,
    $isPassive = false,
    $stay = false,
    $setNameIdPolicy = true,
    $username = 'my_username',
    $password = 'my_password');
```

Alternatively you can construct an authentication request:
```php
new OneLogin_Saml2_AuthnRequest($settings, $forceAuthn = false, $isPassive = false, $setNameIdPolicy = true, $username = 'my_username', $password = 'my_password');
```

An example login page is available in the `demo-inline-login` directory.
