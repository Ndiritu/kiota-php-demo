<?php

use GuzzleHttp\Promise\FulfilledPromise;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAccessTokenProvider;

set_include_path(__DIR__);

require '../vendor/autoload.php';

define("TENANT_ID", getenv('kiota_tenant_id'));
define('CLIENT_ID', getenv('kiota_client_id'));
define('CLIENT_SECRET', getenv('kiota_client_secret'));
const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';

$tokenRequestContext = new ClientCredentialContext(
    TENANT_ID,
    CLIENT_ID,
    CLIENT_SECRET
);
$tokenProvider = new GraphPhpLeagueAccessTokenProvider($tokenRequestContext);
$token = $tokenProvider->getAuthorizationTokenAsync('https://graph.microsoft.com')->wait();
echo $token;




