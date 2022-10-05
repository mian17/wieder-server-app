<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $primaryKey='uuid';

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
    protected $table = "payment_details";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'payment_method_id',
        'amount',
        'status',
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
     * Get the payment methods for a specific order
     */
    public function methods()
    {
        return $this->hasMany(PaymentMethod::class, 'id', 'payment_method_id');
    }
}
