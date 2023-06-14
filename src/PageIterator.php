<?php

namespace Kiota\Demo;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\Core\Tasks\LargeFileUploadTask;
use Microsoft\Graph\Core\Tasks\PageIterator;
use Microsoft\Graph\Generated\Models\AttachmentItem;
use Microsoft\Graph\Generated\Models\AttachmentType;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\MessageCollectionResponse;
use Microsoft\Graph\Generated\Models\ODataErrors\ODataError;
use Microsoft\Graph\Generated\Users\Item\Messages\Item\Attachments\CreateUploadSession\CreateUploadSessionPostRequestBody;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Graph\Generated\Models\UploadSession;
use Microsoft\Graph\Generated\Models\User;
use Microsoft\Graph\Generated\Models\UserCollectionResponse;

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

$authProvider = new GraphPhpLeagueAuthenticationProvider($tokenRequestContext);
$requestAdapter = new GraphRequestAdapter($authProvider, new Client(['debug' => true]));
$graphServiceClient = new GraphServiceClient($requestAdapter);

$users = $graphServiceClient->users()->get()->wait();

$pageIterator = new PageIterator($users, $requestAdapter, [UserCollectionResponse::class]);

try {
    $counter = 1;
    $pageIterator->iterate(function (User $user) use (&$counter) {
        echo "Counter: $counter - name: {$user->getDisplayName()}\n";
        $counter ++;
        return ($counter % 10 != 0);
    });
    echo "\n\n PAUSED ITERATION!\n\n";
    $pageIterator->iterate(function (User $user) use (&$counter) {
        echo "Counter: $counter - name: {$user->getDisplayName()}\n";
        $counter ++;
        return true;
    });
    echo "\n\nTOTAL COUNT OF USERS: $counter\n\n";

} catch (ODataError $ex) {
    print_r($ex);
}



