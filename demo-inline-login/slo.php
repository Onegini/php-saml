<?php
/**
 * SAMPLE Code for a logout handler.
 */


session_start();

require_once '../vendor/autoload.php';
require_once 'settings.php';

$sessionIndex = null;
$nameId = null;

if (isset($_SESSION['samlSessionIndex'])) {
    $sessionIndex = $_SESSION['samlSessionIndex'];
}
if (isset($_SESSION['samlNameId'])) {
    $nameId = $_SESSION['samlNameId'];
}

$auth = new OneLogin_Saml2_Auth($settings);
$auth->logout($returnTo = null, $paramters = array(), $nameId, $sessionIndex, false, $nameIdFormat = null);
