<?php

use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAccessTokenProvider;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\GraphRequestAdapter;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Authentication\Cache\InMemoryAccessTokenCache;
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

$cache = new InMemoryAccessTokenCache();

$client = GraphServiceClient::createWithAuthenticationProvider(
    GraphPhpLeagueAuthenticationProvider::createWithAccessTokenProvider(
        GraphPhpLeagueAccessTokenProvider::createWithCache(
            $cache,
            $tokenRequestContext
        )
    )
);

$me = $client->users()->byUserId(USER_ID)->get()->wait();

// Retrieve token from our InMemoryCache
$tokenInCache = $cache->getTokenWithContext($tokenRequestContext);


$newCache = new InMemoryAccessTokenCache($tokenRequestContext, $tokenInCache);

$newClient = GraphServiceClient::createWithAuthenticationProvider(
    GraphPhpLeagueAuthenticationProvider::createWithAccessTokenProvider(
        GraphPhpLeagueAccessTokenProvider::createWithCache(
            $newCache,
            $tokenRequestContext
        )
    )
);

$me = $client->users()->byUserId(USER_ID)->get()->wait();

echo "done!";

