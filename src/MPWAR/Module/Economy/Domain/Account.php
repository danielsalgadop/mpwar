<?php

namespace MPWAR\Module\Economy\Domain;

use DateTimeImmutable;
use MPWAR\Module\Economy\Contract\DomainEvent\AccountOpened;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;
use SimpleBus\Message\Recorder\RecordsMessages;

final class Account implements RecordsMessages
{
    private $owner;
    private $balance;

    use PrivateMessageRecorderCapabilities;

    public function __construct(AccountOwner $owner, VirtualMoney $balance)
    {
        $this->owner   = $owner;
        $this->balance = $balance;
    }

    public function owner()
    {
        return $this->owner;
    }

    public function balance()
    {
        return $this->balance;
    }

    public static function open(AccountOwner $owner)
    {
        $account = new self($owner, VirtualMoney::coins(0));

        $account->record(new AccountOpened($owner->value(), new DateTimeImmutable()));

        return $account;
    }
}
