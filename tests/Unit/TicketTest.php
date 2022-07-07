<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\Buyer;
use Vlsv\PushkinCardApi\Model\Payment;
use Vlsv\PushkinCardApi\Model\Session;
use Vlsv\PushkinCardApi\Model\Ticket;
use Vlsv\PushkinCardApi\Model\TicketStatus;
use Vlsv\PushkinCardApi\Model\Visitor;

class TicketTest extends TestCase
{
    public function provideRawData(): array
    {
        $faker = Factory::create();

        return [
            'full' => [
                [
                    'id' => $faker->uuid(),
                    'barcode' => (string)$faker->numberBetween(1, 63),
                    'status' => TicketStatus::cases()[array_rand(TicketStatus::cases())]->value,
                    'visitor' => [
                        'full_name' => $faker->firstNameMale(),
                        'first_name' => $faker->firstName(),
                        'middle_name' => $faker->firstNameFemale(),
                        'last_name' => $faker->lastName(),
                    ],
                    'buyer' => [
                        'mobile_phone' => (string)$faker->numberBetween(1000000000, 9999999999),
                    ],
                    'session' => [
                        'event_id' => $faker->uuid(),
                        'organization_id' => $faker->uuid(),
                        'date' => $faker->unixTime(),
                        'place' => 'test_place',
                        'params' => 'test_params',
                    ],
                    'payment' => [
                        'id' => $faker->uuid(),
                        'rrn' => 'test_rrn',
                        'date' => $faker->unixTime(),
                        'ticket_price' => 'test_ticket_price',
                        'amount' => 'test_amount',
                    ],
                    'visit_date' => $faker->unixTime(),
                    'refund_date' => $faker->unixTime(),
                    'refund_reason' => 'test_refund_reason',
                    'refund_rrn' => 'test_refund_rrn',
                    'refund_ticket_price' => 'test_refund_ticket_price',
                    'comment' => 'test_comment',
                ],
            ],
            'has null' => [
                [
                    'id' => $faker->uuid(),
                    'barcode' => (string)$faker->numberBetween(1, 63),
                    'status' => TicketStatus::cases()[array_rand(TicketStatus::cases())]->value,
                    'visitor' => [
                        'full_name' => $faker->firstNameMale(),
                        'first_name' => $faker->firstName(),
                        'middle_name' => $faker->firstNameFemale(),
                        'last_name' => $faker->lastName(),
                    ],
                    'buyer' => [
                        'mobile_phone' => (string)$faker->numberBetween(1000000000, 9999999999),
                    ],
                    'session' => [
                        'event_id' => $faker->uuid(),
                        'organization_id' => $faker->uuid(),
                        'date' => $faker->unixTime(),
                        'place' => 'test_place',
                        'params' => 'test_params',
                    ],
                    'payment' => [
                        'id' => $faker->uuid(),
                        'rrn' => 'test_rrn',
                        'date' => $faker->unixTime(),
                        'ticket_price' => 'test_ticket_price',
                        'amount' => 'test_amount',
                    ],
                    'visit_date' => null,
                    'refund_date' => null,
                    'refund_reason' => null,
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
        $ticket = Ticket::buildByRaw((object)$raw);

        self::assertEquals($raw, $ticket->toArray());

        self::assertInstanceOf(Ticket::class, $ticket);
        self::assertInstanceOf(Visitor::class, $ticket->getVisitor());
        self::assertInstanceOf(Buyer::class, $ticket->getBuyer());
        self::assertInstanceOf(Session::class, $ticket->getSession());
        self::assertInstanceOf(Payment::class, $ticket->getPayment());
    }
}
