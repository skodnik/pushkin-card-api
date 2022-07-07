<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi;

class ClientConfig
{
    public function __construct(
        /** Токен авторизации - bearerAuth token */
        protected string $accessToken,

        /** Адрес хоста */
        protected string $host
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): ClientConfig
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): ClientConfig
    {
        $this->host = $host;

        return $this;
    }
}
