<?php

namespace Kiota\Demo;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\Core\Tasks\LargeFileUploadTask;
use Microsoft\Graph\Generated\Drives\Item\Items\Item\CreateUploadSession\CreateUploadSessionPostRequestBody;
use Microsoft\Graph\Generated\Models\AttachmentItem;
use Microsoft\Graph\Generated\Models\AttachmentType;
use Microsoft\Graph\Generated\Models\DriveItemUploadableProperties;
use Microsoft\Graph\Generated\Models\ODataErrors\ODataError;
// use Microsoft\Graph\Generated\Users\Item\Messages\Item\Attachments\CreateUploadSession\CreateUploadSessionPostRequestBody;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Graph\Generated\Models\UploadSession;
use Microsoft\Graph\Core\Models\PageResult;
use Psr\Http\Client\NetworkExceptionInterface;

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

// $authProvider = new GraphPhpLeagueAuthenticationProvider($tokenRequestContext);
// $requestAdapter = new GraphRequestAdapter($authProvider, new Client(['debug' => true]));
// $graphServiceClient = new GraphServiceClient($requestAdapter);

$graphServiceClient = new GraphServiceClient($tokenRequestContext);

$message = $graphServiceClient->users()->byUserId(USER_ID)->messages()->get()->wait();
$msgId = $message->getValue()[6]->getId();

// OneDrive upload
$file = Utils::streamFor(fopen('./test2mbupload.txt', 'r'));

$driveId = $graphServiceClient->users()->byUserId(USER_ID)->drive()->get()->wait()->getId();

$uploadSessionRequestbody = new CreateUploadSessionPostRequestBody();
$uploadableProperties = new DriveItemUploadableProperties();
$uploadableProperties->setAdditionalData(['@microsoft.graph.conflictBehavior' => 'replace']);
$uploadSessionRequestbody->setItem($uploadableProperties);
$uploadSession = $graphServiceClient->drives()->byDriveId($driveId)->items()->byDriveItemId("root:/test/testLFU.txt:")->createUploadSession()->post($uploadSessionRequestbody)->wait();

// Max slice size must be a multiple of 320 KiB
$maxSliceSize = 320 * 1024;
$largeFileUpload = new LargeFileUploadTask($uploadSession, $graphServiceClient->getRequestAdapter(), $file, $maxSliceSize);

// Create a callback that is invoked after each slice is uploaded
$totalLength = $file->getSize();
$progressCallback = function (array $uploadedByteRange) use ($totalLength) {
    echo "Uploaded {$uploadedByteRange[0]} bytes of {$totalLength} bytes\n\n";
};

try {
    /** @var UploadResult $uploadResult */
    $uploadResult = $largeFileUpload->upload($progressCallback)->wait();
    echo "Upload complete";
} catch (ODataError $ex) {
    echo "Error uploading: {$ex->getError()->getMessage()}";
}





// create an upload session
// $file = Utils::streamFor(fopen('./openapi.yaml', 'r'));

// $attachmentItem = new AttachmentItem();
// $attachmentItem->setAttachmentType(new AttachmentType('file'));
// $attachmentItem->setName('graph-openapi');
// $attachmentItem->setSize($file->getSize());

// $uploadSessionRequestBody = new CreateUploadSessionPostRequestBody();
// $uploadSessionRequestBody->setAttachmentItem($attachmentItem);

// /** @var UploadSession $uploadSession */
// $uploadSession = $graphServiceClient->users()->byUserId(USER_ID)->messages()->byMessageId($msgId)->attachments()->createUploadSession()->post($uploadSessionRequestBody)->wait();

// $largeFileUpload = new LargeFileUploadTask($uploadSession, $graphServiceClient->getRequestAdapter(), $file);
// try{
//     $uploadSession = $largeFileUpload->upload()->wait();
//     echo "Upload complete!";
// } catch (\Psr\Http\Client\NetworkExceptionInterface $ex) {
//     // resume upload in case of network errors
//     $retries = 0;
//     $maxRetries = 3;
//     while ($retries < $maxRetries) {
//         try {
//             $uploadSession = $largeFileUpload->resume()->wait();
//             if ($uploadSession) {
//                 break;
//             }
//         } catch (NetworkExceptionInterface $ex) {
//             $retries ++;
//         }
//     }
//     throw $ex;
// } catch (ODataError $ex) {
//     var_dump($ex);
//     echo $ex->getError()->getMessage();
// }

// if ($uploadSession)
//     echo "Upload complete!";


// // cancel upload session.
// $largeFileUpload->cancel()->wait();
