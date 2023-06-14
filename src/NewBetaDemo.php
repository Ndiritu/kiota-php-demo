<?php

use Microsoft\Graph\Beta\Generated\Models\BodyType;
use Microsoft\Graph\Beta\Generated\Models\EmailAddress;
use Microsoft\Graph\Beta\Generated\Models\Importance;
use Microsoft\Graph\Beta\Generated\Models\ItemBody;
use Microsoft\Graph\Beta\Generated\Models\Message;
use Microsoft\Graph\Beta\Generated\Models\Recipient;
use Microsoft\Graph\Beta\Generated\Users\Count\CountRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Beta\Generated\Users\Item\Messages\MessagesRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Beta\GraphRequestAdapter;
use Microsoft\Graph\Beta\GraphServiceClient;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Authentication\Oauth\ContinuousAccessEvaluationException;

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
$tokenRequestContext->setCAEEnabled(true);
$graphServiceClient = new GraphServiceClient($tokenRequestContext);


try {

    $user = $graphServiceClient->users()->get()->wait();

    // WITH QUERY PARAMETERS & HEADERS
    $requestConfig = new MessagesRequestBuilderGetRequestConfiguration();
    $requestConfig->queryParameters = MessagesRequestBuilderGetRequestConfiguration::createQueryParameters();
    $requestConfig->queryParameters->select = ['subject'];
    $requestConfig->queryParameters->top = 2;
    $requestConfig->headers = ['Prefer' => 'outlook.body-content-type=text']; 

    $messages = $graphServiceClient->users()->byUserId(USER_ID)->messages()->get($requestConfig)->wait();

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


    // DISCRIMINATOR MAPPING
    $appCreator = $graphServiceClient->applications()->byApplicationId('3e90e1bf-6e1d-4f4e-a582-1c399aae626b')->owners()->get()->wait();
  
    // PLAIN TEXT DESERIALIZATION
    $requestConfig = new CountRequestBuilderGetRequestConfiguration();
    $requestConfig->headers = ['ConsistencyLevel' => 'eventual'];
    $numUsers = $graphServiceClient->users()->count()->get($requestConfig)->wait();

    echo "Finished!";


} catch(ApiException $ex) {
    echo $ex->getMessage();
}