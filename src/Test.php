<?php

use Http\Promise\FulfilledPromise;
use Http\Promise\Promise;
use Http\Promise\RejectedPromise;
use League\OAuth2\Client\Grant\AuthorizationCode;
use League\OAuth2\Client\Token\AccessToken;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAccessTokenProvider;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\Core\GraphConstants;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Abstractions\Authentication\AccessTokenProvider;
use Microsoft\Kiota\Abstractions\Authentication\AllowedHostsValidator;
use Microsoft\Kiota\Authentication\Cache\AccessTokenCache;
use Microsoft\Kiota\Authentication\Cache\InMemoryAccessTokenCache;
use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Kiota\Authentication\Oauth\ProviderFactory;
use Microsoft\Kiota\Authentication\PhpLeagueAuthenticationProvider;
use Microsoft\Kiota\Http\GuzzleRequestAdapter;

set_include_path(__DIR__);

require '../vendor/autoload.php';


function getTokenAsync(): Promise
{
    // return new RejectedPromise(new \InvalidArgumentException("Invalid arguments"));
    return (new FulfilledPromise("token"))->then(
        function (string $token) {
            return;
        }
    );
}

echo getTokenAsync()->wait();



class CustomAccessTokenProvider implements AccessTokenProvider
{
    public function getAuthorizationTokenAsync(string $url, array $additionalAuthenticationContext = []): Promise
    {
        // custom logic to return a Promise that resolves to a valid access token
    }

    public function getAllowedHostsValidator(): AllowedHostsValidator
    {
        return new AllowedHostsValidator();

        // alternatively, we can provide a GraphAllowedHostsValidator with Graph allowed hosts
    }
}

$graphServiceClient = GraphServiceClient::createWithAccessTokenProvider(new CustomAccessTokenProvider());
$user = $graphServiceClient->me()->get()->wait();


// Kiota core proposed changes

interface AccessTokenProvider {

    // add new method
    public function getRefreshToken(): string;
}

class PhpLeagueAccessTokenProvider {

    // add new static builder method since constructor overloads are not supported
    public static function createWithRefreshToken(string $refreshToken): this
    {
        //...
    }
}

class GraphServiceClient {

    // add convenience method to fetch access token provider
    public function getAccessTokenProvider(): GraphPhpLeagueAccessTokenProvider
    {

    }
}

// developer use

// initial request
$tokenRequestContext = new AuthorizationCodeContext('tenantId', 'clientId', 'clientSecret', 'authCode', 'redirectUrl');
$graphServiceClient = new GraphServiceClient($tokenRequestContext, ['scopes']);
$me = $graphServiceClient->me()->get()->wait();

// fetch and persist refresh token
$refreshToken = $graphServiceClient->getAccessTokenProvider()->getRefreshToken();

$graphServiceClient->getRequestAdapter()->getAuthenticationProvider()->getAccessTokenProvider()->getRefreshToken();


// initiate future request using refresh token
// re-uses createWithAccessTokenProvider() method added in scenario 1

$graphServiceClient = GraphServiceClient::createWithAccessTokenProvider(
    GraphPhpLeagueAccessTokenProvider::createWithRefreshToken($refreshToken)
);
$me = $graphServiceClient->me()->get()->wait();


// Kiota authentication lib changes
trait SelfManagedTokenTrait {

    private string $accessToken;
    private string $refreshToken;

    public function setAccessToken(string $accessToken) {
        $this->accessToken = $accessToken;
    }

    public function setRefreshToken(string $refreshToken) {
        $this->refreshToken = $refreshToken;
    }

    public function getAccessToken(): AccessToken {

    }

    // no getAccessToken() to discourage bad practice?
}

trait ApplicationPermissionTrait {
    use SelfManagedTokenTrait;
}

trait DelegatedPermissionTrait {
    use SelfManagedTokenTrait;
}

class PhpLeagueAccessTokenProvider {

    public function getAuthorizationTokenAsync(): Promise {
        /**
         * check if TokenRequestContext->getAccessToken() contains something
         * if not null
         *      check if access token exists
         *          check if expired
         *              check for refresh token
         *                  request new access token & refresh token
         *                  set tokenRequestContext with new access token/refresh token for dev to re-use if needed
         *                  add new access token/refresh token to cache
         *              no refresh token
         *                  throw exception
         *          token not expired
         *              return it
         *
         *      access token doesn't exist
         *          check if refresh token exists
         *              request new access token & refresh token
         *              set tokenRequestContext with new access token/refresh token for dev to re-use if needed
         *              add new access token/refresh token to cache
         *          no refresh token
         *              proceed with current auth flow
         *
         * if null (no custom access token provided)
         *      proceed with current auth flow
         *          request token & cache
         */
    }
}


// Developer experience changes
$tokenRequestContext = new AuthorizationCodeContext('tenantId', 'clientId', 'clientSecret', 'authCode');
$tokenRequestContext->setAccessToken(new AccessToken(
    [
        'access_token' => 'string',
        'expiry' => 1231, //seconds
        'refresh_token' => 'string'
    ]
));


$graphServiceClient = new GraphServiceClient($tokenRequestContext, ['scopes']);


// Developer who already has an access token
$tokenRequestContext = new AuthorizationCodeContext('tenantId', 'clientId', 'clientSecret'); // make authCode & redirectUri optional params?

