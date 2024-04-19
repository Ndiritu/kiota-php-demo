<?php

namespace Kiota\Demo;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Utils;
use Http\Promise\Promise;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\Core\GraphClientFactory;
use Microsoft\Graph\Core\GraphConstants;
use Microsoft\Graph\Core\Middleware\Option\GraphTelemetryOption;
use Microsoft\Graph\Generated\Admin\ServiceAnnouncement\Messages\MessagesRequestBuilderGetQueryParameters as MessagesMessagesRequestBuilderGetQueryParameters;
use Microsoft\Graph\Generated\Drives\Item\Items\Item\CreateUploadSession\CreateUploadSessionPostRequestBody;
use Microsoft\Graph\Generated\Groups\Item\Drive\DriveRequestBuilderGetQueryParameters;
use Microsoft\Graph\Generated\Groups\Item\Drive\DriveRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Me\MeRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Me\Messages\MessagesRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Models\AuthenticationMethod;
use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\DriveItemUploadableProperties;
use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Graph\Generated\Models\Importance;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\MessageCollectionResponse;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Graph\Generated\Users\Count\CountRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Users\Item\Drives\Item\Root\CreateUploadSession\CreateUploadSessionPostRequestBody as CreateUploadSessionCreateUploadSessionPostRequestBody;
use Microsoft\Graph\Generated\Users\Item\Messages\MessagesRequestBuilderGetQueryParameters;
use Microsoft\Graph\Generated\Users\Item\Messages\MessagesRequestBuilderGetRequestConfiguration as MessagesMessagesRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Users\Item\Teamwork\InstalledApps\InstalledAppsRequestBuilderGetQueryParameters;
use Microsoft\Graph\Generated\Users\Item\Teamwork\InstalledApps\InstalledAppsRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Users\UsersRequestBuilderGetQueryParameters;
use Microsoft\Graph\Generated\Users\UsersRequestBuilderGetRequestConfiguration;
use Microsoft\Kiota\Abstractions\NativeResponseHandler;
use Microsoft\Kiota\Abstractions\QueryParameter;
use Microsoft\Kiota\Abstractions\ResponseHandler;
use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Authentication\Oauth\OnBehalfOfContext;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Microsoft\Kiota\Http\Middleware\KiotaMiddleware;
use Microsoft\Kiota\Http\Middleware\Options\ChaosOption;
use Microsoft\Kiota\Http\Middleware\Options\RetryOption;
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



// $graphServiceClient = new GraphServiceClient($tokenRequestContext, $scopes);
$graphServiceClient = new GraphServiceClient($tokenRequestContext, ['offline_access', '.default']);


try {

    // // GET collection of messages
    // $user = $graphServiceClient->users()->byUserId(USER_ID)->get()->wait();
    // $messages = $graphServiceClient->users()->byUserId(USER_ID)->messages()->get()->wait();


    // $groupId = '0058f9a0-005a-4e20-b875-4878c99e4f44';
    // $driveConfig = new DriveRequestBuilderGetRequestConfiguration();
    // $driveConfig->queryParameters = new DriveRequestBuilderGetQueryParameters();
    // $driveConfig->queryParameters->expand = ['root'];

    // $defaultDrive = $graphServiceClient->groups()->byGroupId($groupId)->drive()->get($driveConfig)->wait();
    // $groupDriveRoot = $defaultDrive->getRoot();
    // $children = $graphServiceClient->drives()->byDriveId($defaultDrive->getId())->items()->byDriveItemId($groupDriveRoot->getId())->children()->get()->wait();


    // // WITH QUERY PARAMETERS & HEADERS
    // $requestConfig = new MessagesMessagesRequestBuilderGetRequestConfiguration();
    // $requestConfig->queryParameters = new MessagesRequestBuilderGetQueryParameters();
    // $requestConfig->queryParameters->select = ['subject'];
    // $requestConfig->queryParameters->top = 2;
    // $requestConfig->headers = ['Prefer' => 'outlook.body-content-type=text'];

    // $messages = $graphServiceClient->users()->byUserId(USER_ID)->messages()->get($requestConfig)->wait();


    // // GET item
    // $sampleMessageId = $messages->getValue()[0]->getId();
    // $message = $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($sampleMessageId)->get()->wait();

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

    $response = $graphServiceClient->users()->byUserId(USER_ID)->messages()->post($message)->wait();

    // PATCH
    $message = new Message();
    $message->setSubject('Backing Store UpSert TESTED!');
    $message->setConversationIndex(null);
    $updatedMsg = $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($response->getId())->patch($message)->wait();

    // PUT
    $rootDriveId = "b!snvSw7NE8EeDp1CLO07dj3632uZ9FZhDi6IfbdhpPZBtcVvavuhNRYPmoTYXKS5e";
    $driveItemId = 'root:/files/kiota-demo.txt:';

    $inputStream = Utils::streamFor(fopen('demo-upload.txt', 'r'));
    $uploadItem = $graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->content()->put($inputStream)->wait();

    // DOWNLOAD FILE
    $fileContents = $graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->content()->get()->wait();
    $fileContents = $fileContents->getContents();

    // DISCRIMINATOR MAPPING
    $appCreator = $graphServiceClient->applications()->byApplicationId('3e90e1bf-6e1d-4f4e-a582-1c399aae626b')->owners()->get()->wait();

    // PLAIN TEXT DESERIALIZATION
    $requestConfig = new CountRequestBuilderGetRequestConfiguration();
    $requestConfig->headers = ['ConsistencyLevel' => 'eventual'];
    $numUsers = $graphServiceClient->users()->count()->get($requestConfig)->wait();

    // DELETE
    $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($sampleMessageId)->delete();
    // $message = $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($sampleMessageId)->get()->wait();

    // UPLOAD SESSION
    $itemProperties = new DriveItemUploadableProperties();
    $itemProperties->setAdditionalData(['@microsoft.graph.conflictBehavior' => 'replace']);
    $body = new CreateUploadSessionPostRequestBody();
    $body->setItem($itemProperties);

    $body = new CreateUploadSessionPostRequestBody();
    $body->setItem($itemProperties);
    $session = $graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->createUploadSession()->post($body)->wait();

    $var = "last line";


} catch(Exception $ex) {
    print_r($ex);
}


