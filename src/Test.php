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
const USER_ID = 'pgichuhi@pgichuhi.onmicrosoft.com';

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

$messages = $graphClient->usersById(USER_ID)->messages()->get()->wait();
foreach ($messages->getValue() as $message) {
    echo "Id: {$message->getId()}\n";
    $from = $message->getFrom()->getEmailAddress();
    echo "From: {$from->getName()} <{$from->getAddress()}>\n";
    echo "Subject: {$message->getSubject()}\n\n";
}

$message = new \Microsoft\Graph\Models\Microsoft\Graph\Message();
