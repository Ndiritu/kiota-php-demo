<?php

require_once "../vendor/autoload.php";

use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use \Microsoft\Graph\GraphClient;

define("CLIENT_ID", getenv("client_id"));
define("TENANT_ID", getenv("test_tenantId"));
define("CLIENT_SECRET", getenv("test_secret"));

$tokenRequestContext = new ClientCredentialContext(
    TENANT_ID,
    CLIENT_ID,
    CLIENT_SECRET
);
$requestAdapter = new GuzzleRequestAdapter(
    new PhpLeagueAuthenticationProvider($tokenRequestContext, ['https://graph.microsoft.com/.default'])
);
$graphClient = new GraphClient($requestAdapter);

$response = $graphClient->usersById('pgichuhi@pgichuhi.onmicrosoft.com')->messages()->get()->wait();
foreach ($response as $message) {
    echo "From: {$message->getFrom()}";
    echo "Subject: {$message->getSubject()}";
}
