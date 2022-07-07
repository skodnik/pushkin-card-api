<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Integration;

use Faker\Factory;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\ApiClient;
use Vlsv\PushkinCardApi\ClientConfig;
use Vlsv\PushkinCardApi\Model\CreateTicketRequest;
use Vlsv\PushkinCardApi\Model\RefundTicketRequest;
use Vlsv\PushkinCardApi\Model\VisitTicketRequest;

class IntegrationTestCase extends TestCase
{
    protected ApiClient $client;

    public function setUp(): void
    {
        $config = new ClientConfig(
            accessToken: getenv('ACCESS_TOKEN'),
            host: getenv('UAT_HOST')
        );

        $this->client = new ApiClient(
            client: new Client(),
            config: $config
        );
    }

    public static function getCreateTicketRequest(): CreateTicketRequest
    {
        $faker = Factory::create();
        $ticketPrice = rand(100, 900) . '.' . rand(10, 90);

        $ticketRaw = [
            'barcode' => (string)$faker->numberBetween(1000000, 9999999),
            'barcode_type' => (string)$faker->numberBetween(0, 63),
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
                'event_id' => getenv('EVENT_ID'),
                'organization_id' => getenv('ORGANIZATION_ID'),
                'date' => $faker->unixTime(),
                'place' => 'test_place',
                'params' => 'test_params',
            ],
            'payment' => [
                'id' => $faker->uuid(),
                'rrn' => 'test_rrn',
                'date' => $faker->unixTime(),
                'ticket_price' => $ticketPrice,
                'amount' => $ticketPrice,
            ],
            'comment' => 'test comment',
        ];

        return CreateTicketRequest::buildByRaw(
            (object)$ticketRaw
        );
    }

    public static function getRefundTicketRequest(): RefundTicketRequest
    {
        $faker = Factory::create();

        return RefundTicketRequest::buildByRaw(
            (object)[
                'refund_date' => $faker->unixTime(),
                'refund_reason' => $faker->text(),
                'refund_rrn' => (string)$faker->numberBetween(100, 999),
                'refund_ticket_price' => (string)$faker->numberBetween(1, 63),
                'comment' => $faker->text(),
            ],
        );
    }

    public static function getVisitTicketRequest(): VisitTicketRequest
    {
        $faker = Factory::create();

        return VisitTicketRequest::buildByRaw(
            (object)[
                'visit_date' => $faker->unixTime(),
                'comment' => $faker->text(),
            ]
        );
    }
}
