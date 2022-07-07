<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi;

use Vlsv\PushkinCardApi\Model\ErrorResponse;
use Vlsv\PushkinCardApi\Model\Visitor;

class ModelSerializer
{
    public static function getErrorResponse(string $response): ErrorResponse
    {
        $raw = json_decode($response);

        return ErrorResponse::buildByRaw($raw);
    }

    public static function getVisitor(string $response): Visitor
    {
        $raw = json_decode($response);

        return Visitor::buildByRaw($raw);
    }
}
