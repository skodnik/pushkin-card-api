<?php

namespace Vlsv\PushkinCardApi\Tests\Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\VisitTicketRequest;

class VisitTicketRequestTest extends TestCase
{
    public function provideRawData(): array
    {
        $faker = Factory::create();

        return [
            'full' => [
                [
                    'visit_date' => $faker->unixTime(),
                    'comment' => $faker->realText(),
                ],
            ],
            'has null' => [
                [
                    'visit_date' => $faker->unixTime(),
                    'comment' => null,
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters(array $raw)
    {
        $visitTicketRequest = VisitTicketRequest::buildByRaw((object)$raw);

        self::assertEquals($raw, $visitTicketRequest->toArray());

        self::assertEquals($raw['visit_date'], $visitTicketRequest->getVisitDate());
        self::assertEquals($raw['comment'], $visitTicketRequest->getComment());
    }
}
