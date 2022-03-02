<?php

require_once "../vendor/autoload.php";
require_once "./DemoUtils.php";

use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Microsoft\Graph\GraphClient;
use Microsoft\Kiota\Http\KiotaClientFactory;
use Microsoft\Graph\Models\Microsoft\Graph\Message;
use Microsoft\Graph\Models\Microsoft\Graph\ItemBody;
use Microsoft\Graph\Models\Microsoft\Graph\BodyType;
use Microsoft\Graph\Models\Microsoft\Graph\EmailAddress;
use Microsoft\Graph\Models\Microsoft\Graph\Recipient;
use Microsoft\Graph\Models\Microsoft\Graph\Importance;

const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';

$tokenRequestContext = new ClientCredentialContext(
    'a4006d64-dade-442d-a695-5934f14a4150',
    'c2c8e135-e3bd-4870-9092-5eba03dd9102',
    'Exh7Q~NLoJjNSt_UZ6Z..cePwf4tSwsXu-RPj'
);

$requestAdapter = new GuzzleRequestAdapter(
    new PhpLeagueAuthenticationProvider($tokenRequestContext, ['https://graph.microsoft.com/.default']),
);

$graphClient = new GraphClient($requestAdapter);

// GET collection of messages
$messages = $graphClient->usersById(USER_ID)->messages()->get()->wait();
foreach ($messages->getValue() as $message) {
    printMessage($message);
}

// GET item
$sampleMessageId = $messages->getValue()[0]->getId();
$message = $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();
printMessage($message);

// POST
$body = new ItemBody();
$body->setContent("They were awesome");
$body->setContentType(new BodyType(BodyType::TEXT));

$email = new EmailAddress();
$email->setAddress("Test@contoso.onmicrosoft.com");
$recipient = new Recipient();
$recipient->setEmailAddress($email);

$message = new Message();
$message->setSubject("KIOTA DEMO SUBJECT");
$message->setImportance(new Importance(Importance::LOW));
$message->setBody($body);
$message->setToRecipients([$recipient]);

$response = $graphClient->usersById(USER_ID)->messages()->post($message)->wait();
printMessage($response);
