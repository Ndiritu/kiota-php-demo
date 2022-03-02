<?php

use Microsoft\Graph\Models\Microsoft\Graph\Message;

function printMessage(Message $message)
{
    echo "Id: {$message->getId()}\n";
    if ($message->getFrom()) {
        $from = $message->getFrom()->getEmailAddress();
        echo "From: {$from->getName()} <{$from->getAddress()}>\n";
    }
    if ($message->getToRecipients()) {
        echo "Recipients: ";
        foreach ($message->getToRecipients() as $recipient) {
            echo "{$recipient->getEmailAddress()->getName()} <{$recipient->getEmailAddress()->getAddress()}>}, ";
        }
        echo "\n";
    }
    echo "Subject: {$message->getSubject()}\n\n";
}