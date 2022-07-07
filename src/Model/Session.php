<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class Session extends BaseModel
{
    public function __construct(
        /** ID мероприятия в PRO.Культура */
        protected string $event_id,

        /** ID организации в Про.Культура */
        protected string $organization_id,

        /** Дата/Время проведения сеанса (unix timestamp) */
        protected int $date,

        /** Адрес/описание места проведения мероприятия */
        protected string $place = '',

        /** Зал+Сектор+Ряд+Место */
        protected string $params = ''
    ) {
    }

    public function getEventId(): string
    {
        return $this->event_id;
    }

    public function getOrganizationId(): string
    {
        return $this->organization_id;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function getParams(): string
    {
        return $this->params;
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->getEventId(),
            'organization_id' => $this->getOrganizationId(),
            'date' => $this->getDate(),
            'place' => $this->getPlace(),
            'params' => $this->getParams(),
        ];
    }

    public static function buildByRaw(stdClass $raw): Session
    {
        return new self(
            event_id: $raw->event_id,
            organization_id: $raw->organization_id,
            date: $raw->date,
            place: $raw->place ?? '',
            params: $raw->params ?? ''
        );
    }
}
