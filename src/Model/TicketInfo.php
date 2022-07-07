<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class TicketInfo extends BaseModel
{
    public function __construct(
        /** Статус билета */
        protected ?TicketStatus $status,

        /** Сеанс */
        protected ?Session $session,
    ) {
    }

    /**
     * @return TicketStatus|null
     */
    public function getStatus(): ?TicketStatus
    {
        return $this->status ?? null;
    }

    /**
     * @return Session|null
     */
    public function getSession(): ?Session
    {
        return $this->session ?? null;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->getStatus()?->value,
            'session' => $this->getSession()?->toArray(),
        ];
    }

    public static function buildByRaw(stdClass $raw): TicketInfo
    {
        return new self(
            status: $raw->status ? TicketStatus::from($raw->status) : null,
            session: $raw->session ? Session::buildByRaw((object)$raw->session) : null,
        );
    }
}
