<?php

namespace App\Models;

use App\Casts\OrderStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model {
    use HasFactory;

    public $guarded = [];
    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'status'        => OrderStatusCast::class,
        ];
    }

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function student(): HasOneThrough {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'student_id', 'id');
    }

    public function orderBy(): BelongsTo {
        return $this->belongsTo(User::class, 'student_id');
    }
}
