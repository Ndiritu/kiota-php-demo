<?php

use GuzzleHttp\Psr7\Utils;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Generated\IdentityGovernance\AccessReviews\Definitions\Item\Instances\Item\Stages\Item\Decisions\Item\AccessReviewInstanceDecisionItemItemRequestBuilderGetRequestConfiguration;
use Microsoft\Graph\Generated\Models\Json;
use Microsoft\Graph\Generated\Models\Workbook;
use Microsoft\Graph\Generated\Models\WorkbookRange;
use Microsoft\Kiota\Abstractions\HttpMethod;

// Ensures imported classes can be found
set_include_path(__DIR__);
require '../vendor/autoload.php';
// define("TENANT_ID", getenv('kiota_tenant_id'));
// define('CLIENT_ID', getenv('kiota_client_id'));
// define('CLIENT_SECRET', getenv('kiota_client_secret'));
// const USER_ID = 'pgichuhi@sk7xg.onmicrosoft.com';

// $tokenRequestContext = new ClientCredentialContext(TENANT_ID, CLIENT_ID, CLIENT_SECRET);
$tokenRequestContext = new ClientCredentialContext('tenant', 'c', 'c');
$scopes = [];
    
// Raw snippet from docs
// THIS SNIPPET IS A PREVIEW VERSION OF THE SDK. NON-PRODUCTION USE ONLY
$graphServiceClient = new GraphServiceClient($tokenRequestContext, $scopes);

$result = $graphServiceClient->drives()->byDriveId('drive-id')->items()->byDriveItemId('driveItem-id')->workbook()->names()->byWorkbookNamedItemId('workbookNamedItem-id')->range()->get()->wait();




$workbookRange = new WorkbookRange();

$values = new Json();
$values->setAdditionalData([
    [["Hello", "100"],["1/1/2016", null]]
]);
$workbookRange->setValues($values);

$formulas = new Json();
$formulas->setAdditionalData(
    [[null, null], [null, "=B1*2"]]
);
$workbookRange->setFormulas($formulas);

$numberFormat = new Json();
$numberFormat->setAdditionalData(
    [[null,null], ["m-ddd", null]]
);
$workbookRange->setNumberFormat($numberFormat);


$requestInfo = $graphServiceClient->drives()->byDriveId('')->items()->byDriveItemId('')->workbook()->worksheets()->byWorkbookWorksheetId('')->range()->toGetRequestInformation();


$requestInfo->httpMethod = HttpMethod::PATCH;
$requestInfo->setContentFromParsable($graphServiceClient->getRequestAdapter(), 'application/json', $workbookRange);

$result = $graphServiceClient->reports()->getPrinterArchivedPrintJobsWithPrinterIdWithStartDateTimeWithEndDateTime(new \DateTime('endDateTime'),'{printerId}', new \DateTime('startDateTime'))->get()->wait();

