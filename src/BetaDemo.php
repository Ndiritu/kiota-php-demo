<?php

namespace Kiota\Demo;

use Exception;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Utils;
use Http\Promise\Promise;
use Microsoft\Graph\Beta\Generated\Models\BodyType;
use Microsoft\Graph\Beta\Generated\Models\EmailAddress;
use Microsoft\Graph\Beta\Generated\Models\Importance;
use Microsoft\Graph\Beta\Generated\Models\ItemBody;
use Microsoft\Graph\Beta\GraphRequestAdapter;
use Microsoft\Graph\Beta\GraphServiceClient;
use Microsoft\Graph\Beta\Generated\Models\Message;
use Microsoft\Graph\Beta\Generated\Models\MessageCollectionResponse;
use Microsoft\Graph\Beta\Generated\Models\Recipient;
use Microsoft\Graph\Beta\Generated\Users\Count\CountRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Beta\Generated\Users\Item\Messages\MessagesRequestBuilderGetQueryParameters;
use Microsoft\Graph\Beta\Generated\Users\Item\Messages\MessagesRequestBuilderGetRequestConfiguration;
use Microsoft\Kiota\Abstractions\ResponseHandler;
use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Psr\Http\Message\ResponseInterface;

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

// $tokenRequestContext = new AuthorizationCodeContext(
//     TENANT_ID,
        // CLIENT_ID,
        // CLIENT_SECRET
//     'authCode',
//     'http://localhost:8080'
// );

$authProvider = new PhpLeagueAuthenticationProvider($tokenRequestContext, ['https://graph.microsoft.com/.default']);
$requestAdapter = new GraphRequestAdapter($authProvider);
$graphServiceClient = new GraphServiceClient($requestAdapter);

try {
    // GET collection of messages
    $messages = $graphServiceClient->usersById(USER_ID)->messages()->get()->wait();

    // WITH QUERY PARAMETERS & HEADERS
    $requestConfig = new MessagesRequestBuilderGetRequestConfiguration();
    $requestConfig->queryParameters = new MessagesRequestBuilderGetQueryParameters();
    $requestConfig->queryParameters->select = ['subject'];
    $requestConfig->queryParameters->top = 2;
    $requestConfig->headers = ['Prefer' => 'outlook.body-content-type=text']; 

    $nextLink = '';
    $numMessages = 0;

    do {
        $requestInfo = $graphServiceClient->usersById(USER_ID)->messages()->createGetRequestInformation($requestConfig);
        if ($nextLink) {
            $requestInfo->setUri($nextLink);
        }
        $additionalMessages = $requestAdapter->sendAsync($requestInfo, [MessageCollectionResponse::class, 'createFromDiscriminatorValue'])->wait();
        $numMessages += sizeof($additionalMessages->getValue());
        $nextLink = $additionalMessages->getOdatanextLink();
    } while ($nextLink);
   

    // GET item
    $sampleMessageId = $messages->getValue()[0]->getId();
    $message = $graphServiceClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();
    
    // // POST
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

    $response = $graphServiceClient->usersById(USER_ID)->messages()->post($message)->wait();

    // PATCH
    $updatedMsg = new Message();
    $updatedMsg->setSubject("Updated Subject!");
    $updatedMsg = $graphServiceClient->usersById(USER_ID)->messagesById($sampleMessageId)->patch($updatedMsg)->wait();

    // PUT
    $rootDriveId = "b!snvSw7NE8EeDp1CLO07dj3632uZ9FZhDi6IfbdhpPZBtcVvavuhNRYPmoTYXKS5e";
    $driveItemId = 'root:/files/kiota-demo.txt:';

    $inputStream = Utils::streamFor(fopen('demo-upload.txt', 'r'));
    $uploadItem = $graphServiceClient->drivesById($rootDriveId)->itemsById($driveItemId)->content()->put($inputStream)->wait();
        
    // DISCRIMINATOR MAPPING
    $appCreator = $graphServiceClient->applicationsById('3e90e1bf-6e1d-4f4e-a582-1c399aae626b')->owners()->get()->wait();
  
    // PLAIN TEXT DESERIALIZATION
    $requestConfig = new CountRequestBuilderGetRequestConfiguration();
    $requestConfig->headers = ['ConsistencyLevel' => 'eventual'];
    $numUsers = $graphServiceClient->users()->count()->get($requestConfig)->wait();

    // DOWNLOAD FILE
    $fileContents = $graphServiceClient->drivesById($rootDriveId)->itemsById($driveItemId)->content()->get()->wait();
    $fileContents = $fileContents->getContents();

    // DELETE
    $graphServiceClient->usersById(USER_ID)->messagesById($sampleMessageId)->delete();
    $message = $graphServiceClient->usersById(USER_ID)->messagesById($sampleMessageId)->get()->wait();

} catch(Exception $ex) {
    print_r($ex);
}


