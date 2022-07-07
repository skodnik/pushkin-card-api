<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Exception;

use Exception;
use stdClass;

class ApiException extends Exception
{
    protected stdClass|string|null $responseObject;

    public function __construct(
        string $message = '',
        int $code = 0,
        protected ?array $responseHeaders = [],
        protected stdClass|string|null $responseBody = null
    ) {
        parent::__construct($message, $code);
    }

    public function getResponseHeaders(): ?array
    {
        return $this->responseHeaders;
    }

    public function getResponseBody(): string|stdClass|null
    {
        return $this->responseBody;
    }

    public function setResponseObject(string|stdClass|null $obj): void
    {
        $this->responseObject = $obj;
    }

    public function getResponseObject(): string|stdClass|null
    {
        return $this->responseObject;
    }
}
