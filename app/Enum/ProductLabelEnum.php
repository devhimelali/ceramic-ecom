<?php

namespace App\Enum;

enum ProductLabelEnum: string
{
    case TOP_SELLING = 'top selling';
    case NEW_ARRIVAL = 'new arrival';
    case FEATURED = 'featured';

    public function description(): string
    {
        return match ($this) {
            self::TOP_SELLING => 'Top Selling',
            self::NEW_ARRIVAL => 'New Arrival',
            self::FEATURED => 'Featured',
        };
    }
}
