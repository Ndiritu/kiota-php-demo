<?php

namespace Kiota\Demo;

use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Graph\Generated\Models\Importance;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;

require_once "./vendor/autoload.php";

function printMessage(Message $message)
{
    echo "Id: {$message->getId()}\n";
    if ($message->getFrom()) {
        $from = $message->getFrom()->getEmailAddress();
        echo "From: {$from->getName()} <{$from->getAddress()}>\n";
    }
    if ($message->getToRecipients()) {
        echo "Recipients: ";
        foreach ($message->getToRecipients() as $recipient) {
            echo "{$recipient->getEmailAddress()->getName()} <{$recipient->getEmailAddress()->getAddress()}>}, ";
        }
        echo "\n";
    }
    echo "Subject: {$message->getSubject()}\n\n";
}

const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';

$tokenRequestContext = new ClientCredentialContext(
    'a4006d64-dade-442d-a695-5934f14a4150',
    'c2c8e135-e3bd-4870-9092-5eba03dd9102',
    'Exh7Q~NLoJjNSt_UZ6Z..cePwf4tSwsXu-RPj'
);

$requestAdapter = GraphRequestAdapter::createWithTokenRequestContext($tokenRequestContext, ['https://graph.microsoft.com/.default']);

$graphClient = new GraphServiceClient($requestAdapter);

// GET collection of messages
$messages = $graphClient->usersById(USER_ID)->messages()->get()->wait();
echo "Fetched ".sizeof($messages->getValue())." messages\n\n";
foreach ($messages->getValue() as $message) {
    printMessage($message);
}

// GET item
$sampleMessageId = $messages->getValue()[0]->getId();
$message = $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();
echo "\n\n********************** GET ITEM **********************************\n\n";
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
echo "\n\n************************** POST ITEM *****************************************\n\n";
printMessage($response);
