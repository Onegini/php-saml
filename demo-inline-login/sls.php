<?php
/**
 * SAMPLE Code for a logout handler.
 */


session_start();

require_once '../vendor/autoload.php';
require_once 'settings.php';

$auth = new OneLogin_Saml2_Auth($settings);
$auth->processSLO();

var_dump($auth->getErrors());
