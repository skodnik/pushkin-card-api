<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

use stdClass;

class CreateTicketRequest extends BaseModel
{
    public function __construct(
        /** ШК билета (QR-код) */
        protected string $barcode,

        /** Тип ШК билета */
        protected string $barcode_type,

        /** Посетитель мероприятия */
        protected Visitor $visitor,

        /** Участник программы */
        protected Buyer $buyer,

        /** Сеанс */
        protected Session $session,

        /** Платеж */
        protected Payment $payment,

        /** Комментарий (для билета) */
        protected string $comment,
    ) {
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function getBarcodeType(): string
    {
        return $this->barcode_type;
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

    public function getComment(): string
    {
        return $this->comment;
    }

    public function toArray(): array
    {
        return [
            'barcode' => $this->getBarcode(),
            'barcode_type' => $this->getBarcodeType(),
            'visitor' => $this->getVisitor()->toArray(),
            'buyer' => $this->getBuyer()->toArray(),
            'session' => $this->getSession()->toArray(),
            'payment' => $this->getPayment()->toArray(),
            'comment' => $this->getComment(),
        ];
    }

    public static function buildByRaw(stdClass $raw): CreateTicketRequest
    {
        return new self(
            barcode: $raw->barcode,
            barcode_type: $raw->barcode_type ?? '',
            visitor: Visitor::buildByRaw((object)$raw->visitor),
            buyer: Buyer::buildByRaw((object)$raw->buyer),
            session: Session::buildByRaw((object)$raw->session),
            payment: Payment::buildByRaw((object)$raw->payment),
            comment: $raw->comment ?? '',
        );
    }
}
