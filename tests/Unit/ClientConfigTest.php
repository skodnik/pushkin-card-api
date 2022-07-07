<?php

namespace Vlsv\PushkinCardApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vlsv\PushkinCardApi\ClientConfig;

class ClientConfigTest extends TestCase
{
    public function testConstruct(): ClientConfig
    {
        $clientConfig = new ClientConfig(
            accessToken: '93x0ym7pznovkadof1lz',
            host: 'https://pushka-uat.test.gosuslugi.ru/api/v1'
        );

        self::assertInstanceOf(ClientConfig::class, $clientConfig);

        return $clientConfig;
    }

    /**
     * @depends testConstruct
     */
    public function testSetAndGetAccessToken(ClientConfig $clientConfig)
    {
        $newAccessToken = 'new-access-token';
        $clientConfig->setAccessToken($newAccessToken);

        self::assertEquals($newAccessToken, $clientConfig->getAccessToken());
    }

    /** @depends testConstruct */
    public function testSetAndGetHost(ClientConfig $clientConfig)
    {
        $newHost = 'https://new-host.test';
        $clientConfig->setHost($newHost);

        self::assertEquals($newHost, $clientConfig->getHost());
    }
}
