<?php

namespace Kiota\Demo;

use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Kiota\Serialization\Json\JsonParseNode;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;

/**
 * Undocumented function
 *
 * @param callable(ParseNode):Parsable $parseNodeFactory
 * @return void
 */
function getObject(callable $parseNodeFactory) {
    return $parseNodeFactory()(new JsonParseNode(
        json_encode([
            'address' => 'p@gmail.com',
            'name' => 'Philip'
        ])
    ));
}

$email = getObject('EmailAddress::createFromDiscriminatorValue');
print_r($email);

