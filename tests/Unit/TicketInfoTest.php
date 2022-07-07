<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\TicketInfo;
use Vlsv\PushkinCardApi\Model\TicketStatus;

class TicketInfoTest extends TestCase
{
    public function provideRawData(): array
    {
        return [
            'full' => [
                [
                    'status' => TicketStatus::cases()[array_rand(TicketStatus::cases())]->value,
                    'session' => [
                        'event_id' => 'test_event_id',
                        'organization_id' => 'test_organization_id',
                        'date' => 123456789,
                        'place' => 'test_place',
                        'params' => 'test_params',
                    ],
                ],
            ],
            'has null' => [
                [
                    'status' => null,
                    'session' => null,
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters(array $raw)
    {
        $ticketInfo = TicketInfo::buildByRaw((object)$raw);

        self::assertInstanceOf(TicketInfo::class, $ticketInfo);

        self::assertEquals($raw, $ticketInfo->toArray());
    }
}
