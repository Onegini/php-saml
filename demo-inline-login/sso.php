<?php
/**
 * SAMPLE Code to demonstrate how to initiate a SAML Authorization request
 *
 * When the user visits this URL, the browser will be redirected to the SSO
 * IdP with an authorization request. If successful, it will then be
 * redirected to the consume URL (specified in settings) with the auth
 * details. The authentication context can be set using the `authnContext`
 * GET parameter.
 */

session_start();

require_once '../vendor/autoload.php';
require_once 'settings.php';

if (empty($_GET['authnContext'])) {
    echo '<p>No authnContext paramater</p>';
    exit();
}

$username = null;
$password = null;

if ($_GET['authnContext'] == 'facebook') {
    $settings['security']['requestedAuthnContext'] = array('urn:com:onegini:saml:idp:facebook');
} else if ($_GET['authnContext'] == 'inline') {
    $settings['security']['requestedAuthnContext'] = array('urn:com:onegini:saml:InlineLogin');
    $username = $_POST['username'];
    $password = $_POST['password'];
} else {
    echo '<p>Invalid authnContext</p>';
    exit();
}

$auth = new OneLogin_Saml2_Auth($settings);
$auth->login($returnTo = null,
    $parameters = array(),
    $forceAuthn = false,
    $isPassive = false,
    $stay = false,
    $setNameIdPolicy = true,
    $username,
    $password);
