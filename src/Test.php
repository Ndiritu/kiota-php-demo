<?php

require_once "../vendor/autoload.php";
require_once "./DemoUtils.php";

use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Microsoft\Graph\GraphClient;
use Microsoft\Kiota\Http\KiotaClientFactory;
use Microsoft\Graph\Models\Microsoft\Graph\Message;

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

//// GET collection of messages
//$messages = $graphClient->usersById(USER_ID)->messages()->get()->wait();
//foreach ($messages->getValue() as $message) {
//    printMessage($message);
//}
//
//// GET item
//$sampleMessageId = $messages->getValue()[0]->getId();
//$message = $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();
//printMessage($message);

// POST
$body = new \Microsoft\Graph\Models\Microsoft\Graph\ItemBody();
$body->setContent("They were awesome");

$recipient = new \Microsoft\Graph\Models\Microsoft\Graph\Recipient();
$email = new \Microsoft\Graph\Models\Microsoft\Graph\EmailAddress();
$email->setAddress("Test@contoso.onmicrosoft.com");
$recipient->setEmailAddress($email);
$recipients = [
    $recipient
];

$message = new Message();
$message->setSubject("KIOTA DEMO SUBJECT");
$message->setImportance(new \Microsoft\Graph\Models\Microsoft\Graph\Importance('low'));
$message->setBody($body);
$message->setToRecipients($recipients);

$response = $graphClient->usersById(USER_ID)->messages()->post($message);
printMessage($response);
