<?php

require_once "../vendor/autoload.php";

use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Microsoft\Graph\GraphClient;
use Microsoft\Kiota\Http\KiotaClientFactory;

define("CLIENT_ID", getenv("client_id"));
define("TENANT_ID", getenv("test_tenantId"));
define("CLIENT_SECRET", getenv("test_secret"));

$tokenRequestContext = new ClientCredentialContext(
    TENANT_ID,
    CLIENT_ID,
    CLIENT_SECRET
);

$guzzleClient = KiotaClientFactory::createWithConfig([
    'proxy' => 'http://localhost:8888',
    'verify' => false
]);

$requestAdapter = new GuzzleRequestAdapter(
    new PhpLeagueAuthenticationProvider($tokenRequestContext, ['https://graph.microsoft.com/.default']),
    null,
    null,
    $guzzleClient
);

$graphClient = new GraphClient($requestAdapter);

$response = $graphClient->usersById('pgichuhi@pgichuhi.onmicrosoft.com')->messages()->get()->wait();
var_dump($response);
foreach ($response as $message) {
    echo "From: {$message->getFrom()}";
    echo "Subject: {$message->getSubject()}";
}
