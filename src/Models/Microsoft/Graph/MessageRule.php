<?php

namespace Microsoft\Graph\Models\Microsoft\Graph;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class MessageRule extends Entity 
{
    /** @var MessageRuleActions|null $actions  */
    private ?MessageRuleActions $actions = null;
    
    /** @var MessageRulePredicates|null $conditions  */
    private ?MessageRulePredicates $conditions = null;
    
    /** @var string|null $displayName The display name of the rule. */
    private ?string $displayName = null;
    
    /** @var MessageRulePredicates|null $exceptions  */
    private ?MessageRulePredicates $exceptions = null;
    
    /** @var bool|null $hasError Indicates whether the rule is in an error condition. Read-only. */
    private ?bool $hasError = null;
    
    /** @var bool|null $isEnabled Indicates whether the rule is enabled to be applied to messages. */
    private ?bool $isEnabled = null;
    
    /** @var bool|null $isReadOnly Indicates if the rule is read-only and cannot be modified or deleted by the rules REST API. */
    private ?bool $isReadOnly = null;
    
    /** @var int|null $sequence Indicates the order in which the rule is executed, among other rules. */
    private ?int $sequence = null;
    
    /**
     * Instantiates a new messageRule and sets the default values.
    */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Gets the actions property value. 
     * @return MessageRuleActions|null
    */
    public function getActions(): ?MessageRuleActions {
        return $this->actions;
    }

    /**
     * Gets the conditions property value. 
     * @return MessageRulePredicates|null
    */
    public function getConditions(): ?MessageRulePredicates {
        return $this->conditions;
    }

    /**
     * Gets the displayName property value. The display name of the rule.
     * @return string|null
    */
    public function getDisplayName(): ?string {
        return $this->displayName;
    }

    /**
     * Gets the exceptions property value. 
     * @return MessageRulePredicates|null
    */
    public function getExceptions(): ?MessageRulePredicates {
        return $this->exceptions;
    }

    /**
     * Gets the hasError property value. Indicates whether the rule is in an error condition. Read-only.
     * @return bool|null
    */
    public function getHasError(): ?bool {
        return $this->hasError;
    }

    /**
     * Gets the isEnabled property value. Indicates whether the rule is enabled to be applied to messages.
     * @return bool|null
    */
    public function getIsEnabled(): ?bool {
        return $this->isEnabled;
    }

    /**
     * Gets the isReadOnly property value. Indicates if the rule is read-only and cannot be modified or deleted by the rules REST API.
     * @return bool|null
    */
    public function getIsReadOnly(): ?bool {
        return $this->isReadOnly;
    }

    /**
     * Gets the sequence property value. Indicates the order in which the rule is executed, among other rules.
     * @return int|null
    */
    public function getSequence(): ?int {
        return $this->sequence;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable>
    */
    public function getFieldDeserializers(): array {
        return array_merge(parent::getFieldDeserializers(), [
            'actions' => function (self $o, ParseNode $n) { $o->setActions($n->getObjectValue(MessageRuleActions::class)); },
            'conditions' => function (self $o, ParseNode $n) { $o->setConditions($n->getObjectValue(MessageRulePredicates::class)); },
            'displayName' => function (self $o, ParseNode $n) { $o->setDisplayName($n->getStringValue()); },
            'exceptions' => function (self $o, ParseNode $n) { $o->setExceptions($n->getObjectValue(MessageRulePredicates::class)); },
            'hasError' => function (self $o, ParseNode $n) { $o->setHasError($n->getBooleanValue()); },
            'isEnabled' => function (self $o, ParseNode $n) { $o->setIsEnabled($n->getBooleanValue()); },
            'isReadOnly' => function (self $o, ParseNode $n) { $o->setIsReadOnly($n->getBooleanValue()); },
            'sequence' => function (self $o, ParseNode $n) { $o->setSequence($n->getIntegerValue()); },
        ]);
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        parent::serialize($writer);
        $writer->writeObjectValue('actions', $this->actions);
        $writer->writeObjectValue('conditions', $this->conditions);
        $writer->writeStringValue('displayName', $this->displayName);
        $writer->writeObjectValue('exceptions', $this->exceptions);
        $writer->writeBooleanValue('hasError', $this->hasError);
        $writer->writeBooleanValue('isEnabled', $this->isEnabled);
        $writer->writeBooleanValue('isReadOnly', $this->isReadOnly);
        $writer->writeIntegerValue('sequence', $this->sequence);
    }

    /**
     * Sets the actions property value. 
     *  @param MessageRuleActions|null $value Value to set for the actions property.
    */
    public function setActions(?MessageRuleActions $value ): void {
        $this->actions = $value;
    }

    /**
     * Sets the conditions property value. 
     *  @param MessageRulePredicates|null $value Value to set for the conditions property.
    */
    public function setConditions(?MessageRulePredicates $value ): void {
        $this->conditions = $value;
    }

    /**
     * Sets the displayName property value. The display name of the rule.
     *  @param string|null $value Value to set for the displayName property.
    */
    public function setDisplayName(?string $value ): void {
        $this->displayName = $value;
    }

    /**
     * Sets the exceptions property value. 
     *  @param MessageRulePredicates|null $value Value to set for the exceptions property.
    */
    public function setExceptions(?MessageRulePredicates $value ): void {
        $this->exceptions = $value;
    }

    /**
     * Sets the hasError property value. Indicates whether the rule is in an error condition. Read-only.
     *  @param bool|null $value Value to set for the hasError property.
    */
    public function setHasError(?bool $value ): void {
        $this->hasError = $value;
    }

    /**
     * Sets the isEnabled property value. Indicates whether the rule is enabled to be applied to messages.
     *  @param bool|null $value Value to set for the isEnabled property.
    */
    public function setIsEnabled(?bool $value ): void {
        $this->isEnabled = $value;
    }

    /**
     * Sets the isReadOnly property value. Indicates if the rule is read-only and cannot be modified or deleted by the rules REST API.
     *  @param bool|null $value Value to set for the isReadOnly property.
    */
    public function setIsReadOnly(?bool $value ): void {
        $this->isReadOnly = $value;
    }

    /**
     * Sets the sequence property value. Indicates the order in which the rule is executed, among other rules.
     *  @param int|null $value Value to set for the sequence property.
    */
    public function setSequence(?int $value ): void {
        $this->sequence = $value;
    }

}
