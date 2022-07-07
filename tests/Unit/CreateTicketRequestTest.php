<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\CreateTicketRequest;

class CreateTicketRequestTest extends TestCase
{
    public function provideRawData(): array
    {
        $faker = Factory::create();

        return [
            [
                'full' => [
                    'barcode' => (string)$faker->numberBetween(1, 63),
                    'barcode_type' => (string)$faker->numberBetween(1, 63),
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
                    'comment' => 'test_comment',
                ],
                'has null' => [
                    'barcode' => (string)$faker->numberBetween(1, 63),
                    'barcode_type' => null,
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
                    'comment' => null,
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters($raw)
    {
        $createTicketRequest = CreateTicketRequest::buildByRaw((object)$raw);

        self::assertInstanceOf(CreateTicketRequest::class, $createTicketRequest);

        self::assertEquals($raw, $createTicketRequest->toArray());
    }
}
