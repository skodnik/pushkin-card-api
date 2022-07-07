<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\ErrorResponse;

class ErrorResponseTest extends TestCase
{
    protected array $raw = [
        'code' => 'DB error',
        'description' => 'Ticket not found',
    ];

    public function testConstruct(): ErrorResponse
    {
        $errorResponse = ErrorResponse::buildByRaw((object)$this->raw);

        self::assertInstanceOf(ErrorResponse::class, $errorResponse);

        return $errorResponse;
    }

    /** @depends testConstruct */
    public function testGetters(ErrorResponse $errorResponse)
    {
        self::assertEquals($this->raw['code'], $errorResponse->getCode());
        self::assertEquals($this->raw['description'], $errorResponse->getDescription());
    }

    /** @depends testConstruct */
    public function testToArray(ErrorResponse $errorResponse)
    {
        self::assertEquals($this->raw, $errorResponse->toArray());
    }
}
