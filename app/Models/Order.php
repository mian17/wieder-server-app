<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Ramsey\Uuid\Uuid;

class Order extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected $primaryKey = 'uuid';

    /**
     * Since ID type is uuid, to prevent Laravel from decrypting the id
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Prevent Model from incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $table = "order";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_uuid',
        'receiver_name',
        'receiver_email',
        'receiver_phone_number',
        'receiver_address',
        'total',
        'status_id',
        'payment_id'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    /**
     * The order table can have many order statuses
     *
     * @return HasMany
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class, 'id', 'status_id');
    }

    /**
     * One instance of the table can have many order items
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_uuid', 'uuid');
    }

    /**
     * Get the payment details for a specific order
     */
    public function paymentDetails()
    {
        return $this->hasOne(PaymentDetails::class, 'uuid');
    }

    /**
     * Get the user that owns the orders.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,);
    }

    public function kinds($uuid)
    {
        return $this->with('orderItems.kind')
            ->where('order.uuid', '=', $uuid)
            ->get();
    }

}
