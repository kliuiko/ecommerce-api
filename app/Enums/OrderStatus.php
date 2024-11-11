<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'На оплату';
    case PAID = 'Оплачен';
    case CANCELED = 'Отменен';
}
