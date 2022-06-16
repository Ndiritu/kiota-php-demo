<?php

namespace Kiota\Demo;

use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Microsoft\Graph\Core\GraphClientFactory;
use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Graph\Generated\Models\Importance;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Graph\Generated\Users\Item\Messages\MessagesRequestBuilderGetQueryParameters;
use Microsoft\Graph\Generated\Users\Item\Messages\MessagesRequestBuilderGetRequestConfiguration;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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

$logMessageTemplate = "{method}... {uri}\n\n\n{code}...\n";
$messageFormatter = new MessageFormatter($logMessageTemplate);

$log = new Logger('Demo');
$log->pushHandler(new StreamHandler('php://stdout'));

$middleware = GraphClientFactory::getDefaultHandlerStack();
$middleware->push(Middleware::log($log, $messageFormatter));
$httpClient = GraphClientFactory::createWithMiddleware($middleware);

$requestAdapter = GraphRequestAdapter::withTokenRequestContext($tokenRequestContext, ['https://graph.microsoft.com/.default'])::withHttpClient($httpClient);
$graphClient = new GraphServiceClient($requestAdapter);

// GET collection of messages
// $messages = $graphClient->usersById(USER_ID)->messages()->get()->wait();
// echo "Fetched ".sizeof($messages->getValue())." messages\n\n";
// foreach ($messages->getValue() as $message) {
//     printMessage($message);
// }

// GET item
// $sampleMessageId = $messages->getValue()[0]->getId();
// echo "Sample Message ID: {$sampleMessageId}\n\n";
// $message = $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();
// echo "\n\n********************** GET ITEM **********************************\n\n";
// var_dump($message);
// printMessage($message);

// POST
// $body = new ItemBody();
// $body->setContent("They were awesome");
// $body->setContentType(new BodyType(BodyType::TEXT));

// $email = new EmailAddress();
// $email->setAddress("Test@contoso.onmicrosoft.com");
// $recipient = new Recipient();
// $recipient->setEmailAddress($email);

// $message = new Message();
// $message->setSubject("KIOTA DEMO SUBJECT");
// $message->setImportance(new Importance(Importance::LOW));
// $message->setBody($body);
// $message->setToRecipients([$recipient]);

// $response = $graphClient->usersById(USER_ID)->messages()->post($message)->wait();
// echo "\n\n************************** POST ITEM *****************************************\n\n";
// printMessage($response);

// PUT


// PATCH
// $updatedMsg = new Message();
// $updatedMsg->setSubject("Updated Subject!");
// $updatedMsg = $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->patch($updatedMsg)->wait();
// echo "\n\n********************* PATCH ITEM ****************************\n\n";
// var_dump($updatedMsg);

// DELETE
// $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->delete();
// echo "\n\n Trying to feth DELETED message by Id: {$sampleMessageId}\n\n";
// $message = $graphClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();

// WITH QUERY PARAMETERS & HEADERS
// $requestConfig = new MessagesRequestBuilderGetRequestConfiguration();
// $requestConfig->queryParameters = new MessagesRequestBuilderGetQueryParameters();
// $requestConfig->queryParameters->select = ['subject', 'from'];
// $requestConfig->queryParameters->skip = 2;
// $requestConfig->queryParameters->top = 3;
// $requestConfig->headers = ['Prefer' => 'outlook.body-content-type=text']; 

// $messages = $graphClient->usersById(USER_ID)->messages()->get($requestConfig)->wait();
// print_r($messages);
// $sampledMessageId = 'AAMkAGU1MzAyZTlmLThkYTEtNGJmNC05Y2JhLWViMGQ1OTQ5NGIzOQBGAAAAAAC8WzGz8MUOR6pPeJq_p11LBwDDDW8iVoqYRqbHdJQE8vrTAAAAAAEMAADDDW8iVoqYRqbHdJQE8vrTAAA7E5niAAA=';


// PLAIN TEXT DESERIALIZATION
$numMessages = $graphClient->usersById(USER_ID)->messages()->count()->get()->wait();
echo "Num messages: {$numMessages}";


