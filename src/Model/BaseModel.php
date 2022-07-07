<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

abstract class BaseModel
{
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
