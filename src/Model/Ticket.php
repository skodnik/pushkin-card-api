<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class Ticket extends BaseModel
{
    public function __construct(
        /** ID билета */
        protected string $id,

        /** ШК билета (QR-код) */
        protected string $barcode,

        /** Статус билета */
        protected TicketStatus $status,

        /** Посетитель мероприятия */
        protected Visitor $visitor,

        /** Участник программы */
        protected Buyer $buyer,

        /** Сеанс */
        protected Session $session,

        /** Платеж */
        protected Payment $payment,

        /** Дата посещения (гашения) (unix timestamp) */
        protected ?int $visit_date,

        /** Дата возврата билета (unix timestamp) */
        protected ?int $refund_date,

        /** Причина возврата */
        protected string $refund_reason,

        /** RRN(Retrieval Reference Number) -уникальный идентификатор транзакции возврата */
        protected string $refund_rrn,

        /** Сумма возврата */
        protected string $refund_ticket_price,

        /** Комментарий(для билета) */
        protected string $comment
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    public function getVisitor(): Visitor
    {
        return $this->visitor;
    }

    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function getVisitDate(): ?int
    {
        return $this->visit_date;
    }

    public function getRefundDate(): ?int
    {
        return $this->refund_date;
    }

    public function getRefundReason(): string
    {
        return $this->refund_reason;
    }

    public function getRefundRrn(): string
    {
        return $this->refund_rrn;
    }

    public function getRefundTicketPrice(): string
    {
        return $this->refund_ticket_price;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'barcode' => $this->getBarcode(),
            'status' => $this->getStatus()->value,
            'visitor' => $this->getVisitor()->toArray(),
            'buyer' => $this->getBuyer()->toArray(),
            'session' => $this->getSession()->toArray(),
            'payment' => $this->getPayment()->toArray(),
            'visit_date' => $this->getVisitDate(),
            'refund_date' => $this->getRefundDate(),
            'refund_reason' => $this->getRefundReason(),
            'refund_rrn' => $this->getRefundRrn(),
            'refund_ticket_price' => $this->getRefundTicketPrice(),
            'comment' => $this->getComment(),
        ];
    }

    public static function buildByRaw(stdClass $raw): Ticket
    {
        return new self(
            id: $raw->id,
            barcode: $raw->barcode,
            status: TicketStatus::from($raw->status),
            visitor: Visitor::buildByRaw((object)$raw->visitor),
            buyer: Buyer::buildByRaw((object)$raw->buyer),
            session: Session::buildByRaw((object)$raw->session),
            payment: Payment::buildByRaw((object)$raw->payment),
            visit_date: $raw->visit_date ?? null,
            refund_date: $raw->refund_date ?? null,
            refund_reason: $raw->refund_reason ?? '',
            refund_rrn: $raw->refund_rrn ?? '',
            refund_ticket_price: $raw->refund_ticket_price ?? '',
            comment: $raw->comment ?? '',
        );
    }
}
