<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $img_url
 * @property int|null $parent_category_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 *
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $table = "category";

//    public function parent()
//    {
//        return $this->belongsTo('Category', 'id');
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_category_id',
        'img_url',
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
     * Get products that are associated with the category
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get subcategories
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    // recursive, loads all descendants of categories
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }
//    public function childrenRecursive()
//    {
//        return $this->childs()->with('childrenRecursive');
//    }


    /**
     * Get subcategories and its products
     *
     * @return HasMany
     */
    public function childrenProducts(): HasMany
    {
        return $this->children()->with('products');
    }

    /**
     * Get subcategories and its products
     *
     * @return HasManyThrough
     */
    public function childrenProductsWithModels(): HasManyThrough
    {
        return $this->hasManyThrough(Kind::class, Product::class);
    }




}
