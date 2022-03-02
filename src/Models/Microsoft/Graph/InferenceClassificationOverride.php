<?php

namespace Microsoft\Graph\Models\Microsoft\Graph;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class InferenceClassificationOverride extends Entity 
{
    /** @var InferenceClassificationType|null $classifyAs  */
    private ?InferenceClassificationType $classifyAs = null;
    
    /** @var EmailAddress|null $senderEmailAddress  */
    private ?EmailAddress $senderEmailAddress = null;
    
    /**
     * Instantiates a new inferenceClassificationOverride and sets the default values.
    */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Gets the classifyAs property value. 
     * @return InferenceClassificationType|null
    */
    public function getClassifyAs(): ?InferenceClassificationType {
        return $this->classifyAs;
    }

    /**
     * Gets the senderEmailAddress property value. 
     * @return EmailAddress|null
    */
    public function getSenderEmailAddress(): ?EmailAddress {
        return $this->senderEmailAddress;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable>
    */
    public function getFieldDeserializers(): array {
        return array_merge(parent::getFieldDeserializers(), [
            'classifyAs' => function (self $o, ParseNode $n) { $o->setClassifyAs($n->getEnumValue(InferenceClassificationType::class)); },
            'senderEmailAddress' => function (self $o, ParseNode $n) { $o->setSenderEmailAddress($n->getObjectValue(EmailAddress::class)); },
        ]);
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        parent::serialize($writer);
        $writer->writeEnumValue('classifyAs', $this->classifyAs);
        $writer->writeObjectValue('senderEmailAddress', $this->senderEmailAddress);
    }

    /**
     * Sets the classifyAs property value. 
     *  @param InferenceClassificationType|null $value Value to set for the classifyAs property.
    */
    public function setClassifyAs(?InferenceClassificationType $value ): void {
        $this->classifyAs = $value;
    }

    /**
     * Sets the senderEmailAddress property value. 
     *  @param EmailAddress|null $value Value to set for the senderEmailAddress property.
    */
    public function setSenderEmailAddress(?EmailAddress $value ): void {
        $this->senderEmailAddress = $value;
    }

}
