<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\Payment;

class PaymentTest extends TestCase
{
    public function provideRawData(): array
    {
        return [
            'full' => [
                [
                    'id' => 'test_id',
                    'rrn' => 'test_rrn',
                    'date' => 123456789,
                    'ticket_price' => 'test_ticket_price',
                    'amount' => 'test_amount',
                ],
            ],
            'has null' => [
                [
                    'id' => null,
                    'rrn' => null,
                    'date' => 123456789,
                    'ticket_price' => null,
                    'amount' => 'test_amount',
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters($raw)
    {
        $payment = Payment::buildByRaw((object)$raw);

        self::assertInstanceOf(Payment::class, $payment);

        self::assertEquals($raw, $payment->toArray());

        self::assertEquals($raw['id'], $payment->getId());
        self::assertEquals($raw['rrn'], $payment->getRrn());
        self::assertEquals($raw['date'], $payment->getDate());
        self::assertEquals($raw['ticket_price'], $payment->getTicketPrice());
        self::assertEquals($raw['amount'], $payment->getAmount());
    }
}
