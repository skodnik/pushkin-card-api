<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class RefundResult extends Refund
{
    public function __construct(
        /** Дата возврата билета (unix timestamp) */
        protected int $refund_date,

        /** Причина возврата */
        protected string $refund_reason,

        /** RRN (Retrieval Reference Number) - уникальный идентификатор транзакции возврата */
        protected string $refund_rrn,

        /** Сумма возврата */
        protected string $refund_ticket_price,

        /** Статус билета */
        protected TicketStatus $status,
    ) {
    }

    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'refund_date' => $this->getRefundDate(),
            'refund_reason' => $this->getRefundReason(),
            'refund_rrn' => $this->getRefundRrn(),
            'refund_ticket_price' => $this->getRefundTicketPrice(),
            'status' => $this->getStatus()->value,
        ];
    }

    public static function buildByRaw(stdClass $raw): RefundResult
    {
        return new self(
            refund_date: $raw->refund_date,
            refund_reason: $raw->refund_reason,
            refund_rrn: $raw->refund_rrn ?? '',
            refund_ticket_price: $raw->refund_ticket_price ?? '',
            status: TicketStatus::from($raw->status)
        );
    }
}
