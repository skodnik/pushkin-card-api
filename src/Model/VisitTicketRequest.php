<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class VisitTicketRequest extends BaseModel
{
    public function __construct(
        /** Дата возврата билета (unix timestamp) */
        protected int $visit_date,

        /** Комментарий */
        protected string $comment,
    ) {
    }

    public function getVisitDate(): int
    {
        return $this->visit_date;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function toArray(): array
    {
        return [
            'visit_date' => $this->getVisitDate(),
            'comment' => $this->getComment(),
        ];
    }

    public static function buildByRaw(stdClass $raw): VisitTicketRequest
    {
        return new self(
            visit_date: $raw->visit_date,
            comment: $raw->comment ?? ''
        );
    }
}
