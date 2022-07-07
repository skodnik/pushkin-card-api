<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class Visitor extends BaseModel
{
    public function __construct(
        /** ФИО (целиком) */
        protected string $full_name,

        /** Имя */
        protected string $first_name,

        /** Отчество */
        protected string $middle_name,

        /** Фамилия */
        protected string $last_name,
    ) {
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getMiddleName(): string
    {
        return $this->middle_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->getFullName(),
            'first_name' => $this->getFirstName(),
            'middle_name' => $this->getMiddleName(),
            'last_name' => $this->getLastName(),
        ];
    }

    public static function buildByRaw(stdClass $raw): Visitor
    {
        return new self(
            full_name: $raw->full_name,
            first_name: $raw->first_name,
            middle_name: $raw->middle_name,
            last_name: $raw->last_name
        );
    }
}
