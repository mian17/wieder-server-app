<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * The product belongs to many merchants
     *
     *  @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }


    // ----------------------------------------------------------------
    // Products status expectations:
    // ----------------------------------------------------------------
    // Hidden status case:
    // 1 - It can not be seen by the user (checked) (applied in ProductController, show method)
    // 2 - Client site can not load the product. (checked) (applied in ProductController, show method)
    // 3 - Cannot be added to cart. (checked) (By effectively hide the product completely)
    // ----------------------------------------------------------------
    // Trashed status case:
    // 1 - It can be seen by the user
    // 2 - Ideally, it should be shown as decapitated
    // 3 - Cannot be added to cart.
    // ----------------------------------------------------------------


    /**
     * Scope product query to only exclude products which statuses are hidden.
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeNotHidden($query)
    {
        $query->whereNotIn('status', ['Ẩn']); // Despite being shown as unknown column, this is ok.
    }

    /**
     * Scope product query to only exclude products which statuses in trash
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeNotInTrash($query)
    {
        $query->whereNotIn('status', ['-1']);
    }

    /**
     * Scope product query to exclude products which statuses are hidden or moved to trash.
     * HIDDEN_STATUS = "Hiển thị"
     * MOVED_TO_TRASH_STATUS = "Ẩn"
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeNotHiddenOrMovedToTrashForClientSite($query)
    {
        $query->whereNotIn('status', ['Ẩn', -1]);
    }


}
