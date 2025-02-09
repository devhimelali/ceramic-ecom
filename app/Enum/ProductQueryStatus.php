<?php

namespace App\Enum;

enum ProductQueryStatus: string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    public function description(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CANCELLED => 'Cancelled',
            self::COMPLETED => 'Completed',
        };
    }
}
