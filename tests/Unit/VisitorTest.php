<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\Visitor;

class VisitorTest extends TestCase
{
    protected array $raw = [
        'full_name' => 'test_full_name',
        'first_name' => 'test_first_name',
        'middle_name' => 'test_middle_name',
        'last_name' => 'test_last_name',
    ];

    public function testConstruct(): Visitor
    {
        $visitor = Visitor::buildByRaw((object)$this->raw);

        self::assertInstanceOf(Visitor::class, $visitor);

        return $visitor;
    }

    /**
     * @depends testConstruct
     */
    public function testGetters(Visitor $visitor)
    {
        self::assertEquals($this->raw['full_name'], $visitor->getFullName());
        self::assertEquals($this->raw['first_name'], $visitor->getFirstName());
        self::assertEquals($this->raw['middle_name'], $visitor->getMiddleName());
        self::assertEquals($this->raw['last_name'], $visitor->getLastName());
    }


    /** @depends testConstruct */
    public function testToArray(Visitor $visitor)
    {
        self::assertEquals($this->raw, $visitor->toArray());
    }
}
