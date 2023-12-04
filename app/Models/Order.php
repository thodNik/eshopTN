<?php

namespace App\Models;

use App\Enums\StatusOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total_price',
        'quantity',
        'status'
    ];

    protected $casts = [
        'status' => StatusOrder::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
