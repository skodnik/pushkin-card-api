<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\VisitResult;

class VisitResultTest extends TestCase
{
    protected array $raw = [
        'visit_date' => 123456789,
        'status' => 'active',
    ];

    public function testConstruct(): VisitResult
    {
        $visitResult = VisitResult::buildByRaw((object)$this->raw);

        self::assertInstanceOf(VisitResult::class, $visitResult);

        return $visitResult;
    }

    /** @depends testConstruct */
    public function testGetters(VisitResult $visitResult)
    {
        self::assertEquals($this->raw['visit_date'], $visitResult->getVisitDate());
        self::assertEquals($this->raw['status'], $visitResult->getStatus()->value);
    }

    /** @depends testConstruct */
    public function testToArray(VisitResult $visitResult)
    {
        self::assertEquals($this->raw, $visitResult->toArray());
    }
}
