<?php

namespace Kiota\Demo;

use Http\Promise\Promise;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAccessTokenProvider;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\Generated\Models\AccessReviewHistoryDecisionFilter;
use Microsoft\Graph\Generated\Models\AccessReviewHistoryDefinition;
use Microsoft\Graph\Generated\Models\AccessReviewQueryScope;
use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Graph\Generated\Models\Importance;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Graph\Generated\Users\Item\Messages\MessagesRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Graph\Generated\Models\MessageCollectionResponse;
use Microsoft\Graph\Generated\Users\UsersRequestBuilderGetRequestConfiguration;
use Microsoft\Kiota\Abstractions\Authentication\AccessTokenProvider;
use Microsoft\Kiota\Abstractions\NativeResponseHandler;
use Microsoft\Kiota\Authentication\Oauth\TokenRequestContext;
use Microsoft\Kiota\Http\Middleware\Options\ResponseHandlerOption;

const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';


set_include_path(__DIR__);

require '../vendor/autoload.php';

define("TENANT_ID", getenv('kiota_tenant_id'));
define('CLIENT_ID', getenv('kiota_client_id'));
define('CLIENT_SECRET', getenv('kiota_client_secret'));

$tokenRequestContext = new ClientCredentialContext(
    TENANT_ID,
    CLIENT_ID,
    CLIENT_SECRET
);

$graphServiceClient = new GraphServiceClient($tokenRequestContext);


$accessTokenProvider = new CustomTokenProvider();




$authenticationProvider = new GraphPhpLeagueAuthenticationProvider($tokenRequestContext, $scopes);
$requestAdapter = new GraphRequestAdapter($authenticationProvider);
$graphServiceClient = GraphServiceClient::createWithRequestAdapter($requestAdapter);

$graphServiceClient->drives()->byDriveId(config('graphapi.attachments_drive_id'))->items()->byDriveItemId('< drive item id>')->content()->get();

try {

    // $graphServiceClient = new GraphServiceClient($tokenRequestContext, []);

    $config = new UsersRequestBuilderGetRequestConfiguration(null, [
        new ResponseHandlerOption(new NativeResponseHandler())
    ]);
    $user = $graphServiceClient->users()->get($config)->wait()->wait();
    var_dump($user);

    // // WITH QUERY PARAMETERS & HEADERS
    // $requestConfig = new MessagesRequestBuilderGetRequestConfiguration();
    // $requestConfig->queryParameters = MessagesRequestBuilderGetRequestConfiguration::createQueryParameters();
    // $requestConfig->queryParameters->select = ['subject'];
    // $requestConfig->queryParameters->top = 2;
    // $requestConfig->headers = ['Prefer' => 'outlook.body-content-type=text']; 

    // /** @var MessageCollectionResponse $messages */
    // $messages = $graphServiceClient->users()->byUserId(USER_ID)->messages()->get($requestConfig)->wait();
    // $message = $messages->getValue()[0];
    // $additionalData = $message->getAdditionalData();
    // $stuff = $message->getCategories();

    // // POST
    // $body = new ItemBody();
    // $body->setContent("They were awesome");
    // $body->setContentType(new BodyType(BodyType::TEXT));

    // $content = $body->getContent();

    // $email = new EmailAddress();
    // $email->setAddress("Test@contoso.onmicrosoft.com");
    // $recipient = new Recipient();
    // $recipient->setEmailAddress($email);

    // $message = new Message();
    // $message->setSubject("KIOTA DEMO SUBJECT");
    // $message->setImportance(new Importance(Importance::LOW));
    // $message->setBody($body);
    // $message->setToRecipients([$recipient]);

    // $response = $graphServiceClient->users()->byUserId(USER_ID)->messages()->post($message)->wait();



    echo "Finished!";


} catch(ApiException $ex) {
    echo $ex->getMessage();
}


class CustomAccessTokenProvider extends GraphPhpLeagueAccessTokenProvider
{
    public function getAuthorizationTokenAsync(string $url, array $additionalAuthenticationContext = []): Promise
    {
        // check your cache if valid token exists or refresh as necessary
        // call PHP League OAuth 2 client to request access tokens
        
    }
}

class CustomAuthenticationProvider extends GraphPhpLeagueAuthenticationProvider
{
    public function getAccessTokenProvider(): AccessTokenProvider
    {
        return new CustomAccessTokenProvider($this->tokenRequestContext, $this->scopes);
    }
}


$requestAdapter = new GraphRequestAdapter(new CustomAuthenticationProvider($tokenRequestContext, $scopes));
$graphServiceClient = GraphServiceClient::createWithRequestAdapter($requestAdapter);