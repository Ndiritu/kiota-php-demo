<?php

namespace Microsoft\Graph\Models\Microsoft\Graph;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class SingleValueLegacyExtendedProperty extends Entity 
{
    /** @var string|null $value A property value. */
    private ?string $value = null;
    
    /**
     * Instantiates a new singleValueLegacyExtendedProperty and sets the default values.
    */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Gets the value property value. A property value.
     * @return string|null
    */
    public function getValue(): ?string {
        return $this->value;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable>
    */
    public function getFieldDeserializers(): array {
        return array_merge(parent::getFieldDeserializers(), [
            'value' => function (self $o, ParseNode $n) { $o->setValue($n->getStringValue()); },
        ]);
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        parent::serialize($writer);
        $writer->writeStringValue('value', $this->value);
    }

    /**
     * Sets the value property value. A property value.
     *  @param string|null $value Value to set for the value property.
    */
    public function setValue(?string $value ): void {
        $this->value = $value;
    }

}
