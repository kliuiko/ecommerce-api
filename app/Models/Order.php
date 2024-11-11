<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $payment_method_id
 * @property string $status
 * @property float $total_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read PaymentMethod $paymentMethod
 */
class Order extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'status',
        'total_amount',
        'payment_token'
    ];

    /**
     * @return BelongsTo
     */
    public function paymentMethod(): belongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