$tokenRequestContext->setAccessToken(new AccessToken(
    [
        'access_token' => 'string',
        'expiry' => 1231, //seconds
        'refresh_token' => 'string'
    ]
));

$graphServiceClient = new GraphServiceClient($tokenRequestContext, ['scopes']);
$me = $graphServiceClient->me()->get()->wait();

// keep refresh & access token & store for re-use in another session
/* @var AccessToken - contains expiry info etc */
$accessToken = $tokenRequestContext->getAccessToken();


// session 2/process 2
$tokenRequestContext = new AuthorizationCodeContext('tenantId', 'clientId', 'clientSecret');

$tokenRequestContext->setAccessToken(new AccessToken(
    [
        'access_token' => 'string',
        'expiry' => 1231, //seconds
        'refresh_token' => 'string'
    ]
));

$graphServiceClient = new GraphServiceClient($tokenRequestContext, ['scopes']);
$me = $graphServiceClient->me()->get()->wait();



// ** Should we expose tokens the lib fetches directly? or write them to a cache that the developer manages?



// Using a custom AccessTokenCache
class CustomAccessTokenCache implements AccessTokenCache
{
    // handles distributed access to token

    public function getAccessToken(string $cacheKey): ?AccessToken {}

    public function persistAccessToken(string $cacheKey, AccessToken $accessToken): void {}
}

// initial request
$tokenRequestContext = new AuthorizationCodeContext('tenant', 'client', 'secret', 'authCode', 'redirectUri');
$tokenRequestContext->setCacheKeyString('unique-to-user');

$accessTokenCache = new CustomAccessTokenCache();

// using tailored API client from Kiota
$accessTokenProvider = new PhpLeagueAccessTokenProvider($tokenRequestContext, ['scopes'], GraphConstants::ALLOWED_HOSTS, $accessTokenCache);

// using Graph's pre-packaged SDK
$accessTokenProvider = GraphPhpLeagueAccessTokenProvider::createWithCache($tokenRequestContext, ['scopes'], $accessTokenCache);

$graphServiceClient = GraphServiceClient::createWithAccessTokenProvider($accessTokenProvider);

// second session
$tokenRequestContext = new AuthorizationCodeContext('tenant', 'client', 'secret'); // make authCode & redirectUri optional?
$tokenRequestContext->setCacheKeyString('unique-to-user');

$accessTokenProvider = GraphPhpLeagueAccessTokenProvider::createWithCache($tokenRequestContext, ['scopes'], $accessTokenCache);

$graphServiceClient = GraphServiceClient::createWithAccessTokenProvider($accessTokenProvider);

// request uses cached access token
$me = $graphServiceClient->me()->get()->wait();



// Without providing a custom cache
$tokenRequestContext = new AuthorizationCodeContext('tenant', 'client', 'secret', 'authCode', 'redirect');
$graphServiceClient = new GraphServiceClient($tokenRequestContext);
$token = $graphServiceClient->getRequestAdapter()->getAuthenticationProvider()->getAccessTokenProvider()->getCache()->getAccessTokenWithTokenRequestContext($tokenRequestContext);

// If a custom cache is initialised/built-in inMemoryCache is initialized
$tokenCache = new InMemoryAccessTokenCache();
$accessTokenProvider = PhpLeagueAccessTokenProvider::createWithCache($tokenRequestContext, ['scopes'], $tokenCache);
$graphServiceClient = GraphServiceClient::createWithAccessTokenProvider($accessTokenProvider);
$token = $tokenCache->getAccessTokenWithTokenRequestContext($tokenRequestContext);

// re-using an access token
$accessToken = new AccessToken([
    'access_token' => 'custom-token',
    'expiry' => 123, // optional. Seconds
    'refresh_token' => 'refresh-token' // optional
]);

$tokenRequestContext = new AuthorizationCodeContext('tenant', 'client', 'secret');

// developer hydrates the built-in cache
$tokenCache = new InMemoryAccessTokenCache(
    [
        $tokenRequestContext => $accessToken,
        //... multiple tokens
    ]
);

// developer hydrates a custom cache
$tokenCache = 


$cacheIdentifier = $tokenRequestContext->setCacheKey($accessToken);


$tokenCache = new InMemoryAccessTokenCache();
$tokenCache->persistAccessToken($cacheIdentifier, $accessToken);

// initialise client
$accessTokenProvider = PhpLeagueAccessTokenProvider::createWithCache($tokenRequestContext, ['scopes'], $tokenCache);
$graphServiceClient = GraphServiceClient::createWithAccessTokenProvider($accessTokenProvider);


// problem we're solving
// hey, here's my cache, let me initialise it with the tokens I have

// how do I initialize this InMemoryCache with data? (one/more contexts & tokens)
    // how do I maintain the relationship between a tokenContext & it's associated access token?
    // esp when they're many being initialised


// Developer hydrates the cache with one or more tokens
$cache = new InMemoryAccessTokenCache(
    [
        $tokenRequestContext => $accessToken,
        //... multiple tokens
    ]
);

InMemoryAccessTokenCache::createWithTokens([
    $tokenRequestContext => $accessToken,
    //... multiple tokens
]);

$cache->initWithTokens([
    $tokenRequestContext => $accessToken,
    //... multiple tokens
]);





