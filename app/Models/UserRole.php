<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;




/**
 * App\Models\UserRole
 *
 * @property int $id
 * @property string $role_name
 * @property int|null $upper_role_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUpperRoleId($value)
 * @mixin \Eloquent
 */
class UserRole extends Model
{
    use HasFactory;

    /**
     * Disable 'created_at' and 'updated_at' Laravel default
     *
     * @var bool
     */

    public $timestamps = false;


    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $table = 'user_role';


    /**
     *
     * Establishing connection to User table (or User Model)
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role_user');
    }
}
