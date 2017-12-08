<?php
/**
 * SAMPLE Code for a Login page.
 *
 * If the user is logged in, a table with their SAML attributes will be printed.
 * Otherwise, a login form an a Link to login through Facebook are displayed.
 */

session_start();

echo '<style>
.container {
    max-width: 400px;
    margin: 0 auto;
}
form {
    display: flex;
    flex-direction: column;
}
input {
  margin: 3px;
}
</style>';

if (isset($_SESSION['samlUserdata'])) {
    if (!empty($_SESSION['samlUserdata'])) {
        $attributes = $_SESSION['samlUserdata'];
        echo 'You have the following attributes:<br>';
        echo '<table><thead><th>Name</th><th>Values</th></thead><tbody>';
        foreach ($attributes as $attributeName => $attributeValues) {
            echo '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
            foreach ($attributeValues as $attributeValue) {
                echo '<li>' . htmlentities($attributeValue) . '</li>';
            }
            echo '</ul></td></tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p>You don't have any attribute</p>";
    }
    echo '<p><a href="slo.php" >Logout</a></p>';
} else {
    echo '<div class="container">
    <form method="POST" action="sso.php?authnContext=inline">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="submit" value="Login with password" />
    </form>
    <a href="sso.php?authnContext=facebook">Login with Facebook</a>
</div>';
}
