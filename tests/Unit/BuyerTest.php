<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\Buyer;

class BuyerTest extends TestCase
{
    protected array $raw = ['mobile_phone' => '7771112233'];

    public function testConstruct(): Buyer
    {
        $buyer = Buyer::buildByRaw((object)$this->raw);

        self::assertInstanceOf(Buyer::class, $buyer);

        return $buyer;
    }

    /** @depends testConstruct */
    public function testGetters(Buyer $buyer)
    {
        self::assertEquals($this->raw['mobile_phone'], $buyer->getMobilePhone());
    }

    /** @depends testConstruct */
    public function testToArray(Buyer $buyer)
    {
        self::assertEquals($this->raw, $buyer->toArray());
    }
}
