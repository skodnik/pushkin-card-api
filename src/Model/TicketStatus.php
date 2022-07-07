<?php

declare(strict_types=1);

namespace Vlsv\PushkinCardApi\Model;

enum TicketStatus: string
{
    case ACTIVE = 'active';
    case VISITED = 'visited';
    case REFUNDED = 'refunded';
    case CANCELED = 'canceled';
}
