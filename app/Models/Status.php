<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This class is for order status,
 * if the name wasn't specific enough
 *
 */
class Status extends Model
{
    use HasFactory;

    /**
     * No created_at, updated_at column for this model
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $table = "status";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

}
