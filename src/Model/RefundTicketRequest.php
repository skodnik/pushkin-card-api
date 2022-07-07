<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class RefundTicketRequest extends Refund
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

        /** Комментарий */
        protected string $comment,
    ) {
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function toArray(): array
    {
        return [
            'refund_date' => $this->getRefundDate(),
            'refund_reason' => $this->getRefundReason(),
            'refund_rrn' => $this->getRefundRrn(),
            'refund_ticket_price' => $this->getRefundTicketPrice(),
            'comment' => $this->getComment(),
        ];
    }

    public static function buildByRaw(stdClass $raw): RefundTicketRequest
    {
        return new self(
            refund_date: $raw->refund_date,
            refund_reason: $raw->refund_reason,
            refund_rrn: $raw->refund_rrn ?? '',
            refund_ticket_price: $raw->refund_ticket_price ?? '',
            comment: $raw->comment ?? ''
        );
    }
}
