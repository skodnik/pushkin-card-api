<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\Model\Session;

class SessionTest extends TestCase
{
    public function provideRawData(): array
    {
        return [
            'full' => [
                [
                    'event_id' => 'test_event_id',
                    'organization_id' => 'test_organization_id',
                    'date' => 123456789,
                    'place' => 'test_place',
                    'params' => 'test_params',
                ],
            ],
            'has null' => [
                [
                    'event_id' => 'test_event_id',
                    'organization_id' => 'test_organization_id',
                    'date' => 123456789,
                    'place' => null,
                    'params' => null,
                ],
            ],
        ];
    }

    /** @dataProvider provideRawData */
    public function testConstructAndGetters(array $raw)
    {
        $session = Session::buildByRaw((object)$raw);

        self::assertInstanceOf(Session::class, $session);

        self::assertEquals($raw, $session->toArray());

        self::assertEquals($raw['event_id'], $session->getEventId());
        self::assertEquals($raw['organization_id'], $session->getOrganizationId());
        self::assertEquals($raw['date'], $session->getDate());
        self::assertEquals($raw['place'], $session->getPlace());
        self::assertEquals($raw['params'], $session->getParams());
    }
}
