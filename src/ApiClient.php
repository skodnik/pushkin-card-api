<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Vlsv\PushkinCardApi\Exception\ApiException;
use Vlsv\PushkinCardApi\Model\CreateTicketRequest;
use Vlsv\PushkinCardApi\Model\ErrorResponse;
use Vlsv\PushkinCardApi\Model\RefundResult;
use Vlsv\PushkinCardApi\Model\RefundTicketRequest;
use Vlsv\PushkinCardApi\Model\Ticket;
use Vlsv\PushkinCardApi\Model\TicketInfo;
use Vlsv\PushkinCardApi\Model\VisitResult;
use Vlsv\PushkinCardApi\Model\VisitTicketRequest;

/**
 * Работа с билетами.
 * API для передачи информации в реестр сведений о билетах.
 *
 * @link https://docs.culture.ru/tickets
 */
class ApiClient
{
    public function __construct(
        /** http клиент */
        protected ClientInterface $client,

        /** Объект конфигурации для http клиента */
        protected ClientConfig $config
    ) {
    }

    /**
     * Добавить в реестр информацию о билете, купленном по Пушкинской карте.
     *
     * @throws ApiException
     */
    public function postTicket(CreateTicketRequest $createTicketRequest): ErrorResponse|Ticket
    {
        $resourcePath = '/tickets';
        $request = new Request('POST', $this->config->getHost() . $resourcePath);

        try {
            $response = $this->makeRequest($request, $createTicketRequest->toJson());
        } catch (Throwable $exception) {
            return $this->exceptionGuard($exception);
        }

        return Ticket::buildByRaw(json_decode($response->getBody()->getContents()));
    }

    /**
     * Запросить билет по ID.
     *
     * @throws ApiException
     */
    public function getTicketInfoById(string $id): ErrorResponse|Ticket
    {
        $resourcePath = '/tickets/' . rawurlencode($id);
        $request = new Request('GET', $this->config->getHost() . $resourcePath);

        try {
            $response = $this->makeRequest($request);
        } catch (Throwable $exception) {
            return $this->exceptionGuard($exception);
        }

        return Ticket::buildByRaw(json_decode($response->getBody()->getContents()));
    }

    /**
     * Добавить информацию о возврате билета.
     *
     * @throws ApiException
     */
    public function refundTicket(
        RefundTicketRequest $refundTicketRequest,
        string $id
    ): ErrorResponse|RefundResult {
        $resourcePath = '/tickets/' . rawurlencode($id) . '/refund';
        $request = new Request('PUT', $this->config->getHost() . $resourcePath);

        try {
            $response = $this->makeRequest($request, $refundTicketRequest->toJson());
        } catch (Throwable $exception) {
            return $this->exceptionGuard($exception);
        }

        return RefundResult::buildByRaw(json_decode($response->getBody()->getContents()));
    }

    /**
     * Получение информации о сеансе по QR и ID события.
     *
     * @throws ApiException
     */
    public function getTicketInfoByEventId(
        string $eventId,
        string $barcode
    ): ErrorResponse|TicketInfo {
        $resourcePath = '/events/' . rawurlencode($eventId) . '/tickets/' . rawurldecode($barcode);
        $request = new Request('GET', $this->config->getHost() . $resourcePath);

        try {
            $response = $this->makeRequest($request);
        } catch (Throwable $exception) {
            return $this->exceptionGuard($exception);
        }

        return TicketInfo::buildByRaw(json_decode($response->getBody()->getContents()));
    }

    /**
     * Добавить в билет информацию о посещении. Продавцы билетов.
     */
    public function redeemTicketInfoByTicketId(
        VisitTicketRequest $visitTicketRequest,
        string $ticketId,
    ): ErrorResponse|VisitResult {
        $resourcePath = '/tickets/' . rawurlencode($ticketId) . '/visit';
        $request = new Request('PUT', $this->config->getHost() . $resourcePath);

        try {
            $response = $this->makeRequest($request, $visitTicketRequest->toJson());
        } catch (Throwable $exception) {
            return $this->exceptionGuard($exception);
        }

        return VisitResult::buildByRaw(json_decode($response->getBody()->getContents()));
    }

    /**
     * Добавить в билет информацию о посещении. Контролеры билетов.
     */
    public function redeemTicketInfoByEventId(
        VisitTicketRequest $visitTicketRequest,
        string $eventId,
        string $barcode
    ): ErrorResponse|VisitResult {
        $resourcePath = '/events/' . rawurlencode($eventId) . '/tickets/' . rawurldecode($barcode) . '/visit';
        $request = new Request('PUT', $this->config->getHost() . $resourcePath);

        try {
            $response = $this->makeRequest($request, $visitTicketRequest->toJson());
        } catch (Throwable $exception) {
            return $this->exceptionGuard($exception);
        }

        return VisitResult::buildByRaw(json_decode($response->getBody()->getContents()));
    }

    /**
     * @throws GuzzleException
     */
    private function makeRequest(Request $request, string $body = ''): ErrorResponse|ResponseInterface
    {
        return $this->client->send($request, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->config->getAccessToken(),
            ],
            'body' => $body,
        ]);
    }

    /**
     * @throws ApiException
     */
    private function exceptionGuard(Throwable|Exception $e): ErrorResponse
    {
        if ($e->getCode() === 400 && $e->hasResponse()) {
            return ModelSerializer::getErrorResponse((string)$e->getResponse()->getBody());
        }

        throw new ApiException(
            '[' . $e->getCode() . '] ' . $e->getMessage(),
            $e->getCode(),
            $e->getResponse() ? $e->getResponse()->getHeaders() : null,
            $e->getResponse() ? (string)$e->getResponse()->getBody() : null
        );
    }
}
