<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class ErrorResponse extends BaseModel
{
    public function __construct(
        /** Код ошибки */
        protected string $code,

        /** Описание ошибки */
        protected string $description
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
        ];
    }

    public static function buildByRaw(stdClass $raw): ErrorResponse
    {
        return new self(
            code: $raw->code,
            description: $raw->description
        );
    }
}
