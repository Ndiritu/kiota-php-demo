<?php

function printMessage($message)
{
    echo "Id: {$message->getId()}\n";
    $from = $message->getFrom()->getEmailAddress();
    echo "From: {$from->getName()} <{$from->getAddress()}>\n";
    echo "Subject: {$message->getSubject()}\n\n";
}