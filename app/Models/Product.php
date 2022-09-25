<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
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
        'category_id',
        'warehouse_id_group',
        'brand',
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

    /**
     * The product belongs to many merchants
     *
     *  @return BelongsToMany
     */
    public function merchants(): BelongsToMany
    {
        return $this->belongsToMany(Merchant::class, 'merchant_product');
    }

    /**
     * The product belongs to many warehouses
     *
     *  @return BelongsToMany
     */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_product');
    }

    /**
     * The product belongs to many merchants
     *
     *  @return HasMany
     */
    public function kinds(): HasMany
    {
        return $this->hasMany(Kind::class);
    }

    /**
     * The product belongs to many merchants
     *
     *  @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }




}
