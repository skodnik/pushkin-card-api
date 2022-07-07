<?php

namespace Vlsv\PushkinCardApi\Tests\Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\RefundResult;
use Vlsv\PushkinCardApi\Model\TicketStatus;

class RefundResultTest extends TestCase
{
    public function provideRawData(): array
    {
        $faker = Factory::create();

        return [
            'full' => [
                [
                    'refund_date' => $faker->unixTime(),
                    'refund_reason' => $faker->realText(),
                    'refund_rrn' => $faker->uuid(),
                    'refund_ticket_price' => (string)$faker->numberBetween(100, 999),
                    'status' => TicketStatus::cases()[array_rand(TicketStatus::cases())]->value,
                ],
            ],
            'has null' => [
                [
                    'refund_date' => $faker->unixTime(),
                    'refund_reason' => $faker->realText(),
                    'refund_rrn' => null,
                    'refund_ticket_price' => null,
                    'status' => TicketStatus::cases()[array_rand(TicketStatus::cases())]->value,
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters(array $raw)
    {
        $refundResult = RefundResult::buildByRaw((object)$raw);

        self::assertEquals($raw, $refundResult->toArray());

        self::assertEquals($raw['refund_date'], $refundResult->getRefundDate());
        self::assertEquals($raw['refund_reason'], $refundResult->getRefundReason());
        self::assertEquals($raw['refund_rrn'], $refundResult->getRefundRrn());
        self::assertEquals($raw['refund_ticket_price'], $refundResult->getRefundTicketPrice());
        self::assertEquals($raw['status'], $refundResult->getStatus()->value);
    }
}
