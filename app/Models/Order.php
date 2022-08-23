<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $table = "product";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_uuid',
        'total',
        'warehouse_id_group',
        'name',
        'summary',
        'desc',
        'detail_info',
        'quantity',
        'SKU',
        'mass',
        'cost_price',
        'price',
        'unit',
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
}
