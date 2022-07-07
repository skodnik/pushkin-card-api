<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class Buyer extends BaseModel
{
    public function __construct(
        /** Мобильный телефон (10 цифр) */
        protected string $mobile_phone
    ) {
    }

    public function getMobilePhone(): string
    {
        return $this->mobile_phone;
    }

    public function toArray(): array
    {
        return [
            'mobile_phone' => $this->getMobilePhone(),
        ];
    }

    public static function buildByRaw(stdClass $raw): Buyer
    {
        return new self(mobile_phone: $raw->mobile_phone);
    }
}
