<?php

namespace Microsoft\Graph;

use Microsoft\Graph\Users\Item\UserRequestBuilder;
use Microsoft\Graph\Users\UsersRequestBuilder;
use Microsoft\Kiota\Abstractions\ApiClientBuilder;
use Microsoft\Kiota\Abstractions\RequestAdapter;

class GraphClient 
{
    /** @var array<string, mixed> $pathParameters Path parameters for the request */
    private array $pathParameters;
    
    /** @var RequestAdapter $requestAdapter The request adapter to use to execute the requests. */
    private RequestAdapter $requestAdapter;
    
    /** @var string $urlTemplate Url template to use to build the URL for the current request builder */
    private string $urlTemplate;
    
    public function users(): UsersRequestBuilder {
        return new UsersRequestBuilder($this->pathParameters, $this->requestAdapter);
    }
    
    /**
     * Instantiates a new GraphClient and sets the default values.
     * @param RequestAdapter $requestAdapter The request adapter to use to execute the requests.
    */
    public function __construct(RequestAdapter $requestAdapter) {
        $this->pathParameters = [];
        $this->urlTemplate = '{+baseurl}';
        $this->requestAdapter = $requestAdapter;
        ApiClientBuilder::registerDefaultSerializer(\Microsoft\Kiota\Serialization\Json\JsonSerializationWriterFactory::class);
        ApiClientBuilder::registerDefaultDeserializer(\Microsoft\Kiota\Serialization\Json\JsonParseNodeFactory::class);
        $this->requestAdapter->setBaseUrl('https://graph.microsoft.com/v1.0');
    }

    /**
     * Gets an item from the Microsoft\Graph.users.item collection
     * @param string $id Unique identifier of the item
     * @return UserRequestBuilder
    */
    public function usersById(string $id): UserRequestBuilder {
        $urlTplParams = $this->pathParameters;
        $urlTplParams['user_id'] = $id;
        return new UserRequestBuilder($urlTplParams, $this->requestAdapter);
    }

}
