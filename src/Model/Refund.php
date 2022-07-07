<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

abstract class Refund extends BaseModel
{
    public function getRefundDate(): int
    {
        return $this->refund_date;
    }

    public function getRefundReason(): string
    {
        return $this->refund_reason;
    }

    public function getRefundRrn(): string
    {
        return $this->refund_rrn;
    }

    public function getRefundTicketPrice(): string
    {
        return $this->refund_ticket_price;
    }
}
