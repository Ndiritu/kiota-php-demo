<?php

use Microsoft\Graph\Graph;
use Beta\Microsoft\Graph\Model as BetaModel;
use Beta\Microsoft\Graph\Model\User;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Authentication\PhpLeagueAccessTokenProvider;

set_include_path(__DIR__);

require '../vendor/autoload.php';

// define("TENANT_ID", getenv('kiota_tenant_id'));
// define('CLIENT_ID', getenv('kiota_client_id'));
// define('CLIENT_SECRET', getenv('kiota_client_secret'));
// const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';


// $tokenRequestContext = new ClientCredentialContext(
//     TENANT_ID,
//     CLIENT_ID,
//     CLIENT_SECRET
// );

// $accessToken = (new PhpLeagueAccessTokenProvider($tokenRequestContext))->getAuthorizationTokenAsync('https://graph.microsoft.com/beta')->wait();
$graph = new Graph();
// $graph->setAccessToken($accessToken);
$graph->setApiVersion('beta');

// $result = $graph->createRequest('GET', '/users')->setReturnType(User::class)->execute();

echo "finished";