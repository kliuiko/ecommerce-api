<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $payment_url_template
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection|Order[] $orders
 */
class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'payment_url_template',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
