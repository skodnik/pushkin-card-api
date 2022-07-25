<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Tests\Integration;

use Vlsv\PushkinCardApi\Exception\ApiException;
use Vlsv\PushkinCardApi\Model\Buyer;
use Vlsv\PushkinCardApi\Model\ErrorResponse;
use Vlsv\PushkinCardApi\Model\Payment;
use Vlsv\PushkinCardApi\Model\RefundResult;
use Vlsv\PushkinCardApi\Model\Session;
use Vlsv\PushkinCardApi\Model\Ticket;
use Vlsv\PushkinCardApi\Model\Visitor;
use Vlsv\PushkinCardApi\Model\VisitResult;

/**
 * Продавцы билетов.
 */
class ApiSellersTest extends IntegrationTestCase
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
     * Запросить билет по ID.
     *
     * @see     https://docs.culture.ru/tickets/#/%D0%9F%D1%80%D0%BE%D0%B4%D0%B0%D0%B2%D1%86%D1%8B%20%D0%B1%D0%B8%D0%BB%D0%B5%D1%82%D0%BE%D0%B2/get_tickets__id_
     * @depends testPostTicket
     */
    public function testGetTicketInfoById(Ticket $ticketOriginal): ErrorResponse|Ticket
    {
        $ticket = $this->client->getTicketInfoById(
            id: $ticketOriginal->getId()
        );

        self::assertInstanceOf(Ticket::class, $ticket);
        self::assertEquals($ticketOriginal, $ticket);

        return $ticket;
    }

    /**
     * Добавить информацию о возврате билета.
     *
     * @see     https://docs.culture.ru/tickets/#/%D0%9F%D1%80%D0%BE%D0%B4%D0%B0%D0%B2%D1%86%D1%8B%20%D0%B1%D0%B8%D0%BB%D0%B5%D1%82%D0%BE%D0%B2/put_tickets__id__refund
     * @depends testGetTicketInfoById
     */
    public function testRefundTicket(Ticket $ticket): Ticket
    {
        $refundTicketRequest = parent::getRefundTicketRequest();

        $refund = $this->client->refundTicket(
            refundTicketRequest: $refundTicketRequest,
            id: $ticket->getId()
        );

        self::assertInstanceOf(RefundResult::class, $refund);
        self::assertEquals($refundTicketRequest->getRefundDate(), $refund->getRefundDate());
        self::assertEquals($refundTicketRequest->getRefundReason(), $refund->getRefundReason());
        self::assertEquals($refundTicketRequest->getRefundRrn(), $refund->getRefundRrn());
        self::assertEquals($refundTicketRequest->getRefundTicketPrice(), $refund->getRefundTicketPrice());
        self::assertEquals('refunded', $refund->getStatus()->value);

        return $ticket;
    }

    /**
     * Добавить в билет информацию о посещении.
     *
     * @see     https://docs.culture.ru/tickets/#/%D0%9F%D1%80%D0%BE%D0%B4%D0%B0%D0%B2%D1%86%D1%8B%20%D0%B1%D0%B8%D0%BB%D0%B5%D1%82%D0%BE%D0%B2/put_tickets__id__visit
     * @depends testRefundTicket
     */
    public function testRedeemTicketInfoByTicketId($ticket): void
    {
        $visitResult = $this->client->redeemTicketInfoByTicketId(
            visitTicketRequest: parent::getVisitTicketRequest(),
            ticketId: $ticket->getId()
        );

        self::assertInstanceOf(VisitResult::class, $visitResult);
        self::assertEquals('visited', $visitResult->getStatus()->value);
    }
}
