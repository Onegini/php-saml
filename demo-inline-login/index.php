<?php

session_start();

require_once '../vendor/autoload.php';
require_once 'settings_example.php';

$auth = new OneLogin_Saml2_Auth($settings);

if (isset($_GET['sso'])) {
    $username = '';
    $password = '';

    if (empty($_POST['username']) || empty($_POST['password'])) {
        header('Location: /', true, 303);
        die();
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

    $auth->login($returnTo = $settings['baseurl'] . '/attrs.php',
        $parameters = array(),
        $forceAuthn = false,
        $isPassive = false,
        $stay = false,
        $setNameIdPolicy = true,
        $username,
        $password);
} else if (isset($_GET['slo'])) {
    $returnTo = null;
    $parameters = array();
    $nameId = null;
    $sessionIndex = null;
    $nameIdFormat = null;

    if (isset($_SESSION['samlNameId'])) {
        $nameId = $_SESSION['samlNameId'];
    }
    if (isset($_SESSION['samlSessionIndex'])) {
        $sessionIndex = $_SESSION['samlSessionIndex'];
    }
    if (isset($_SESSION['samlNameIdFormat'])) {
        $nameIdFormat = $_SESSION['samlNameIdFormat'];
    }

    $auth->logout($returnTo, $parameters, $nameId, $sessionIndex, false, $nameIdFormat);
} else if (isset($_GET['acs'])) {
    if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
        $requestID = $_SESSION['AuthNRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processResponse($requestID);

    $errors = $auth->getErrors();

    if (!empty($errors)) {
        print_r('<p>' . implode(', ', $errors) . '</p>');
    }

    if (!$auth->isAuthenticated()) {
        echo "<p>Not authenticated</p>";
        exit();
    }

    $_SESSION['samlUserdata'] = $auth->getAttributes();
    $_SESSION['samlNameId'] = $auth->getNameId();
    $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
    $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();
    unset($_SESSION['AuthNRequestID']);
    if (isset($_POST['RelayState']) && OneLogin_Saml2_Utils::getSelfURL() != $_POST['RelayState']) {
        $auth->redirectTo($_POST['RelayState']);
    }
} else if (isset($_GET['sls'])) {
    if (isset($_SESSION) && isset($_SESSION['LogoutRequestID'])) {
        $requestID = $_SESSION['LogoutRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processSLO(false, $requestID);
    $errors = $auth->getErrors();
    if (empty($errors)) {
        print_r('<p>Sucessfully logged out</p>');
    } else {
        print_r('<p>' . implode(', ', $errors) . '</p>');
    }
}

if (isset($_SESSION['samlUserdata'])) {
    header('Location: attrs.php', true, 303);
    die();
} else {
    echo '<style>
form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 0 auto;
}

input {
  margin: 3px;
}
</style>
<form method="POST" action="?sso">
  <input type="text" name="username" placeholder="Username" required />
  <input type="password" name="password" placeholder="Password" required />
  <input type="submit" value="Login" />
</form>';
}
