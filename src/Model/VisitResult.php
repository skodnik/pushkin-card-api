<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class VisitResult extends BaseModel
{
    public function __construct(
        /** Дата возврата билета (unix timestamp) */
        protected int $visit_date,

        /** Статус билета */
        protected TicketStatus $status,
    ) {
    }

    /**
     * @return int
     */
    public function getVisitDate(): int
    {
        return $this->visit_date;
    }

    /**
     * @return TicketStatus
     */
    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'visit_date' => $this->getVisitDate(),
            'status' => $this->getStatus()->value,
        ];
    }

    public static function buildByRaw(stdClass $raw): VisitResult
    {
        return new self(
            visit_date: $raw->visit_date,
            status: TicketStatus::from($raw->status)
        );
    }
}
