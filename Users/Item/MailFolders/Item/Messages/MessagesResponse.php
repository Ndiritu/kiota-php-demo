<?php

namespace Microsoft\Graph\Users\Item\MailFolders\Item\Messages;

use Microsoft\Graph\Models\Microsoft\Graph\Message;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class MessagesResponse implements Parsable 
{
    /** @var array<string, mixed> $AdditionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well. */
    private array $additionalData;
    
    /** @var string|null $nextLink  */
    private ?string $nextLink;
    
    /** @var array<Message>|null $value  */
    private ?array $value;
    
    /**
     * Instantiates a new messagesResponse and sets the default values.
    */
    public function __construct() {
        $this->additionalData = [];
    }

    /**
     * Gets the additionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>
    */
    public function getAdditionalData(): array {
        return $this->additionalData;
    }

    /**
     * Gets the @odata.nextLink property value. 
     * @return string|null
    */
    public function getNextLink(): ?string {
        return $this->nextLink;
    }

    /**
     * Gets the value property value. 
     * @return array<Message>|null
    */
    public function getValue(): ?array {
        return $this->value;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable>
    */
    public function getFieldDeserializers(): array {
        return  [
            '@odata.nextLink' => function (self $o, ParseNode $n) { $o->setNextLink($n->getStringValue()); },
            'value' => function (self $o, ParseNode $n) { $o->setValue($n->getCollectionOfObjectValues(Message::class)); },
        ];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('@odata.nextLink', $this->nextLink);
        $writer->writeCollectionOfObjectValues('value', $this->value);
        $writer->writeAdditionalData($this->additionalData);
    }

    /**
     * Sets the additionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     *  @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value ): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the @odata.nextLink property value. 
     *  @param string|null $value Value to set for the nextLink property.
    */
    public function setNextLink(?string $value ): void {
        $this->nextLink = $value;
    }

    /**
     * Sets the value property value. 
     *  @param array<Message>|null $value Value to set for the value property.
    */
    public function setValue(?array $value ): void {
        $this->value = $value;
    }

}
