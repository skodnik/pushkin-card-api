<?php

namespace Vlsv\PushkinCardApi\Tests\Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\RefundTicketRequest;

class RefundTicketRequestTest extends TestCase
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
                    'comment' => $faker->realText(),
                ],
            ],
            'has null' => [
                [
                    'refund_date' => $faker->unixTime(),
                    'refund_reason' => $faker->realText(),
                    'refund_rrn' => null,
                    'refund_ticket_price' => null,
                    'comment' => null,
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters(array $raw)
    {
        $refundTicketRequest = RefundTicketRequest::buildByRaw((object)$raw);

        self::assertEquals($raw, $refundTicketRequest->toArray());

        self::assertEquals($raw['refund_date'], $refundTicketRequest->getRefundDate());
        self::assertEquals($raw['refund_reason'], $refundTicketRequest->getRefundReason());
        self::assertEquals($raw['refund_rrn'], $refundTicketRequest->getRefundRrn());
        self::assertEquals($raw['refund_ticket_price'], $refundTicketRequest->getRefundTicketPrice());
        self::assertEquals($raw['comment'], $refundTicketRequest->getComment());
    }
}
