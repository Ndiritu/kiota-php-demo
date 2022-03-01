<?php

namespace Microsoft\Graph\Models\Microsoft\Graph;

use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class MessageRulePredicates implements Parsable 
{
    /** @var array<string, mixed> $AdditionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well. */
    private array $additionalData;
    
    /** @var array<string>|null $bodyContains Represents the strings that should appear in the body of an incoming message in order for the condition or exception to apply. */
    private ?array $bodyContains;
    
    /** @var array<string>|null $bodyOrSubjectContains Represents the strings that should appear in the body or subject of an incoming message in order for the condition or exception to apply. */
    private ?array $bodyOrSubjectContains;
    
    /** @var array<string>|null $categories Represents the categories that an incoming message should be labeled with in order for the condition or exception to apply. */
    private ?array $categories;
    
    /** @var array<Recipient>|null $fromAddresses Represents the specific sender email addresses of an incoming message in order for the condition or exception to apply. */
    private ?array $fromAddresses;
    
    /** @var bool|null $hasAttachments Indicates whether an incoming message must have attachments in order for the condition or exception to apply. */
    private ?bool $hasAttachments;
    
    /** @var array<string>|null $headerContains Represents the strings that appear in the headers of an incoming message in order for the condition or exception to apply. */
    private ?array $headerContains;
    
    /** @var Importance|null $importance  */
    private ?Importance $importance;
    
    /** @var bool|null $isApprovalRequest Indicates whether an incoming message must be an approval request in order for the condition or exception to apply. */
    private ?bool $isApprovalRequest;
    
    /** @var bool|null $isAutomaticForward Indicates whether an incoming message must be automatically forwarded in order for the condition or exception to apply. */
    private ?bool $isAutomaticForward;
    
    /** @var bool|null $isAutomaticReply Indicates whether an incoming message must be an auto reply in order for the condition or exception to apply. */
    private ?bool $isAutomaticReply;
    
    /** @var bool|null $isEncrypted Indicates whether an incoming message must be encrypted in order for the condition or exception to apply. */
    private ?bool $isEncrypted;
    
    /** @var bool|null $isMeetingRequest Indicates whether an incoming message must be a meeting request in order for the condition or exception to apply. */
    private ?bool $isMeetingRequest;
    
    /** @var bool|null $isMeetingResponse Indicates whether an incoming message must be a meeting response in order for the condition or exception to apply. */
    private ?bool $isMeetingResponse;
    
    /** @var bool|null $isNonDeliveryReport Indicates whether an incoming message must be a non-delivery report in order for the condition or exception to apply. */
    private ?bool $isNonDeliveryReport;
    
    /** @var bool|null $isPermissionControlled Indicates whether an incoming message must be permission controlled (RMS-protected) in order for the condition or exception to apply. */
    private ?bool $isPermissionControlled;
    
    /** @var bool|null $isReadReceipt Indicates whether an incoming message must be a read receipt in order for the condition or exception to apply. */
    private ?bool $isReadReceipt;
    
    /** @var bool|null $isSigned Indicates whether an incoming message must be S/MIME-signed in order for the condition or exception to apply. */
    private ?bool $isSigned;
    
    /** @var bool|null $isVoicemail Indicates whether an incoming message must be a voice mail in order for the condition or exception to apply. */
    private ?bool $isVoicemail;
    
    /** @var MessageActionFlag|null $messageActionFlag  */
    private ?MessageActionFlag $messageActionFlag;
    
    /** @var bool|null $notSentToMe Indicates whether the owner of the mailbox must not be a recipient of an incoming message in order for the condition or exception to apply. */
    private ?bool $notSentToMe;
    
    /** @var array<string>|null $recipientContains Represents the strings that appear in either the toRecipients or ccRecipients properties of an incoming message in order for the condition or exception to apply. */
    private ?array $recipientContains;
    
    /** @var array<string>|null $senderContains Represents the strings that appear in the from property of an incoming message in order for the condition or exception to apply. */
    private ?array $senderContains;
    
    /** @var Sensitivity|null $sensitivity  */
    private ?Sensitivity $sensitivity;
    
    /** @var bool|null $sentCcMe Indicates whether the owner of the mailbox must be in the ccRecipients property of an incoming message in order for the condition or exception to apply. */
    private ?bool $sentCcMe;
    
    /** @var bool|null $sentOnlyToMe Indicates whether the owner of the mailbox must be the only recipient in an incoming message in order for the condition or exception to apply. */
    private ?bool $sentOnlyToMe;
    
    /** @var array<Recipient>|null $sentToAddresses Represents the email addresses that an incoming message must have been sent to in order for the condition or exception to apply. */
    private ?array $sentToAddresses;
    
    /** @var bool|null $sentToMe Indicates whether the owner of the mailbox must be in the toRecipients property of an incoming message in order for the condition or exception to apply. */
    private ?bool $sentToMe;
    
    /** @var bool|null $sentToOrCcMe Indicates whether the owner of the mailbox must be in either a toRecipients or ccRecipients property of an incoming message in order for the condition or exception to apply. */
    private ?bool $sentToOrCcMe;
    
    /** @var array<string>|null $subjectContains Represents the strings that appear in the subject of an incoming message in order for the condition or exception to apply. */
    private ?array $subjectContains;
    
    /** @var SizeRange|null $withinSizeRange  */
    private ?SizeRange $withinSizeRange;
    
    /**
     * Instantiates a new messageRulePredicates and sets the default values.
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
     * Gets the bodyContains property value. Represents the strings that should appear in the body of an incoming message in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getBodyContains(): ?array {
        return $this->bodyContains;
    }

    /**
     * Gets the bodyOrSubjectContains property value. Represents the strings that should appear in the body or subject of an incoming message in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getBodyOrSubjectContains(): ?array {
        return $this->bodyOrSubjectContains;
    }

    /**
     * Gets the categories property value. Represents the categories that an incoming message should be labeled with in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getCategories(): ?array {
        return $this->categories;
    }

    /**
     * Gets the fromAddresses property value. Represents the specific sender email addresses of an incoming message in order for the condition or exception to apply.
     * @return array<Recipient>|null
    */
    public function getFromAddresses(): ?array {
        return $this->fromAddresses;
    }

    /**
     * Gets the hasAttachments property value. Indicates whether an incoming message must have attachments in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getHasAttachments(): ?bool {
        return $this->hasAttachments;
    }

    /**
     * Gets the headerContains property value. Represents the strings that appear in the headers of an incoming message in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getHeaderContains(): ?array {
        return $this->headerContains;
    }

    /**
     * Gets the importance property value. 
     * @return Importance|null
    */
    public function getImportance(): ?Importance {
        return $this->importance;
    }

    /**
     * Gets the isApprovalRequest property value. Indicates whether an incoming message must be an approval request in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsApprovalRequest(): ?bool {
        return $this->isApprovalRequest;
    }

    /**
     * Gets the isAutomaticForward property value. Indicates whether an incoming message must be automatically forwarded in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsAutomaticForward(): ?bool {
        return $this->isAutomaticForward;
    }

    /**
     * Gets the isAutomaticReply property value. Indicates whether an incoming message must be an auto reply in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsAutomaticReply(): ?bool {
        return $this->isAutomaticReply;
    }

    /**
     * Gets the isEncrypted property value. Indicates whether an incoming message must be encrypted in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsEncrypted(): ?bool {
        return $this->isEncrypted;
    }

    /**
     * Gets the isMeetingRequest property value. Indicates whether an incoming message must be a meeting request in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsMeetingRequest(): ?bool {
        return $this->isMeetingRequest;
    }

    /**
     * Gets the isMeetingResponse property value. Indicates whether an incoming message must be a meeting response in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsMeetingResponse(): ?bool {
        return $this->isMeetingResponse;
    }

    /**
     * Gets the isNonDeliveryReport property value. Indicates whether an incoming message must be a non-delivery report in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsNonDeliveryReport(): ?bool {
        return $this->isNonDeliveryReport;
    }

    /**
     * Gets the isPermissionControlled property value. Indicates whether an incoming message must be permission controlled (RMS-protected) in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsPermissionControlled(): ?bool {
        return $this->isPermissionControlled;
    }

    /**
     * Gets the isReadReceipt property value. Indicates whether an incoming message must be a read receipt in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsReadReceipt(): ?bool {
        return $this->isReadReceipt;
    }

    /**
     * Gets the isSigned property value. Indicates whether an incoming message must be S/MIME-signed in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsSigned(): ?bool {
        return $this->isSigned;
    }

    /**
     * Gets the isVoicemail property value. Indicates whether an incoming message must be a voice mail in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getIsVoicemail(): ?bool {
        return $this->isVoicemail;
    }

    /**
     * Gets the messageActionFlag property value. 
     * @return MessageActionFlag|null
    */
    public function getMessageActionFlag(): ?MessageActionFlag {
        return $this->messageActionFlag;
    }

    /**
     * Gets the notSentToMe property value. Indicates whether the owner of the mailbox must not be a recipient of an incoming message in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getNotSentToMe(): ?bool {
        return $this->notSentToMe;
    }

    /**
     * Gets the recipientContains property value. Represents the strings that appear in either the toRecipients or ccRecipients properties of an incoming message in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getRecipientContains(): ?array {
        return $this->recipientContains;
    }

    /**
     * Gets the senderContains property value. Represents the strings that appear in the from property of an incoming message in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getSenderContains(): ?array {
        return $this->senderContains;
    }

    /**
     * Gets the sensitivity property value. 
     * @return Sensitivity|null
    */
    public function getSensitivity(): ?Sensitivity {
        return $this->sensitivity;
    }

    /**
     * Gets the sentCcMe property value. Indicates whether the owner of the mailbox must be in the ccRecipients property of an incoming message in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getSentCcMe(): ?bool {
        return $this->sentCcMe;
    }

    /**
     * Gets the sentOnlyToMe property value. Indicates whether the owner of the mailbox must be the only recipient in an incoming message in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getSentOnlyToMe(): ?bool {
        return $this->sentOnlyToMe;
    }

    /**
     * Gets the sentToAddresses property value. Represents the email addresses that an incoming message must have been sent to in order for the condition or exception to apply.
     * @return array<Recipient>|null
    */
    public function getSentToAddresses(): ?array {
        return $this->sentToAddresses;
    }

    /**
     * Gets the sentToMe property value. Indicates whether the owner of the mailbox must be in the toRecipients property of an incoming message in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getSentToMe(): ?bool {
        return $this->sentToMe;
    }

    /**
     * Gets the sentToOrCcMe property value. Indicates whether the owner of the mailbox must be in either a toRecipients or ccRecipients property of an incoming message in order for the condition or exception to apply.
     * @return bool|null
    */
    public function getSentToOrCcMe(): ?bool {
        return $this->sentToOrCcMe;
    }

    /**
     * Gets the subjectContains property value. Represents the strings that appear in the subject of an incoming message in order for the condition or exception to apply.
     * @return array<string>|null
    */
    public function getSubjectContains(): ?array {
        return $this->subjectContains;
    }

    /**
     * Gets the withinSizeRange property value. 
     * @return SizeRange|null
    */
    public function getWithinSizeRange(): ?SizeRange {
        return $this->withinSizeRange;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable>
    */
    public function getFieldDeserializers(): array {
        return  [
            'bodyContains' => function (self $o, ParseNode $n) { $o->setBodyContains($n->getCollectionOfPrimitiveValues()); },
            'bodyOrSubjectContains' => function (self $o, ParseNode $n) { $o->setBodyOrSubjectContains($n->getCollectionOfPrimitiveValues()); },
            'categories' => function (self $o, ParseNode $n) { $o->setCategories($n->getCollectionOfPrimitiveValues()); },
            'fromAddresses' => function (self $o, ParseNode $n) { $o->setFromAddresses($n->getCollectionOfObjectValues(Recipient::class)); },
            'hasAttachments' => function (self $o, ParseNode $n) { $o->setHasAttachments($n->getBooleanValue()); },
            'headerContains' => function (self $o, ParseNode $n) { $o->setHeaderContains($n->getCollectionOfPrimitiveValues()); },
            'importance' => function (self $o, ParseNode $n) { $o->setImportance($n->getEnumValue(Importance::class)); },
            'isApprovalRequest' => function (self $o, ParseNode $n) { $o->setIsApprovalRequest($n->getBooleanValue()); },
            'isAutomaticForward' => function (self $o, ParseNode $n) { $o->setIsAutomaticForward($n->getBooleanValue()); },
            'isAutomaticReply' => function (self $o, ParseNode $n) { $o->setIsAutomaticReply($n->getBooleanValue()); },
            'isEncrypted' => function (self $o, ParseNode $n) { $o->setIsEncrypted($n->getBooleanValue()); },
            'isMeetingRequest' => function (self $o, ParseNode $n) { $o->setIsMeetingRequest($n->getBooleanValue()); },
            'isMeetingResponse' => function (self $o, ParseNode $n) { $o->setIsMeetingResponse($n->getBooleanValue()); },
            'isNonDeliveryReport' => function (self $o, ParseNode $n) { $o->setIsNonDeliveryReport($n->getBooleanValue()); },
            'isPermissionControlled' => function (self $o, ParseNode $n) { $o->setIsPermissionControlled($n->getBooleanValue()); },
            'isReadReceipt' => function (self $o, ParseNode $n) { $o->setIsReadReceipt($n->getBooleanValue()); },
            'isSigned' => function (self $o, ParseNode $n) { $o->setIsSigned($n->getBooleanValue()); },
            'isVoicemail' => function (self $o, ParseNode $n) { $o->setIsVoicemail($n->getBooleanValue()); },
            'messageActionFlag' => function (self $o, ParseNode $n) { $o->setMessageActionFlag($n->getEnumValue(MessageActionFlag::class)); },
            'notSentToMe' => function (self $o, ParseNode $n) { $o->setNotSentToMe($n->getBooleanValue()); },
            'recipientContains' => function (self $o, ParseNode $n) { $o->setRecipientContains($n->getCollectionOfPrimitiveValues()); },
            'senderContains' => function (self $o, ParseNode $n) { $o->setSenderContains($n->getCollectionOfPrimitiveValues()); },
            'sensitivity' => function (self $o, ParseNode $n) { $o->setSensitivity($n->getEnumValue(Sensitivity::class)); },
            'sentCcMe' => function (self $o, ParseNode $n) { $o->setSentCcMe($n->getBooleanValue()); },
            'sentOnlyToMe' => function (self $o, ParseNode $n) { $o->setSentOnlyToMe($n->getBooleanValue()); },
            'sentToAddresses' => function (self $o, ParseNode $n) { $o->setSentToAddresses($n->getCollectionOfObjectValues(Recipient::class)); },
            'sentToMe' => function (self $o, ParseNode $n) { $o->setSentToMe($n->getBooleanValue()); },
            'sentToOrCcMe' => function (self $o, ParseNode $n) { $o->setSentToOrCcMe($n->getBooleanValue()); },
            'subjectContains' => function (self $o, ParseNode $n) { $o->setSubjectContains($n->getCollectionOfPrimitiveValues()); },
            'withinSizeRange' => function (self $o, ParseNode $n) { $o->setWithinSizeRange($n->getObjectValue(SizeRange::class)); },
        ];
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeCollectionOfNonParsableObjectValues('bodyContains', $this->bodyContains);
        $writer->writeCollectionOfNonParsableObjectValues('bodyOrSubjectContains', $this->bodyOrSubjectContains);
        $writer->writeCollectionOfNonParsableObjectValues('categories', $this->categories);
        $writer->writeCollectionOfObjectValues('fromAddresses', $this->fromAddresses);
        $writer->writeBooleanValue('hasAttachments', $this->hasAttachments);
        $writer->writeCollectionOfNonParsableObjectValues('headerContains', $this->headerContains);
        $writer->writeEnumValue('importance', $this->importance);
        $writer->writeBooleanValue('isApprovalRequest', $this->isApprovalRequest);
        $writer->writeBooleanValue('isAutomaticForward', $this->isAutomaticForward);
        $writer->writeBooleanValue('isAutomaticReply', $this->isAutomaticReply);
        $writer->writeBooleanValue('isEncrypted', $this->isEncrypted);
        $writer->writeBooleanValue('isMeetingRequest', $this->isMeetingRequest);
        $writer->writeBooleanValue('isMeetingResponse', $this->isMeetingResponse);
        $writer->writeBooleanValue('isNonDeliveryReport', $this->isNonDeliveryReport);
        $writer->writeBooleanValue('isPermissionControlled', $this->isPermissionControlled);
        $writer->writeBooleanValue('isReadReceipt', $this->isReadReceipt);
        $writer->writeBooleanValue('isSigned', $this->isSigned);
        $writer->writeBooleanValue('isVoicemail', $this->isVoicemail);
        $writer->writeEnumValue('messageActionFlag', $this->messageActionFlag);
        $writer->writeBooleanValue('notSentToMe', $this->notSentToMe);
        $writer->writeCollectionOfNonParsableObjectValues('recipientContains', $this->recipientContains);
        $writer->writeCollectionOfNonParsableObjectValues('senderContains', $this->senderContains);
        $writer->writeEnumValue('sensitivity', $this->sensitivity);
        $writer->writeBooleanValue('sentCcMe', $this->sentCcMe);
        $writer->writeBooleanValue('sentOnlyToMe', $this->sentOnlyToMe);
        $writer->writeCollectionOfObjectValues('sentToAddresses', $this->sentToAddresses);
        $writer->writeBooleanValue('sentToMe', $this->sentToMe);
        $writer->writeBooleanValue('sentToOrCcMe', $this->sentToOrCcMe);
        $writer->writeCollectionOfNonParsableObjectValues('subjectContains', $this->subjectContains);
        $writer->writeObjectValue('withinSizeRange', $this->withinSizeRange);
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
     * Sets the bodyContains property value. Represents the strings that should appear in the body of an incoming message in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the bodyContains property.
    */
    public function setBodyContains(?array $value ): void {
        $this->bodyContains = $value;
    }

    /**
     * Sets the bodyOrSubjectContains property value. Represents the strings that should appear in the body or subject of an incoming message in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the bodyOrSubjectContains property.
    */
    public function setBodyOrSubjectContains(?array $value ): void {
        $this->bodyOrSubjectContains = $value;
    }

    /**
     * Sets the categories property value. Represents the categories that an incoming message should be labeled with in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the categories property.
    */
    public function setCategories(?array $value ): void {
        $this->categories = $value;
    }

    /**
     * Sets the fromAddresses property value. Represents the specific sender email addresses of an incoming message in order for the condition or exception to apply.
     *  @param array<Recipient>|null $value Value to set for the fromAddresses property.
    */
    public function setFromAddresses(?array $value ): void {
        $this->fromAddresses = $value;
    }

    /**
     * Sets the hasAttachments property value. Indicates whether an incoming message must have attachments in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the hasAttachments property.
    */
    public function setHasAttachments(?bool $value ): void {
        $this->hasAttachments = $value;
    }

    /**
     * Sets the headerContains property value. Represents the strings that appear in the headers of an incoming message in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the headerContains property.
    */
    public function setHeaderContains(?array $value ): void {
        $this->headerContains = $value;
    }

    /**
     * Sets the importance property value. 
     *  @param Importance|null $value Value to set for the importance property.
    */
    public function setImportance(?Importance $value ): void {
        $this->importance = $value;
    }

    /**
     * Sets the isApprovalRequest property value. Indicates whether an incoming message must be an approval request in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isApprovalRequest property.
    */
    public function setIsApprovalRequest(?bool $value ): void {
        $this->isApprovalRequest = $value;
    }

    /**
     * Sets the isAutomaticForward property value. Indicates whether an incoming message must be automatically forwarded in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isAutomaticForward property.
    */
    public function setIsAutomaticForward(?bool $value ): void {
        $this->isAutomaticForward = $value;
    }

    /**
     * Sets the isAutomaticReply property value. Indicates whether an incoming message must be an auto reply in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isAutomaticReply property.
    */
    public function setIsAutomaticReply(?bool $value ): void {
        $this->isAutomaticReply = $value;
    }

    /**
     * Sets the isEncrypted property value. Indicates whether an incoming message must be encrypted in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isEncrypted property.
    */
    public function setIsEncrypted(?bool $value ): void {
        $this->isEncrypted = $value;
    }

    /**
     * Sets the isMeetingRequest property value. Indicates whether an incoming message must be a meeting request in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isMeetingRequest property.
    */
    public function setIsMeetingRequest(?bool $value ): void {
        $this->isMeetingRequest = $value;
    }

    /**
     * Sets the isMeetingResponse property value. Indicates whether an incoming message must be a meeting response in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isMeetingResponse property.
    */
    public function setIsMeetingResponse(?bool $value ): void {
        $this->isMeetingResponse = $value;
    }

    /**
     * Sets the isNonDeliveryReport property value. Indicates whether an incoming message must be a non-delivery report in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isNonDeliveryReport property.
    */
    public function setIsNonDeliveryReport(?bool $value ): void {
        $this->isNonDeliveryReport = $value;
    }

    /**
     * Sets the isPermissionControlled property value. Indicates whether an incoming message must be permission controlled (RMS-protected) in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isPermissionControlled property.
    */
    public function setIsPermissionControlled(?bool $value ): void {
        $this->isPermissionControlled = $value;
    }

    /**
     * Sets the isReadReceipt property value. Indicates whether an incoming message must be a read receipt in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isReadReceipt property.
    */
    public function setIsReadReceipt(?bool $value ): void {
        $this->isReadReceipt = $value;
    }

    /**
     * Sets the isSigned property value. Indicates whether an incoming message must be S/MIME-signed in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isSigned property.
    */
    public function setIsSigned(?bool $value ): void {
        $this->isSigned = $value;
    }

    /**
     * Sets the isVoicemail property value. Indicates whether an incoming message must be a voice mail in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the isVoicemail property.
    */
    public function setIsVoicemail(?bool $value ): void {
        $this->isVoicemail = $value;
    }

    /**
     * Sets the messageActionFlag property value. 
     *  @param MessageActionFlag|null $value Value to set for the messageActionFlag property.
    */
    public function setMessageActionFlag(?MessageActionFlag $value ): void {
        $this->messageActionFlag = $value;
    }

    /**
     * Sets the notSentToMe property value. Indicates whether the owner of the mailbox must not be a recipient of an incoming message in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the notSentToMe property.
    */
    public function setNotSentToMe(?bool $value ): void {
        $this->notSentToMe = $value;
    }

    /**
     * Sets the recipientContains property value. Represents the strings that appear in either the toRecipients or ccRecipients properties of an incoming message in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the recipientContains property.
    */
    public function setRecipientContains(?array $value ): void {
        $this->recipientContains = $value;
    }

    /**
     * Sets the senderContains property value. Represents the strings that appear in the from property of an incoming message in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the senderContains property.
    */
    public function setSenderContains(?array $value ): void {
        $this->senderContains = $value;
    }

    /**
     * Sets the sensitivity property value. 
     *  @param Sensitivity|null $value Value to set for the sensitivity property.
    */
    public function setSensitivity(?Sensitivity $value ): void {
        $this->sensitivity = $value;
    }

    /**
     * Sets the sentCcMe property value. Indicates whether the owner of the mailbox must be in the ccRecipients property of an incoming message in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the sentCcMe property.
    */
    public function setSentCcMe(?bool $value ): void {
        $this->sentCcMe = $value;
    }

    /**
     * Sets the sentOnlyToMe property value. Indicates whether the owner of the mailbox must be the only recipient in an incoming message in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the sentOnlyToMe property.
    */
    public function setSentOnlyToMe(?bool $value ): void {
        $this->sentOnlyToMe = $value;
    }

    /**
     * Sets the sentToAddresses property value. Represents the email addresses that an incoming message must have been sent to in order for the condition or exception to apply.
     *  @param array<Recipient>|null $value Value to set for the sentToAddresses property.
    */
    public function setSentToAddresses(?array $value ): void {
        $this->sentToAddresses = $value;
    }

    /**
     * Sets the sentToMe property value. Indicates whether the owner of the mailbox must be in the toRecipients property of an incoming message in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the sentToMe property.
    */
    public function setSentToMe(?bool $value ): void {
        $this->sentToMe = $value;
    }

    /**
     * Sets the sentToOrCcMe property value. Indicates whether the owner of the mailbox must be in either a toRecipients or ccRecipients property of an incoming message in order for the condition or exception to apply.
     *  @param bool|null $value Value to set for the sentToOrCcMe property.
    */
    public function setSentToOrCcMe(?bool $value ): void {
        $this->sentToOrCcMe = $value;
    }

    /**
     * Sets the subjectContains property value. Represents the strings that appear in the subject of an incoming message in order for the condition or exception to apply.
     *  @param array<string>|null $value Value to set for the subjectContains property.
    */
    public function setSubjectContains(?array $value ): void {
        $this->subjectContains = $value;
    }

    /**
     * Sets the withinSizeRange property value. 
     *  @param SizeRange|null $value Value to set for the withinSizeRange property.
    */
    public function setWithinSizeRange(?SizeRange $value ): void {
        $this->withinSizeRange = $value;
    }

}