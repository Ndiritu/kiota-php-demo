<?php

use League\OAuth2\Client\Token\AccessToken;
use Microsoft\Kiota\Authentication\Cache\AccessTokenCache;
use Microsoft\Kiota\Authentication\Cache\InMemoryAccessTokenCache;

class RedisTokenCache extends InMemoryAccessTokenCache
{

    private $tokens = [];

    public function __construct()
    {
        // reads from file, inits TokenRequestContext objects

    }

    public function persistAccessToken(string $identity, AccessToken $accessToken): void
    {
        // writes to file

        parent::persistAccessToken($identity, $accessToken);
    }
}
