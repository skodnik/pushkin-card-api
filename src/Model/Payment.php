<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class Payment extends BaseModel
{
    public function __construct(
        /** ID платежа у Билетного оператора */
        protected string $id,

        /** RRN (Retrieval Reference Number) - уникальный идентификатор транзакции */
        protected string $rrn,

        /** Дата/время совершения платежа (unix timestamp) */
        protected int $date,

        /** Цена билета (номинал) */
        protected string $ticket_price,

        /** Сумма платежа по Пушкинской карт */
        protected string $amount
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRrn(): string
    {
        return $this->rrn;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getTicketPrice(): string
    {
        return $this->ticket_price;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'rrn' => $this->getRrn(),
            'date' => $this->getDate(),
            'ticket_price' => $this->getTicketPrice(),
            'amount' => $this->getAmount(),
        ];
    }

    public static function buildByRaw(stdClass $raw): Payment
    {
        return new self(
            id: $raw->id ?? '',
            rrn: $raw->rrn ?? '',
            date: $raw->date,
            ticket_price: $raw->ticket_price ?? '',
            amount: $raw->amount
        );
    }
}
