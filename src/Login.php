<?php

set_include_path(__DIR__);

require '../vendor/autoload.php';

define("TENANT_ID", getenv('delegated_tenant_id'));
define('CLIENT_ID', getenv('delegated_client_id'));
define('CLIENT_SECRET', getenv('delegated_client_secret'));
const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';

$authorizeUrl = "https://login.microsoftonline.com/".TENANT_ID."/oauth2/v2.0/authorize?";
$loginUrl = $authorizeUrl . http_build_query([
    'client_id' => CLIENT_ID,
    'response_type' => 'code',
    'redirect_uri' => 'http://localhost:8080',
    'response_mode' => 'query',
    'scope' => 'openid profile email offline_access user.read',
    'state' => '12345'
]);

// echo $loginUrl;

// header("Location: {$loginUrl}");

echo "<html>";
echo "<body>";

echo "<button>";
echo "<a href=".$loginUrl.">";
echo "Login with Microsoft Account";
echo "</a>";
echo "</button>";

echo "</body>";
echo "</html>";


