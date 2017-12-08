<?php
/**
 * SAMPLE Code to demonstrate how to handle a SAML assertion response.
 *
 * The URL of this file will have been given during the SAML authorization.
 * After a successful authorization, the browser will be directed to this
 * link where it will send a certified response via $_POST.
 * If the SAML response is valid, this script will redirect to /
 */

session_start();

require_once '../vendor/autoload.php';
require_once 'settings.php';

try {
    if (isset($_POST['SAMLResponse'])) {
        $samlSettings = new OneLogin_Saml2_Settings($settings);
        $samlResponse = new OneLogin_Saml2_Response($samlSettings, $_POST['SAMLResponse']);
        if ($samlResponse->isValid()) {
            $_SESSION['samlUserdata'] = $samlResponse->getAttributes();
            header('Location: /', true, 303);
        } else {
            echo 'Invalid SAML Response';
        }
    } else {
        echo 'No SAML Response found in POST.';
    }
} catch (Exception $e) {
    echo 'Invalid SAML Response: ' . $e->getMessage();
}
