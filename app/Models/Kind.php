<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 *  Renamed Kind for model table to avoid Model class name collision
 *
 */
class Kind extends Model
{
    use HasFactory;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $table = "model";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image_1',
        'image_2',
        'hex_color',
        'product_id',
        'quantity',
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
     * Get model images for product
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(KindImage::class, 'model_id');
    }
}
