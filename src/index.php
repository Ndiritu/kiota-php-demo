<?php

use League\OAuth2\Client\Token\AccessToken;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAccessTokenProvider;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Authentication\Cache\InMemoryAccessTokenCache;
use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;

set_include_path(__DIR__);

require '../vendor/autoload.php';

define("TENANT_ID", getenv('delegated_tenant_id'));
define('CLIENT_ID', getenv('delegated_client_id'));
define('CLIENT_SECRET', getenv('delegated_client_secret'));
const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';

// $code = $_GET['code'];
$code = 'code';

$tokenRequestContext = new AuthorizationCodeContext(
    TENANT_ID,
    CLIENT_ID,
    CLIENT_SECRET,
    $code,
    'http://localhost:8080/'
);
$scopes = ['openid', 'profile', 'email', 'offline_access', 'user.read'];

// $cache = new InMemoryAccessTokenCache();

$accessToken = "eyJ0eXAiOiJKV1QiLCJub25jZSI6ImFvaXZuSldGMWFTdXpLOTFFaEp3YmdJTWNQajhFNVBaX1lnTDNWYUFYZEUiLCJhbGciOiJSUzI1NiIsIng1dCI6IlhSdmtvOFA3QTNVYVdTblU3Yk05blQwTWpoQSIsImtpZCI6IlhSdmtvOFA3QTNVYVdTblU3Yk05blQwTWpoQSJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hNDAwNmQ2NC1kYWRlLTQ0MmQtYTY5NS01OTM0ZjE0YTQxNTAvIiwiaWF0IjoxNzA5NzM1NTk0LCJuYmYiOjE3MDk3MzU1OTQsImV4cCI6MTcwOTc0MDA5NywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFWUUFxLzhXQUFBQWRaejFkNHEvRGRmdWhvOGJuNUMxRnBlT2VKNU1ONjdWeTI0ZGpqSGVYMHlTaXI5c1haNkNVMU5pRGVwM2RSS0NpNzVhb3BSVUMzRjJSbmtsKzl0Q1RCN1IxcVlycVVnU0htTkVadVZXd000PSIsImFtciI6WyJwd2QiLCJtZmEiXSwiYXBwX2Rpc3BsYXluYW1lIjoiRGVsZWdhdGVkIFBlcm1pc3Npb25zIEFwcCIsImFwcGlkIjoiYzhhYjQxM2MtY2Y4MS00OWY3LTg0MTUtNDg5ZDU4Zjg1YjYwIiwiYXBwaWRhY3IiOiIxIiwiZmFtaWx5X25hbWUiOiJHaWNodWhpIiwiZ2l2ZW5fbmFtZSI6IlBoaWxpcCIsImlkdHlwIjoidXNlciIsImlwYWRkciI6IjQxLjgxLjk0LjE3OSIsIm5hbWUiOiJQaGlsaXAgR2ljaHVoaSIsIm9pZCI6IjM1ZTljNjNhLTlkOWQtNGE3Zi05ZGEwLWVmNmI2NWQ5ZmU2YyIsInBsYXRmIjoiMyIsInB1aWQiOiIxMDAzMjAwMURGN0MzMkU4IiwicmgiOiIwLkFVWUFaRzBBcE43YUxVU21sVmswOFVwQlVBTUFBQUFBQUFBQXdBQUFBQUFBQUFDQUFPMC4iLCJzY3AiOiJVc2VyLlJlYWQgVXNlci5SZWFkV3JpdGUuQWxsIHByb2ZpbGUgb3BlbmlkIGVtYWlsIiwic3ViIjoiSGVkSmtDNE1ZWGNZZXhCcTZUc3V3cHRkbjY4bXhMZDFWeWhTVzlyTExOSSIsInRlbmFudF9yZWdpb25fc2NvcGUiOiJOQSIsInRpZCI6ImE0MDA2ZDY0LWRhZGUtNDQyZC1hNjk1LTU5MzRmMTRhNDE1MCIsInVuaXF1ZV9uYW1lIjoicGdpY2h1aGlAc2s3eGcub25taWNyb3NvZnQuY29tIiwidXBuIjoicGdpY2h1aGlAc2s3eGcub25taWNyb3NvZnQuY29tIiwidXRpIjoidTJEOEFaYTQ1a2F0bWNGeEFJSVlBUSIsInZlciI6IjEuMCIsIndpZHMiOlsiNjJlOTAzOTQtNjlmNS00MjM3LTkxOTAtMDEyMTc3MTQ1ZTEwIiwiYjc5ZmJmNGQtM2VmOS00Njg5LTgxNDMtNzZiMTk0ZTg1NTA5Il0sInhtc19zdCI6eyJzdWIiOiJCOHBfX29ad3BQdmJKems4ckxCSy0tTE5kOUxXaUwzUHVTc1hiWkh3eDVjIn0sInhtc190Y2R0IjoxNjQ1OTMzNTI4fQ.KZcbSaiONvG3bCjR-BG-ylVdN40Wr1LWnpf1s8jhDqIFLXHeQdmnF2nvgRNdXfcjmZl5-ylwdiPlA-ZsrMYDqWXMQDgqFlqbxAs9PuOI1nN2tK5mqR89j68BQLB2sQZEfX9d4F6xfUTSOTFbsoh94g-F-X903MIHVulvKzNZDoz4Oa_FMmUOne6Ks4FZlRQY__887AjcKLn2Z1Jjkpmfzw3izwPePYJ8FUAcsE0eCeN_Xa1YCAE833pjuRCbFbKU2issl1QyDhl5nohb57HuKIeZm19umm-F5kbim352sQLcv8OH9KLowNZaMi3O5kOhb5d12n9YWb1uMSlZPiaXIA";
$refreshToken = "0.AUYAZG0ApN7aLUSmlVk08UpBUDxBq8iBz_dJhBVInVj4W2CAAO0.AgABAAEAAADnfolhJpSnRYB1SVj-Hgd8AgDs_wUA9P_CB8y6n7zlZ3PGT0VdiG1kY3eiOmdYx_TbaxeOiOJqRMSyOeWlkPyzEz2-TzeYddY3DcVUV5_3rWxnjw7n14bwP5zQSuXIUyi2h6wtKstKErMmdto65YV9v6NVgTX4jAdh2KMRzKa3sEmvtfP_MlAjoVzCrNf_hX5R2wz6v0ZNRaOPoIgs0nIyU51qeM5VSZtJEYzT7gBI1uy0znxYvBuOaV0G2hbdntPuBPhgDvc6DVR2VyMp4pinY-YSQGXScRVNtRh9z6Ono4Zbc5zptUsi3A0xDq3qD3cJ3dMXo-3kxG21PQxvYjk-OptROvmS5aapfdX5a2gQgfMxtmr0JGr7RLe9UAlYiheol3nmiCbPR8RJf1DtK3RDGTMiEtgl18JLswqn4i3HTQ8nfFaPeGdOnpE6vYI-eiSyGjOqL_MLcM95nwcC9OJuH3pEQNguHhc7LL3Iya_L3m8S8T49_64SS6u-QzM2DzoYKeI1x2ShgnOTlfafC0ZvuU0epCDPR7_LXuuzoQwbaCDbcZhDge29N_dvg19-wbS742MglxNSg47dQu6294IPJjvgw5bNn4MQKt3VZBV83jwrWbtgbZ_V9boV4t8KIWp_uwqDkD45lRoSAtyjrAjYpHzUevlHMrgNBFOm7n0ypEQHP5cvpaRNGb6Q_Y4tHkJI6_fYrE9qH2DMHTqf0qrVrEDKQfypWxRirVkHhMGIjY9anURsJJ2r310RvkV6ghHgg8z74wU96vZNk6qEK1vMnksKy9jO2I-uq8ffQigKu58D3l8LGFQRO2bYGK76KBQHYj8_myClKw";
$cache = new InMemoryAccessTokenCache(
    $tokenRequestContext,
    new AccessToken(
        [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ]
    )
);



$graphServiceClient = GraphServiceClient::createWithAuthenticationProvider(
    GraphPhpLeagueAuthenticationProvider::createWithAccessTokenProvider(
        GraphPhpLeagueAccessTokenProvider::createWithCache(
            $cache,
            $tokenRequestContext,
            $scopes
        )
    )
);


try {

    $me = $graphServiceClient->users()->byUserId(USER_ID)->get()->wait();

    echo "Name: " . $me->getDisplayName() . "\n\n";

} catch (Exception $e) {
    echo $e->getMessage();
    print_r($e);
}


print("AccessToken: " . $cache->getTokenWithContext($tokenRequestContext)->getToken());
print("<br /><br />");
print("Refresh token: " . $cache->getTokenWithContext($tokenRequestContext)->getRefreshToken());
print("<br /><br />");
print("Expiry: " . $cache->getTokenWithContext($tokenRequestContext)->getExpires());
