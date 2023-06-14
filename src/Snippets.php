<?php

namespace Kiota\Demo;

use Microsoft\Graph\Generated\Models\ODataErrors\ODataError;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;

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

} catch (ODataError $ex) {
    echo $ex->getError()->getMessage();
}