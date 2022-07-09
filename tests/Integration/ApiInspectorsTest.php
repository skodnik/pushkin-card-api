<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Integration;

use Vlsv\PushkinCardApi\Exception\ApiException;
use Vlsv\PushkinCardApi\Model\Buyer;
use Vlsv\PushkinCardApi\Model\ErrorResponse;
use Vlsv\PushkinCardApi\Model\Payment;
use Vlsv\PushkinCardApi\Model\Session;
use Vlsv\PushkinCardApi\Model\Ticket;
use Vlsv\PushkinCardApi\Model\TicketInfo;
use Vlsv\PushkinCardApi\Model\Visitor;
use Vlsv\PushkinCardApi\Model\VisitResult;

/**
 * Контролеры билетов.
 */
class ApiInspectorsTest extends IntegrationTestCase
{
    /**
     * Добавить в реестр информацию о билете, купленном по Пушкинской карте.
     *
     * @see    https://docs.culture.ru/tickets/#/%D0%9F%D1%80%D0%BE%D0%B4%D0%B0%D0%B2%D1%86%D1%8B%20%D0%B1%D0%B8%D0%BB%D0%B5%D1%82%D0%BE%D0%B2/post_tickets
     * @throws ApiException
     */
    public function testPostTicket(): ErrorResponse|Ticket
    {
        $createTicketRequest = parent::getCreateTicketRequest();

        $ticket = $this->client->postTicket(
            createTicketRequest: $createTicketRequest
        );

        self::assertInstanceOf(Ticket::class, $ticket);
        self::assertInstanceOf(Visitor::class, $ticket->getVisitor());
        self::assertInstanceOf(Buyer::class, $ticket->getBuyer());
        self::assertInstanceOf(Session::class, $ticket->getSession());
        self::assertInstanceOf(Payment::class, $ticket->getPayment());

        // Проверяет, что созданный билет содержит идентификатор - uuid.
        self::assertEquals(36, strlen($ticket->getId()));

        // Проверяет соответствие переданных и возвращенных параметров.
        self::assertEquals($createTicketRequest->getVisitor(), $ticket->getVisitor());
        self::assertEquals($createTicketRequest->getBuyer(), $ticket->getBuyer());
        self::assertEquals(
            $createTicketRequest->getSession()->getEventId(),
            $ticket->getSession()->getEventId()
        );
        self::assertEquals(
            $createTicketRequest->getSession()->getOrganizationId(),
            $ticket->getSession()->getOrganizationId()
        );
        self::assertEquals(
            $createTicketRequest->getSession()->getPlace(),
            $ticket->getSession()->getPlace()
        );
        self::assertEquals(
            $createTicketRequest->getSession()->getParams(),
            $ticket->getSession()->getParams()
        );
        self::assertEquals($createTicketRequest->getPayment(), $ticket->getPayment());

        return $ticket;
    }

    /**
     * Добавить в билет информацию о посещении.
     *
     * @see     https://docs.culture.ru/tickets/#/%D0%9A%D0%BE%D0%BD%D1%82%D1%80%D0%BE%D0%BB%D1%91%D1%80%D1%8B%20%D0%B1%D0%B8%D0%BB%D0%B5%D1%82%D0%BE%D0%B2/put_events__event_id__tickets__barcode__visit
     * @depends testPostTicket
     */
    public function testRedeemTicketInfoByEventId(Ticket $ticket): void
    {
        $visitResult = $this->client->redeemTicketInfoByEventId(
            visitTicketRequest: parent::getVisitTicketRequest(),
            eventId: $ticket->getSession()->getEventId(),
            barcode: $ticket->getBarcode()
        );

        self::assertInstanceOf(VisitResult::class, $visitResult);
        self::assertEquals('visited', $visitResult->getStatus()->value);
    }

    /**
     * Получение информации о сеансе по QR и ID события.
     *
     * @see     https://docs.culture.ru/tickets/#/%D0%9A%D0%BE%D0%BD%D1%82%D1%80%D0%BE%D0%BB%D1%91%D1%80%D1%8B%20%D0%B1%D0%B8%D0%BB%D0%B5%D1%82%D0%BE%D0%B2/get_events__event_id__tickets__barcode_
     * @depends testPostTicket
     */
    public function testGetTicketInfoByEventId(Ticket $ticket): Ticket
    {
        $ticketInfo = $this->client->getTicketInfoByEventId(
            eventId: $ticket->getSession()->getEventId(),
            barcode: $ticket->getBarcode()
        );

        self::assertInstanceOf(TicketInfo::class, $ticketInfo);
        self::assertInstanceOf(Session::class, $ticketInfo->getSession());
        self::assertEquals('visited', $ticketInfo->getStatus()->value);
        self::assertEquals(
            $ticket->getSession()->getEventId(),
            $ticketInfo->getSession()->getEventId()
        );
        self::assertEquals(
            $ticket->getSession()->getOrganizationId(),
            $ticketInfo->getSession()->getOrganizationId()
        );
        self::assertEquals(
        // $ticket->getSession()->getPlace(),
            '',
            $ticketInfo->getSession()->getPlace()
        );
        self::assertEquals(
            $ticket->getSession()->getParams(),
            $ticketInfo->getSession()->getParams()
        );

        return $ticket;
    }
}
