<?php

namespace Kiota\Demo;

use GuzzleHttp\Psr7\Utils;
use Microsoft\Graph\BatchRequestBuilder;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\Core\Requests\BatchRequestContent;
use Microsoft\Graph\Core\Requests\BatchRequestItem;
use Microsoft\Graph\Generated\Models\DriveItem;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;


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

$graphServiceClient = new GraphServiceClient($tokenRequestContext);


$message = new Message();
$message->setSubject("UPDATED Subject");

$msgId = "AAMkAGU1MzAyZTlmLThkYTEtNGJmNC05Y2JhLWViMGQ1OTQ5NGIzOQBGAAAAAAC8WzGz8MUOR6pPeJq_p11LBwDDDW8iVoqYRqbHdJQE8vrTAAAAAAEMAADDDW8iVoqYRqbHdJQE8vrTAAD_HmWqAAA=";

// $request1 = new BatchRequestItem($graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($msgId)->toGetRequestInformation());
// $request2 = new BatchRequestItem($graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($msgId)->toPatchRequestInformation($message));
// $request2->dependsOn([$request1]);

$rootDriveId = "b!snvSw7NE8EeDp1CLO07dj3632uZ9FZhDi6IfbdhpPZBtcVvavuhNRYPmoTYXKS5e";
$driveItemId = 'root:/files/kiota-demo.txt:';
$inputStream = Utils::streamFor(fopen('demo-upload.txt', 'r'));
// $request3 = new BatchRequestItem($graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->content()->toPutRequestInformation($inputStream));
// $request3->dependsOn([$request2]);

// $batchRequestContent = new BatchRequestContent([
//     $request1, 
//     $request2,
//     $request3
// ]);

$batchRequestContent = new BatchRequestContent([
    $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($msgId)->toGetRequestInformation(),
    $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($msgId)->toPatchRequestInformation($message),
    $graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->content()->toPutRequestInformation($inputStream)
]);
$batchRequests = $batchRequestContent->getRequests();

$requestBuilder = new BatchRequestBuilder($graphServiceClient->getRequestAdapter());

try {
    /** @var BatchResponseContent $batchResponse */
    $batchResponse = $requestBuilder->postAsync($batchRequestContent)->wait();

    $response1 = $batchResponse->getResponse($batchRequests[0]->getId());
    echo "Response1 status code: {$response1->getStatusCode()}, body: {$response1->getBody()->getContents()}\n";

    $response1->getBody()->rewind();

    $message = $batchResponse->getResponseBody($batchRequests[0]->getId(), Message::class);
    echo "Initial subject: {$message->getSubject()}\n";

    $downloadedContent = $graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->content()->get()->wait();
    $downloadedContent = $downloadedContent->getContents();

    $response3Contents = $batchResponse->getResponse($batchRequests[2]->getId())->getBody()->getContents();
    $response3 = $batchResponse->getResponseBody($batchRequests[2]->getId(), DriveItem::class);

    // patched message
    $updatedMessage = $batchResponse->getResponseBody($batchRequests[1]->getId(), Message::class);
    echo "Updated subject: {$updatedMessage->getSubject()}\n";



    // $response1 = $batchResponse->getResponse($request1->getId());
    // echo "Response1 status code: {$response1->getStatusCode()}, body: {$response1->getBody()->getContents()}\n";

    // $response1->getBody()->rewind();

    // $message = $batchResponse->getResponseBody($request1->getId(), Message::class);
    // echo "Initial subject: {$message->getSubject()}\n";

    // $downloadedContent = $graphServiceClient->drives()->byDriveId($rootDriveId)->items()->byDriveItemId($driveItemId)->content()->get()->wait();
    // $downloadedContent = $downloadedContent->getContents();

    // $response3Contents = $batchResponse->getResponse($request3->getId())->getBody()->getContents();
    // $response3 = $batchResponse->getResponseBody($request3->getId(), DriveItem::class);

    // // patched message
    // $updatedMessage = $batchResponse->getResponseBody($request2->getId(), Message::class);
    // echo "Updated subject: {$updatedMessage->getSubject()}\n";

} catch(ApiException $ex) {
    print_r($ex);
}
